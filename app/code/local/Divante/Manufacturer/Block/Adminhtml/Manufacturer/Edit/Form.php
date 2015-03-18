<?php
/**
 * Created by PhpStorm.
 * User: Marek Kidon
 * Date: 17.04.14
 * Time: 13:09
 */
class Divante_Manufacturer_Block_Adminhtml_Manufacturer_Edit_Form extends Mage_Adminhtml_Block_Widget_Form
{
    protected function _construct()
    {
        parent::_construct();
        $this->setId('manufacturer_form');
        $this->setTitle($this->__('Producent - edycja'));
    }

    /**
     * @return Mage_Adminhtml_Model_Session
     */
    protected function _getSession()
    {
        return Mage::getSingleton('adminhtml/session');
    }

    /**
     * @return Divante_Manufacturer_Model_Manufacturer
     */
    protected function _getManufacuter()
    {
        return Mage::registry('manufacturer');
    }

    protected function _prepareForm()
    {
        $data = array();

        if ($this->_getSession()->getData('manufacturer')) {
            $data = $this->_getSession()->getData('manufacturer');
            Mage::getSingleton('adminhtml/session')->setData('manufacturer', false);
        } elseif($this->_getManufacuter()) {
            $data = $this->_getManufacuter()->getData();
        }

        /** @var Divante_Manufacturer_Helper_Data $helper */
        $helper = Mage::helper('divante_manufacturer');

        if(isset($data['logo'])) {
            $data['logo'] = $helper->getImageUrl($data['logo']);
        }

        if(isset($data['logo_thumbnail'])) {
            $data['logo_thumbnail'] = $helper->getImageUrl($data['logo_thumbnail']);
        }

        $form = new Varien_Data_Form(array(
            'id' => 'edit_form',
            'action' => $this->getUrl('*/*/save', array('id' => $this->getRequest()->getParam('id'))),
            'method' => 'post',
            'enctype' => 'multipart/form-data',
        ));

        $form->setUseContainer(true);

        $this->setForm($form);

        $fieldSetSettings = array('legend' => $helper->__('Podstawowe informacje'));

        $fieldSet = $form->addFieldset('edit_form_base', $fieldSetSettings);

        if(isset($data['manufacturer_id'])) {
            $fieldSet->addField('manufacturer_id', 'hidden', array(
                'name'      => 'manufacturer_id',
            ));
        }

        $fieldSet->addField('label', 'text', array(
            'label'     => $helper->__('Producent'),
            'class'     => 'required-entry',
            'required'  => true,
            'name'      => 'label',
            'note'      => $helper->__('Nazwa producenta'),
        ));


        $fieldSet->addField('url_key', 'text', array(
            'label'     => $helper->__('Klucz URL'),
            'name'      => 'url_key',
            'class'     => 'required-entry',
            'required'  => true,
        ));

        $fieldSet->addField('logo', 'image', array(
            'label'     => $helper->__('Logo'),
            'name'      => 'logo',
            'required' => false,
            'note'     => $helper->__('Plik png, jpg.'),
        ));

        $fieldSet->addField('logo_thumbnail', 'image', array(
            'label'     => $helper->__('Miniaturka logo'),
            'name'      => 'logo_thumbnail',
            'required'  => false,
            'note'      => $helper->__('Plik png, jpg.'),
        ));

        $wysiwygBaseConfig = array('files_browser_window_url'=> Mage::helper('adminhtml')->getUrl('adminhtml/cms_wysiwyg_images/index') , 'store_id' => 0);
        $wysiwygConfig = Mage::getSingleton('cms/wysiwyg_config')->getConfig($wysiwygBaseConfig);

        $fieldSet->addField('description', 'editor', array(
            'label'     => $helper->__('Opis'),
            'required'  => false,
            'name'      => 'description',
            'style'     => 'height:19em; width: 98%;',
            'config'    => $wysiwygConfig,
            'wysiwyg'   => true,
        ));

        $fieldSet->addField('meta_keywords', 'textarea', array(
            'label'     => $helper->__('Meta keywords'),
            'required'  => false,
            'name'      => 'meta_keywords',
        ));

        $fieldSet->addField('meta_description', 'textarea', array(
            'label'     => $helper->__('Meta description'),
            'required'  => false,
            'name'      => 'meta_description',
        ));

        if($this->_getManufacuter() && $this->_getManufacuter()->getId()) {
            $fieldSetSettings = array('legend' => $helper->__('Usunięcie producenta'));

            $manufacturers = Mage::getResourceModel('divante_manufacturer/manufacturer_collection')->toOptionHash();

            $delFieldSet = $form->addFieldset('delete_form', $fieldSetSettings);
            $delFieldSet->addField('new_manufacturer', 'select', array(
                'label'     => $helper->__('Przypisz produkty do innego producenta'),
                'name'      => 'new_manufacturer',
                'options'   => $manufacturers,
            ));

            $delFieldSet->addField('create_button', 'note', array(
                'text' => $this->getButtonHtml(
                        $this->__('Usuń'),
                        "editForm.submit($('edit_form').action+'back/edit/delete/true');",
                        'delete'
                    )
            ));
        }

        $form->setValues($data);

        return parent::_prepareForm();
    }

}
