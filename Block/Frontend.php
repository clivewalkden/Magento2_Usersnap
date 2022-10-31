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
use Magento\Customer\Api\GroupRepositoryInterface;
use Magento\Customer\Model\Session;
use Magento\Framework\App\State;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\View\Element\Template\Context;

class Frontend extends Display
{
    /**
     * @var Session
     */
    private $customerSession;

    /**
     * @var GroupRepositoryInterface
     */
    private $groupRepository;

    /**
     * @param Context $context
     * @param ConfigProvider $configProvider
     * @param IpCheckerService $ipCheckerService
     * @param State $state
     * @param Session $customerSession
     * @param GroupRepositoryInterface $groupRepository
     * @param array $data
     */
    public function __construct(
        Context $context,
        ConfigProvider $configProvider,
        IpCheckerService $ipCheckerService,
        State $state,
        Session $customerSession,
        GroupRepositoryInterface $groupRepository,
        array $data = []
    ) {
        parent::__construct($context, $configProvider, $ipCheckerService, $state, $data);
        $this->customerSession = $customerSession;
        $this->groupRepository = $groupRepository;
    }

    /**
     * Retrieve the customer group name
     *
     * @param int $groupId
     * @return string
     * @throws LocalizedException
     * @throws NoSuchEntityException
     */
    protected function getCustomerGroupName(int $groupId): string
    {
        $groupRepository = $this->groupRepository->getById($groupId);

        return $groupRepository->getCode();
    }

    /**
     * @inheritdoc
     *
     * @return string
     */
    public function _toHtml(): string
    {
        if ($this->configProvider->isFrontendEnabled()) {
            return parent::_toHtml();
        }

        return '';
    }

    /**
     * @inheritdoc
     *
     * @throws NoSuchEntityException
     * @throws LocalizedException
     */
    public function prepareConfig(): array
    {
        $config = parent::prepareConfig();
        if ($this->customerSession->isLoggedIn() && $this->configProvider->isFrontendCaptureUserData()) {
            $config['user'] = [
                'userId' => $this->customerSession->getId(),
                'email' => $this->customerSession->getName(),
                'userGroup' => $this->getCustomerGroupName($this->customerSession->getCustomerGroupId()),
            ];
        }

        if ($this->configProvider->isFrontendDeactivateTracking()) {
            $config['collectGeoLocation'] = 'none';
        }

        if ($this->configProvider->isFrontendDeactivateLocalStorage()) {
            $config['useLocalStorage'] = false;
        }

        return $this->jsConfig = array_merge($this->jsConfig, $config);
    }
}
