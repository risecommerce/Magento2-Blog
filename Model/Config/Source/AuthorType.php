<?php
/**
 * Copyright © Risecommerce (support@risecommerce.com). All rights reserved.
 * 
 *
 * Glory to Ukraine! Glory to the heroes!
 */

namespace Risecommerce\Blog\Model\Config\Source;

/**
 * Authors types
 *
 */
class AuthorType implements \Magento\Framework\Option\ArrayInterface
{
    /**
     * @const string
     */
    const GUEST = 0;

    /**
     * @const string
     */
    const CUSTOMER = 1;

    /**
     * @const string
     */
    const ADMIN = 2;

    /**
     * Options getter
     *
     * @return array
     */
    public function toOptionArray()
    {
        return [
            ['value' => self::GUEST, 'label' => __('Guest')],
            ['value' => self::CUSTOMER, 'label' => __('Customer')],
            ['value' => self::ADMIN, 'label' => __('Admin')],
        ];
    }

    /**
     * Get options in "key-value" format
     *
     * @return array
     */
    public function toArray()
    {
        $array = [];
        foreach ($this->toOptionArray() as $item) {
            $array[$item['value']] = $item['label'];
        }
        return $array;
    }
}
