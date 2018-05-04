<?php

namespace DeepFish\Theme\Block\Html;

/**
 * Social links
 */
class Socials extends \Magento\Framework\View\Element\Template
{
    /**
     * @var array
     */
    protected $_socials = [
        'facebook' => [
            'href' => 'https://www.facebook.com/',
            'icon' => 'fa-facebook'
        ],
        'twitter' => [
            'href' => 'https://twitter.com/',
            'icon' => 'fa-twitter'
        ],
        'google' => [
            'href' => 'https://plus.google.com/',
            'icon' => 'fa-google-plus'
        ]
    ];

    /**
     * Return social list
     *
     * @return array
     */
    public function renderSocials()
    {
        return $this->_socials;
    }
}
