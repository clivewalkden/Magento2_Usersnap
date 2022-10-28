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
use Magento\Backend\Model\Auth\Session;
use Magento\Framework\View\Element\Template\Context;

class Backend extends Display
{
    private Session $authSession;

    public function __construct(Context $context, Data $snapHelper, IpCheckerService $ipCheckerService, Session $authSession, array $data = [])
    {
        parent::__construct($context, $snapHelper, $ipCheckerService, $data);
        $this->authSession = $authSession;
    }

    protected function getCurrentUser(): ?\Magento\User\Model\User
    {
        return $this->authSession->getUser();
    }

    public function getConfig(): string
    {
        $config = [];
        if ($this->getCurrentUser()) {
            $config = [
                'userId' => $this->getCurrentUser()->getEntityId(),
                'email' => $this->getCurrentUser()->getEmail()
            ];
        }

        return json_encode($config);
    }

    /**
     * @return string
     */
    public function _toHtml(): string
    {
        if ($this->snapHelper->getBackendEnabled()) {
            return parent::_toHtml();
        }

        return '';
    }
}
