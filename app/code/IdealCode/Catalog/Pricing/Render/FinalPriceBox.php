<?php
namespace IdealCode\Catalog\Pricing\Render;

class FinalPriceBox extends \Magento\Catalog\Pricing\Render\FinalPriceBox
{
    public function wrapResult($html)
    {
        return '<div class="price">'.$html.'</div>';
    }
}
