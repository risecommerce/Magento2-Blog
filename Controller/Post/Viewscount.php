<?php
/**
 * Copyright © Risecommerce (support@risecommerce.com). All rights reserved.
 * 
 *
 * Glory to Ukraine! Glory to the heroes!
 */

namespace Risecommerce\Blog\Controller\Post;

/**
 * Class Count increment views_count value
 */
class Viewscount extends View
{

    /**
     * @return $this|\Magento\Framework\Controller\ResultInterface
     * @throws \Magento\Framework\Exception\AlreadyExistsException
     */
    public function execute()
    {
        $post = parent::_initPost();
        if ($post && $post->getId()) {
            $post->getResource()->incrementViewsCount($post);
        }
    }
}
