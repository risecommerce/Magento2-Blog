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
 * Blog post Facebook comments block
 */
class Facebook extends \Risecommerce\Blog\Block\Post\View\Comments
{
    /**
     * @var string
     */
    protected $commetType = CommetType::FACEBOOK;

    /**
     * @return string
     */
    public function getFbSdkJsUrl()
    {
        return '//connect.facebook.net/'.
            $this->getLocaleCode() . '/sdk.js#xfbml=1&version=v3.3&appId=' .
            $this->getFacebookAppId() . '&autoLogAppEvents=1';
    }
}
