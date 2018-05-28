<?php
namespace DeepFish\Catalog\Observer;

class PageBlockHtmlTopmenuGethtmlBefore implements \Magento\Framework\Event\ObserverInterface
{
    /** @var \Magento\Catalog\Api\CategoryRepositoryInterface */
    protected $_categoryRepository;

    /**
     * @param \Magento\Catalog\Api\CategoryRepositoryInterface $categoryRepository
     */
    public function __construct(
        \Magento\Catalog\Api\CategoryRepositoryInterface $categoryRepository
    ) {
        $this->_categoryRepository = $categoryRepository;
    }

    /**
     * Add additional category description for navigation menu
     *
     * @param \Magento\Framework\Event\Observer $observer
     * @return void
     */
    public function execute(
        \Magento\Framework\Event\Observer $observer
    ) {
        /** @var \Magento\Framework\Data\Tree\Node $menu */
        $menu = $observer->getData('menu');

        /** @var \Magento\Framework\Data\Tree\Node $node */
        foreach($menu->getChildren() as $node) {
            preg_match("/\d+/", $node->getId(), $matches);
            $categoryId = intval($matches[0]);

            if($categoryId > 0) {
                $category = $this->_categoryRepository->get($categoryId);

                if($category) {
                    $descriptionAttribute = $category->getCustomAttribute('menu_description');

                    $node->setData(
                        'description',
                        $descriptionAttribute ? $descriptionAttribute->getValue() : ''
                    );
                }
            }
        }
    }
}
