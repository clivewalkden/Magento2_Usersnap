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

namespace CliveWalkden\Usersnap\Block;

use CliveWalkden\Usersnap\Helper\Data;
use CliveWalkden\Usersnap\Service\IpCheckerService;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;

class Display extends Template
{
    /**
     * @var Data
     */
    protected $snapHelper;

    /**
     * @var IpCheckerService
     */
    protected $ipChecker;

    protected $jsConfig = [];

    /**
     * @param Context $context
     * @param Data $snapHelper
     * @param IpCheckerService $ipCheckerService
     * @param array $data
     */
    public function __construct(Context $context, Data $snapHelper, IpCheckerService $ipCheckerService, array $data = [])
    {
        $this->snapHelper = $snapHelper;
        $this->ipChecker = $ipCheckerService;

        parent::__construct($context, $data);
    }

    /**
     * Get the Widget ID
     *
     * @return mixed
     */
    public function getWidgetId()
    {
        return $this->snapHelper->getWidgetId();
    }

    /**
     * Get the Project API Key
     *
     * @return mixed
     */
    public function getProjectApiKey(): ?string
    {
        return $this->snapHelper->getProjectApiKey();
    }

    /**
     * Get the Widget Environment
     *
     * @return mixed
     */
    public function getEnvironment()
    {
        return $this->snapHelper->getEnvironment();
    }

    public function prepareConfig(): array
    {
        return $this->jsConfig = [
            'custom' => [
                'capturedBy' => 'Magento 2 Usersnap Module: ' . $this->snapHelper->getExtensionVersion(),
                'environment' => $this->snapHelper->getEnvironment()
            ]
        ];
    }

    public function getJsConfig(): string
    {
        $this->prepareConfig();
        return json_encode($this->jsConfig, JSON_FORCE_OBJECT);
    }

    /**
     * Generate the Usersnap output
     *
     * @return string
     */
    public function _toHtml(): string
    {
        $enabled = $this->snapHelper->getEnabled();
        $ipAllowed = $this->ipChecker->checkAllowed();

        return ($enabled && $ipAllowed) ? parent::_toHtml() : '';
    }
}
