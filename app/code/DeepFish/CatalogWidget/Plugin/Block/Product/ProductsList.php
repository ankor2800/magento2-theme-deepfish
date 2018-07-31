<?php
namespace DeepFish\CatalogWidget\Plugin\Block\Product;

class ProductsList
{
    /**
     * Get js layout from other block
     *
     * @param \Magento\CatalogWidget\Block\Product\ProductsList $subject
     * @param $jsLayout
     * @return mixed
     */
    public function afterGetJsLayout(
        \Magento\CatalogWidget\Block\Product\ProductsList $subject,
        $jsLayout
    ) {
        /** @var \Magento\Catalog\Block\Product\ListProduct $block */
        $block = $subject->getLayout()->createBlock(\Magento\Catalog\Block\Product\ListProduct::class);
        $block->setCollection($subject->createCollection());

        return $block->getJsLayout();
    }
}
