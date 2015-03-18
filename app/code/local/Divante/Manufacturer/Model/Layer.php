<?php
/**
 * Created by PhpStorm.
 * User: Marek Kidon
 * Date: 18.04.14
 * Time: 11:41
 */

/**
 * Class Divante_Manufacturer_Model_Layer
 */
class Divante_Manufacturer_Model_Layer extends Mage_Catalog_Model_Layer
{
    /**
     * @return Mage_Catalog_Model_Resource_Product_Collection
     */
    public function getProductCollection()
    {
        if (isset($this->_productCollections[$this->getManufacturer()->getId()][$this->getCurrentCategory()->getId()])) {
            $collection = $this->_productCollections[$this->getManufacturer()->getId()][$this->getCurrentCategory()->getId()];
        } else {
            $collection = Mage::getResourceModel('catalog/product_collection');
            $collection->addAttributeToFilter('manufacturer', array('eq' => $this->getManufacturer()->getId()));
            $collection->addCategoryFilter($this->getCurrentCategory());
            $this->prepareProductCollection($collection);
            $this->_productCollections[$this->getManufacturer()->getId()][$this->getCurrentCategory()->getId()] = $collection;
        }

        return $collection;
    }

    /**
     * @return Divante_Manufacturer_Model_Manufacturer
     */
    public function getManufacturer()
    {
        return Mage::getSingleton('divante_manufacturer/manufacturer');
    }
}