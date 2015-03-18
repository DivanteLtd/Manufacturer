<?php
/**
 * Created by PhpStorm.
 * User: Marek Kidon
 * Date: 15.04.14
 * Time: 12:02
 */ 
class Divante_Manufacturer_Model_Resource_Manufacturer extends Mage_Core_Model_Resource_Db_Abstract
{

    protected function _construct()
    {
        $this->_init('divante_manufacturer/manufacturer', 'manufacturer_id');
    }
}
