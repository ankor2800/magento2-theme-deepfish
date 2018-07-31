<?php
namespace DeepFish\Wishlist\Plugin\Catalog\Block\Product;

class AbstractProduct extends \DeepFish\Catalog\Plugin\Block\Product\AbstractListProduct
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

    public function afterGetJsLayout(
        \Magento\Catalog\Block\Product\AbstractProduct $subject,
        $jsLayout
    ) {
        if($this->_wishlistHelper->isAllow()) {
            $index = 0;

            /** @var \Magento\Catalog\Model\Product $item */
            foreach($subject->getData('product_collection') as $item) {
                $jsLayout['data']['items'][$index++] += [
                    'add_to_wishlist' => $this->_getAddToParams(
                        $subject->getUrl('wishlist/index/add'),
                        $item
                    )
                ];
            }
        }

        return $jsLayout;
    }
}
