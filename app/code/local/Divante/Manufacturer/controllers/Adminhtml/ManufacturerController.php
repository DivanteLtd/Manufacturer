<?php
/**
 * Created by JetBrains PhpStorm.
 * User: msznurawa
 * Date: 11.12.12
 * Time: 11:42
 * To change this template use File | Settings | File Templates.
 */


class Divante_Manufacturer_Adminhtml_ManufacturerController extends Mage_Adminhtml_Controller_Action
{
    protected function _initAction()
    {
        return $this->loadLayout()->_setActiveMenu('catalog/divante_manufacturer');
    }

    /**
     * @param string $fieldName
     * @return array
     */
    protected function _saveImage($fieldName)
    {
        /** @var Varien_File_Uploader $uploader */
        $uploader = new Varien_File_Uploader($fieldName);

        $uploader->setAllowedExtensions(array('jpg','jpeg','gif','png')); // or pdf or anything
        $uploader->setAllowRenameFiles(false);
        $uploader->setFilesDispersion(false);

        $path = Mage::helper('divante_manufacturer')->getImagesBaseDir();

        return $uploader->save($path, $_FILES[$fieldName]['name']);
    }

    public function indexAction()
    {
        $this->_title($this->__('Producenci'));
        $this->_initAction();
        $this->renderLayout();
    }

    public function gridAction()
    {
        $this->loadLayout()->renderLayout();
    }

    public function editAction()
    {
        $manufacturerId = $this->getRequest()->getParam('id', 0);
        $manufacturer = Mage::getModel('divante_manufacturer/manufacturer')->load($manufacturerId);

        if ($manufacturer->getId() || $manufacturerId == 0) {
            Mage::register('manufacturer', $manufacturer);

            $this->_initAction();
            $this->getLayout()->getBlock('head')->setCanLoadExtJs(true);
            $this->renderLayout();
        } else {
            Mage::getSingleton('adminhtml/session')->addError(Mage::helper('adminhtml')->__('Niepoprawne Id'));
            $this->_redirect('*/*/');
        }
    }

    public function newAction()
    {
        $this->_forward('edit');
    }

    public function saveAction()
    {
        if($this->getRequest()->getParam('delete', false)) {
            $this->_forward('delete');
            return $this;
        }

        if($this->getRequest()->isPost()) {

            try {
                $data = $this->getRequest()->getPost();
                /** @var Divante_Manufacturer_Model_Manufacturer $manufacturer */
                $manufacturer = Mage::getModel('divante_manufacturer/manufacturer');

                $manufacturerId = $this->getRequest()->getParam('manufacturer_id');

                if ($manufacturerId) {
                    $manufacturer->load($manufacturerId);
                }

                if(isset($_FILES['logo']['name']) and (file_exists($_FILES['logo']['tmp_name']))) {
                    $result = $this->_saveImage('logo');
                    $data['logo'] = isset($result['file']) ? $result['file'] : null;
                } else {
                    if(isset($data['logo']['delete']) && $data['logo']['delete'] == 1) {
                        $data['logo'] = '';
                    } else {
                        unset($data['logo']);
                    }
                }

                if(isset($_FILES['logo_thumbnail']['name']) and (file_exists($_FILES['logo_thumbnail']['tmp_name']))) {
                    $result = $this->_saveImage('logo_thumbnail');
                    $data['logo_thumbnail'] = isset($result['file']) ? $result['file'] : null;
                } else {
                    if(isset($data['logo_thumbnail']['delete']) && $data['logo_thumbnail']['delete'] == 1) {
                        $data['logo_thumbnail'] = '';
                    } else {
                        unset($data['logo_thumbnail']);
                    }
                }

                $manufacturer->addData($data);
                $manufacturer->save();

                $this->_getSession()->addSuccess($this->__('Producent zapisany poprawnie.'));
                $this->_getSession()->setData('manufacturer', false);

                if ($this->getRequest()->getParam('back')) {
                    return $this->_redirect('*/*/edit', array('id' => $manufacturer->getId()));
                }

            } catch(Exception $e) {
                Mage::logException($e);
                $this->_getSession()->addError($e->getMessage());
                $this->_getSession()->setData('manufacturer', $this->getRequest()->getPost());
            }
        }

        return $this->_redirect('*/*/');
    }

    public function deleteAction()
    {
        $newManufacturerId = (int) $this->getRequest()->getPost('new_manufacturer', 0);
        $manufacturerId = $this->getRequest()->getParam('manufacturer_id');

        /** @var Divante_Manufacturer_Model_Manufacturer $manufacturer */
        $manufacturer = Mage::getModel('divante_manufacturer/manufacturer');
        $manufacturer->load($manufacturerId);

        if (!$manufacturer->getId()) {
            $this->_getSession()->addError($this->__('Nieprawidłowy producent.'));
            return $this->_redirect('*/*/');
        }

        if($newManufacturerId > 0) {
            /** @var Divante_Manufacturer_Model_Manufacturer $newManufacturer */
            $newManufacturer = Mage::getModel('divante_manufacturer/manufacturer')->load($newManufacturerId);

            if(!$newManufacturer->getId()) {
                $this->_getSession()->addError($this->__('Producent do którego przenieść produkty nie istnieje.'));
                return $this->_redirect('*/*/edit', array('id' => $manufacturerId));
            }
        } else {
            $newManufacturerId = null;
        }

        try {
            $counter = 0;
            foreach($manufacturer->getProductCollection() as $product) {
                /** @var Mage_Catalog_Model_Product $product */
                $product->setData('manufacturer', $newManufacturerId);
                $product->getResource()->saveAttribute($product, 'manufacturer');
                $product->clearInstance();
                $counter++;
            }

            $manufacturer->delete();

            $this->_getSession()->addSuccess($this->__('Producent poprawnie usunięty.'));
            $this->_getSession()->addNotice($this->__('Zaktualizowano %s produktów.', $counter));
        } catch(Exception $e) {
            $this->_getSession()->addError($e->getMessage());
        }

        return $this->_redirect('*/*/');
    }
}
