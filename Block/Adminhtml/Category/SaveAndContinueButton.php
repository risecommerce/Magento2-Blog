<?php
/**
 * Copyright © Risecommerce (support@risecommerce.com). All rights reserved.
 * 
 *
 * Glory to Ukraine! Glory to the heroes!
 */

namespace Risecommerce\Blog\Block\Adminhtml\Category;

/**
 * Class Save And Continue Button Block
 */
class SaveAndContinueButton extends \Risecommerce\Core\Block\Adminhtml\Edit\SaveAndContinueButton
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
