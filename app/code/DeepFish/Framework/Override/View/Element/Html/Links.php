<?php
namespace DeepFish\Framework\Override\View\Element\Html;

class Links extends \Magento\Framework\View\Element\Html\Links
{
    const SORT_ORDER = 'sortOrder';

    /**
     * Get links
     */
    public function getLinks()
    {
        // get links
        $links = parent::getLinks();

        // sorting
        usort($links, [$this, 'compare']);
        return $links;
    }

    /**
     * Compare sortOrder in links.
     *
     * @param \Magento\Framework\View\Element\Html\Link $firstLink
     * @param \Magento\Framework\View\Element\Html\Link $secondLink
     * @return boolean
     */
    private function compare($firstLink, $secondLink)
    {
        return ($firstLink->getData(self::SORT_ORDER) > $secondLink->getData(self::SORT_ORDER));
    }
}
