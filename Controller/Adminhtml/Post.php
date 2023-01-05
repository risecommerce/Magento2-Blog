<?php
/**
 * Copyright © Risecommerce (support@risecommerce.com). All rights reserved.
 * 
 *
 * Glory to Ukraine! Glory to the heroes!
 */

namespace Risecommerce\Blog\Controller\Adminhtml;

/**
 * Admin blog post edit controller
 */
class Post extends Actions
{
    /**
     * Form session key
     * @var string
     */
    protected $_formSessionKey  = 'blog_post_form_data';

    /**
     * Allowed Key
     * @var string
     */
    protected $_allowedKey      = 'Risecommerce_Blog::post';

    /**
     * Model class name
     * @var string
     */
    protected $_modelClass      = \Risecommerce\Blog\Model\Post::class;

    /**
     * Active menu key
     * @var string
     */
    protected $_activeMenu      = 'Risecommerce_Blog::post';

    /**
     * Status field name
     * @var string
     */
    protected $_statusField     = 'is_active';
}
