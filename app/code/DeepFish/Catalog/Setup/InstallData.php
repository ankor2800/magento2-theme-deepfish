<?php
namespace DeepFish\Catalog\Setup;

class InstallData implements \Magento\Framework\Setup\InstallDataInterface
{
    /** @var \Magento\Eav\Setup\EavSetupFactory */
    protected $_eavSetupFactory;

    /**
     * @param \Magento\Eav\Setup\EavSetupFactory $eavSetupFactory
     */
    public function __construct(
        \Magento\Eav\Setup\EavSetupFactory $eavSetupFactory
    ) {
        $this->_eavSetupFactory = $eavSetupFactory;
    }

    public function install(
        \Magento\Framework\Setup\ModuleDataSetupInterface $setup,
        \Magento\Framework\Setup\ModuleContextInterface $context
    ) {
        /** @var \Magento\Eav\Setup\EavSetup $eavSetup */
        $eavSetup = $this->_eavSetupFactory->create(['setup' => $setup]);

        $eavSetup->addAttribute(\Magento\Catalog\Model\Category::ENTITY, 'menu_description', [
            'type' => 'text',
            'label' => 'Menu Description',
            'required' => false,
            'global' => \Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface::SCOPE_STORE,
            'wysiwyg_enabled' => true
        ]);
    }
}
