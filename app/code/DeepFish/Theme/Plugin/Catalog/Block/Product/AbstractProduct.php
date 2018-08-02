<?php
namespace DeepFish\Theme\Plugin\Catalog\Block\Product;

class AbstractProduct extends \DeepFish\Catalog\Plugin\Block\Product\AbstractListProduct
{
    /** @var \Magento\Framework\App\Config\ScopeConfigInterface */
    protected $_scopeConfig;

    /**
     * @param \Magento\Framework\Data\Helper\PostHelper $postHelper
     * @param \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
     */
    public function __construct(
        \Magento\Framework\Data\Helper\PostHelper $postHelper,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
    ) {
        $this->_scopeConfig = $scopeConfig;
        parent::__construct($postHelper);
    }

    public function afterGetJsLayout(
        \Magento\Catalog\Block\Product\AbstractProduct $subject,
        $jsLayout
    ) {
        if($subject->getData('show_pager')) {

            /** @var \Magento\Theme\Block\Html\Pager $pager */
            $pager = $subject->getLayout()->createBlock(\Magento\Theme\Block\Html\Pager::class);

            /** @var \Magento\Catalog\Model\ResourceModel\Product\Collection $collection */
            $collection = $subject->getData('product_collection');

            if($subject->getData('page_var_name')) {
                $pager->setPageVarName($subject->getData('page_var_name'));
            }

            $pager
                ->setFrameLength(
                    $this->_scopeConfig->getValue(
                        'design/pagination/pagination_frame',
                        \Magento\Store\Model\ScopeInterface::SCOPE_STORE
                    )
                )
                ->setJump(
                    $this->_scopeConfig->getValue(
                        'design/pagination/pagination_frame_skip',
                        \Magento\Store\Model\ScopeInterface::SCOPE_STORE
                    )
                )
                ->setLimit($collection->getPageSize())
                ->setCollection($collection);

            $jsLayout['data']['pager'] = [
                'anchor_text_for_next' => $pager->getAnchorTextForNext(),
                'anchor_text_for_previous' => $pager->getAnchorTextForPrevious(),
                'cur_page' => $pager->getCurrentPage(),
                'last_page_num' => $pager->getLastPageNum(),
                'can_show_first' => $pager->canShowFirst(),
                'can_show_last' => $pager->canShowLast(),
                'can_show_next_jump' => $pager->canShowNextJump(),
                'can_show_previous_jump' => $pager->canShowPreviousJump(),
                'frame_pages' => $pager->getFramePages(),
                'page_var_name' => $pager->getPageVarName()
            ];
            $jsLayout['params'][$pager->getPageVarName()] = $pager->getCurrentPage();
        }

        return $jsLayout;
    }
}
