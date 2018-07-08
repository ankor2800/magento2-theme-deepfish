<?php
namespace DeepFish\CatalogAjax\Plugin\Catalog\Block\Product;

class ListProduct
{
    /** @var \Magento\Catalog\Helper\Image */
    protected $_imageHelper;

    /**
     * @param \Magento\Catalog\Helper\Image $imageHelper
     */
    public function __construct(
        \Magento\Catalog\Helper\Image $imageHelper
    ) {
        $this->_imageHelper = $imageHelper;
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

            $items[] = [
                'id' => $item->getEntityId(),
                'name' => $item->getName(),
                'url' => $item->getProductUrl(),
                'image' => [
                    'src' => $image->getUrl(),
                    'alt' => $image->getLabel()
                ],
                'description' => $item->getData('short_description')
            ];
        }

        $subject->setData('jsLayoutItems', $items);
    }
}
