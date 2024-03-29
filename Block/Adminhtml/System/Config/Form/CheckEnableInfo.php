<?php
/**
 * Copyright © Risecommerce (support@risecommerce.com). All rights reserved.
 * 
 *
 * Glory to Ukraine! Glory to the heroes!
 */

namespace Risecommerce\Blog\Block\Adminhtml\System\Config\Form;

use Magento\Framework\App\ObjectManager;
use Risecommerce\Core\Model\Section;

/**
 * Class Check EnableInfo Block
 */
class CheckEnableInfo extends \Magento\Backend\Block\Template
{
    /**
     * Risecommerce Blog Plus Module
     * @deprecated
     */
    const MAGEFAN_BLOG_PLUS = 'Risecommerce_BlogPlus';

    /**
     * Extension key config path
     */
    const XML_PATH_KEY = 'rcblog/general/key';

    /**
     * @var \Risecommerce\Blog\Model\Config
     */
    protected $config;

    /**
     * @var \Magento\Framework\Module\ModuleListInterface
     */
    protected $moduleList;

    /**
     * @var \Magento\Framework\App\ProductMetadataInterface
     */
    protected $metadata;

    /**
     * CheckEnableInfo constructor.
     * @param \Magento\Backend\Block\Template\Context $context
     * @param \Risecommerce\Blog\Model\Config $config
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     * @param \Magento\Framework\Module\ModuleListInterface $moduleList
     * @param \Magento\Framework\App\ProductMetadataInterface $metadata
     * @param array $data
     */
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Risecommerce\Blog\Model\Config $config,
        \Magento\Framework\Module\ModuleListInterface $moduleList,
        \Magento\Framework\App\ProductMetadataInterface $metadata,
        array $data = []
    ) {
        $this->config = $config;
        $this->moduleList  = $moduleList;
        $this->metadata = $metadata;
        parent::__construct($context, $data);
    }

    /**
     * @return bool
     */
    public function isEnabled()
    {
        foreach ($this->_storeManager->getWebsites() as $website) {
            foreach ($website->getGroups() as $group) {
                $stores = $group->getStores();
                if (count($stores) == 0) {
                    continue;
                }

                foreach ($stores as $store) {
                    if ($this->config->isEnabled($store->getId())) {
                        return true;
                    }
                }
            }
        }

        return false;
    }

    /**
     * @return bool
     */
    public function isKeyMissing()
    {
        $section = ObjectManager::getInstance()->create(Section::class, ['name' => 'rcblog']);
        return !$this->config->getConfig(self::XML_PATH_KEY)
            && $section->getModule();
    }

    /**
     * @return array|bool
     */
    public function isAnotherBlogModulesEnabled()
    {
        $blogModules = [];

        foreach ($this->moduleList->getNames() as $module) {
            if (false === strpos($module, '_')) {
                continue;
            }

            list($vendor, $name) = explode('_', $module);
            if ('Risecommerce' == $vendor) {
                continue;
            }

            if ('Blog' == $name) {
                $blogModules[] = $module;
            }
        }

        if (count($blogModules) && $this->isEnabled()) {
            return $blogModules;
        }

        return false;
    }
}
