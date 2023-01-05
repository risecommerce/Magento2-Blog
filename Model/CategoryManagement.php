<?php
/**
 * Copyright © Risecommerce (support@risecommerce.com). All rights reserved.
 * 
 *
 * Glory to Ukraine! Glory to the heroes!
 */

namespace Risecommerce\Blog\Model;

/**
 * Category management model
 */
class CategoryManagement extends AbstractManagement
{
    /**
     * @var \Risecommerce\Blog\Model\CategoryFactory
     */
    protected $_itemFactory;

    /**
     * Initialize dependencies.
     *
     * @param \Risecommerce\Blog\Model\CategoryFactory $categoryFactory
     */
    public function __construct(
        \Risecommerce\Blog\Model\CategoryFactory $categoryFactory
    ) {
        $this->_itemFactory = $categoryFactory;
    }

     /**
      * Retrieve list of category by page type, term, store, etc
      *
      * @param  string $type
      * @param  string $term
      * @param  int $storeId
      * @param  int $page
      * @param  int $limit
      * @return string
      */
    public function getList($type, $term, $storeId, $page, $limit)
    {
        try {
            $collection = $this->_itemFactory->create()->getCollection();
            $collection
                ->addActiveFilter()
                ->addStoreFilter($storeId)
                ->setCurPage($page)
                ->setPageSize($limit);

            $type = strtolower($type);

            switch ($type) {
                case 'search':
                    $collection->addSearchFilter($term);
                    break;
            }

            $categories = [];
            foreach ($collection as $item) {
                $categories[] = $this->getDynamicData($item);
            }

            $result = [
                'categories' => $categories,
                'total_number' => $collection->getSize(),
                'current_page' => $collection->getCurPage(),
                'last_page' => $collection->getLastPageNumber(),
            ];

            return json_encode($result);
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * @param $item
     * @return array
     */
    protected function getDynamicData($item)
    {
        $data = $item->getData();

        $keys = [
            'meta_description',
            'meta_title',
            'category_url',
        ];

        foreach ($keys as $key) {
            $method = 'get' . str_replace('_', '', ucwords($key, '_'));
            $data[$key] = $item->$method();
        }

        return $data;
    }
}
