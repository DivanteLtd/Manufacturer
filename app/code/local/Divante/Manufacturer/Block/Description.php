<?php
/**
 * Created by PhpStorm.
 * User: Marek Kidon
 * Date: 15.05.14
 * Time: 14:19
 */
class Divante_Manufacturer_Block_Description extends Mage_Core_Block_Template
{
    /**
     * @return Divante_Manufacturer_Model_Manufacturer
     */
    public function getManufacturer()
    {
        return Mage::getSingleton('divante_manufacturer/manufacturer');
    }

    public function getDescription()
    {
        $helper = Mage::helper('cms');
        $processor = $helper->getBlockTemplateProcessor();
        $html = $processor->filter($this->getManufacturer()->getDescription());
        return $html;
    }

    public function showBlock()
    {
        if($this->getManufacturer()->getDescription() || $this->getManufacturer()->getLogo()) {
            return true;
        }

        return false;
    }

    public function getLogoUrl()
    {
        return $this->getManufacturer()->getLogoUrl();
    }
}