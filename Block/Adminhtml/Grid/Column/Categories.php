<?php
/**
 * Copyright © Risecommerce (support@risecommerce.com). All rights reserved.
 * 
 *
 * Glory to Ukraine! Glory to the heroes!
 */

namespace Risecommerce\Blog\Block\Adminhtml\Grid\Column;

/**
 * Admin blog grid categories
 */
class Categories extends \Magento\Backend\Block\Widget\Grid\Column
{
    /**
     * @return void
     */
    public function _construct()
    {
        parent::_construct();
        $this->_rendererTypes['category'] = \Risecommerce\Blog\Block\Adminhtml\Grid\Column\Render\Category::class;
        $this->_filterTypes['category'] = \Risecommerce\Blog\Block\Adminhtml\Grid\Column\Filter\Category::class;
    }
}
