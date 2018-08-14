<?php
namespace DeepFish\Checkout\Plugin\Catalog\Block\Product;

class AbstractProduct extends \DeepFish\Catalog\Plugin\Block\Product\AbstractListProduct
{
    public function afterGetJsLayout(
        \Magento\Catalog\Block\Product\AbstractProduct $subject,
        $jsLayout
    ) {
        $index = 0;

        /** @var \Magento\Catalog\Model\Product $item */
        foreach($subject->getData('product_collection') as $item) {
            $jsLayout['data']['items'][$index++] += [
                'format_price' => $subject->getProductPrice($item),
                'is_salable' => $item->isSalable(),
                'required_options' => $item->getTypeInstance()->hasRequiredOptions($item),
                'add_to_cart' => $this->_getAddToParams(
                    $subject->getUrl('checkout/cart/add'),
                    $item
                )
            ];
        }

        return $jsLayout;
    }
}
