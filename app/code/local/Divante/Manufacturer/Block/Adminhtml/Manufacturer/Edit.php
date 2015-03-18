<?php
/**
 * Created by PhpStorm.
 * User: Marek Kidon
 * Date: 17.04.14
 * Time: 13:09
 */
class Divante_Manufacturer_Block_Adminhtml_Manufacturer_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        parent::__construct();

        $this->_objectId = Mage::getModel('divante_manufacturer/manufacturer')->getIdFieldName();
        $this->_blockGroup = 'divante_manufacturer';
        $this->_controller = 'adminhtml_manufacturer';

        $this->_addButton('saveandcontinue', array(
            'label'     => Mage::helper('adminhtml')->__('Save And Continue Edit'),
            'onclick'   => 'saveAndContinueEdit()',
            'class'     => 'save',
        ), -100);

        $this->_formScripts[] = "
            function saveAndContinueEdit(){
                editForm.submit($('edit_form').action+'back/edit/');
            }
        ";

        $this->_removeButton('delete');
    }

    protected function _prepareLayout()
    {
        $this->getLayout()->getBlock('head')->setCanLoadTinyMce(true);
        return parent::_prepareLayout();
    }


    public function getHeaderText()
    {
        return Mage::helper('divante_manufacturer')->__('Producent');
    }
}
