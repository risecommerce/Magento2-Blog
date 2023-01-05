<?php
/**
 * Copyright © Risecommerce (support@risecommerce.com). All rights reserved.
 * 
 *
 * Glory to Ukraine! Glory to the heroes!
 */

namespace Risecommerce\Blog\Block\Post\View;

use \Risecommerce\Blog\Block\Post\AbstractPost;

/**
 * Class Views Counter Block
 */
class ViewsCount extends AbstractPost
{
    /**
     * Retrieve counter controller url
     * @return string
     */
    public function getCounterUrl()
    {
        return $this->getUrl('blog/post/viewscount', [
            'id' => $this->getPost()->getId()
        ]);
    }

    /**
     * Render block HTML
     *
     * @return string
     */
    protected function _toHtml()
    {
        if ($this->_scopeConfig->getValue(
            'rcblog/post_view/views_count/enabled',
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        )) {
            return parent::_toHtml();
        }
        return '';
    }
}
