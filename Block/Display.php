<?php
/**
 * Clive Walkden
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 *
 * @category    Clive Walkden
 * @package     CliveWalkden_Usersnap
 * @copyright   Copyright (c) 2018 Clive Walkden (https://clivewalkden.co.uk)
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 *
 */

namespace CliveWalkden\Usersnap\Block;

use CliveWalkden\Usersnap\Helper\Data;
use Magento\Framework\App\State;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;

class Display extends Template
{
    /**
     * @var \CliveWalkden\Usersnap\Helper\Data
     */
    protected $snapHelper;

    /**
     * @var \Magento\Framework\App\State
     */
    protected $state;

    /**
     * Display constructor.
     *
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param \CliveWalkden\Usersnap\Helper\Data               $snapHelper
     * @param \Magento\Framework\App\State                     $state
     * @param array                                            $data
     */
    public function __construct(Context $context, Data $snapHelper, State $state, array $data = [])
    {
        $this->snapHelper = $snapHelper;
        parent::__construct($context, $data);
        $this->state = $state;
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

    public function isAllowed()
    {
        $areaEnabled = $this->snapHelper->getArea();
        $area = $this->state->getAreaCode();

        return ($areaEnabled == \Magento\Framework\App\Area::AREA_GLOBAL)
            || ($area == $areaEnabled);
    }

    /**
     * Generate the Usersnap output
     *
     * @return string
     */
    public function _toHtml()
    {
        if (!$this->snapHelper->getEnabled()) {
            return '';
        }

        return parent::_toHtml();
    }
}
