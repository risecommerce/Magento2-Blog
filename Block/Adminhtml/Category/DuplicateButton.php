<?php
/**
 * Copyright © Risecommerce (support@risecommerce.com). All rights reserved.
 * 
 *
 * Glory to Ukraine! Glory to the heroes!
 */

namespace Risecommerce\Blog\Block\Adminhtml\Category;

/**
 * Class Duplicate Button Block
 */
class DuplicateButton extends \Risecommerce\Core\Block\Adminhtml\Edit\DuplicateButton
{
    /**
     * @return array|string
     */
    public function getButtonData()
    {
        if (!$this->authorization->isAllowed("Risecommerce_Blog::category_save")) {
            return [];
        }
        return parent::getButtonData();
    }
}
