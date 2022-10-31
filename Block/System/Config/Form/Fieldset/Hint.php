<?php
/*
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
 * @copyright   Copyright (c) Clive Walkden (https://clivewalkden.co.uk)
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

declare(strict_types=1);

namespace CliveWalkden\Usersnap\Block\System\Config\Form\Fieldset;

use CliveWalkden\Usersnap\Model\ConfigProvider;
use Magento\Backend\Block\Template;
use Magento\Backend\Block\Template\Context;
use Magento\Framework\App\ProductMetadataInterface;
use Magento\Framework\Data\Form\Element\AbstractElement;
use Magento\Framework\Data\Form\Element\Renderer\RendererInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Module\ModuleList\Loader;

class Hint extends Template implements RendererInterface
{
    /**
     * @var ConfigProvider
     */
    protected $configProvider;

    /**
     * @var string
     */
    protected $_template = 'CliveWalkden_Usersnap::system/config/fieldset/hint.phtml';

    /**
     * @var ProductMetadataInterface
     */
    protected $metaData;

    /**
     * @var Loader
     */
    protected $loader;

    /**
     * Hint constructor.
     *
     * @param Context $context
     * @param ProductMetadataInterface $productMetaData
     * @param Loader $loader
     * @param ConfigProvider $configProvider
     * @param array $data
     */
    public function __construct(
        Context                  $context,
        ProductMetadataInterface $productMetaData,
        Loader                   $loader,
        ConfigProvider           $configProvider,
        array                    $data = []
    ) {
        parent::__construct($context, $data);
        $this->metaData = $productMetaData;
        $this->loader = $loader;
        $this->configProvider = $configProvider;
    }

    /**
     * @inheritdoc
     *
     * @param AbstractElement $element
     *
     * @return string
     */
    public function render(AbstractElement $element): string
    {
        return $this->toHtml();
    }

    /**
     * Used to confirm usage of the module (not used)
     *
     * @return string
     * @throws LocalizedException
     */
    public function getPxParams(): string
    {
        $modules = $this->loader->load();
        $v = $this->configProvider->getExtensionVersion();
        $extension = "Usersnap;{$v}";
        $mageEdition = $this->metaData->getEdition();
        switch ($mageEdition) {
            case 'Community':
                $mageEdition = 'CE';
                break;
            case 'Enterprise':
                $mageEdition = 'EE';
                break;
        }
        $mageVersion = $this->metaData->getVersion();
        $mage = "Magento {$mageEdition};{$mageVersion}";
        $hash = hash('sha256', $extension . '_' . $mage . '_' . $extension);
        return "ext=$extension&mage={$mage}&ctrl={$hash}";
    }

    /**
     * Retrieve the module version number
     *
     * @return string
     */
    public function getVersion(): string
    {
        return $this->configProvider->getExtensionVersion();
    }
}
