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

namespace CliveWalkden\Usersnap\Block\System\Config\Form\Field;

use CliveWalkden\Usersnap\Model\ConfigProvider;
use Magento\Backend\Block\Template\Context;
use Magento\Config\Block\System\Config\Form\Field;
use Magento\Framework\Data\Form\Element\AbstractElement;

class Version extends Field
{
    public const EXTENSION_URL = 'https://github.com/clivewalkden/Magento2_Usersnap';

    /**
     * @var ConfigProvider $configProvider
     */
    protected $configProvider;

    /**
     * @param Context $context
     * @param ConfigProvider $configProvider
     */
    public function __construct(
        Context $context,
        ConfigProvider $configProvider
    ) {
        $this->configProvider = $configProvider;
        parent::__construct($context);
    }

    /**
     * @inheritdoc
     *
     * @param AbstractElement $element
     *
     * @return string
     */
    protected function _getElementHtml(AbstractElement $element): string
    {
        $extensionVersion = $this->configProvider->getExtensionVersion();
        $extensionTitle = 'Clive Walkden - Usersnap';
        $versionLabel = sprintf(
            '<a href="%s" title="%s" target="_blank">%s</a>',
            self::EXTENSION_URL,
            $extensionTitle,
            $extensionVersion
        );
        $element->setValue($versionLabel);

        return $element->getValue();
    }
}
