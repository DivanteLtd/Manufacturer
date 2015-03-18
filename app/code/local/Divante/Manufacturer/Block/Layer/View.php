<?php
/**
 * Created by PhpStorm.
 * User: Marek Kidon
 * Date: 18.04.14
 * Time: 12:18
 */
class Divante_Manufacturer_Block_Layer_View extends Mage_Catalog_Block_Layer_View
{
    public function getLayer()
    {
        return Mage::getSingleton('divante_manufacturer/layer');
    }
}
