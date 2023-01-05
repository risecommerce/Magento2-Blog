<?php
/**
 * Copyright © Risecommerce (support@risecommerce.com). All rights reserved.
 * 
 *
 * Glory to Ukraine! Glory to the heroes!
 */

namespace Risecommerce\Blog\Block\Adminhtml\Grid\Column\Render;

/**
 * Category column renderer
 */
class Category extends \Magento\Backend\Block\Widget\Grid\Column\Renderer\AbstractRenderer
{
    /**
     * @var \Risecommerce\Blog\Model\CategoryFactory
     */
    protected $categoryFactory;

    /**
     * @var array
     */
    protected static $categories = [];

    /**
     * @param \Magento\Backend\Block\Context $context
     * @param \Risecommerce\Blog\Model\CategoryFactory $localeLists
     * @param array $data
     */
    public function __construct(
        \Magento\Backend\Block\Context $context,
        \Risecommerce\Blog\Model\CategoryFactory $categoryFactory,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->categoryFactory = $categoryFactory;
    }

    /**
     * Render category grid column
     *
     * @param   \Magento\Framework\DataObject $row
     * @return  string
     */
    public function render(\Magento\Framework\DataObject $row)
    {
        if ($data = $row->getData($this->getColumn()->getIndex())) {
            $titles = [];
            foreach ($data as $id) {
                $title = $this->getCategoryById($id)->getTitle();
                if ($title) {
                    $titles[] = $title;
                }
            }

            return implode(', ', $titles);
        }
        return null;
    }

    /**
     * Retrieve category by id
     *
     * @param   int $id
     * @return  \Risecommerce\Blog\Model\Category
     */
    protected function getCategoryById($id)
    {
        if (!isset(self::$categories[$id])) {
            self::$categories[$id] = $this->categoryFactory->create()->load($id);
        }
        return self::$categories[$id];
    }
}
