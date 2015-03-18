<?php
/**
 * Created by PhpStorm.
 * User: Marek Kidon
 * Date: 17.04.14
 * Time: 12:20
 */
class Divante_Manufacturer_Block_Adminhtml_Widget_Grid_Column_Renderer_Image extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{
    protected static $_width = 50;
    protected static $_height = 50;

    /**
     * @param   Varien_Object $row
     * @return  string
     */
    public function render(Varien_Object $row)
    {
        /** @var Divante_Manufacturer_Helper_Data $helper */
        $helper = Mage::helper('divante_manufacturer');

        $val = $row->getData($this->getColumn()->getIndex());
        $url = $helper->getImageUrl($val);

        $out = '';

        if(empty($val) ) {
            $out = "<center>" . $this->__("(no image)") . "</center>";
        } else {
            $out .= "<center><img src=". $url ." width='". self::$_width ."' ";
            if(self::$_height > self::$_width) {
                $out .= "height='". self::$_height ."' ";
            }
            $out .=" /></center>";
        }

        return $out;
    }
}
