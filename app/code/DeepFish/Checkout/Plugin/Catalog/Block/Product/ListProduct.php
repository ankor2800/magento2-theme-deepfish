<?php
namespace DeepFish\Checkout\Plugin\Catalog\Block\Product;

class ListProduct
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
     * Extend JS layout for product list block
     *
     * @param \Magento\Catalog\Block\Product\ListProduct $subject
     */
    public function beforeToHtml(
        \Magento\Catalog\Block\Product\ListProduct $subject
    ) {
        $items = $subject->getData('jsLayoutItems');
        $index = 0;

        /** @var \Magento\Catalog\Model\Product $item */
        foreach($subject->getLoadedProductCollection() as $item) {
            $addToCart = $this->_postHelper->getPostData(
                $subject->getUrl('checkout/cart/add'),
                [
                    'product' => $item->getEntityId(),
                    \Magento\Framework\App\ActionInterface::PARAM_NAME_URL_ENCODED => ''
                ]
            );

            $items[$index++] += [
                'price' => $subject->getProductPrice($item),
                'is_salable' => $item->isSalable(),
                'required_options' => $item->getData('required_options') > 0,
                'add_to_cart' => $addToCart
            ];
        }

        $subject->setData('jsLayoutItems', $items);
    }
}
