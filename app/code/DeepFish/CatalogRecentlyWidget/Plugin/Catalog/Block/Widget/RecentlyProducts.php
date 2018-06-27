<?php
namespace DeepFish\CatalogRecentlyWidget\Plugin\Catalog\Block\Widget;

class RecentlyProducts
{
    /**
     * Edit widget arguments before work
     *
     * @param \Magento\Framework\View\Element\Template $subject
     */
    public function beforeToHtml(
        \Magento\Framework\View\Element\Template $subject
    ) {
        foreach(['show_attributes', 'show_buttons'] as $item) {
            $value = $subject->getData($item);
            $subject->setData($item, $value ? explode(',', $value) : []);
        }

        if(!$subject->hasData('jsLayout')) {
            $subject->setData('jsLayout', []);
        }
    }
}
