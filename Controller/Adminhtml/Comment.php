<?php
/**
 * Copyright © Risecommerce (support@risecommerce.com). All rights reserved.
 * 
 *
 * Glory to Ukraine! Glory to the heroes!
 */

namespace Risecommerce\Blog\Controller\Adminhtml;

/**
 * Admin blog comment edit controller
 */
class Comment extends Actions
{
    /**
     * Form session key
     * @var string
     */
    protected $_formSessionKey  = 'blog_comment_form_data';

    /**
     * Allowed Key
     * @var string
     */
    protected $_allowedKey      = 'Risecommerce_Blog::comment';

    /**
     * Model class name
     * @var string
     */
    protected $_modelClass      = \Risecommerce\Blog\Model\Comment::class;

    /**
     * Active menu key
     * @var string
     */
    protected $_activeMenu      = 'Risecommerce_Blog::comment';

    /**
     * Status field name
     * @var string
     */
    protected $_statusField     = 'status';
}
