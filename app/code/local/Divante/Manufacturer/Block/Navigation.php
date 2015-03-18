<?php
/**
 * Created by PhpStorm.
 * User: Marek Kidon
 * Date: 2014-10-12
 * Time: 15:08
 */
class Divante_Manufacturer_Block_Navigation extends Mage_Catalog_Block_Navigation
{
    /**
     * @return Divante_Manufacturer_Model_Manufacturer
     */
    public function getManufacturer()
    {
        return Mage::getSingleton('divante_manufacturer/manufacturer');
    }

    public function getCurrentCategory()
    {
        if (Mage::getSingleton('divante_manufacturer/layer')) {
            return Mage::getSingleton('divante_manufacturer/layer')->getCurrentCategory();
        }
        return false;
    }

    public function getCurrentChildCategories()
    {
        if (null === $this->_currentChildCategories) {
            $layer = Mage::getSingleton('divante_manufacturer/layer');
            $category = $layer->getCurrentCategory();
            $this->_currentChildCategories = $category->getChildrenCategories();
            $productCollection = $this->getManufacturer()->getProductCollection();
            $layer->prepareProductCollection($productCollection);
            $productCollection->addCountToCategories($this->_currentChildCategories);
        }
        return $this->_currentChildCategories;
    }

    /**
     * @param Mage_Catalog_Model_Category $category
     * @return string
     */
    public function getCategoryUrl($category)
    {
        return $this->_getHelper()->getUrl($this->getManufacturer(), $category);
    }

    /**
     * @return Divante_Manufacturer_Helper_Data
     */
    protected function _getHelper()
    {
        return Mage::helper('divante_manufacturer');
    }
}