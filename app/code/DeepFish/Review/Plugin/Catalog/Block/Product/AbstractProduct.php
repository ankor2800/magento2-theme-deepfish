<?php
namespace DeepFish\Review\Plugin\Catalog\Block\Product;

class AbstractProduct extends \DeepFish\Catalog\Plugin\Block\Product\AbstractListProduct
{
    /** @var \Magento\Review\Model\ReviewFactory */
    protected $_reviewFactory;

    /** @var \Magento\Store\Model\StoreManagerInterface */
    protected $_storeManager;

    /**
     * @param \Magento\Framework\Data\Helper\PostHelper $postHelper
     * @param \Magento\Review\Model\ReviewFactory $reviewFactory
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     */
    public function __construct(
        \Magento\Framework\Data\Helper\PostHelper $postHelper,
        \Magento\Review\Model\ReviewFactory $reviewFactory,
        \Magento\Store\Model\StoreManagerInterface $storeManager
    ) {
        $this->_reviewFactory = $reviewFactory;
        $this->_storeManager = $storeManager;
        parent::__construct($postHelper);
    }

    public function afterGetJsLayout(
        \Magento\Catalog\Block\Product\AbstractProduct $subject,
        $jsLayout
    ) {
        $index = 0;

        /** @var \Magento\Review\Model\Review $review */
        $review = $this->_reviewFactory->create();

        /** @var \Magento\Catalog\Model\Product $item */
        foreach($subject->getData('product_collection') as $item) {
            if(!$item->getData('rating_summary')) {
                $review->getEntitySummary($item, $this->_storeManager->getStore()->getId());
            }

            /** @var \Magento\Review\Model\Review\Summary $ratingSummary */
            $ratingSummary = $item->getData('rating_summary');
            $jsLayout['data']['items'][$index++] += [
                'rating_summary' => intval($ratingSummary->getRatingSummary()),
                'reviews_count' => intval($ratingSummary->getReviewsCount())
            ];
        }

        return $jsLayout;
    }
}
