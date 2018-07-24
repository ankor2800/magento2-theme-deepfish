<?php
namespace DeepFish\CatalogSearch\Override\Model\Autocomplete;

class DataProvider implements \Magento\Search\Model\Autocomplete\DataProviderInterface
{
    /**
     * @var \Magento\Catalog\Helper\Image
     */
    protected $_imageHelper;

    /**
     * @var \Magento\Search\Model\Autocomplete\ItemFactory
     */
    protected $_itemFactory;

    /**
     * @var \Magento\Catalog\Model\Layer\Resolver
     */
    protected $_catalogLayer;

    /**
     * @var \Magento\Catalog\Model\Layer
     */
    protected $_layer;

    /**
     * @param \Magento\Catalog\Model\Layer\Resolver $layerResolver
     * @param \Magento\Search\Model\Autocomplete\ItemFactory $itemFactory
     * @param \Magento\Catalog\Helper\Image $imageHelper
     */
    public function __construct(
        \Magento\Catalog\Model\Layer\Resolver $layerResolver,
        \Magento\Search\Model\Autocomplete\ItemFactory $itemFactory,
        \Magento\Catalog\Helper\Image $imageHelper
    )
    {
        $this->_imageHelper = $imageHelper;
        $this->_itemFactory = $itemFactory;
        $this->_catalogLayer = $layerResolver->create($layerResolver::CATALOG_LAYER_SEARCH);
        $this->_layer = $layerResolver->get();
    }

    public function getItems()
    {
        /**
         * @var \Magento\Catalog\Model\ResourceModel\Product\Collection $product
         */
        $products = $this->_layer->getProductCollection()->setPageSize(3);

        $result = [];

        if ($products->count() > 0) {

            /** @var \Magento\Catalog\Model\Product $product */
            foreach ($products->getItems() as $product) {

                $image = $this->_imageHelper->init($product, 'product_search_grid');

                $template = $image->getFrame()
                    ? 'Magento_Catalog/product/image'
                    : 'Magento_Catalog/product/image_with_borders';

                $result[] = $this->_itemFactory->create([
                    'name' => $product->getName(),
                    'url' => $product->getProductUrl(),
                    'image' => [
                        'template' => $template,
                        'src' => $image->getUrl(),
                        'alt' => $image->getLabel(),
                        'width' => $image->getWidth(),
                        'height' => $image->getHeight()
                    ],
                    'description' => $product->getData('short_description'),
                ]);
            }
        }

        return $result;
    }
}
