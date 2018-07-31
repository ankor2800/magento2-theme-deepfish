<?php
namespace DeepFish\Catalog\Plugin\Block\Product;

class AbstractProduct extends AbstractListProduct
{
    /** @var \Magento\Catalog\Helper\Image */
    protected $_imageHelper;

    /**
     * @param \Magento\Framework\Data\Helper\PostHelper $postHelper
     * @param \Magento\Catalog\Helper\Image $imageHelper
     */
    public function __construct(
        \Magento\Framework\Data\Helper\PostHelper $postHelper,
        \Magento\Catalog\Helper\Image $imageHelper
    ) {
        $this->_imageHelper = $imageHelper;
        parent::__construct($postHelper);
    }

    public function afterGetJsLayout(
        \Magento\Catalog\Block\Product\AbstractProduct $subject,
        $jsLayout
    ) {
        /** @var \Magento\Framework\View\Element\Template $jsLayoutBlock */
        $jsLayoutBlock = $subject->getLayout()->getBlock('catalog.product.list');
        $jsLayout = $jsLayoutBlock->getData('jsLayout');

        $jsLayout['data'] = [
            'items' => []
        ];

        if(method_exists($subject, 'createCollection')) {
            $subject->setData('product_collection', $subject->createCollection());
        } else {
            $subject->setData('product_collection', $subject->getLoadedProductCollection());
        }

        /** @var \Magento\Catalog\Model\Product $item */
        foreach($subject->getData('product_collection') as $item) {
            $image = $this->_imageHelper->init($item, 'category_page_grid');

            $jsLayout['data']['items'][] = [
                'id' => $item->getEntityId(),
                'name' => $item->getName(),
                'url' => $item->getProductUrl(),
                'image' => [
                    'src' => $image->getUrl(),
                    'alt' => $image->getLabel()
                ],
                'description' => $item->getData('short_description'),
                'add_to_compare' => $this->_getAddToParams($subject->getAddToCompareUrl(), $item)
            ];
        }

        return $jsLayout;
    }
}
