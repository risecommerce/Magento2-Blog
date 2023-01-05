<?php
/**
 * Copyright © Risecommerce (support@risecommerce.com). All rights reserved.
 * 
 *
 * Glory to Ukraine! Glory to the heroes!
 */
namespace Risecommerce\Blog\Block\Widget;

use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\View\Element\AbstractBlock;
use Risecommerce\Blog\Model\Url;

/**
 * Class Link
 */
class Link extends AbstractBlock implements \Magento\Widget\Block\BlockInterface
{
    /**
     * @var Url
     */
    private $blogUrl;

    /**
     * @var null
     */
    private $modelRepository;

    /**
     * @var mixed
     */
    private $model;

    /**
     * Link constructor.
     * @param \Magento\Framework\View\Element\Context $context
     * @param Url $blogUrl
     * @param $modelRepository
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\View\Element\Context $context,
        Url $blogUrl,
        $modelRepository,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->blogUrl = $blogUrl;
        $this->modelRepository = $modelRepository;
    }

    /**
     * @return string
     */
    protected function _toHtml()
    {
        $model = $this->getModel();
        if (!$model || !$model->getId()) {
            return '';
        }

        $href = $this->blogUrl->getUrl($model, $this->model->getControllerName());

        $title = $this->getData('title') ? trim($this->getData('title')) : '';
        if (!$title) {
            $title = $model->getTitle();
        }

        $anchorText = trim($this->getData('anchor_text'));
        if (!$anchorText) {
            $anchorText = $model->getTitle();
        }

        if (!$href) {
            return $this->escapeHtml(__($title));
        } else {
            return '<a href="' . $this->escapeUrl($href) . '" title="' . $this->escapeHtml(__($anchorText)) . '">' . $this->escapeHtml(__($title)) . '</a>';
        }
    }

    /**
     * @return mixed
     */
    private function getModel()
    {
        if (null === $this->model) {
            $this->model = false;

            try {
                $id = trim($this->getData('entity_id'));
                if ($id) {
                    $this->model = \Magento\Framework\App\ObjectManager::getInstance()
                        ->get($this->modelRepository['instance'])
                        ->getbyId($id);
                }
            } catch (\Magento\Framework\Exception\NoSuchEntityException $e) {

            }
        }
        return $this->model;
    }
}
