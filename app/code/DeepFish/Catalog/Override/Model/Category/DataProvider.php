<?php
namespace DeepFish\Catalog\Override\Model\Category;

class DataProvider extends \Magento\Catalog\Model\Category\DataProvider
{
    protected function getFieldsMap()
    {
        $result = parent::getFieldsMap();

        $result['general'][] = 'show_index_page';
        $result['content'][] = 'menu_description';

        return $result;
    }
}
