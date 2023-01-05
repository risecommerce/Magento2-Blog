<?php
/**
 * Copyright © Risecommerce (support@risecommerce.com). All rights reserved.
 * 
 *
 * Glory to Ukraine! Glory to the heroes!
 */
declare(strict_types=1);

namespace Risecommerce\Blog\Api;

interface AuthorInterface
{
    /**
     * @param int $storeId
     * @return bool
     */
    public function isVisibleOnStore(int $storeId): bool;
}
