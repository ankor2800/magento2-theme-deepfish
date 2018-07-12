<?php
namespace DeepFish\Checkout\Plugin\Catalog\Block\Product;

class ListProduct extends \DeepFish\Catalog\Plugin\Block\Product\AbstractListProduct
{
    public function beforeToHtml(
        \Magento\Catalog\Block\Product\ListProduct $subject
    ) {
        $config = $subject->getData('jsLayoutConfig');
        $index = 0;

        /** @var \Magento\Catalog\Model\Product $item */
        foreach($subject->getLoadedProductCollection() as $item) {
            $config['items'][$index++] += [
                'price' => $subject->getProductPrice($item),
                'is_salable' => $item->isSalable(),
                'required_options' => $item->getTypeInstance()->hasRequiredOptions($item),
                'add_to_cart' => $this->_getAddToParams(
                    $subject->getUrl('checkout/cart/add'),
                    $item
                )
            ];
        }

        $subject->setData('jsLayoutConfig', $config);
    }
}
