<?php
/**
 * Copyright © Risecommerce (support@risecommerce.com). All rights reserved.
 * 
 *
 * Glory to Ukraine! Glory to the heroes!
 */

namespace Risecommerce\Blog\Block\Post\PostList;

use Magento\Store\Model\ScopeInterface;
use Magento\Framework\Api\SortOrder;
use \Magento\Framework\View\Element\Template;
use \Magento\Framework\DataObject\IdentityInterface;

/**
 * Abstract blog post list block
 */
abstract class AbstractList extends Template implements IdentityInterface
{
    /**
     * @var \Magento\Cms\Model\Template\FilterProvider
     */
    protected $_filterProvider;

    /**
     * @var \Magento\Cms\Model\Page
     */
    protected $_post;

    /**
     * @var \Magento\Framework\Registry
     */
    protected $_coreRegistry;

    /**
     * @var \Risecommerce\Blog\Model\ResourceModel\Post\CollectionFactory
     */
    protected $_postCollectionFactory;

    /**
     * @var \Risecommerce\Blog\Model\ResourceModel\Post\Collection
     */
    protected $_postCollection;

    /**
     * @var \Risecommerce\Blog\Model\Url
     */
    protected $_url;

    /**
     * @var \Risecommerce\Blog\Model\Config
     */
    protected $config;

    /**
     * @var \Risecommerce\Blog\Model\TemplatePool
     */
    protected $templatePool;

    const POSTS_SORT_FIELD_BY_PUBLISH_TIME = 'publish_time';
    const POSTS_SORT_FIELD_BY_POSITION = 'position';
    const POSTS_SORT_FIELD_BY_TITLE = 'title';

    /**
     * AbstractList constructor.
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param \Magento\Framework\Registry $coreRegistry
     * @param \Magento\Cms\Model\Template\FilterProvider $filterProvider
     * @param \Risecommerce\Blog\Model\ResourceModel\Post\CollectionFactory $postCollectionFactory
     * @param \Risecommerce\Blog\Model\Url $url
     * @param array $data
     * @param null $config
     * @param null $templatePool
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Framework\Registry $coreRegistry,
        \Magento\Cms\Model\Template\FilterProvider $filterProvider,
        \Risecommerce\Blog\Model\ResourceModel\Post\CollectionFactory $postCollectionFactory,
        \Risecommerce\Blog\Model\Url $url,
        array $data = [],
        $config = null,
        $templatePool = null
    ) {
        parent::__construct($context, $data);
        $this->_coreRegistry = $coreRegistry;
        $this->_filterProvider = $filterProvider;
        $this->_postCollectionFactory = $postCollectionFactory;
        $this->_url = $url;

        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $this->config = $config ?: $objectManager->get(
            \Risecommerce\Blog\Model\Config::class
        );
        $this->templatePool = $templatePool ?: $objectManager->get(
            \Risecommerce\Blog\Model\TemplatePool::class
        );
    }

    /**
     * Prepare posts collection
     *
     * @return void
     */
    protected function _preparePostCollection()
    {
        $this->_postCollection = $this->_postCollectionFactory->create()
            ->addActiveFilter()
            ->addStoreFilter($this->_storeManager->getStore()->getId())
            ->setOrder($this->getCollectionOrderField(), $this->getCollectionOrderDirection());

        if ($this->getPageSize()) {
            $this->_postCollection->setPageSize($this->getPageSize());
        }
    }

    /**
     * Retrieve collection order field
     *
     * @return string
     */
    public function getCollectionOrderField()
    {
        return self::POSTS_SORT_FIELD_BY_PUBLISH_TIME;
    }

    /**
     * Retrieve collection order direction
     *
     * @return string
     */
    public function getCollectionOrderDirection()
    {
        return SortOrder::SORT_DESC;
    }

    /**
     * Prepare posts collection
     *
     * @return \Risecommerce\Blog\Model\ResourceModel\Post\Collection
     */
    public function getPostCollection()
    {
        if (null === $this->_postCollection) {
            $this->_preparePostCollection();
        }

        return $this->_postCollection;
    }

    /**
     * Render block HTML
     *
     * @return string
     */
    protected function _toHtml()
    {
        if (!$this->_scopeConfig->getValue(
            \Risecommerce\Blog\Model\Config::XML_PATH_EXTENSION_ENABLED,
            ScopeInterface::SCOPE_STORE
        )) {
            return '';
        }

        return parent::_toHtml();
    }

    /**
     * Retrieve identities
     *
     * @return array
     */
    public function getIdentities()
    {
        $identities = [];
        $identities[] = \Risecommerce\Blog\Model\Post::CACHE_TAG . '_' . 0;
        foreach ($this->getPostCollection() as $item) {
            $identities = array_merge($identities, $item->getIdentities());
        }

        return array_unique($identities);
    }

    /**
     * Get cache key informative items
     *
     * @return array
     */
    public function getCacheKeyInfo()
    {
        return array_merge(
            parent::getCacheKeyInfo(),
            [$this->getNameInLayout()]
        );
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

    /**
     * @return \Risecommerce\Blog\ViewModel\Style
     */
    public function getStyleViewModel()
    {
        $viewModel = $this->getData('style_view_model');
        if (!$viewModel) {
            $viewModel = \Magento\Framework\App\ObjectManager::getInstance()
                ->get(\Risecommerce\Blog\ViewModel\Style::class);
            $this->setData('style_view_model', $viewModel);
        }

        return $viewModel;
    }
}
