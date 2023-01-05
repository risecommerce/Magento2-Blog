<?php
/**
 * Copyright © Risecommerce (support@risecommerce.com). All rights reserved.
 * 
 *
 * Glory to Ukraine! Glory to the heroes!
 */
namespace Risecommerce\Blog\Controller\Tag;

use Magento\Store\Model\ScopeInterface;

/**
 * Blog tag posts view
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

        $tag = $this->_initTag();
        if (!$tag) {
            return $this->_forwardNoroute();
        }

        $this->_objectManager->get(\Magento\Framework\Registry::class)->register('current_blog_tag', $tag);

        $resultPage = $this->_objectManager->get(\Risecommerce\Blog\Helper\Page::class)
            ->prepareResultPage($this, $tag);

        return $resultPage;
    }

    /**
     * Init author
     *
     * @return \Risecommerce\Blog\Model\Tag || false
     */
    protected function _initTag()
    {
        $id = (int)$this->getRequest()->getParam('id');
        if (!$id) {
            return false;
        }

        $storeId = $this->getStoreManager()->getStore()->getId();
        $tag = $this->_objectManager->create(\Risecommerce\Blog\Model\Tag::class)->load($id);

        if (!$tag->isVisibleOnStore($storeId)) {
            return false;
        }

        $tag->setStoreId($storeId);

        return $tag;
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
