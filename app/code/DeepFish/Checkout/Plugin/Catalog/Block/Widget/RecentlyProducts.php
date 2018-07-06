<?php
namespace DeepFish\Checkout\Plugin\Catalog\Block\Widget;

class RecentlyProducts
{
    /**
     * Extend JS layout for recently product block widgets
     *
     * @param \Magento\Framework\View\Element\Template $subject
     */
    public function beforeToHtml(
        \Magento\Framework\View\Element\Template $subject
    ) {
        $showButtons = $subject->getData('show_buttons');

        if(in_array('add_to_cart', $showButtons)) {
            $jsLayout = [
                'children' => [
                    'additionalButtons' => [
                        'component' => 'uiComponent',
                        'config' => [
                            'displayArea' => 'additionalButtons'
                        ],
                        'children' => [
                            'addToCart' => [
                                'component' => 'uiComponent',
                                'config' => [
                                    'template' => 'DeepFish_Checkout/catalog-recently-widget/sidebar/add-to-cart'
                                ]
                            ]
                        ]
                    ]
                ]
            ];

            $subject->setData(
                'jsLayout',
                array_replace_recursive($subject->getData('jsLayout'), $jsLayout)
            );
        }
    }
}
