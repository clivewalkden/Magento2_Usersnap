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
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;

class Display extends Template
{
    /**
     * @var \CliveWalkden\Usersnap\Helper\Data
     */
    protected $snapHelper;

    public function __construct(Context $context, Data $snapHelper, array $data = [])
    {
        $this->snapHelper = $snapHelper;
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
