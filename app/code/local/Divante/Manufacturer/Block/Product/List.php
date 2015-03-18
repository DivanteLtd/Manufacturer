<?php
/**
 * Created by PhpStorm.
 * User: Marek Kidon
 * Date: 18.04.14
 * Time: 11:38
 */
class Divante_Manufacturer_Block_Product_List extends Mage_Catalog_Block_Product_List
{
    protected function _prepareLayout()
    {
        parent::_prepareLayout();

        $this->getLayout()->createBlock('divante_manufacturer/breadcrumbs');

        return $this;
    }

    /**
     * @return Divante_Manufacturer_Model_Layer
     */
    public function getLayer()
    {
        return Mage::getSingleton('divante_manufacturer/layer');
    }

    /**
     * @return Divante_Manufacturer_Helper_Data
     */
    public function getManufacturerHelper()
    {
        return Mage::helper('divante_manufacturer');
    }

    /**
     * @return Divante_Manufacturer_Model_Manufacturer
     */
    public function getManufacturer()
    {
        return Mage::getSingleton('divante_manufacturer/manufacturer');
    }
}
