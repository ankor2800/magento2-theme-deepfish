<?php
namespace DeepFish\Catalog\Plugin\Framework\App\Action;

class Action
{
    /** @var \Magento\Framework\Data\Form\FormKey\Validator */
    protected $_formKeyValidator;

    /** @var \Magento\Framework\Controller\Result\JsonFactory */
    protected $_resultJsonFactory;

    /**
     * @param \Magento\Framework\Data\Form\FormKey\Validator $formKeyValidator
     * @param \Magento\Framework\Controller\Result\JsonFactory $resultJsonFactory
     */
    public function __construct(
        \Magento\Framework\Data\Form\FormKey\Validator $formKeyValidator,
        \Magento\Framework\Controller\Result\JsonFactory $resultJsonFactory
    ) {
        $this->_formKeyValidator = $formKeyValidator;
        $this->_resultJsonFactory = $resultJsonFactory;
    }

    /**
     * Handle ajax requests for product list
     *
     * @param \Magento\Framework\App\Action\Action $subject
     * @param mixed $result
     * @return mixed
     */
    public function afterExecute(
        \Magento\Framework\App\Action\Action $subject,
        $result
    ) {
        /** @var \Magento\Framework\View\Result\Page $result */
        if($result instanceof \Magento\Framework\View\Result\Page) {

            /** @var \Magento\Framework\App\Request\Http $request */
            $request = $subject->getRequest();
            $blockName = $request->getParam('block_name');

            if($blockName && $request->isAjax() && $this->_formKeyValidator->validate($request)) {

                $layout = $result->getLayout();

                // For generate cms blocks
                if(!$layout->isBlock($blockName) && $layout->isBlock('cms_page')) {
                    $layout->getBlock('cms_page')->toHtml();
                }

                if($layout->isBlock($blockName)) {

                    /** @var \Magento\Catalog\Block\Product\AbstractProduct $block */
                    $block = $layout->getBlock($blockName);

                    /** @var array $jsLayout */
                    $jsLayout = $block->getJsLayout();

                    /** @var \Magento\Framework\Controller\Result\Json $result */
                    $result = $this->_resultJsonFactory->create();
                    return $result->setData($jsLayout['data']);
                }
            }
        }

        return $result;
    }
}
