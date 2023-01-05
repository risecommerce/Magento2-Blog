<?php
/**
 * Copyright © Risecommerce (support@risecommerce.com). All rights reserved.
 * 
 *
 * Glory to Ukraine! Glory to the heroes!
 */

namespace Risecommerce\Blog\Block\Adminhtml\Grid\Column\Render;

/**
 * Author column renderer
 */
class Author extends \Magento\Backend\Block\Widget\Grid\Column\Renderer\AbstractRenderer
{
    /**
     * @var \Risecommerce\Blog\Api\AuthorInterfaceFactory
     */
    protected $authorFactory;

    /**
     * @var array
     */
    protected static $authors = [];

    /**
     * Author constructor.
     * @param \Magento\Backend\Block\Context $context
     * @param \Risecommerce\Blog\Api\AuthorInterfaceFactory $authorFactory
     * @param array $data
     */
    public function __construct(
        \Magento\Backend\Block\Context $context,
        \Risecommerce\Blog\Api\AuthorInterfaceFactory $authorFactory,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->authorFactory = $authorFactory;
    }

    /**
     * Render author grid column
     *
     * @param   \Magento\Framework\DataObject $row
     * @return  string
     */
    public function render(\Magento\Framework\DataObject $row)
    {
        if ($id = $row->getData($this->getColumn()->getIndex())) {
            $title = $this->getAuthorById($id)->getTitle();
            if ($title) {
                return $title;
            }
        }
        return null;
    }

    /**
     * Retrieve author by id
     *
     * @param   int $id
     * @return  \Risecommerce\Blog\Model\Author
     */
    protected function getAuthorById($id)
    {
        if (!isset(self::$authors[$id])) {
            self::$authors[$id] = $this->authorFactory->create()->load($id);
        }
        return self::$authors[$id];
    }
}
