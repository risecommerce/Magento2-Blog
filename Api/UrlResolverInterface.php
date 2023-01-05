<?php
/**
 * Copyright © Risecommerce (support@risecommerce.com). All rights reserved.
 * 
 */
namespace Risecommerce\Blog\Api;

/**
 * Interface UrlResolverInterface
 */
interface UrlResolverInterface
{
    /**
     * @param string $path
     * @return array
     */
    public function resolve($path);
}
