<?php
namespace DeepFish\Wishlist\Plugin\Catalog\Block\Product;

class ListProduct extends \DeepFish\Catalog\Plugin\Block\Product\AbstractListProduct
{
    /** @var \Magento\Wishlist\Helper\Data */
    protected $_wishlistHelper;

    /**
     * @param \Magento\Framework\Data\Helper\PostHelper $postHelper
     * @param \Magento\Wishlist\Helper\Data $wishlistHelper
     */
    public function __construct(
        \Magento\Framework\Data\Helper\PostHelper $postHelper,
        \Magento\Wishlist\Helper\Data $wishlistHelper
    ) {
        $this->_wishlistHelper = $wishlistHelper;
        parent::__construct($postHelper);
    }

    public function beforeToHtml(
        \Magento\Catalog\Block\Product\ListProduct $subject
    ) {
        if($this->_wishlistHelper->isAllow()) {
            $items = $subject->getData('jsLayoutItems');
            $index = 0;

            /** @var \Magento\Catalog\Model\Product $item */
            foreach($subject->getLoadedProductCollection() as $item) {
                $items[$index++] += [
                    'add_to_wishlist' => $this->_getAddToParams(
                        $subject->getUrl('wishlist/index/add'),
                        $item
                    )
                ];
            }

            $subject->setData('jsLayoutItems', $items);
        }
    }
}
