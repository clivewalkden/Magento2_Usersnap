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

class ConfigProvider extends ConfigProviderAbstract
{
    /**
     * xpath prefix of module (section)
     * @var string '{section}/'
     */
    protected $pathPrefix = 'clivewalkden_usersnap/';

    /**
     * @var string
     */
    protected $moduleCode = 'CliveWalkden_Usersnap';

    private const CFG_USERSNAP_ENABLED = 'general/enabled';
    private const CFG_USERSNAP_GLOBAL_API_KEY = 'general/global_api_key';
    private const CFG_USERSNAP_PROJECT_API_KEY = 'general/project_api_key';
    private const CFG_USERSNAP_DEACTIVATE_GOOGLEFONTS = 'general/deactivate_googlefonts';

    private const CFG_USERSNAP_FRONTEND_ENABLED = 'frontend/enabled';
    private const CFG_USERSNAP_FRONTEND_DEACTIVATE_TRACKING = 'frontend/deactivate_tracking';
    private const CFG_USERSNAP_FRONTEND_DEACTIVATE_LOCALSTORAGE = 'frontend/deactivate_localstorage';
    private const CFG_USERSNAP_FRONTEND_CAPTURE_USER_DATA = 'frontend/capture_user_data';

    private const CFG_USERSNAP_BACKEND_ENABLED = 'backend/enabled';
    private const CFG_USERSNAP_BACKEND_DEACTIVATE_TRACKING = 'backend/deactivate_tracking';
    private const CFG_USERSNAP_BACKEND_DEACTIVATE_LOCALSTORAGE = 'backend/deactivate_localstorage';
    private const CFG_USERSNAP_BACKEND_CAPTURE_USER_DATA = 'backend/capture_user_data';

    private const CFG_USERSNAP_WHITELIST_ENABLED = 'ip_whitelist/enabled';
    private const CFG_USERSNAP_WHITELIST_WHITELIST = 'ip_whitelist/whitelist';

    /**
     * Is the module enabled
     *
     * @param int|null $storeId
     * @return bool
     */
    public function isEnabled(int $storeId = null): bool
    {
        return $this->isSetFlag(self::CFG_USERSNAP_ENABLED, $storeId);
    }

    /**
     * Retrieve the Global API Key
     *
     * @param int|null $storeId
     * @return string
     */
    public function getGlobalApiKey(int $storeId = null): string
    {
        return $this->validateGlobalApiKey($storeId);
    }

    /**
     * Retrieve the Project API key
     *
     * @param int|null $storeId
     * @return string|null
     */
    public function getProjectApiKey(int $storeId = null): ?string
    {
        return $this->getValue(self::CFG_USERSNAP_PROJECT_API_KEY, $storeId);
    }

    /**
     * Are Google fonts disabled from the widgets
     *
     * @param int|null $storeId
     * @return bool
     */
    public function isDeactivateGoogleFonts(int $storeId = null): bool
    {
        return $this->isSetFlag(self::CFG_USERSNAP_DEACTIVATE_GOOGLEFONTS, $storeId);
    }

    /**
     * Is the frontend widget enabled
     *
     * @param int|null $storeId
     * @return bool
     */
    public function isFrontendEnabled(int $storeId = null): bool
    {
        return $this->isSetFlag(self::CFG_USERSNAP_FRONTEND_ENABLED, $storeId);
    }

    /**
     * Is the frontend widget localStorage disabled
     *
     * @param int|null $storeId
     * @return bool
     */
    public function isFrontendDeactivateTracking(int $storeId = null): bool
    {
        return $this->isSetFlag(self::CFG_USERSNAP_FRONTEND_DEACTIVATE_TRACKING, $storeId);
    }

    /**
     * Is the frontend widget localStorage disabled
     *
     * @param int|null $storeId
     * @return bool
     */
    public function isFrontendDeactivateLocalStorage(int $storeId = null): bool
    {
        return $this->isSetFlag(self::CFG_USERSNAP_FRONTEND_DEACTIVATE_LOCALSTORAGE, $storeId);
    }

    /**
     * Can the frontend widget capture user data and send it to Usersnap
     *
     * @param int|null $storeId
     * @return bool
     */
    public function isFrontendCaptureUserData(int $storeId = null): bool
    {
        return $this->isSetFlag(self::CFG_USERSNAP_FRONTEND_CAPTURE_USER_DATA, $storeId);
    }

    /**
     * Is the backend widget enabled
     *
     * @param int|null $storeId
     * @return bool
     */
    public function isBackendEnabled(int $storeId = null): bool
    {
        return $this->isSetFlag(self::CFG_USERSNAP_BACKEND_ENABLED, $storeId);
    }

    /**
     * Is the backend widget GEOIP location tracking disabled
     *
     * @param int|null $storeId
     * @return bool
     */
    public function isBackendDeactivateTracking(int $storeId = null): bool
    {
        return $this->isSetFlag(self::CFG_USERSNAP_BACKEND_DEACTIVATE_TRACKING, $storeId);
    }

    /**
     * Is the backend widget localStorage disabled
     *
     * @param int|null $storeId
     * @return bool
     */
    public function isBackendDeactivateLocalStorage(int $storeId = null): bool
    {
        return $this->isSetFlag(self::CFG_USERSNAP_BACKEND_DEACTIVATE_LOCALSTORAGE, $storeId);
    }

    /**
     * Can the backend widget capture user data and send it to Usersnap
     *
     * @param int|null $storeId
     * @return bool
     */
    public function isBackendCaptureUserData(int $storeId = null): bool
    {
        return $this->isSetFlag(self::CFG_USERSNAP_BACKEND_CAPTURE_USER_DATA, $storeId);
    }

    /**
     * Check if the whitelist is enabled
     *
     * @param int|null $storeId
     * @return bool
     */
    public function getWhitelistEnabled(int $storeId = null): bool
    {
        return $this->isSetFlag(self::CFG_USERSNAP_WHITELIST_ENABLED, $storeId);
    }

    /**
     * Retrieve the whitelist
     *
     * @param int|null $storeId
     * @return string
     */
    public function getWhitelist(int $storeId = null): string
    {
        return ($this->getValue(self::CFG_USERSNAP_WHITELIST_WHITELIST, $storeId) ?? '');
    }

    /**
     * Check that the string doesn't contain a .js extension
     *
     * @param int|null $storeId
     * @return string
     */
    protected function validateGlobalApiKey(?int $storeId): string
    {
        $apiKey = $this->getValue(self::CFG_USERSNAP_GLOBAL_API_KEY, $storeId);

        // Remove and .js from legacy widget_id
        if (substr_compare($apiKey, '.js', -3, 3, true) === 0) {
            $apiKey = substr($apiKey, 0, -3);
        }

        return $apiKey ?? '';
    }
}
