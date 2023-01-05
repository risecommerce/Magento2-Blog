<?php
/**
 * Copyright © Risecommerce (support@risecommerce.com). All rights reserved.
 * 
 *
 * Glory to Ukraine! Glory to the heroes!
 */

namespace Risecommerce\Blog\Plugin\Magento\AdminGws\Model;

/**
 * Class ModelsPlugin class
 */
class ModelsPlugin
{
    /**
     * @param $subject
     * @param callable $proceed
     * @param $model
     * @return callable
     */
    public function aroundCmsPageSaveBefore($subject, callable $proceed, $model)
    {
        $isBlogModel = ($model instanceof \Risecommerce\Blog\Model\Post
            || $model instanceof \Risecommerce\Blog\Model\Category
        );
        if ($isBlogModel) {
            $storeId = $model->getStoreId();
            if ($model->getStoreIds()) {
                $model->setStoreId($model->getStoreIds());
            }
        }

        return $proceed($model);
    }
}
