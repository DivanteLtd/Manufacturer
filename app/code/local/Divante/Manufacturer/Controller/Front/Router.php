<?php
/**
 * Created by PhpStorm.
 * User: Marek Kidon
 * Date: 2014-09-26
 * Time: 12:23
 */
class Divante_Manufacturer_Controller_Front_Router extends Mage_Core_Controller_Varien_Router_Standard
{
    public function match(Zend_Controller_Request_Http $request)
    {
        if(strpos($request->getRequestUri(), '/' . Mage::helper('divante_manufacturer')->getIndexURI()) !== 0) {
            return false;
        }

        $actionName = '';
        $categoryPath = '';
        $manufacturerPath = '';

        if(str_replace('/', '', $request->getRequestUri()) == Mage::helper('divante_manufacturer')->getIndexURI()) {
            $actionName = 'index';
        } else {
            $actionName = 'manufacturer';
            $requestedPath = explode('/', $request->getPathInfo());

            $baseSlug = $requestedPath[1];
            $manufacturerSlug = $requestedPath[2];
            $categorySlug = str_replace('/' . $baseSlug . '/' . $manufacturerSlug . '/', '', $request->getRequestUri());

            /** @var $manufacturer Divante_Manufacturer_Model_Manufacturer */
            $manufacturer = Mage::getSingleton('divante_manufacturer/manufacturer');
            $manufacturer->loadByUrlKey($manufacturerSlug);

            if (!$manufacturer->getId()) {
                return false;
            }

            $manufacturerPath = 'id/' . $manufacturer->getId();

            $request->setParam('id', $manufacturer->getId());

            if ($categorySlug != '') {
                $resource = Mage::getSingleton('core/resource');

                /** @var $connread Varien_Db_Adapter_Pdo_Mysql */
                $read = $resource->getConnection('core_read');
                $tab = $resource->getTableName('core/url_rewrite');

                $select  = $read->select()
                    ->from($tab,'category_id')
                    ->where('store_id = ?', Mage::app()->getStore()->getId())
                    ->where('request_path = ?', $categorySlug)
                    ->orWhere('request_path = ?', $categorySlug . '.html');

                if ($categoryId = $read->fetchOne($select)) {
                    $categoryPath = 'category/' . $categoryId;

                    $request->setParam('category', $categoryId);
                }
            }
        }

        $request->setModuleName('divante_manufacturer')
            ->setControllerName('index')
            ->setActionName($actionName)
            ->setControllerModule('Divante_Manufacturer')
            ->setRouteName('divante_manufacturer');

        $request->setAlias(Mage_Core_Model_Url_Rewrite::REWRITE_REQUEST_PATH_ALIAS, ltrim($request->getOriginalPathInfo(), '/'));

        $path = 'manufacturer/index/' . $actionName;

        if($manufacturerPath != '') {
            $path .= '/'. $manufacturerPath;
        }

        if($categoryPath != '') {
            $path .= '/'. $categoryPath;
        }

        $request->setRequestUri('/' . $path);
        $request->setPathInfo($path);

        $controllerClassName = $this->_validateControllerClassName($request->getControllerModule(), $request->getControllerName());

        $controllerInstance = Mage::getControllerInstance($controllerClassName, $request, $this->getFront()->getResponse());

        $request->setDispatched(true);
        $controllerInstance->dispatch($request->getActionName());

        return true;
    }
}