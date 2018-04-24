<?php
namespace DeepFish\Catalog\Override\Pricing\Render;

class FinalPriceBox extends \Magento\Catalog\Pricing\Render\FinalPriceBox
{
    protected function wrapResult($html)
    {
        return '<div class="price">'.$html.'</div>';
    }
}
