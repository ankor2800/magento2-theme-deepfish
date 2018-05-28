<?php
namespace DeepFish\Theme\Override\Block\Html;

class Topmenu extends \Magento\Theme\Block\Html\Topmenu
{
    protected function _addSubMenu($child, $childLevel, $childrenWrapClass, $limit)
    {
        $html = parent::_addSubMenu($child, $childLevel, $childrenWrapClass, $limit);

        if($childLevel == 0) {
            if(strlen($html) > 0) {
                $html = '<div class="submenu">'.$html.$child->getData('description').'</div>';
            }

            // Add dividers for menu items top level
            $html .= '</li><li class="divider">';
        }
        return $html;
    }

    protected function _getMenuItemAttributes(
        \Magento\Framework\Data\Tree\Node $item
    ) {
        $result = parent::_getMenuItemAttributes($item);
        if(empty($result['class'])) {
            unset($result['class']);
        }

        return $result;
    }

    protected function _getMenuItemClasses(
        \Magento\Framework\Data\Tree\Node $item
    ) {
        $classes = [];

        if($item->getIsActive()) {
            $classes[] = 'active';
        } elseif($item->getHasActive()) {
            $classes[] = 'has-active';
        }

        if($item->hasChildren()) {
            $classes[] = 'parent';
        }

        return $classes;
    }
}
