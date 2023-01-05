<?php
/**
 * Copyright © Risecommerce (support@risecommerce.com). All rights reserved.
 * 
 *
 * Glory to Ukraine! Glory to the heroes!
 */

namespace Risecommerce\Blog\Block\Sidebar;

use Magento\Store\Model\ScopeInterface;

/**
 * Blog sidebar custom block
 */
class Custom extends \Magento\Framework\View\Element\Template
{
    use Widget;

    /**
     * @var \Magento\Cms\Model\Template\FilterProvider
     */
    protected $filterProvider;

    /**
     * Construct
     *
     * @param \Magento\Framework\View\Element\Context $context
     * @param \Risecommerce\Blog\Model\Url $url
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Cms\Model\Template\FilterProvider $filterProvider,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->filterProvider = $filterProvider;
    }

    /**
     * @var string
     */
    protected $_widgetKey = 'custom';

    /**
     * Retrieve filtered content
     *
     * @return string
     */
    public function getContent()
    {
        $key = 'content';
        if (!$this->hasData($key)) {
            $content = $this->_scopeConfig->getValue(
                'rcblog/sidebar/'.$this->_widgetKey.'/html',
                ScopeInterface::SCOPE_STORE
            );
            $content = $this->filterProvider->getPageFilter()->filter(
                (string) $content ?: ''
            );
            $this->setData($key, $content);
        }
        return $this->getData($key);
    }

    /**
     * Get cache key informative items
     *
     * @return array
     */
    public function getCacheKeyInfo()
    {
        $cacheKeyInfo = parent::getCacheKeyInfo();
        $cacheKeyInfo['block_name'] = $this->getNameInLayout();
        return $cacheKeyInfo;
    }
}
