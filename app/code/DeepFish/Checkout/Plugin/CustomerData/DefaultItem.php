<?php
namespace DeepFish\Checkout\Plugin\CustomerData;

class DefaultItem
{
    /** @var \Magento\Checkout\Helper\Cart */
    protected $_cartHelper;

    /** @var \Magento\Framework\DataObject\Factory */
    protected $_objectFactory;

    /**
     * @param \Magento\Checkout\Helper\Cart $cartHelper
     * @param \Magento\Framework\DataObject\Factory $objectFactory
     */
    public function __construct(
        \Magento\Checkout\Helper\Cart $cartHelper,
        \Magento\Framework\DataObject\Factory $objectFactory
    ) {
        $this->_cartHelper = $cartHelper;
        $this->_objectFactory = $objectFactory;
    }

    /**
     * Add remove_url to checkout section
     *
     * @param \Magento\Checkout\CustomerData\DefaultItem $subject
     * @param array $result
     * @return array
     */
    public function afterGetItemData(
        \Magento\Checkout\CustomerData\DefaultItem $subject,
        array $result
    ) {
        $result['remove_url'] = $this->_cartHelper->getDeletePostJson(
            $this->_objectFactory->create(['id' => $result['item_id']])
        );
        return $result;
    }
}
