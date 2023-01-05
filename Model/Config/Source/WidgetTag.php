<?php
/**
 * Copyright © Risecommerce (support@risecommerce.com). All rights reserved.
 * 
 *
 * Glory to Ukraine! Glory to the heroes!
 */

namespace Risecommerce\Blog\Model\Config\Source;

/**
 * Used in recent post widget
 *
 */
class WidgetTag extends Tag
{
    /**
     * Options getter
     *
     * @return array
     */
    public function toOptionArray()
    {
        if ($this->options === null) {
            parent::toOptionArray();
            array_unshift($this->options, ['label' => __('Please select'), 'value' => 0]);
        }

        return $this->options;
    }
}
