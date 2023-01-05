<?php
/**
 * Copyright © Risecommerce (support@risecommerce.com). All rights reserved.
 * 
 *
 * Glory to Ukraine! Glory to the heroes!
 */

namespace Risecommerce\Blog\Model\Config\Source;

use Magento\Config\Model\Config\Source\Design\Robots;

/**
 * Class Tag Robots Model
 */
class TagRobots extends Robots
{
    /**
     * @return array
     */
    public function toOptionArray()
    {
        $options = parent::toOptionArray();
        array_unshift($options, ['value' => '', 'label' => 'Use config settings']);
        return $options;
    }
}
