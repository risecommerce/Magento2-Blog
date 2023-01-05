<?php
/**
 * Copyright © Risecommerce (support@risecommerce.com). All rights reserved.
 * 
 *
 * Glory to Ukraine! Glory to the heroes!
 */

namespace Risecommerce\Blog\App\Action;

/**
 * Blog frontend action controller
 */
abstract class Action extends \Magento\Framework\App\Action\Action
{
    /**
     * Retrieve true if blog extension is enabled.
     *
     * @return bool
     */
    protected function moduleEnabled()
    {
        return (bool) $this->getConfigValue(
            \Risecommerce\Blog\Helper\Config::XML_PATH_EXTENSION_ENABLED,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
    }

    /**
     * Retrieve store config value
     *
     * @return string | null | bool
     */
    protected function getConfigValue($path)
    {
        $config = $this->_objectManager->get(\Magento\Framework\App\Config\ScopeConfigInterface::class);
        return $config->getValue(
            $path,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
    }

    /**
     * Throw control to cms_index_noroute action.
     *
     * @return void
     */
    protected function _forwardNoroute()
    {
        $this->_forward('index', 'noroute', 'cms');
    }
}
