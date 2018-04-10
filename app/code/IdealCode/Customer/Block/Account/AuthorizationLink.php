<?php

namespace IdealCode\Customer\Block\Account;

/**
 * Customer authorization link
 */
class AuthorizationLink extends \Magento\Framework\View\Element\Template
{
    /**
     * @var \Magento\Customer\Model\Url
     */
    protected $_customerUrl;

    /**
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param \Magento\Customer\Model\Url $customerUrl
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Customer\Model\Url $customerUrl,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->_customerUrl = $customerUrl;
    }

    /**
     * Login url
     *
     * @return string
     */
    public function getLoginUrl()
    {
        return $this->_customerUrl->getLoginUrl();
    }

    /**
     * Logout url
     *
     * @return string
     */
    public function getLogoutUrl()
    {
        return $this->_customerUrl->getLogoutUrl();
    }
}
