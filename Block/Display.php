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
 * @copyright   Copyright (c) 2017 Clive Walkden (https://clivewalkden.co.uk)
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 *
 */

namespace CliveWalkden\Usersnap\Block;

use Magento\Framework\View\Element\Template;
use CliveWalkden\Usersnap\Helper\Data;

class Display extends Template
{
    /**
     * @var \CliveWalkden\Usersnap\Helper\Data
     */
    protected $snapHelper;

    public function __construct(Data $snapHelper)
    {
        $this->snapHelper = $snapHelper;
    }

    /**
     * Generate the JivoChat output
     *
     * @return string
     */
    public function _toHtml()
    {
        if ($this->snapHelper->getEnabled()) {
            $this
                ->setTemplate('snap/widget.phtml')
                ->setKey($this->snapHelper->getWidgetId()
                ->setEnabled($this->snapHelper->getEnabled()));
            return parent::_toHtml();
        }
        return '';
    }
}
