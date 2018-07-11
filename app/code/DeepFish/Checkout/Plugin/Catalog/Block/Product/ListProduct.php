<?php
namespace DeepFish\Checkout\Plugin\Catalog\Block\Product;

class ListProduct extends \DeepFish\Catalog\Plugin\Block\Product\AbstractListProduct
{
    public function beforeToHtml(
        \Magento\Catalog\Block\Product\ListProduct $subject
    ) {
        $items = $subject->getData('jsLayoutItems');
        $index = 0;

        /** @var \Magento\Catalog\Model\Product $item */
        foreach($subject->getLoadedProductCollection() as $item) {
            $items[$index++] += [
                'price' => $subject->getProductPrice($item),
                'is_salable' => $item->isSalable(),
                'required_options' => $item->getData('required_options') > 0,
                'add_to_cart' => $this->_getAddToParams(
                    $subject->getUrl('checkout/cart/add'),
                    $item
                )
            ];
        }

        $subject->setData('jsLayoutItems', $items);
    }
}
