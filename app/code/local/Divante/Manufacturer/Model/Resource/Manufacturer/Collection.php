<?php
/**
 * Created by PhpStorm.
 * User: Marek Kidon
 * Date: 15.04.14
 * Time: 12:02
 */

/**
 * Class Divante_Manufacturer_Model_Resource_Manufacturer_Collection
 *
 * @method Divante_Manufacturer_Model_Resource_Manufacturer getResource()
 */
class Divante_Manufacturer_Model_Resource_Manufacturer_Collection extends Mage_Core_Model_Resource_Db_Collection_Abstract
{
    protected function _construct()
    {
        $this->_init('divante_manufacturer/manufacturer');
    }

    public function toOptionArray()
    {
        $this->setOrder('label', 'ASC');
        return $this->_toOptionArray('manufacturer_id', 'label');
    }

    public function toOptionHash()
    {
        $this->setOrder('label', 'ASC');
        return $this->_toOptionHash('manufacturer_id', 'label');
    }
}