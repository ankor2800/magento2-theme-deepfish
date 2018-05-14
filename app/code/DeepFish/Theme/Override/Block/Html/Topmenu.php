<?php
namespace DeepFish\Theme\Override\Block\Html;

class Topmenu extends \Magento\Theme\Block\Html\Topmenu
{
    protected function _addSubMenu($child, $childLevel, $childrenWrapClass, $limit)
    {
        $html = parent::_addSubMenu($child, $childLevel, $childrenWrapClass, $limit);

        // Add dividers for menu items top level
        if($childLevel == 0) {
            $html .= '</li><li class="divider">';
        }
        return $html;
    }
}
