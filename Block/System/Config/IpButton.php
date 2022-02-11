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

namespace CliveWalkden\Usersnap\Block\System\Config;

use Magento\Backend\Block\Template\Context;
use Magento\Backend\Block\Widget\Button;
use Magento\Config\Block\System\Config\Form\Field;
use Magento\Framework\Data\Form\Element\AbstractElement;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\HTTP\PhpEnvironment\RemoteAddress;
use Magento\Framework\View\Helper\Js as JsHelper;

class IpButton extends Field
{
    const WHITELIST_DOM_ID = 'clivewalkden_usersnap_ip_whitelist_whitelist';

    /**
     * @var JsHelper
     */
    protected $jsHelper;

    /**
     * @var RemoteAddress
     */
    private $remoteAddress;

    /**
     * @param Context $context
     * @param JsHelper $jsHelper
     * @param RemoteAddress $remoteAddress
     * @param array $data
     */
    public function __construct(Context $context, JsHelper $jsHelper, RemoteAddress $remoteAddress, array $data = [])
    {
        $this->jsHelper = $jsHelper;
        $this->remoteAddress = $remoteAddress;

        parent::__construct($context, $data);
    }

    /**
     * @param AbstractElement $element
     * @return string
     */
    public function render(AbstractElement $element): string
    {
        $html = parent::render($element);

        return $html . $this->_getAdditionalJs($element);
    }

    /**
     * @param AbstractElement $element
     * @return string
     * @throws LocalizedException
     */
    public function _getElementHtml(AbstractElement $element): string
    {
        $button = $this->getLayout()->createBlock(Button::class);

        $button->setData([
            'id' => $element->getHtmlId(),
            'label' => 'Add IP Address'
        ]);

        return $button->toHtml();
    }

    /**
     * @return string
     */
    protected function getWhitelistDOMId(): string
    {
        return self::WHITELIST_DOM_ID;
    }

    /**
     * @return false|string
     */
    public function getCurrentIpAddress()
    {
        return $this->remoteAddress->getRemoteAddress();
    }

    /**
     * @param AbstractElement $element
     * @return string
     */
    protected function _getAdditionalJs(AbstractElement $element): string
    {
        $output = <<<JS
            require(['jquery'], function($) {
                $(function() {
                    var button = $('#{$element->getHtmlId()}');
                    var currentIp = '{$this->getCurrentIpAddress()}';
                    var whitelist = $('#{$this->getWhitelistDOMId()}');

                    button.on('click', function(){
                        if (whitelist.val().includes(currentIp)) {
                            alert('That IP Address is already in the list!');
                        } else if (!whitelist.val()) {
                            whitelist.val(currentIp);
                        } else {
                            var existing = whitelist.val();
                            whitelist.val(existing + "\\n" + currentIp);
                        }
                    });
                });
            });
JS;

        return $this->jsHelper->getScript($output);
    }
}
