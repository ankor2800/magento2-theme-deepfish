<?php
namespace DeepFish\Wishlist\Plugin\Catalog\Block\Widget;

class RecentlyProducts
{
    /** @var \Magento\Wishlist\Helper\Data */
    protected $_helper;

    /**
     * @param \Magento\Wishlist\Helper\Data $helper
     */
    function __construct(
        \Magento\Wishlist\Helper\Data $helper
    ) {
        $this->_helper = $helper;
    }

    /**
     * Extend JS layout for recently product block widgets
     *
     * @param \Magento\Framework\View\Element\Template $subject
     */
    public function beforeToHtml(
        \Magento\Framework\View\Element\Template $subject
    ) {
        $showButtons = $subject->getData('show_buttons');

        if(in_array('add_to_wishlist', $showButtons)) {
            if($this->_helper->isAllow()) {
                $jsLayout = [
                    'children' => [
                        'additionalButtons' => [
                            'component' => 'uiComponent',
                            'config' => [
                                'displayArea' => 'additionalButtons'
                            ],
                            'children' => [
                                'addToWishlist' => [
                                    'component' => 'uiComponent',
                                    'config' => [
                                        'template' =>
                                            'DeepFish_Wishlist/catalog-recently-widget/sidebar/add-to-wishlist'
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
            } else {
                unset($showButtons[array_search('add_to_wishlist', $showButtons)]);
                $subject->setData('show_buttons', $showButtons);
            }
        }
    }
}
