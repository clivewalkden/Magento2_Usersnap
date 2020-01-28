<?php
/**
 * SOZO Design Ltd
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the SOZO Proprietary EULA
 * that is bundled with this package in the file LICENSE.
 * It is also available through the world-wide-web at this URL:
 * https://sozodesign.co.uk/magento/license.php
 *
 * @category    SOZO Design Ltd
 * @package     Sozo_Verifone
 * @copyright   Copyright (c) 2020 SOZO Design Ltd (https://sozodesign.co.uk)
 * @license     https://sozodesign.co.uk/magento/license.php  SOZO Proprietary EULA
 */

namespace CliveWalkden\Usersnap\Model\Config\Source;


use Magento\Framework\Data\OptionSourceInterface;

class Area implements OptionSourceInterface
{
    /**
     * Options getter
     *
     * @return array
     */
    public function toOptionArray()
    {
        return [
            ['value' => \Magento\Framework\App\Area::AREA_GLOBAL, 'label' => __('All')],
            ['value' => \Magento\Framework\App\Area::AREA_FRONTEND, 'label' => __('Frontend only')],
            ['value' => \Magento\Framework\App\Area::AREA_ADMINHTML, 'label' => __('Adminhtml only')]
        ];
    }

}