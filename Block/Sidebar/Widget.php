<?php
/**
 * Copyright © Risecommerce (support@risecommerce.com). All rights reserved.
 * 
 *
 * Glory to Ukraine! Glory to the heroes!
 */

namespace Risecommerce\Blog\Block\Sidebar;

/**
 * Blog sidebar widget trait
 */
trait Widget
{
    /**
     * Retrieve block sort order
     * @return int
     */
    public function getSortOrder()
    {
        if (!$this->hasData('sort_order')) {
            $this->setData('sort_order', $this->_scopeConfig->getValue(
                'rcblog/sidebar/'.$this->_widgetKey.'/sort_order',
                \Magento\Store\Model\ScopeInterface::SCOPE_STORE
            ));
        }
        return (int) $this->getData('sort_order');
    }

    /**
     * Retrieve block html
     *
     * @return string
     */
    protected function _toHtml()
    {
        if ($this->_scopeConfig->getValue(
            'rcblog/sidebar/'.$this->_widgetKey.'/enabled',
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        )) {
            return parent::_toHtml();
        }

        return '';
    }

    /**
     * Retrieve widget key
     *
     * @return string
     */
    public function getWidgetKey()
    {
        return $this->_widgetKey;
    }
}
