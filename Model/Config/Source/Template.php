<?php
/**
 * Copyright © Risecommerce (support@risecommerce.com). All rights reserved.
 * 
 *
 * Glory to Ukraine! Glory to the heroes!
 */

declare(strict_types=1);

namespace Risecommerce\Blog\Model\Config\Source;

use Risecommerce\Blog\Model\TemplatePool;

class Template implements \Magento\Framework\Option\ArrayInterface
{
    /**
     * @var TemplatePool
     */
    private $templatePool;

    /**
     * @var string
     */
    private $templateType;

    /**
     * @var array
     */
    private $options;

    /**
     * Template constructor.
     * @param TemplatePool $templatePool
     * @param string $templateType
     */
    public function __construct(
        TemplatePool $templatePool,
        string $templateType
    ) {
        $this->templatePool = $templatePool;
        $this->templateType = $templateType;
    }

    /**
     * {@inheritdoc}
     *
     * @codeCoverageIgnore
     */
    public function toOptionArray():array
    {
        if (!$this->templateType) {
            return[];
        }
        if (!isset($this->options[$this->templateType])) {
            $this->options[$this->templateType] = [];
            foreach ($this->templatePool->getAll($this->templateType) as $value => $info) {
                $this->options[$this->templateType][] = ['value' => $info['value'], 'label' => $info['label']];
            }
        }
        return $this->options[$this->templateType];
    }
}
