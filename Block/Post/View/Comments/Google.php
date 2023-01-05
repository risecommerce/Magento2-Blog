<?php
/**
 * Copyright © Risecommerce (support@risecommerce.com). All rights reserved.
 * 
 *
 * Glory to Ukraine! Glory to the heroes!
 */

namespace Risecommerce\Blog\Block\Post\View\Comments;

use Risecommerce\Blog\Model\Config\Source\CommetType;

/**
 * Blog post Google comments block
 */
class Google extends \Risecommerce\Blog\Block\Post\View\Comments
{
    protected $commetType = CommetType::GOOGLE;
}
