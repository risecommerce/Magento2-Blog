<?php
/**
 * Copyright © Risecommerce (support@risecommerce.com). All rights reserved.
 * 
 *
 * Glory to Ukraine! Glory to the heroes!
 */

namespace Risecommerce\Blog\Model\Comment;

/**
 * Admin notifications about new pending comments
 */
class Notification
{
     /**
     * Check every 10 min
     */
    const TIMEOUT = 600;

    /**
     * @var \Magento\Framework\Message\ManagerInterface
     */
    private $messageManager;

    /**
     * @var \Magento\Backend\Model\Auth\Session
     */
    private $backendSession;

    /**
     * @var \Magento\Framework\Stdlib\DateTime\DateTime
     */
    private $date;

    /**
     * @var \Magento\Framework\UrlInterface
     */
    private $url;

    /**
     * @var \Risecommerce\Blog\Model\ResourceModel\Comment\CollectionFactory
     */
    protected $commentCollectionFactory;

    /**
     * Initialization
     * @param \Magento\Framework\Message\ManagerInterface                  $messageManager
     * @param \Magento\Backend\Model\Auth\Session                          $backendSession
     * @param \Magento\Framework\Stdlib\DateTime\DateTime                  $date,
     * @param \Magento\Framework\UrlInterface                              $url
     * @param \Risecommerce\Blog\Model\ResourceModel\Comment\CollectionFactory  $commentCollectionFactory
     */
    public function __construct(
        \Magento\Framework\Message\ManagerInterface $messageManager,
        \Magento\Backend\Model\Auth\Session $backendSession,
        \Magento\Framework\Stdlib\DateTime\DateTime $date,
        \Magento\Framework\UrlInterface $url,
        \Risecommerce\Blog\Model\ResourceModel\Comment\CollectionFactory $commentCollectionFactory
    ) {
        $this->messageManager = $messageManager;
        $this->backendSession = $backendSession;
        $this->date = $date;
        $this->url = $url;
        $this->commentCollectionFactory = $commentCollectionFactory;
    }

    /**
     * Check if any pending blog comment exists
     * @return void
     */
    public function checkComments()
    {
        if (!$this->backendSession->isLoggedIn()) {
            return; // Isn't logged in
        }

        $time = $this->date->gmtTimestamp();
        if ($this->backendSession->getLastRcNtfCheck() > $time - self::TIMEOUT) {
            return; // It's not time
        }

        $pendignComment = $this->commentCollectionFactory->create()
            ->addFieldToFilter('status', \Risecommerce\Blog\Model\Config\Source\CommentStatus::PENDING)
            ->setPageSize(1)
            ->getFirstItem();

        if ($pendignComment->getId()) {
            $this->messageManager->addNotice(
                __(
                    'Some blog comments are pending for approval. <a href="%1">Manage Comments</a>.',
                    $this->url->getUrl('blog/comment/index')
                )
            );
        }

        $this->backendSession->setLastRcNtfCheck($time);
    }
}
