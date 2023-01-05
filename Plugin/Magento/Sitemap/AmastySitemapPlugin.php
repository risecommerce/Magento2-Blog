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

/**
 * Plugin for sitemap generation
 */
class AmastySitemapPlugin
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
        \Risecommerce\Blog\Model\Config $config
    ) {
        $this->postFactory = $postFactory;
        $this->categoryFactory = $categoryFactory;
        $this->sitemapFactory = $sitemapFactory;
        $this->config = $config;
    }

    /**
     * @param $subject
     * @param $result
     * @param $sitemap
     * @return mixed
     */
    public function afterGenerate($subject, $result, $sitemap) {

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
        if ($sitemap instanceof \Amasty\XmlSitemap\Api\SitemapInterface ) {
            if ($sitemap->getFilePath()) {
                $filepath = $sitemap->getFilePath();
                $pathArray = explode('/', $filepath);
                $filename = end($pathArray);
                $blogFilepath = str_replace($filename, '', $filepath);
                $blogFilepath = str_replace('pub/', '', $blogFilepath);
                $blogSitemap->setSitemapFilename('blog_sitemap.xml');
                $blogSitemap->setSitemapPath($blogFilepath);
            }
            $blogSitemap->generateXml();
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
}
