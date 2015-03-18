<?php
/**
 * Created by PhpStorm.
 * User: Marek Kidon
 * Date: 2014-10-12
 * Time: 15:56
 */
class Divante_Manufacturer_Block_Breadcrumbs extends Mage_Core_Block_Template
{
    /**
     * Retrieve HTML title value separator (with space)
     *
     * @param mixed $store
     * @return string
     */
    public function getTitleSeparator($store = null)
    {
        $separator = (string)Mage::getStoreConfig('catalog/seo/title_separator', $store);
        return ' ' . $separator . ' ';
    }

    /**
     * Preparing layout
     *
     * @return Mage_Catalog_Block_Breadcrumbs
     */
    protected function _prepareLayout()
    {
        /** @var Mage_Page_Block_Html_Breadcrumbs $breadcrumbsBlock */
        $breadcrumbsBlock = $this->getLayout()->getBlock('breadcrumbs');

        if ($breadcrumbsBlock) {
            $breadcrumbsBlock->addCrumb('home', array(
                'label'=>Mage::helper('catalog')->__('Home'),
                'title'=>Mage::helper('catalog')->__('Go to Home Page'),
                'link'=>Mage::getBaseUrl()
            ));

            $title = array();
            $title[] = $this->__('Producenci');

            $breadcrumbsBlock->addCrumb('manufacturers', array(
                'label' => $this->__('Producenci'),
                'link'  => $this->getUrl($this->_getHelper()->getIndexURI())
            ));

            if($this->_getManufacturer()->getId()) {
                $title[0] = $this->_getManufacturer()->getLabel();

                $path  = Mage::helper('catalog')->getBreadcrumbPath();

                $breadcrumbsBlock->addCrumb('current_manufacturer', array(
                    'label' => $this->_getManufacturer()->getLabel(),
                    'link'  => empty($path) ? null : $this->_getHelper()->getUrl($this->_getManufacturer()),
                ));

                foreach ($path as $name => $breadcrumb) {
                    $url = str_replace($this->getUrl(), $this->_getHelper()->getUrl($this->_getManufacturer()), $breadcrumb['link']);

                    $breadcrumbsBlock->addCrumb($name, array(
                        'label' => $breadcrumb['label'],
                        'link'  => $url,
                    ));

                    $title[] = $breadcrumb['label'];
                }
            }

            if ($headBlock = $this->getLayout()->getBlock('head')) {
                $headBlock->setTitle(join($this->getTitleSeparator(), array_reverse($title)));
            }
        }

        return parent::_prepareLayout();
    }

    /**
     * @return Divante_Manufacturer_Helper_Data
     */
    protected function _getHelper()
    {
        return Mage::helper('divante_manufacturer');
    }

    /**
     * @return Divante_Manufacturer_Model_Manufacturer
     */
    protected function _getManufacturer()
    {
        return Mage::getSingleton('divante_manufacturer/manufacturer');
    }
}