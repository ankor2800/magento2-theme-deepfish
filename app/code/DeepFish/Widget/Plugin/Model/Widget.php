<?php
namespace DeepFish\Widget\Plugin\Model;

class Widget
{
    /** @var \Magento\Framework\Math\Random */
    protected $_mathRandom;

    /**
     * @param \Magento\Framework\Math\Random $mathRandom
     */
    public function __construct(
        \Magento\Framework\Math\Random $mathRandom
    ) {
        $this->_mathRandom = $mathRandom;
    }

    /**
     * Adding unique name for widget block
     *
     * @param string $type
     * @param array $params
     * @param bool $asIs
     * @return array
     */
    public function beforeGetWidgetDeclaration(
        \Magento\Widget\Model\Widget $subject,
        $type,
        $params = [],
        $asIs = true
    ) {
        if(!isset($params['name'])) {
            $params['name'] = $this->_mathRandom->getUniqueHash();
        }

        return [$type, $params, $asIs];
    }
}
