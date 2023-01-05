<?php
/**
 * Copyright © Risecommerce (support@risecommerce.com). All rights reserved.
 * 
 *
 * Glory to Ukraine! Glory to the heroes!
 */
namespace Risecommerce\Blog\Model\Config\Source;

class BlogPages implements \Magento\Framework\Option\ArrayInterface
{
    /**
     * Options int
     *
     * @return array
     */
    public function toOptionArray()
    {
        return  [
            ['value' => \Risecommerce\Blog\Model\Config::CANONICAL_PAGE_TYPE_NONE, 'label' => __('Please select')],
            ['value' => \Risecommerce\Blog\Model\Config::CANONICAL_PAGE_TYPE_ALL, 'label' => __('All Blog Pages')],
            ['value' => \Risecommerce\Blog\Model\Config::CANONICAL_PAGE_TYPE_INDEX, 'label' => __('Blog Index Page')],
            ['value' => \Risecommerce\Blog\Model\Config::CANONICAL_PAGE_TYPE_POST, 'label' => __('Blog Post Page')],
            ['value' => \Risecommerce\Blog\Model\Config::CANONICAL_PAGE_TYPE_CATEGORY, 'label' => __('Blog Category Page')],
            ['value' => \Risecommerce\Blog\Model\Config::CANONICAL_PAGE_TYPE_AUTHOR, 'label' => __('Blog Author Page')],
            ['value' => \Risecommerce\Blog\Model\Config::CANONICAL_PAGE_TYPE_ARCHIVE, 'label' => __('Blog Archive Page')],
            ['value' => \Risecommerce\Blog\Model\Config::CANONICAL_PAGE_TYPE_TAG, 'label' => __('Blog Tag Page')],
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
