<?php
/**
 * Copyright © Risecommerce (support@risecommerce.com). All rights reserved.
 * 
 *
 * Glory to Ukraine! Glory to the heroes!
 */

namespace Risecommerce\Blog\Block\Post;

use Magento\Store\Model\ScopeInterface;

/**
 * Blog post info block
 */
class Info extends \Magento\Framework\View\Element\Template
{
    /**
     * Block template file
     * @var string
     */
    protected $_template = 'Risecommerce_Blog::post/info.phtml';

    /**
     * Retrieve formated posted date
     * @var string
     * @deprecated Use $post->getPublishDate() instead
     * @return string
     */
    public function getPostedOn($format = 'Y-m-d H:i:s')
    {
        return $this->getPost()->getPublishDate($format);
    }

    /**
     * Retrieve 1 if display author information is enabled
     * @return int
     */
    public function authorEnabled()
    {
        return (int) $this->_scopeConfig->getValue(
            'rcblog/author/enabled',
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
    }

    /**
     * Retrieve 1 if author page is enabled
     * @return int
     */
    public function authorPageEnabled()
    {
        return (int) $this->_scopeConfig->getValue(
            'rcblog/author/page_enabled',
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
    }

    /**
     * Retrieve true if risecommerce comments are enabled
     * @return bool
     */
    public function risecommerceCommentsEnabled()
    {
        return $this->_scopeConfig->getValue(
            'rcblog/post_view/comments/type',
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        ) == \Risecommerce\Blog\Model\Config\Source\CommetType::MAGEFAN;
    }

    /**
     * @return bool
     */
    public function viewsCountEnabled()
    {
        return (bool)$this->_scopeConfig->getValue(
            'rcblog/post_view/views_count/enabled',
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
    }
}
