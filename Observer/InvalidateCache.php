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
 * DEPRECATED
 *
 * Blog observer
 */
class InvalidateCache implements ObserverInterface
{
    /**
     * @var \Magento\Framework\App\Cache\TypeListInterface
     */
    protected $_typeList;

    /**
     * Application config object
     *
     * @var \Magento\PageCache\Model\Config
     */
    protected $_config;

    /**
     * @param \Magento\PageCache\Model\Config $config
     * @param \Magento\Framework\App\Cache\TypeListInterface $typeList
     */
    public function __construct(
        \Magento\PageCache\Model\Config $config,
        \Magento\Framework\App\Cache\TypeListInterface $typeList
    ) {
        $this->_config = $config;
        $this->_typeList = $typeList;
    }

    /**
     * Invalidate full page and block cache
     *
     * @param \Magento\Framework\Event\Observer $observer
     * @return void
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        if ($this->_config->isEnabled()) {
            $this->_typeList->invalidate(
                \Magento\PageCache\Model\Cache\Type::TYPE_IDENTIFIER
            );
        }

        $this->_typeList->invalidate(
            \Magento\Framework\App\Cache\Type\Block::TYPE_IDENTIFIER
        );
    }
}
