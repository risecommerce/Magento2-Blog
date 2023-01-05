<?php
/**
 * Copyright © Risecommerce (support@risecommerce.com). All rights reserved.
 * 
 */

namespace Risecommerce\Blog\Controller\Adminhtml\Tag;

use Magento\Framework\Controller\ResultFactory;

/**
 * Class Tag Ajax Autocomplete
 */
class Autocomplete extends \Risecommerce\Blog\Controller\Adminhtml\Tag
{
    /**
     * @return \Magento\Framework\Controller\Result\Json
     */
    public function execute()
    {
        $search = (string)$this->getRequest()->getParam('search');
        $collection = $this->_objectManager->create(\Risecommerce\Blog\Model\Tag\AutocompleteData::class);

        /** @var \Magento\Framework\Controller\Result\Json $resultJson */
        $resultJson= $this->resultFactory->create(ResultFactory::TYPE_JSON);
        $resultJson->setData($collection->getItems($search));
        return $resultJson;
    }
}
