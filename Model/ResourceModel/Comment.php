<?php
/**
 * Copyright © Risecommerce (support@risecommerce.com). All rights reserved.
 * 
 *
 * Glory to Ukraine! Glory to the heroes!
 */

namespace Risecommerce\Blog\Model\ResourceModel;

/**
 * Blog comment resource model
 */
class Comment extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{

    /**
     * @var \Magento\Framework\Stdlib\DateTime\DateTime
     */
    protected $date;
    /**
     * Construct
     *
     * @param \Magento\Framework\Model\ResourceModel\Db\Context $context
     * @param \Magento\Framework\Stdlib\DateTime\DateTime $date
     * @param string|null $resourcePrefix
     */
    public function __construct(
        \Magento\Framework\Model\ResourceModel\Db\Context $context,
        \Magento\Framework\Stdlib\DateTime\DateTime $date,
        $resourcePrefix = null
    ) {
        parent::__construct($context, $resourcePrefix);
        $this->date = $date;
    }

    /**
     * Initialize resource model
     * Get tablename from config
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('risecommerce_blog_comment', 'comment_id');
    }

    /**
     * Process post data before saving
     *
     * @param \Magento\Framework\Model\AbstractModel $object
     * @return $this
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    protected function _beforeSave(\Magento\Framework\Model\AbstractModel $object)
    {
        $object->validate();
        $gmtDate = $this->date->gmtDate();

        if ($object->isObjectNew() && !$object->getCreationTime()) {
            $object->setCreationTime($gmtDate);
        }

        $object->setUpdateTime($gmtDate);

        return parent::_beforeSave($object);
    }

    /**
     * Assign post to store views, categories, related posts, etc.
     *
     * @param \Magento\Framework\Model\AbstractModel $object
     * @return $this
     */
    protected function _afterSave(\Magento\Framework\Model\AbstractModel $object)
    {
        $result =  parent::_afterSave($object);
        $postId = $object->getData('post_id');

        if ($postId) {
            $this->updatePostCommentsCount($postId);
        }

        return $result;
    }

    /**
     * Perform actions after object delete
     *
     * @param \Magento\Framework\Model\AbstractModel|\Magento\Framework\DataObject $object
     * @return $this
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function _afterDelete(\Magento\Framework\Model\AbstractModel $object)
    {
        $result = parent::_beforeDelete($object);
        $postId = $object->getData('post_id');
        if ($postId) {
            $this->updatePostCommentsCount($postId);
        }

        return $result;
    }

    public function updatePostCommentsCount($postId)
    {
        $connection = $this->getConnection();

        $select = $connection->select()
            ->from(
                [$this->getTable('risecommerce_blog_comment')],
                ['count' => 'count(*)']
            )
            ->where('post_id = ?', $postId)
            ->where('status = ?', 1);

        $count = (int)$connection->fetchOne($select);

        $this->getConnection()->update(
            $this->getTable('risecommerce_blog_post'),
            ['comments_count' => $count],
            ['post_id = ' . ((int)$postId)]
        );
    }
}
