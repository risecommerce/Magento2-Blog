<?php
/**
 * Copyright © Risecommerce (support@risecommerce.com). All rights reserved.
 * 
 *
 * Glory to Ukraine! Glory to the heroes!
 */

namespace Risecommerce\Blog\Setup;

use Risecommerce\Blog\Model\Post;
use Risecommerce\Blog\Model\PostFactory;
use Magento\Framework\Module\Setup\Migration;
use Magento\Framework\Setup\InstallDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;

/**
 * @codeCoverageIgnore
 */
class InstallData implements InstallDataInterface
{
    /**
     * Post factory
     *
     * @var \Risecommerce\Blog\Model\PostFactory
     */
    private $_postFactory;

    /**
     * State
     *
     * @var \Magento\Framework\App\State
     */
    private $state;

    /**
     * @var \Magento\Framework\App\Config\ScopeConfigInterface
     */
    private $scopeConfig;

    /**
     * Init
     *
     * @param \Risecommerce\Blog\Model\PostFactory $postFactory
     */
    public function __construct(
        \Risecommerce\Blog\Model\PostFactory $postFactory,
        \Magento\Framework\App\State $state,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
    ) {
        $this->_postFactory = $postFactory;
        $this->state = $state;
        $this->scopeConfig = $scopeConfig;
    }

    /**
     * {@inheritdoc}
     * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
     */
    public function install(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        try {
            $this->state->setAreaCode('adminhtml');
        } catch (\Exception $e) {
            /* Do nothing, it's OK */
        }

        $url =  $this->scopeConfig
            ->getValue(
                'web/unsecure/base_url',
                \Magento\Store\Model\ScopeInterface::SCOPE_STORE,
                0
            );
        $useLinks = \Risecommerce\Core\Model\UrlChecker::showUrl($url);
        $useLinks = false;

        $data = [
            'title' => 'Magento 2 Blog Post Sample',
            'meta_keywords' => 'magento 2 blog sample',
            'meta_description' => 'Magento 2 blog default post.',
            'identifier' => 'magento-2-blog-post-sample',
            'content_heading' => 'Magento 2 Blog Post Sample',
            'content' =>
                $useLinks
                ? '<p>Welcome to 
                    <a title="Magento Blog" 
                       href="https://risecommerce.com/magento2-blog-extension" 
                       target="_blank">Magento Blog</a> by
                    <a title="Magento 2 Extensions" 
                       href="https://risecommerce.com/magento-2-extensions"
                       target="_blank">Risecommerce</a>. 
                       This is your first post. Edit or delete it, then start blogging!
                </p>
                <p><!-- pagebreak --></p>
                <p>Please also read&nbsp;
                    <a title="Magento 2 Blog online documentation" 
                       href="https://risecommerce.com/blog/magento-2-blog-extension-documentation" 
                       target="_blank">Magento 2 Blog online documentation</a>&nbsp;and&nbsp;
                    <a href="https://risecommerce.com/blog/add-read-more-tag-to-blog-post-content" 
                       target="_blank">How to add "read more" tag to post content</a>
                </p>
                <p>Follow Risecommerce on:</p>
                <p>
                    <a title="Magento 2 Blog Extension GitHub" 
                       href="https://github.com/risecommerce/module-blog" 
                       target="_blank">Magento 2 Blog Extension GitHub</a>&nbsp;|&nbsp;
                    <a href="https://twitter.com/magento2fan" title="Risecommerce at Twitter"
                       target="_blank">Risecommerce at Twitter</a>&nbsp;|&nbsp;
                    <a href="https://www.facebook.com/risecommerce/"  title="Risecommerce at Facebook"
                       target="_blank">Risecommerce at Facebook</a>
                </p>'
                : '<p>Welcome to Magento 2 Blog extension by Risecommerce.
                        This is your first post. Edit or delete it, then start blogging!
                </p>',
            'store_ids' => [0]
        ];

        $this->_postFactory->create()->setData($data)->save();
    }
}
