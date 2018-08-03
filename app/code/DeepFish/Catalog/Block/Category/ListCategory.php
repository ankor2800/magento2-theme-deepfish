<?php
namespace DeepFish\Catalog\Block\Category;

class ListCategory extends \Magento\Framework\View\Element\Template
{
    /**
     * @var \Magento\Framework\Api\SearchCriteriaBuilder
     */
    protected $_searchCriteriaBuilder;

    /**
     * @var \Magento\Catalog\Api\CategoryListInterface
     */
    protected $_categoryList;

    /**
     * ListCategory constructor.
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param \Magento\Framework\Api\SearchCriteriaBuilder $searchCriteriaBuilder
     * @param \Magento\Catalog\Api\CategoryListInterface $categoryList
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Framework\Api\SearchCriteriaBuilder $searchCriteriaBuilder,
        \Magento\Catalog\Api\CategoryListInterface $categoryList,
        array $data = []
    )
    {
        parent::__construct($context, $data);
        $this->_searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->_categoryList = $categoryList;
    }

    /**
     * @return \Magento\Catalog\Model\Category[] $result
     */
    public function getList()
    {
        $this->_searchCriteriaBuilder->addFilter('show_index_page', true);

        /** @var \Magento\Framework\Api\SearchCriteria $searchCategories */
        $searchCategories = $this->_searchCriteriaBuilder->create();

        /** @var \Magento\Catalog\Api\Data\CategorySearchResultsInterface $categories */
        $categories = $this->_categoryList->getList($searchCategories);

        $result = [];

        /** @var \Magento\Catalog\Model\Category $category */
        foreach ($categories->getItems() as $category) {

            if ($category->getChildrenCount() > 0) {
                /** @var \Magento\Catalog\Model\ResourceModel\Category\Collection $children */
                $children = $category->getTreeModel()->getCollection();

                $children->addFieldToFilter('parent_id', $category->getData($category->getIdFieldName()));

                if ($this->getData('child-limit') > 0) {
                    $children->setPageSize($this->getData('child-limit'));
                }

                $category->setData('children', $children->getItems());
            }

            $result[] = $category;
        }

        return $result;
    }
}
