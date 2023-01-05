<?php
/**
 * Copyright © Risecommerce (support@risecommerce.com). All rights reserved.
 * 
 *
 * Glory to Ukraine! Glory to the heroes!
 */

namespace Risecommerce\Blog\Block\Adminhtml\Category;

/**
 * Class Delete Button Block
 */
class DeleteButton extends \Risecommerce\Core\Block\Adminhtml\Edit\DeleteButton
{
    /**
     * @return array|string
     */
    public function getButtonData()
    {
        if (!$this->authorization->isAllowed("Risecommerce_Blog::category_delete")) {
            return [];
        }
        return parent::getButtonData();
    }
}
