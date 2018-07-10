<?php
namespace DeepFish\Wishlist\Override\CustomerData;

class Wishlist extends \Magento\Wishlist\CustomerData\Wishlist
{
    /**
     * @return string
     */
    public function getSidebarItemsNumber()
    {
        return $this::SIDEBAR_ITEMS_NUMBER;
    }

    protected function getItems()
    {
        // Get all items in collection (parent class sets limit, only 3 items)
        $collection = $this->wishlistHelper->getWishlistItemCollection();
        $collection->clear()->setInStockFilter()->setOrder('added_at');

        $items = [];

        /** @var \Magento\Wishlist\Model\Item $wishlistItem */
        foreach($collection as $wishlistItem) {
            $items[] = $this->getItemData($wishlistItem);
        }

        return $items;
    }

    protected function getItemData(
        \Magento\Wishlist\Model\Item $wishlistItem
    ) {
        $result = parent::getItemData($wishlistItem);
        $result['product_id'] = $wishlistItem->getProduct()->getEntityId();

        return $result;
    }
}
