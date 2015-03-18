<?php
/**
 * Created by PhpStorm.
 * User: Marek Kidon
 * Date: 2014-10-12
 * Time: 11:28
 */
class Divante_Manufacturer_Block_List extends Mage_Core_Block_Template
{
    /** @var Divante_Manufacturer_Model_Resource_Manufacturer_Collection|Divante_Manufacturer_Model_Manufacturer[] */
    protected $_collection;

    protected function _prepareLayout()
    {
        parent::_prepareLayout();

        $this->getLayout()->createBlock('divante_manufacturer/breadcrumbs');

        return $this;
    }

    public function getManufacturers()
    {
        if(is_null($this->_collection)) {
            $collection = Mage::getModel('divante_manufacturer/manufacturer')->getCollection();
            $collection->setOrder('label', 'ASC');
            $this->_collection = $collection;
        }

        return $this->_collection;
    }

    /**
     * @param Divante_Manufacturer_Model_Manufacturer $manufacturer
     * @return string
     */
    public function getManufacturerUrl(Divante_Manufacturer_Model_Manufacturer $manufacturer)
    {
        return $this->_getHelper()->getUrl($manufacturer);
    }

    /**
     * @return Divante_Manufacturer_Helper_Data
     */
    protected function _getHelper()
    {
        return Mage::helper('divante_manufacturer');
    }
}