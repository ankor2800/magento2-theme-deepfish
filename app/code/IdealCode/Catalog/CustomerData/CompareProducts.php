<?php
namespace IdealCode\Catalog\CustomerData;

class CompareProducts extends \Magento\Catalog\CustomerData\CompareProducts
{
    /** @var \Magento\Framework\Data\Helper\PostHelper */
    protected $postHelper;

    /**
     * @param \Magento\Catalog\Helper\Product\Compare $helper
     * @param \Magento\Catalog\Model\Product\Url $productUrl
     * @param \Magento\Catalog\Helper\Output $outputHelper
     * @param \Magento\Framework\Data\Helper\PostHelper $postHelper
     */
    public function __construct(
        \Magento\Catalog\Helper\Product\Compare $helper,
        \Magento\Catalog\Model\Product\Url $productUrl,
        \Magento\Catalog\Helper\Output $outputHelper,
        \Magento\Framework\Data\Helper\PostHelper $postHelper
    ) {
        $this->postHelper = $postHelper;
        parent::__construct($helper, $productUrl, $outputHelper);
    }

    protected function getItems()
    {
        $items = parent::getItems();
        foreach ($items as &$item) {
            $data = [
                \Magento\Framework\App\ActionInterface::PARAM_NAME_URL_ENCODED => '',
                'product' => $item['id']
            ];
            $item['remove_url'] = $this->postHelper->getPostData($this->helper->getRemoveUrl(), $data);
        }

        return $items;
    }
}
