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

namespace CliveWalkden\Usersnap\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Helper\Context;
use Magento\Framework\Module\ModuleListInterface;
use Magento\Store\Model\ScopeInterface;

class Data extends AbstractHelper
{
    const CFG_USERSNAP_ENABLED = 'clivewalkden_usersnap/general/enabled';
    const CFG_USERSNAP_WIDGET_ID = 'clivewalkden_usersnap/general/widget_id';
    const CFG_USERSNAP_ENVIRONMENT = 'clivewalkden_usersnap/general/environment';

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
        return $this->scopeConfig->getValue(self::CFG_USERSNAP_WIDGET_ID, ScopeInterface::SCOPE_STORE);
    }

    /**
     * @return mixed
     */
    public function getEnvironment()
    {
        return $this->scopeConfig->getValue(self::CFG_USERSNAP_ENVIRONMENT, ScopeInterface::SCOPE_STORE);
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
