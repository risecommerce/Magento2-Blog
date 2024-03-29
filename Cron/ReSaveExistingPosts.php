<?php
/**
 * Copyright © Risecommerce (support@risecommerce.com). All rights reserved.
 * 
 */

namespace Risecommerce\Blog\Cron;

use Risecommerce\Blog\Model\ResourceModel\Post\CollectionFactory as PostCollectionFactory;
use Risecommerce\Blog\Model\Config;
use Magento\Framework\Stdlib\DateTime\DateTime;

/**
 * ReSave Posts that have PublishTime <= CurrentTime In Order To They Be Visible - Need If FPC Is Enabled
 */
class ReSaveExistingPosts
{
    /**
     * @var Config
     */
    private $config;

    /**
     * @var PostCollectionFactory
     */
    private $postCollectionFactory;

    /**
     * @var DateTime
     */
    private $date;

    /**
     * @param Config $config
     * @param PostCollectionFactory $postCollectionFactory
     * @param DateTime $date
     */
    public function __construct(
        Config $config,
        PostCollectionFactory $postCollectionFactory,
        DateTime $date
    ) {
        $this->config = $config;
        $this->postCollectionFactory = $postCollectionFactory;
        $this->date = $date;
    }

    /**
     * @return void
     */
    public function execute()
    {
        if (!$this->config->isEnabled()) {
            return;
        }

        $postCollection = $this->postCollectionFactory->create()
            ->addActiveFilter()
            ->addFieldToFilter('publish_time', ['gteq' => $this->date->gmtDate('Y-m-d H:i:s', strtotime('-2 minutes'))])
            ->addFieldToFilter('publish_time', ['lteq' => $this->date->gmtDate()]);

        foreach ($postCollection as $post) {
            $post->setOrigData('is_active', 0);
            $post->afterCommitCallback();
        }
    }
}
