<?php
/**
 * Created by PhpStorm.
 * User: Marek Kidon
 * Date: 17.04.14
 * Time: 14:56
 */
class Divante_Manufacturer_Model_Entity_Attribute_Source_Manufacturer extends Mage_Eav_Model_Entity_Attribute_Source_Abstract
{
    public function getAllOptions()
    {
        if (is_null($this->_options)) {
            $this->_options = array( );

            /** @var  $manufacturers Divante_Manufacturer_Model_Resource_Manufacturer_Collection */
            $manufacturers = Mage::getModel('divante_manufacturer/manufacturer')->getCollection();
            $manufacturers->setOrder('label',$manufacturers::SORT_ORDER_ASC);
            $this->_options[] = array(
                'value' => '',
                'label' => '--'
            );

            foreach ($manufacturers as $manufacturer) {
                $this->_options[] = array(
                    'value' => $manufacturer->getId(),
                    'label' => $manufacturer->getLabel()
                );
            }
        }

        return $this->_options;
    }

    public function getFlatColums()
    {
        return array($this->getAttribute()->getAttributeCode() => array(
            'type'      => 'int',
            'unsigned'  => true,
            'is_null'   => true,
            'default'   => null,
            'extra'     => null
        ));
    }

    public function getFlatUpdateSelect($store)
    {
        return Mage::getResourceSingleton('eav/entity_attribute')
            ->getFlatUpdateSelect($this->getAttribute(), $store);
    }
}
