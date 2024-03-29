<?php
/**
 * Copyright © Risecommerce (support@risecommerce.com). All rights reserved.
 * 
 *
 * Glory to Ukraine! Glory to the heroes!
 */

namespace Risecommerce\Blog\Ui\DataProvider\Post\Related;

use Magento\Ui\DataProvider\AbstractDataProvider;
use Risecommerce\Blog\Model\ResourceModel\Post\Collection;
use Risecommerce\Blog\Model\ResourceModel\Post\CollectionFactory;
use Magento\Framework\App\RequestInterface;

/**
 * Class PostDataProvider get post data
 */
class PostDataProvider extends AbstractDataProvider
{
    /**
     * @var RequestInterface
     */
    protected $request;

    /**
     * @var post
     */
    private $post;

    /**
     * Construct
     *
     * @param string $name
     * @param string $primaryFieldName
     * @param string $requestFieldName
     * @param CollectionFactory $collectionFactory
     * @param RequestInterface $request
     * @param array $meta
     * @param array $data
     */
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $collectionFactory,
        RequestInterface $request,
        array $meta = [],
        array $data = []
    ) {
        parent::__construct(
            $name,
            $primaryFieldName,
            $requestFieldName,
            $meta,
            $data
        );
        $this->collection = $collectionFactory->create();
        $this->request = $request;
    }

    /**
     * {@inheritdoc}
     */
    public function getCollection()
    {
        /** @var Collection $collection */
        $collection = parent::getCollection();

        if (!$this->getPost()) {
            return $collection;
        }

        $collection->addFieldToFilter(
            $collection->getIdFieldName(),
            ['nin' => [$this->getPost()->getId()]]
        );

        return $this->addCollectionFilters($collection);
    }

    /**
     * Retrieve post
     *
     * @return PostInterface|null
     */
    protected function getPost()
    {
        if (null !== $this->post) {
            return $this->post;
        }

        if (!($id = $this->request->getParam('current_post_id'))) {
            return null;
        }

        return $this->post = $this->postRepository->getById($id);
    }
}
