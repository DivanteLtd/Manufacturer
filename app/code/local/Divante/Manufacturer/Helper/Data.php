<?php
/**
 * Created by PhpStorm.
 * User: Marek Kidon
 * Date: 14.04.14
 * Time: 14:26
 */ 
class Divante_Manufacturer_Helper_Data extends Mage_Core_Helper_Abstract 
{
    /**
     * @return string
     */
    public function getIndexURI()
    {
        return Mage::getStoreConfig('divante_manufacturer/general/index_uri');
    }

    public function getUrlKeyFromString($string)
    {
        $search = explode(",","ç,æ,œ,á,é,í,ó,ú,à,è,ì,ò,ù,ä,ë,ï,ö,ü,ÿ,â,ê,î,ô,û,å,e,i,ø,u,ą,ś,ę,ć,ń,ł,ó,ż,ź");
        $replace = explode(",","c,ae,oe,a,e,i,o,u,a,e,i,o,u,a,e,i,o,u,y,a,e,i,o,u,a,e,i,o,u,a,s,e,c,n,l,o,z,z");

        $string = str_replace($search, $replace, (mb_strtolower(trim(strip_tags($string)), mb_detect_encoding($string))));
        $string = str_replace(array('[\', \']'), '', $string);
        $string = preg_replace('/\[.*\]/U', '', $string);
        $string = preg_replace('/&(amp;)?#?[a-z0-9]+;/i', '-', $string);
        $string = htmlentities($string, ENT_COMPAT, 'utf-8');
        $string = preg_replace('/&([a-z])(acute|uml|circ|grave|ring|cedil|slash|tilde|caron|lig|quot|rsquo);/i', '\\1', $string);
        $string = preg_replace(array('/[^a-z0-9]/i', '/[-]+/') , '-', $string);
        return strtolower(trim($string, '-'));
    }

    public function getImageUrl($img)
    {
        $url = $this->getImagesBaseUrl() . $img;
        return $url;
    }

    public function getImagesBaseUrl()
    {
        return Mage::getBaseUrl('media') . 'manufacturers/';
    }

    public function getImagesBaseDir()
    {
        return Mage::getBaseDir('media') . DS . 'manufacturers' . DS;
    }

    /**
     * @param int|Divante_Manufacturer_Model_Manufacturer $manufacturer
     * @param Mage_Catalog_Model_Category $category
     * @return string
     */
    public function getUrl($manufacturer, $category = null)
    {
        if (is_numeric($manufacturer)) {
            $manufacturer = Mage::getModel('divante_manufacturer/manufacturer')->load($manufacturer);
        }

        try {
            if (!$manufacturer instanceof Divante_Manufacturer_Model_Manufacturer) {
                Mage::throwException($this->__('Manufacturer must be an instance of Divante_Manufacturer_Model_Manufacturer.'));
            }
            if (!$manufacturer->getId()) {
                Mage::throwException($this->__('Invalid manufacturer.'));
            }
        } catch(Exception $e) {
            Mage::logException($e);
            return '#';
        }



        if ($category instanceof Mage_Catalog_Model_Category) {
            $cpath =  '';

            if ($category->getRequestPath()) {
                $cpath = $category->getRequestPath();
            } elseif($category->getUrlPath()) {
                $cpath = $category->getUrlPath();
            }

            if ($cpath != '') {
                return $this->getManufacturerBaseUrl($manufacturer) . '/' . $cpath;
            }
        }

        return $this->getManufacturerBaseUrl($manufacturer);
    }

    /**
     * @param Divante_Manufacturer_Model_Manufacturer $manufacturer
     * @return string
     */
    public function getManufacturerBaseUrl(Divante_Manufacturer_Model_Manufacturer $manufacturer)
    {
        return  Mage::getBaseUrl() . $this->getIndexURI() . '/' . $manufacturer->getUrlKey();
    }
}
