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
class PageBlockHtmlTopmenuBethtmlBeforeObserver implements ObserverInterface
{
    /**
     * @var \Risecommerce\Blog\Helper\Menu
     */
    protected $menuHelper;

    /**
     * @param \Risecommerce\Blog\Helper\Menu $menuHelper
     */
    public function __construct(
        \Risecommerce\Blog\Helper\Menu $menuHelper
    ) {
        $this->menuHelper = $menuHelper;
    }

    /**
     * Page block html topmenu gethtml before
     *
     * @param \Magento\Framework\Event\Observer $observer
     * @return void
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        /** @var \Magento\Framework\Data\Tree\Node $menu */
        $menu = $observer->getMenu();
        $tree = $menu->getTree();

        $blogNode = $this->menuHelper->getBlogNode($menu, $menu->getTree());
        if ($blogNode) {
            $menu->addChild($blogNode);
        }
    }
}
