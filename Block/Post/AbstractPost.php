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
 * Abstract post мшуц block
 */
abstract class AbstractPost extends \Magento\Framework\View\Element\Template
{

    /**
     * Deprecated property. Do not use it.
     * @var \Magento\Cms\Model\Template\FilterProvider
     */
    protected $_filterProvider;

    /**
     * @var \Risecommerce\Blog\Model\Post
     */
    protected $_post;

    /**
     * Page factory
     *
     * @var \Risecommerce\Blog\Model\PostFactory
     */
    protected $_postFactory;

    /**
     * @var \Magento\Framework\Registry
     */
    protected $_coreRegistry;

    /**
     * @var string
     */
    protected $_defaultPostInfoBlock = \Risecommerce\Blog\Block\Post\Info::class;

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

    /**
     * AbstractPost constructor.
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param \Risecommerce\Blog\Model\Post $post
     * @param \Magento\Framework\Registry $coreRegistry
     * @param \Magento\Cms\Model\Template\FilterProvider $filterProvider
     * @param \Risecommerce\Blog\Model\PostFactory $postFactory
     * @param \Risecommerce\Blog\Model\Url $url
     * @param \Risecommerce\Blog\Model\Config $config
     * @param array $data
     * @param null $config
     * @param null $templatePool
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Risecommerce\Blog\Model\Post $post,
        \Magento\Framework\Registry $coreRegistry,
        \Magento\Cms\Model\Template\FilterProvider $filterProvider,
        \Risecommerce\Blog\Model\PostFactory $postFactory,
        \Risecommerce\Blog\Model\Url $url,
        array $data = [],
        $config = null,
        $templatePool = null
    ) {
        parent::__construct($context, $data);
        $this->_post = $post;
        $this->_coreRegistry = $coreRegistry;
        $this->_filterProvider = $filterProvider;
        $this->_postFactory = $postFactory;
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
     * Retrieve post instance
     *
     * @return \Risecommerce\Blog\Model\Post
     */
    public function getPost()
    {
        if (!$this->hasData('post')) {
            $this->setData(
                'post',
                $this->_coreRegistry->registry('current_blog_post')
            );
        }
        return $this->getData('post');
    }

    /**
     * Retrieve post short content
     *
     * @param  mixed $len
     * @param  mixed $endCharacters
     * @return string
     */
    public function getShorContent($len = null, $endCharacters = null)
    {
        return $this->getPost()->getShortFilteredContent($len, $endCharacters);
    }

    /**
     * Retrieve post content
     *
     * @return string
     */
    public function getContent()
    {
        return $this->getPost()->getFilteredContent();
    }

    /**
     * Retrieve post info html
     *
     * @return string
     */
    public function getInfoHtml()
    {
        return $this->getInfoBlock()->toHtml();
    }

    /**
     * Retrieve post info block
     *
     * @return \Risecommerce\Blog\Block\Post\Info
     */
    public function getInfoBlock()
    {
        $k = 'info_block';
        if (!$this->hasData($k)) {
            $blockName = $this->getPostInfoBlockName();
            if ($blockName) {
                $block = $this->getLayout()->getBlock($blockName);
            }

            if (empty($block)) {
                $block = $this->getLayout()->createBlock($this->_defaultPostInfoBlock, uniqid(microtime()));
            }

            $this->setData($k, $block);
        }

        return $this->getData($k)->setPost($this->getPost());
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

    /**
     * Check if AddThis Enabled and key exist
     *
     * @return bool
     */
    public function displayAddThisToolbox()
    {
        $isSocialEnabled = $this->_scopeConfig->getValue(
            'rcblog/social/add_this_enabled', ScopeInterface::SCOPE_STORE);
        $isSocialIdExist = $this->_scopeConfig->getValue(
            'rcblog/social/add_this_pubid', ScopeInterface::SCOPE_STORE);

        return $isSocialEnabled && $isSocialIdExist;
    }
}
