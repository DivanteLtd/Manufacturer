<?php
/**
 * Created by PhpStorm.
 * User: Marek Kidon
 * Date: 16.04.14
 * Time: 15:42
 */
class Divante_Manufacturer_Block_Adminhtml_Manufacturer extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    public function __construct()
    {
        parent::__construct();
        $this->_controller = 'adminhtml_manufacturer';
        $this->_blockGroup = 'divante_manufacturer';
        $this->_headerText = $this->__('Producenci');
        $this->_addButtonLabel = $this->__('Dodaj producenta');
    }
}
