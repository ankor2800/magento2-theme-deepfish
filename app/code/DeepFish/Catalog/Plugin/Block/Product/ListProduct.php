<?php
namespace DeepFish\Catalog\Plugin\Block\Product;

class ListProduct extends AbstractListProduct
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

    public function beforeToHtml(
        \Magento\Catalog\Block\Product\ListProduct $subject
    ) {
        $config = $subject->getData('jsLayoutConfig');
        $config['items'] = $config['items'] ?: [];

        /** @var \Magento\Catalog\Model\Product $item */
        foreach($subject->getLoadedProductCollection() as $item) {
            $image = $this->_imageHelper->init($item, 'category_page_grid');

            $config['items'][] = [
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

        $subject->setData('jsLayoutConfig', $config);
    }
}
