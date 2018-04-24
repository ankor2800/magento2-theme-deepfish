<?php
namespace DeepFish\Catalog\Plugin\CustomerData;

class CompareProducts
{
    /** @var \Magento\Catalog\Helper\Product\Compare */
    protected $_compareHelper;

    /** @var \Magento\Framework\Data\Helper\PostHelper */
    protected $_postHelper;

    /**
     * @param \Magento\Catalog\Helper\Product\Compare $compareHelper
     * @param \Magento\Framework\Data\Helper\PostHelper $postHelper
     */
    public function __construct(
        \Magento\Catalog\Helper\Product\Compare $compareHelper,
        \Magento\Framework\Data\Helper\PostHelper $postHelper
    ) {
        $this->_compareHelper = $compareHelper;
        $this->_postHelper = $postHelper;
    }

    /**
     * Delete confirmation from remove_url
     *
     * @param \Magento\Catalog\CustomerData\CompareProducts $subject
     * @param array $result
     * @return array
     */
    public function afterGetSectionData(
        \Magento\Catalog\CustomerData\CompareProducts $subject,
        array $result
    ) {
        foreach($result['items'] as &$item) {
            $data = [
                \Magento\Framework\App\ActionInterface::PARAM_NAME_URL_ENCODED => '',
                'product' => $item['id']
            ];
            $item['remove_url'] = $this->_postHelper->getPostData(
                $this->_compareHelper->getRemoveUrl(),
                $data
            );
        }

        return $result;
    }
}
