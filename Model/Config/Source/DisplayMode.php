<?php
/**
 * Copyright © 2015-17 Risecommerce (support@risecommerce.com). All rights reserved.
 * 
 *
 * Glory to Ukraine! Glory to the heroes!
 */

namespace Risecommerce\Blog\Model\Config\Source;

/**
 * Comment statuses
 */
class DisplayMode implements \Magento\Framework\Option\ArrayInterface
{
    /**
     * @const string
     */
    const PENDING = 0;

    /**
     * @const int
     */
    const APPROVED = 1;

    /**
     * @const int
     */
    const BLANK = 2;
    
    /**
     * Options int
     *
     * @return array
     */
    public function toOptionArray()
    {
        return  [
            ['value' => self::PENDING, 'label' => __('Recent Blog Posts')],
            ['value' => self::APPROVED, 'label' => __('Featured Blog Posts')],
            ['value' => self::BLANK, 'label' => __('Blank (Use widgets to build the page content)')],

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
