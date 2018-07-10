<?php
namespace DeepFish\CatalogAjax\Plugin\Catalog\Block\Product;

class ListProduct
{
    /** @var \Magento\Catalog\Helper\Image */
    protected $_imageHelper;

    /** @var \Magento\Framework\Data\Helper\PostHelper */
    protected $_postHelper;

    /**
     * @param \Magento\Catalog\Helper\Image $imageHelper
     * @param \Magento\Framework\Data\Helper\PostHelper $postHelper
     */
    public function __construct(
        \Magento\Catalog\Helper\Image $imageHelper,
        \Magento\Framework\Data\Helper\PostHelper $postHelper
    ) {
        $this->_imageHelper = $imageHelper;
        $this->_postHelper = $postHelper;
    }

    /**
     * Prepare information about products for JS render
     *
     * @param \Magento\Catalog\Block\Product\ListProduct $subject
     */
    public function beforeToHtml(
        \Magento\Catalog\Block\Product\ListProduct $subject
    ) {
        $items = [];

        /** @var \Magento\Catalog\Model\Product $item */
        foreach($subject->getLoadedProductCollection() as $item) {
            $image = $this->_imageHelper->init($item, 'category_page_grid');
            $addToCompare = $this->_postHelper->getPostData(
                $subject->getAddToCompareUrl(),
                [
                    'product' => $item->getEntityId(),
                    \Magento\Framework\App\ActionInterface::PARAM_NAME_URL_ENCODED => ''
                ]
            );

            $items[] = [
                'id' => $item->getEntityId(),
                'name' => $item->getName(),
                'url' => $item->getProductUrl(),
                'image' => [
                    'src' => $image->getUrl(),
                    'alt' => $image->getLabel()
                ],
                'description' => $item->getData('short_description'),
                'add_to_compare' => $addToCompare
            ];
        }

        $subject->setData('jsLayoutItems', $items);
    }
}
