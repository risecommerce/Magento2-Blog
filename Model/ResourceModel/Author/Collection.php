<?php
/**
 * Copyright © Risecommerce (support@risecommerce.com). All rights reserved.
 * 
 *
 * Glory to Ukraine! Glory to the heroes!
 */

namespace Risecommerce\Blog\Model\ResourceModel\Author;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Risecommerce\Blog\Api\AuthorCollectionInterface;

/**
 * Blog author collection
 */
class Collection extends AbstractCollection implements AuthorCollectionInterface
{
    /**
     * Constructor
     * Configures collection
     *
     * @return void
     */
    protected function _construct()
    {
        parent::_construct();
        $this->_init(\Risecommerce\Blog\Model\Author::class, \Risecommerce\Blog\Model\ResourceModel\Author::class);
    }
}
