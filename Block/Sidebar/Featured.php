<?php
/**
 * Copyright © Risecommerce (support@risecommerce.com). All rights reserved.
 * 
 *
 * Glory to Ukraine! Glory to the heroes!
 */

declare(strict_types=1);

namespace Risecommerce\Blog\Block\Sidebar;

/**
 * Blog sidebar categories block
 */
class Featured extends \Risecommerce\Blog\Block\Post\PostList\AbstractList
{
    use Widget;

    /**
     * @var string
     */
    protected $_widgetKey = 'featured_posts';

    /**
     * Prepare posts collection
     *
     * @return void
     */
    protected function _preparePostCollection()
    {
        parent::_preparePostCollection();
        $this->_postCollection->addPostsFilter(
            $this->getPostIdsConfigValue()
        );

        $ids = [];
        foreach (explode(',', $this->getPostIdsConfigValue()) as $id) {
            $id = (int)trim($id);
            if ($id) {
                $ids[] = $id;
            }
        }

        if ($ids) {
            $ids = implode(',', $ids);
            $this->_postCollection->getSelect()->order(
                new \Zend_Db_Expr('FIELD(`main_table`.`post_id`,' . $ids .')')
            );
        }
    }

    /**
     * Retrieve post ids string
     * @return string
     */
    protected function getPostIdsConfigValue()
    {
        return (string)$this->_scopeConfig->getValue(
            'rcblog/sidebar/'.$this->_widgetKey.'/posts_ids',
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
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
