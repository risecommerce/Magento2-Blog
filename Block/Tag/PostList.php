<?php
/**
 * Copyright © Risecommerce (support@risecommerce.com). All rights reserved.
 * 
 *
 * Glory to Ukraine! Glory to the heroes!
 */

namespace Risecommerce\Blog\Block\Tag;

use Risecommerce\Blog\Block\Post\PostList\Toolbar;
use Magento\Store\Model\ScopeInterface;

/**
 * Blog tag posts list
 */
class PostList extends \Risecommerce\Blog\Block\Post\PostList
{
    /**
     * Prepare posts collection
     *
     * @return void
     */
    protected function _preparePostCollection()
    {
        parent::_preparePostCollection();
        if ($tag = $this->getTag()) {
            $this->_postCollection->addTagFilter($tag);
        }
    }

    /**
     * Retrieve tag instance
     *
     * @return \Risecommerce\Blog\Model\Tag
     */
    public function getTag()
    {
        return $this->_coreRegistry->registry('current_blog_tag');
    }

    /**
     * Preparing global layout
     *
     * @return $this
     */
    protected function _prepareLayout()
    {
        if ($tag = $this->getTag()) {
            $this->_addBreadcrumbs($tag->getTitle(), 'blog_tag');
            $this->pageConfig->addBodyClass('blog-tag-' . $tag->getIdentifier());
            $this->pageConfig->getTitle()->set($tag->getMetaTitle());
            $this->pageConfig->setKeywords($tag->getMetaKeywords());
            $this->pageConfig->setDescription($tag->getMetaDescription());
            /*
            $page = $this->_request->getParam(\Risecommerce\Blog\Block\Post\PostList\Toolbar::PAGE_PARM_NAME);
            if ($page < 2) {
            */
                $robots = $tag->getData('meta_robots');
                if ($robots) {
                    $this->pageConfig->setRobots($robots);
                } else {
                    $robots = $this->config->getTagRobots();
                    $this->pageConfig->setRobots($robots);
                }
            /*
            }

            if ($page > 1) {
                $this->pageConfig->setRobots('NOINDEX,FOLLOW');
            }
            */

            if ($this->config->getDisplayCanonicalTag(\Risecommerce\Blog\Model\Config::CANONICAL_PAGE_TYPE_TAG)) {

                $canonicalUrl = $tag->getTagUrl();
                $page = (int)$this->_request->getParam(Toolbar::PAGE_PARM_NAME);
                if ($page > 1) {
                    $canonicalUrl .= ((false === strpos($canonicalUrl, '?')) ? '?' : '&')
                        . Toolbar::PAGE_PARM_NAME . '=' . $page;
                }

                $this->pageConfig->addRemotePageAsset(
                    $canonicalUrl,
                    'canonical',
                    ['attributes' => ['rel' => 'canonical']]
                );
            }

            $pageMainTitle = $this->getLayout()->getBlock('page.main.title');
            if ($pageMainTitle) {
                $pageMainTitle->setPageTitle(
                    $this->escapeHtml($tag->getTitle())
                );
            }
        }

        return parent::_prepareLayout();
    }

    /**
     * Get template type
     *
     * @return string
     */
    public function getPostTemplateType()
    {
        $template = (string)$this->getTag()->getData('posts_list_template');
        if ($template) {
            return $template;
        }

        return parent::getPostTemplateType();
    }

    /**
     * Retrieve Toolbar Block
     * @return \Risecommerce\Blog\Block\Post\PostList\Toolbar
     */
    public function getToolbarBlock()
    {
        $toolBarBlock = parent::getToolbarBlock();
        $limit = (int)$this->getTag()->getData('posts_per_page');

        if ($limit) {
            $toolBarBlock->setData('limit', $limit);
        }

        return $toolBarBlock;
    }
}
