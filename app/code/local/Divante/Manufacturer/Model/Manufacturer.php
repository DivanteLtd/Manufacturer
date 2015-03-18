<?php
/**
 * Created by PhpStorm.
 * User: Marek Kidon
 * Date: 15.04.14
 * Time: 12:02
 */

/**
 * Class Divante_Manufacturer_Model_Manufacturer
 *
 * @method Divante_Manufacturer_Model_Manufacturer setLabel(string $value)
 * @method string getLabel()
 * @method Divante_Manufacturer_Model_Manufacturer setUrlKey(string $value)
 * @method string getUrlKey()
 * @method Divante_Manufacturer_Model_Manufacturer setLogo(string $value)
 * @method string getLogo()
 * @method Divante_Manufacturer_Model_Manufacturer setLogoThumbnail(string $value)
 * @method string getLogoThumbnail()
 * @method Divante_Manufacturer_Model_Manufacturer setDescription(string $value)
 * @method string getDescription()
 * @method Divante_Manufacturer_Model_Manufacturer setMetaKeywords(string $value)
 * @method string getMetaKeywords()
 * @method Divante_Manufacturer_Model_Manufacturer setMetaDescription(string $value)
 * @method string getMetaDescription()
 */
class Divante_Manufacturer_Model_Manufacturer extends Mage_Core_Model_Abstract
{
    /** @var Mage_Catalog_Model_Resource_Product_Collection */
    protected $_productCollection;

    protected function _construct()
    {
        $this->_init('divante_manufacturer/manufacturer');
    }

    /**
     * @return Divante_Manufacturer_Helper_Data
     */
    protected function _getHelper()
    {
        return Mage::helper('divnate_manufacturer');
    }

    protected function _getImgUrl($img = null)
    {
        $url = false;
        if ($img) {
            $url = Mage::getBaseUrl('media'). 'manufacturers/' . $img;
        }

        return $url;
    }

    /**
     * @return bool|string
     */
    public function getLogoUrl()
    {
        return $this->_getImgUrl($this->getLogo());
    }

    /**
     * @return bool|string
     */
    public function getThumbnailUrl()
    {
        return $this->_getImgUrl($this->getLogoThumbnail());
    }

    /**
     * @return Mage_Catalog_Model_Resource_Product_Collection
     */
    public function getProductCollection()
    {
        if(is_null($this->_productCollection)) {
            /** @var Mage_Catalog_Model_Resource_Product_Collection $productsCollection */
            $productsCollection = Mage::getResourceModel('catalog/product_collection');
            $productsCollection->addAttributeToFilter('manufacturer', array('eq' => $this->getId()));
            $this->_productCollection = $productsCollection;
        }

        return $this->_productCollection;
    }

    public function loadByUrlKey($urlKey)
    {
        parent::load($urlKey, 'url_key');
        return $this;
    }
}
