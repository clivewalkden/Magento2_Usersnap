<?php
/*
 * Clive Walkden
 *
 *  NOTICE OF LICENSE
 *
 *  This source file is subject to the Open Software License (OSL 3.0)
 *  that is bundled with this package in the file LICENSE.
 *  It is also available through the world-wide-web at this URL:
 *  http://opensource.org/licenses/osl-3.0.php
 *
 *  @category    Clive Walkden
 *  @package     CliveWalkden_Usersnap
 *  @copyright   Copyright (c) Clive Walkden (https://clivewalkden.co.uk)
 *  @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 *
 */

declare(strict_types=1);

namespace CliveWalkden\Usersnap\Service;

use CliveWalkden\Usersnap\Helper\Data;
use Magento\Framework\HTTP\PhpEnvironment\RemoteAddress;

class IpCheckerService
{
    /**
     * @var array
     */
    protected $whitelist;

    /**
     * @var Data
     */
    protected $helper;

    /**
     * @var string
     */
    protected $ipAddress;

    /**
     * @param Data $helper
     * @param RemoteAddress $remoteAddress
     */
    public function __construct(Data $helper, RemoteAddress $remoteAddress)
    {
        $this->helper = $helper;

        $whitelist = $this->helper->getWhitelist();
        $whitelist = explode("\n", $whitelist);
        $this->whitelist = $whitelist;

        $this->ipAddress = $remoteAddress->getRemoteAddress();
    }

    /**
     * Check if the whitelist is used and if so the current IP is allowed
     *
     * @return bool
     */
    public function checkAllowed(): bool
    {
        if (!(bool)$this->helper->getWhitelistEnabled()) {
            return true;
        }

        return $this->isInWhitelist();
    }

    /**
     * Check if the current IP is whitelisted
     *
     * @return bool
     */
    protected function isInWhitelist(): bool
    {
        if ($this->isExactMatch() || $this->isNetmaskMatch() || $this->isRangeMatch()) {
            return true;
        }

        return false;
    }

    /**
     * Check if the current IP is in the whitelist
     *
     * @return bool
     */
    protected function isExactMatch(): bool
    {
        return in_array($this->ipAddress, $this->whitelist);
    }

    /**
     * Check if IP has a match to a whitelisted IP with netmask
     * Credits to Paul Gregg (https://pgregg.com/projects/php/ip_in_range/ip_in_range.phps)
     *
     * @return bool
     */
    protected function isNetmaskMatch(): bool
    {
        foreach ($this->whitelist as $ipRange) {
            if (strpos($ipRange, '/') === false) {
                return false;
            }

            list($ipRange, $netmask) = explode('/', $ipRange, 2);
            if (strpos($netmask, '.') !== false) {
                // $netmask is a 255.255.0.0 format
                $netmask = str_replace('*', '0', $netmask);
                $decimalNetmask = ip2long($netmask);

                if ((ip2long($this->ipAddress) & $decimalNetmask) == (ip2long($ipRange) & $decimalNetmask)) {
                    return true;
                }
            } else {
                // $netmask is a CIDR size block
                // fix the range argument
                $x = explode('.', $ipRange);
                while (count($x) < 4) {
                    $x[] = '0';
                }
                list($a, $b, $c, $d) = $x;
                $ipRange = sprintf(
                    "%u.%u.%u.%u",
                    empty($a) ? '0' : $a,
                    empty($b) ? '0' : $b,
                    empty($c) ? '0' : $c,
                    empty($d) ? '0' : $d
                );
                $decimalIpRange = ip2long($ipRange);
                $decimalIpAddress = ip2long($this->ipAddress);

                $decimalWildcard = pow(2, (32 - $netmask)) - 1;
                $decimalNetmask = ~$decimalWildcard;

                if (($decimalIpAddress & $decimalNetmask) == ($decimalIpRange & $decimalNetmask)) {
                    return true;
                }
            }
        }

        return false;
    }

    /**
     * Check if IP has a match to a whitelisted IP with netmask
     * Credits to Paul Gregg (https://pgregg.com/projects/php/ip_in_range/ip_in_range.phps)
     *
     * @return bool
     */
    protected function isRangeMatch(): bool
    {
        foreach ($this->whitelist as $ipRange) {
            // Check if IP is in A.B.*.* format
            if (strpos($ipRange, '*') !== false) {
                // Just convert to A-B format by setting * to 0 for A and 255 for B
                $lowerIpAddress = str_replace('*', '0', $ipRange);
                $upperIpAddress = str_replace('*', '255', $ipRange);
                $ipRange = $lowerIpAddress . '-' . $upperIpAddress;
            }

            // Check if IP is in A-B format
            if (strpos($ipRange, '-') !== false) { // A-B format
                list($lowerIpAddress, $upperIpAddress) = explode('-', $ipRange, 2);
                $decimalLowerIpAddress = (float)sprintf("%u", ip2long($lowerIpAddress));
                $decimalUpperIpAddress = (float)sprintf("%u", ip2long($upperIpAddress));
                $decimalIpAddress = (float)sprintf("%u", ip2long($this->ipAddress));

                if (($decimalIpAddress >= $decimalLowerIpAddress) && ($decimalIpAddress <= $decimalUpperIpAddress)) {
                    return true;
                }
            }
        }

        return false;
    }
}
