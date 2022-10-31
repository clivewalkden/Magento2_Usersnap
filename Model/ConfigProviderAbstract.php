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

namespace CliveWalkden\Usersnap\Model;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\Config\ScopeInterface;
use Magento\Framework\Module\ModuleListInterface;

abstract class ConfigProviderAbstract
{
    /**
     * @var string
     */
    protected $pathPrefix = '/';

    /**
     * @var ScopeConfigInterface
     */
    protected $scopeConfig;

    /**
     * @var ModuleListInterface
     */
    protected $moduleList;

    /**
     * @var array
     */
    protected $data = [];

    /**
     * @var string
     */
    protected $moduleCode;

    /**
     * @param ScopeConfigInterface $scopeConfig
     * @param ModuleListInterface $moduleList
     */
    public function __construct(ScopeConfigInterface $scopeConfig, ModuleListInterface $moduleList)
    {
        $this->scopeConfig = $scopeConfig;
        $this->moduleList = $moduleList;
        if ($this->pathPrefix === '/') {
            throw new \LogicException('$pathPrefix should be declared');
        }
    }

    /**
     * Return the config value
     *
     * @param string $path
     * @param int|ScopeInterface|null $storeId
     * @param string $scopeType
     * @return mixed
     */
    protected function getValue(
        string $path,
        $storeId = null,
        string $scopeType = ScopeConfigInterface::SCOPE_TYPE_DEFAULT
    ): mixed {
        // Global store value
        if ($storeId === null && $scopeType !== ScopeConfigInterface::SCOPE_TYPE_DEFAULT) {
            return $this->scopeConfig->getValue($this->pathPrefix . $path, $scopeType, $storeId);
        }

        if ($storeId instanceof \Magento\Framework\App\ScopeInterface) {
            $storeId = $storeId->getId();
        }
        $scopeKey = $storeId . $scopeType;

        // Store value retrieve and save to cache if not already set
        if (!isset($this->data[$path]) || !\array_key_exists($scopeKey, $this->data[$path])) {
            $this->data[$path][$scopeKey] =
                $this->scopeConfig->getValue($this->pathPrefix . $path, $scopeType, $storeId);
        }

        // Return from prefilled cache
        return $this->data[$path][$scopeKey];
    }

    /**
     * Check if a value is set
     *
     * @param string $path
     * @param int|ScopeInterface|null $storeId
     * @param string $scopeType
     * @return bool
     */
    protected function isSetFlag(
        string $path,
        $storeId = null,
        string $scopeType = ScopeConfigInterface::SCOPE_TYPE_DEFAULT
    ): bool {
        return (bool)$this->getValue($path, $storeId, $scopeType);
    }

    /**
     * Retrieve the extension version
     *
     * @return string
     */
    public function getExtensionVersion(): string
    {
        $moduleInfo = $this->moduleList->getOne($this->moduleCode);
        return $moduleInfo['setup_version'] ?? '0.0.1';
    }
}
