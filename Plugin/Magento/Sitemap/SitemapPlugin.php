<?php
/**
 * Copyright © Risecommerce (support@risecommerce.com). All rights reserved.
 * 
 *
 * Glory to Ukraine! Glory to the heroes!
 */

namespace Risecommerce\Blog\Plugin\Magento\Sitemap;

use Risecommerce\Blog\Model\CategoryFactory;
use Risecommerce\Blog\Model\PostFactory;
use Magento\Framework\DataObject;
use Magento\Sitemap\Model\Sitemap;

/**
 * Plugin for sitemap generation
 */
class SitemapPlugin
{
    /**
     * @var \Risecommerce\Blog\Model\SitemapFactory
     */
    protected $sitemapFactory;

    /**
     * @var CategoryFactory
     */
    protected $categoryFactory;

    /**
     * @var PostFactory
     */
    protected $postFactory;

    /**
     * @var mixed
     */
    protected $config;

    /**
     * Generated sitemaps
     * @var array
     */
    protected $generated = [];

    /**
     * SitemapPlugin constructor.
     * @param \Risecommerce\Blog\Model\SitemapFactory $sitemapFactory
     * @param CategoryFactory $categoryFactory
     * @param PostFactory $postFactory
     * @param null|\Risecommerce\Blog\Model\Config config
     */
    public function __construct(
        \Risecommerce\Blog\Model\SitemapFactory $sitemapFactory,
        CategoryFactory $categoryFactory,
        PostFactory $postFactory,
        $config = null
    ) {
        $this->postFactory = $postFactory;
        $this->categoryFactory = $categoryFactory;
        $this->sitemapFactory = $sitemapFactory;

        $this->config = $config ?: \Magento\Framework\App\ObjectManager::getInstance()
            ->get(\Risecommerce\Blog\Model\Config::class);
    }

    /**
     * Deprecated
     * Used for Magento 2.1.x only to create blog_sitemap.xml
     * Add risecommerce blog actions to allowed list
     * @param  \Magento\Framework\Model\AbstractModel $sitemap
     * @return array
     */
    public function afterGenerateXml(\Magento\Framework\Model\AbstractModel $sitemap, $result)
    {
        if ($this->isEnabled($sitemap)) {
            $sitemapId = $sitemap->getId() ?: 0;
            if (in_array($sitemapId, $this->generated)) {
                return $result;
            }
            $this->generated[] = $sitemapId;

            $blogSitemap = $this->sitemapFactory->create();
            $blogSitemap->setData(
                $sitemap->getData()
            );

            if (!$blogSitemap->getSitemapId() && $sitemap->getId()) {
                $blogSitemap->setSitemapId($sitemap->getId());
            }

            /* Fix for Amasty\XmlSitemap\Model\Sitemap */
            if ($sitemap->getFolderName()) {
                $filename = pathinfo($sitemap->getFolderName());
                if (!$blogSitemap->getSitemapFilename()) {
                    if (isset($filename['basename'])) {
                        $blogSitemap->setSitemapFilename($filename['basename']);
                    }
                }
                if (!$blogSitemap->getSitemapPath()) {
                    if (isset($filename['dirname'])) {
                        $blogSitemap->setSitemapPath($filename['dirname']);
                    }
                }
            }

            if (strpos($blogSitemap->getSitemapFilename(), 'blog_') !== 0) {
                $blogSitemap->setSitemapFilename(
                    'blog_' . $blogSitemap->getSitemapFilename()
                );
                $blogSitemap->generateXml();
            }
        }
        return $result;
    }

    /**
     * Deprecated
     * @param \Magento\Framework\Model\AbstractModel $sitemap
     * @param $result
     * @return mixed
     */
    public function afterCollectSitemapItems(\Magento\Framework\Model\AbstractModel $sitemap, $result)
    {
        return $result;
        /*
        if ($this->isEnabled($sitemap) && !$this->isMageWorxXmlSitemap($sitemap)) {
            $storeId = $sitemap->getStoreId();

            $sitemap->addSitemapItem(new DataObject(
                [
                    'changefreq' => 'weekly',
                    'priority' => '0.25',
                    'collection' => $this->categoryFactory->create()
                        ->getCollection($storeId)
                        ->addStoreFilter($storeId)
                        ->addActiveFilter(),
                ]
            ));

            $sitemap->addSitemapItem(new DataObject(
                [
                    'changefreq' => 'weekly',
                    'priority' => '0.25',
                    'collection' => $this->postFactory->create()
                        ->getCollection($storeId)
                        ->addStoreFilter($storeId)
                        ->addActiveFilter(),
                ]
            ));
        }

        return $result;
        */
    }

    /**
     * @param $sitemap
     * @return mixed
     */
    protected function isEnabled($sitemap)
    {
        return $this->config->isEnabled(
            $sitemap->getStoreId()
        );
    }

    /**
     * Deprecated
     * @param $sitemap
     * @return mixed
     */
    public function isMageWorxXmlSitemap($sitemap)
    {
        return (get_class($sitemap) == 'MageWorx\XmlSitemap\Model\Rewrite\Sitemap\Interceptor');
    }
}
