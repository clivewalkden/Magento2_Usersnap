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
use Magento\Backend\Model\Auth\Session;
use Magento\Framework\App\State;
use Magento\Framework\View\Element\Template\Context;

class Backend extends Display
{
    /**
     * @var Session
     */
    private $authSession;

    /**
     * @param Context $context
     * @param ConfigProvider $configProvider
     * @param IpCheckerService $ipCheckerService
     * @param State $state
     * @param Session $authSession
     * @param array $data
     */
    public function __construct(
        Context $context,
        ConfigProvider $configProvider,
        IpCheckerService $ipCheckerService,
        State $state,
        Session $authSession,
        array $data = []
    ) {
        parent::__construct($context, $configProvider, $ipCheckerService, $state, $data);
        $this->authSession = $authSession;
    }

    /**
     * Return current admin user information
     *
     * @return \Magento\User\Model\User|null
     */
    protected function getCurrentUser(): ?\Magento\User\Model\User
    {
        return $this->authSession->getUser();
    }

    /**
     * @inheritdoc
     *
     * @return array|array[]
     */
    public function prepareConfig(): array
    {
        $config = parent::prepareConfig();
        if ($this->getCurrentUser() && $this->configProvider->isBackendCaptureUserData()) {
            $config['user'] = [
                'userId' => $this->getCurrentUser()->getId(),
                'email' => $this->getCurrentUser()->getEmail(),
                'role' => $this->getCurrentUser()->getRole()->getRoleName(),
            ];
        }

        if ($this->configProvider->isBackendDeactivateTracking()) {
            $config['collectGeoLocation'] = 'none';
        }

        if ($this->configProvider->isBackendDeactivateLocalStorage()) {
            $config['useLocalStorage'] = false;
        }

        return $this->jsConfig = array_merge($this->jsConfig, $config);
    }

    /**
     * @inheritdoc
     *
     * @return string
     */
    public function _toHtml(): string
    {
        if ($this->configProvider->isBackendEnabled()) {
            return parent::_toHtml();
        }

        return '';
    }
}
