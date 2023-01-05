<?php
/**
 * Copyright © Risecommerce (support@risecommerce.com). All rights reserved.
 * 
 *
 * Glory to Ukraine! Glory to the heroes!
 */

namespace Risecommerce\Blog\Api;

/**
 * Interface SitemapConfigInterface
 */
interface SitemapConfigInterface
{
    const HOME_PAGE = 'index';
    const CATEGORIES_PAGE = 'category';
    const POSTS_PAGE = 'post';

    /**
     * @param string $page
     * @return bool
     */
    public function isEnabledSitemap($page);

    /**
     * @param string $page
     * @return string
     */
    public function getFrequency($page);

    /**
     * @param string $page
     * @return float
     */
    public function getPriority($page);
}
