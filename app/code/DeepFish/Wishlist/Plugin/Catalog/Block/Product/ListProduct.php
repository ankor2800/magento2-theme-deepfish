<?php
namespace DeepFish\Wishlist\Plugin\Catalog\Block\Product;

class ListProduct
{
    /** @var \Magento\Wishlist\Helper\Data */
    protected $_wishlistHelper;

    /** @var \Magento\Framework\Data\Helper\PostHelper */
    protected $_postHelper;

    /**
     * @param \Magento\Wishlist\Helper\Data $wishlistHelper
     * @param \Magento\Framework\Data\Helper\PostHelper $postHelper
     */
    public function __construct(
        \Magento\Wishlist\Helper\Data $wishlistHelper,
        \Magento\Framework\Data\Helper\PostHelper $postHelper
    ) {
        $this->_wishlistHelper = $wishlistHelper;
        $this->_postHelper = $postHelper;
    }

    /**
     * Extend JS layout for product list block
     *
     * @param \Magento\Catalog\Block\Product\ListProduct $subject
     */
    public function beforeToHtml(
        \Magento\Catalog\Block\Product\ListProduct $subject
    ) {
        if($this->_wishlistHelper->isAllow()) {
            $items = $subject->getData('jsLayoutItems');
            $index = 0;

            /** @var \Magento\Catalog\Model\Product $item */
            foreach($subject->getLoadedProductCollection() as $item) {
                $addToWishlist = $this->_postHelper->getPostData(
                    $subject->getUrl('wishlist/index/add'),
                    [
                        'product' => $item->getEntityId(),
                        \Magento\Framework\App\ActionInterface::PARAM_NAME_URL_ENCODED => ''
                    ]
                );

                $items[$index++] += [
                    'add_to_wishlist' => $addToWishlist
                ];
            }

            $subject->setData('jsLayoutItems', $items);
        }
    }
}
