<?php
/**
 * Copyright © Risecommerce (support@risecommerce.com). All rights reserved.
 * 
 *
 * Glory to Ukraine! Glory to the heroes!
 */

namespace Risecommerce\Blog\Block\Sidebar;

/**
 * Blog sidebar categories block
 */
class Recent extends \Risecommerce\Blog\Block\Post\PostList\AbstractList
{
    use Widget;

    /**
     * @var string
     */
    protected $_widgetKey = 'recent_posts';

    /**
     * @return $this
     */
    public function _construct()
    {
        $this->setPageSize(
            (int) $this->_scopeConfig->getValue(
                'rcblog/sidebar/'.$this->_widgetKey.'/posts_per_page',
                \Magento\Store\Model\ScopeInterface::SCOPE_STORE
            )
        );
        return parent::_construct();
    }

    /**
     * Prepare posts collection
     *
     * @return void
     */
    protected function _preparePostCollection()
    {
        parent::_preparePostCollection();
        $this->_postCollection->addRecentFilter();
    }

    /**
     * Retrieve true if display the post image is enabled in the config
     * @return bool
     */
    public function getDisplayImage()
    {
        return (bool)$this->_scopeConfig->getValue(
            'rcblog/sidebar/'.$this->_widgetKey.'/display_image',
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
    }

    /**
     * Get relevant path to template
     *
     * @return string
     */
    public function getTemplate()
    {
        $templateName = (string)$this->_scopeConfig->getValue(
            'rcblog/sidebar/'.$this->_widgetKey.'/template',
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
        if ($template = $this->templatePool->getTemplate('blog_post_sidebar_posts', $templateName)) {
            $this->_template = $template;
        }
        return parent::getTemplate();
    }
}
