<?php
/**
 * Copyright © Risecommerce (support@risecommerce.com). All rights reserved.
 * 
 *
 * Glory to Ukraine! Glory to the heroes!
 */

namespace Risecommerce\Blog\Observer;

use Magento\Framework\Event\ObserverInterface;

/**
 * Blog observer
 */
class PredispathAdminActionControllerObserver implements ObserverInterface
{
    /**
     * @var \Risecommerce\Blog\Model\AdminNotificationFeedFactory
     */
    protected $_feedFactory;

    /**
     * @var \Magento\Backend\Model\Auth\Session
     */
    protected $_backendAuthSession;

    /**
     * @var \Risecommerce\Blog\Model\Comment\Notification
     */
    protected $commentNotification;

    /**
     * @param \Risecommerce\Blog\Model\AdminNotificationFeedFactory $feedFactory
     * @param \Magento\Backend\Model\Auth\Session $backendAuthSession
     * @param \Risecommerce\Blog\Model\Comment\Notification $commentNotification,
     */
    public function __construct(
        \Risecommerce\Blog\Model\AdminNotificationFeedFactory $feedFactory,
        \Magento\Backend\Model\Auth\Session $backendAuthSession,
        \Risecommerce\Blog\Model\Comment\Notification $commentNotification
    ) {
        $this->_feedFactory = $feedFactory;
        $this->_backendAuthSession = $backendAuthSession;
        $this->commentNotification = $commentNotification;
    }

    /**
     * Predispath admin action controller
     *
     * @param \Magento\Framework\Event\Observer $observer
     * @return void
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        if ($this->_backendAuthSession->isLoggedIn()) {
            $feedModel = $this->_feedFactory->create();
            /* @var $feedModel \Risecommerce\Blog\Model\AdminNotificationFeed */
            $feedModel->checkUpdate();

            /** Check pending blog comments */
            $this->commentNotification->checkComments();
        }
    }
}
