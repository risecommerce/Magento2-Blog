<?php
/**
 * Copyright © Risecommerce (support@risecommerce.com). All rights reserved.
 * 
 *
 * Glory to Ukraine! Glory to the heroes!
 */

namespace Risecommerce\Blog\Controller\Adminhtml;

/**
 * Admin blog tag edit controller
 */
class Tag extends Actions
{
    /**
     * Form session key
     * @var string
     */
    protected $_formSessionKey  = 'blog_tag_form_data';

    /**
     * Allowed Key
     * @var string
     */
    protected $_allowedKey      = 'Risecommerce_Blog::tag';

    /**
     * Model class name
     * @var string
     */
    protected $_modelClass      = \Risecommerce\Blog\Model\Tag::class;

    /**
     * Active menu key
     * @var string
     */
    protected $_activeMenu      = 'Risecommerce_Blog::tag';

    /**
     * Status field name
     * @var string
     */
    protected $_statusField     = 'is_active';
}
