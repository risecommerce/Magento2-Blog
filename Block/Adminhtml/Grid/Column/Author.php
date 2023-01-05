<?php
/**
 * Copyright © Risecommerce (support@risecommerce.com). All rights reserved.
 * 
 *
 * Glory to Ukraine! Glory to the heroes!
 */

namespace Risecommerce\Blog\Block\Adminhtml\Grid\Column;

/**
 * Admin blog grid author
 */
class Author extends \Magento\Backend\Block\Widget\Grid\Column
{
    /**
     * @return void
     */
    public function _construct()
    {
        parent::_construct();
        $this->_rendererTypes['author'] = \Risecommerce\Blog\Block\Adminhtml\Grid\Column\Render\Author::class;
        $this->_filterTypes['author'] = \Risecommerce\Blog\Block\Adminhtml\Grid\Column\Filter\Author::class;
    }
}
