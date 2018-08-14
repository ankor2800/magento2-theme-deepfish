<?php
namespace DeepFish\Catalog\Plugin\Block\Product;

use \Magento\Catalog\Model\Product\ProductList\Toolbar;

class AbstractProduct extends AbstractListProduct
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

    public function afterGetJsLayout(
        \Magento\Catalog\Block\Product\AbstractProduct $subject,
        $jsLayout
    ) {
        /** @var \Magento\Framework\View\Element\Template $jsLayoutBlock */
        $jsLayoutBlock = $subject->getLayout()->getBlock('catalog.product.list');
        $jsLayout = $jsLayoutBlock->getData('jsLayout');

        $jsLayout['data'] = [
            'items' => []
        ];
        $jsLayout['params'] = [
            'block_name' => $subject->getNameInLayout()
        ];

        /** @var \Magento\Catalog\Model\ResourceModel\Product\Collection $collection */
        if(method_exists($subject, 'getItems')) {
            $collection = $subject->getItems();
        } elseif(method_exists($subject, 'createCollection')) {
            $collection = $subject->createCollection();
        } else {
            $collection = $subject->getLoadedProductCollection();
        }

        if($subject->getData('show_toolbar')) {

            /** @var \Magento\Catalog\Block\Product\ProductList\Toolbar $toolbar */
            $toolbar = $subject->getLayout()->createBlock(
                \Magento\Catalog\Block\Product\ProductList\Toolbar::class
            );
            $orderVarName = Toolbar::ORDER_PARAM_NAME;
            $directionVarName = Toolbar::DIRECTION_PARAM_NAME;
            $limitVarName = Toolbar::LIMIT_PARAM_NAME;
            $modeVarName = Toolbar::MODE_PARAM_NAME;
            $firstNum = $collection->getPageSize() * ($collection->getCurPage() - 1);
            $imageId = 'category_page_'.$toolbar->getCurrentMode();

            $jsLayout['data']['toolbar'] = [
                'modes' => $toolbar->getModes(),
                'orders' => $toolbar->getAvailableOrders(),
                'limits' => array_keys($toolbar->getAvailableLimit()),
                'cur_mode' => $toolbar->getCurrentMode(),
                'cur_order' => $toolbar->getCurrentOrder(),
                'cur_direction' => $toolbar->getCurrentDirection(),
                'cur_limit' => $toolbar->getLimit(),
                'first_num' => $firstNum + 1,
                'last_num' => $firstNum + $collection->count(),
                'total_num' => $collection->getSize(),
                'mode_var_name' => $modeVarName,
                'order_var_name' => $orderVarName,
                'direction_var_name' => $directionVarName,
                'limit_var_name' => $limitVarName
            ];

            $jsLayout['params'][$modeVarName] = $toolbar->getCurrentMode();
            $jsLayout['params'][$orderVarName] = $toolbar->getCurrentOrder();
            $jsLayout['params'][$directionVarName] = $toolbar->getCurrentDirection();
            $jsLayout['params'][$limitVarName] = $toolbar->getLimit();
        }

        /** @var \Magento\Catalog\Model\Product $item */
        foreach($collection as $item) {
            $image = $this->_imageHelper->init($item, isset($imageId) ? $imageId : 'category_page_grid');
            $imageTemplate = $image->getFrame() ?
                'Magento_Catalog/product/image' :
                'Magento_Catalog/product/image_with_borders';

            $jsLayout['data']['items'][] = [
                'id' => $item->getEntityId(),
                'name' => $item->getName(),
                'url' => $item->getProductUrl(),
                'image' => [
                    'template' => $imageTemplate,
                    'src' => $image->getUrl(),
                    'width' => $image->getWidth(),
                    'height' => $image->getHeight(),
                    'alt' => $image->getLabel()
                ],
                'description' => $item->getData('short_description'),
                'add_to_compare' => $this->_getAddToParams($subject->getAddToCompareUrl(), $item)
            ];
        }

        $subject->setData('product_collection', $collection);
        return $jsLayout;
    }
}
