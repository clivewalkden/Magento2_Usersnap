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

namespace CliveWalkden\Usersnap\Block;

use CliveWalkden\Usersnap\Model\ConfigProvider;
use CliveWalkden\Usersnap\Service\IpCheckerService;
use Magento\Framework\App\State;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;

class Display extends Template
{
    /**
     * @var ConfigProvider
     */
    protected $configProvider;

    /**
     * @var IpCheckerService
     */
    protected $ipChecker;
    /**
     * @var State
     */
    private $state;

    /**
     * @var array
     */
    protected $jsConfig = [];

    /**
     * @param Context $context
     * @param ConfigProvider $configProvider
     * @param IpCheckerService $ipCheckerService
     * @param State $state
     * @param array $data
     */
    public function __construct(
        Context $context,
        ConfigProvider $configProvider,
        IpCheckerService $ipCheckerService,
        State $state,
        array $data = []
    ) {
        $this->configProvider = $configProvider;
        $this->ipChecker = $ipCheckerService;
        $this->state = $state;

        parent::__construct($context, $data);
    }

    /**
     * Get the Widget ID
     *
     * @return string|null
     */
    public function getGlobalApiKey(): ?string
    {
        return $this->configProvider->getGlobalApiKey();
    }

    /**
     * Get the Project API Key
     *
     * @return mixed
     */
    public function getProjectApiKey(): ?string
    {
        return $this->configProvider->getProjectApiKey();
    }

    /**
     * Prepare the api configuration
     *
     * @return array[]
     */
    public function prepareConfig(): array
    {
        $config = [
            'custom' => [
                'capturedBy' => 'Magento 2 Usersnap Module: ' . $this->configProvider->getExtensionVersion(),
                'magentoDeployMode' => $this->state->getMode()
            ]
        ];

        if ($this->configProvider->isDeactivateGoogleFonts()) {
            $config['useSystemFonts'] = true;
        }

        return $this->jsConfig = $config;
    }

    /**
     * Return the JSON encoded api configuration
     *
     * @return string
     */
    public function getJsConfig(): string
    {
        $this->prepareConfig();
        return json_encode($this->jsConfig, JSON_FORCE_OBJECT);
    }

    /**
     * Generate the Usersnap output
     *
     * @return string
     */
    public function _toHtml(): string
    {
        $enabled = $this->configProvider->isEnabled();
        $ipAllowed = $this->ipChecker->checkAllowed();

        return ($enabled && $ipAllowed) ? parent::_toHtml() : '';
    }
}
