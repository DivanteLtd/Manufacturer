<?php
/**
 * Created by PhpStorm.
 * User: Marek Kidon
 * Date: 18.04.14
 * Time: 11:22
 */

class Divante_Manufacturer_IndexController extends Mage_Core_Controller_Front_Action
{
    /**
     * @return bool|Divante_Manufacturer_Model_Manufacturer
     */
    protected function _initManufacturer()
    {
        if(!Mage::getSingleton('divante_manufacturer/manufacturer')->getId()) {
            $manufacturerId = $this->getRequest()->getParam('id', false);

            if($manufacturerId) {
                /** @var Divante_Manufacturer_Model_Manufacturer $category */
                $manufacturer = Mage::getSingleton('divante_manufacturer/manufacturer')->load($manufacturerId);

                if($manufacturer->getId()) {
                    return $manufacturer;
                }
            }

            return false;
        }

        return Mage::getSingleton('divante_manufacturer/manufacturer');
    }

    /**
     * @return bool|Mage_Catalog_Model_Category
     */
    protected function _initCategory()
    {
        $categoryId = $this->getRequest()->getParam('category', false);

        if($categoryId) {
            /** @var Mage_Catalog_Model_Category $category */
            $category = Mage::getModel('catalog/category')->load($categoryId);

            if($category->getId()) {
                Mage::register('current_category', $category);
                Mage::register('category', $category);

                return $category;
            }
        }

        $category = Mage::getModel('catalog/category')->load(Mage::app()->getStore()->getRootCategoryId());
        Mage::register('current_category', $category);
        Mage::register('category', $category);

        return $category;
    }

    public function manufacturerAction()
    {
        if($manufacturer = $this->_initManufacturer()) {
            $this->_initCategory();
            $this->loadLayout();

            /** @var Mage_Page_Block_Html_Head $headBlock */
            $headBlock = $this->getLayout()->getBlock('head');

            if($headBlock) {
                $headBlock->setDescription($manufacturer->getMetaDescription());
                $headBlock->setKeywords($manufacturer->getMetaKeywords());
            }

            return $this->renderLayout();
        }

        Mage::getSingleton('core/session')->addError($this->__('Producent nie został odnaleziony.'));
        return $this->_redirect('');
    }

    public function indexAction()
    {
        $this->loadLayout();
        $this->renderLayout();
    }
}
