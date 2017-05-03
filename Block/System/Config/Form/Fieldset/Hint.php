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

namespace CliveWalkden\Usersnap\Block\System\Config\Form\Fieldset;

use CliveWalkden\Usersnap\Helper\Data;

class Hint extends \Magento\Backend\Block\Template implements \Magento\Framework\Data\Form\Element\Renderer\RendererInterface
{
    /**
     * @var \CliveWalkden\Usersnap\Helper\Data
     */
    protected $_helper;

    /**
     * @var string
     */
    protected $_template = 'CliveWalkden_Usersnap::system/config/fieldset/hint.phtml';
    /**
     * @var \Magento\Framework\App\ProductMetadataInterface
     */
    protected $_metaData;
    /**
     * @var \Magento\Framework\Module\ModuleList\Loader
     */
    protected $_loader;
    /**
     * @param \Magento\Backend\Block\Template\Context $context
     * @param \Magento\Framework\App\ProductMetadataInterface $productMetaData
     * @param \Magento\Framework\Module\ModuleList\Loader $loader
     * @param array $data
     */
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Framework\App\ProductMetadataInterface $productMetaData,
        \Magento\Framework\Module\ModuleList\Loader $loader,
        Data $helper,
        array $data = []
    ) {

        parent::__construct($context, $data);
        $this->_metaData = $productMetaData;
        $this->_loader = $loader;
        $this->_helper = $helper;
    }
    /**
     * @param \Magento\Framework\Data\Form\Element\AbstractElement $element
     * @return mixed
     */
    public function render(\Magento\Framework\Data\Form\Element\AbstractElement $element)
    {
        return $this->toHtml();
    }
    public function getPxParams()
    {
        $modules = $this->_loader->load();
        $v = $this->_helper->getExtensionVersion();
        $extension = "Usersnap;{$v}";
        $mageEdition = $this->_metaData->getEdition();
        switch ($mageEdition) {
            case 'Community':
                $mageEdition = 'CE';
                break;
            case 'Enterprise':
                $mageEdition = 'EE';
                break;
        }
        $mageVersion = $this->_metaData->getVersion();
        $mage = "Magento {$mageEdition};{$mageVersion}";
        $hash = md5($extension . '_' . $mage . '_' . $extension);
        return "ext=$extension&mage={$mage}&ctrl={$hash}";
    }
    public function getVersion()
    {
        return $this->_helper->getExtensionVersion();
    }
}
