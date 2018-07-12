<?php
namespace DeepFish\Catalog\Plugin\Block\Product;

abstract class AbstractListProduct
{
    /** @var \Magento\Framework\Data\Helper\PostHelper */
    protected $_postHelper;

    /**
     * @param \Magento\Framework\Data\Helper\PostHelper $postHelper
     */
    public function __construct(
        \Magento\Framework\Data\Helper\PostHelper $postHelper
    ) {
        $this->_postHelper = $postHelper;
    }

    /**
     * Prepare config for js layout
     *
     * @param \Magento\Catalog\Block\Product\ListProduct $subject
     */
    abstract public function beforeToHtml(
        \Magento\Catalog\Block\Product\ListProduct $subject
    );

    /**
     * @param string $url
     * @param \Magento\Catalog\Model\Product $item
     * @return string
     */
    protected function _getAddToParams($url, \Magento\Catalog\Model\Product $item)
    {
        return $this->_postHelper->getPostData($url, [
            'product' => $item->getEntityId(),
            \Magento\Framework\App\ActionInterface::PARAM_NAME_URL_ENCODED => ''
        ]);
    }
}
