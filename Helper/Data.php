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

namespace CliveWalkden\Usersnap\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Helper\Context;
use Magento\Framework\Module\ModuleListInterface;
use Magento\Store\Model\ScopeInterface;

class Data extends AbstractHelper
{
    const CFG_USERSNAP_ENABLED = 'clivewalkden_usersnap/general/enabled';
    const CFG_USERSNAP_WIDGET_ID = 'clivewalkden_usersnap/general/widget_id';
    const CFG_USERSNAP_FRONTEND_ENABLED = 'clivewalkden_usersnap/general/frontend_enabled';
    const CFG_USERSNAP_BACKEND_ENABLED = 'clivewalkden_usersnap/general/backend_enabled';
    const CFG_USERSNAP_ENVIRONMENT = 'clivewalkden_usersnap/general/environment';
    const CFG_USERSNAP_WHITELIST_ENABLED = 'clivewalkden_usersnap/ip_whitelist/enabled';
    const CFG_USERSNAP_WHITELIST_WHITELIST = 'clivewalkden_usersnap/ip_whitelist/whitelist';

    /**
     * @var \Magento\Framework\Module\ModuleListInterface
     */
    protected $moduleList;

    public function __construct(
        Context $context,
        ModuleListInterface $moduleList
    ) {
        $this->moduleList = $moduleList;

        parent::__construct($context);
    }

    /**
     * @return bool
     */
    public function getEnabled()
    {
        return $this->scopeConfig->isSetFlag(self::CFG_USERSNAP_ENABLED, ScopeInterface::SCOPE_STORE);
    }

    /**
     * @return mixed
     */
    public function getWidgetId()
    {
        return $this->validateWidgetID();
    }

    protected function validateWidgetID() {
        $widgetId = $this->scopeConfig->getValue(self::CFG_USERSNAP_WIDGET_ID, ScopeInterface::SCOPE_STORE);

        if (substr_compare($widgetId, '.js', -3, 3, true) === 0) {
            return $widgetId;
        } else {
            return $widgetId . '.js';
        }
    }

    /**
     * @return bool
     */
    public function getFrontendEnabled() {
        return $this->scopeConfig->isSetFlag(self::CFG_USERSNAP_FRONTEND_ENABLED, ScopeInterface::SCOPE_STORE);
    }

    /**
     * @return bool
     */
    public function getBackendEnabled() {
        return $this->scopeConfig->isSetFlag(self::CFG_USERSNAP_BACKEND_ENABLED, ScopeInterface::SCOPE_STORE);
    }

    /**
     * @return mixed
     */
    public function getEnvironment()
    {
        return $this->scopeConfig->getValue(self::CFG_USERSNAP_ENVIRONMENT, ScopeInterface::SCOPE_STORE);
    }

    /**
     * @return bool
     */
    public function getWhitelistEnabled(): bool
    {
        return $this->scopeConfig->isSetFlag(self::CFG_USERSNAP_WHITELIST_ENABLED, ScopeInterface::SCOPE_STORE);
    }

    /**
     * @return mixed
     */
    public function getWhitelist()
    {
        return $this->scopeConfig->getValue(self::CFG_USERSNAP_WHITELIST_WHITELIST, ScopeInterface::SCOPE_STORE);
    }

    /**
     * @return mixed
     */
    public function getExtensionVersion()
    {
        $moduleCode = 'CliveWalkden_Usersnap';
        $moduleInfo = $this->moduleList->getOne($moduleCode);
        return $moduleInfo['setup_version'];
    }
}
