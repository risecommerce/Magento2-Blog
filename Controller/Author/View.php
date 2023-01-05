<?php
/**
 * Copyright © Risecommerce (support@risecommerce.com). All rights reserved.
 * 
 *
 * Glory to Ukraine! Glory to the heroes!
 */
namespace Risecommerce\Blog\Controller\Author;

/**
 * Blog author posts view
 */
class View extends \Risecommerce\Blog\App\Action\Action
{
    /**
     * Store manager
     *
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    private $_storeManager;

    /**
     * View blog author action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        if (!$this->moduleEnabled()) {
            return $this->_forwardNoroute();
        }

        $enabled = (int) $this->getConfigValue('rcblog/author/enabled');
        $pageEnabled = (int) $this->getConfigValue('rcblog/author/page_enabled');

        if (!$enabled || !$pageEnabled) {
            return $this->_forwardNoroute();
        }

        $author = $this->_initAuthor();
        if (!$author) {
            return $this->_forwardNoroute();
        }

        $this->_objectManager->get(\Magento\Framework\Registry::class)->register('current_blog_author', $author);

        $resultPage = $this->_objectManager->get(\Risecommerce\Blog\Helper\Page::class)
            ->prepareResultPage($this, $author);
        return $resultPage;
    }

    /**
     * Init author
     *
     * @return \Risecommerce\Blog\Api\AuthorInterface || false
     */
    protected function _initAuthor()
    {
        $id = (int)$this->getRequest()->getParam('id');
        if (!$id) {
            return false;
        }

        $storeId = $this->getStoreManager()->getStore()->getId();
        $author = $this->_objectManager->create(\Risecommerce\Blog\Api\AuthorInterface::class)->load($id);

        if (!$author->isVisibleOnStore($storeId)) {
            return false;
        }

        $author->setStoreId($storeId);

        return $author;
    }

    /**
     * @return \Magento\Store\Model\StoreManagerInterface|mixed
     */
    private function getStoreManager()
    {
        if (null === $this->_storeManager) {
            $this->_storeManager = $this->_objectManager->get(\Magento\Store\Model\StoreManagerInterface::class);
        }
        return $this->_storeManager;
    }
}
