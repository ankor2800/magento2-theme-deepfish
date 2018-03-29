<?php
namespace IdealCode\Blog\Helper;

/**
 * Blog helper
 */
class Blog extends \Magento\Framework\App\Helper\AbstractHelper
{
    /**
     * Retrieve blog url
     *
     * @return string
     */
    public function getBlogUrl()
    {
        return $this->_getUrl('blog');
    }
}
