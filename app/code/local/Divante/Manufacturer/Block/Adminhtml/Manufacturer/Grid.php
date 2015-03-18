<?php
/**
 * Created by PhpStorm.
 * User: Marek Kidon
 * Date: 16.04.14
 * Time: 15:42
 */
class Divante_Manufacturer_Block_Adminhtml_Manufacturer_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    public function __construct()
    {
        parent::__construct();
        $this->setId('divante_manufacturer_grid');
        $this->setDefaultSort('label');
        $this->setDefaultDir('asc');
        $this->setSaveParametersInSession(true);
        $this->setUseAjax(true);
    }

    protected function _prepareCollection()
    {
        /** @var Divante_Manufacturer_Model_Resource_Manufacturer_Collection $collection */
        $collection = Mage::getModel('divante_manufacturer/manufacturer')->getCollection();
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    protected function _prepareColumns()
    {
        $id_field  = Mage::getModel('divante_manufacturer/manufacturer')->getIdFieldName();

        $this->addColumn($id_field, array(
            'header'    => $this->__('ID'),
            'align'     =>'right',
            'width'     => '50px',
            'index'     => $id_field,
            'type'      => 'number',
        ));

        $this->addColumn('logo', array(
            'header'    => $this->__('Logo producenta'),
            'align'     => 'left',
            'index'     => 'logo',
            'width'     => '50px',
            'renderer'  => 'divante_manufacturer/adminhtml_widget_grid_column_renderer_image',
            'filter'    => false,
            'sortable'  => false,
        ));

        $this->addColumn('label', array(
            'header'    => $this->__('Producent'),
            'align'     => 'left',
            'index'     => 'label',
        ));

        $this->addColumn('url_key', array(
            'header'    => $this->__('Klucz URL'),
            'align'     => 'left',
            'index'     => 'url_key',
        ));

        return parent::_prepareColumns();
    }

    public function getRowUrl($row)
    {
        return $this->getUrl('*/*/edit', array('id' => $row->getId()));
    }

    public function getAbsoluteGridUrl($params = array())
    {
        return $this->getUrl('*/*/grid', $params);
    }

    public function getGridUrl()
    {
        return $this->getUrl('*/*/grid');
    }
}
