<?php
/**
 * Created by PhpStorm.
 * User: Marek Kidon
 * Date: 14.04.14
 * Time: 14:26
 */ 
/* @var $installer Mage_Core_Model_Resource_Setup */
$installer = $this;

$installer->startSetup();

$installer->run("

CREATE TABLE IF NOT EXISTS {$this->getTable('divante_manufacturer/manufacturer')} (
  `manufacturer_id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT ,
  `label` VARCHAR(128) NOT NULL ,
  `url_key` VARCHAR(128) NOT NULL ,
  `logo` VARCHAR(128) NULL ,
  `logo_thumbnail` VARCHAR(128) NULL ,
  `meta_keywords` VARCHAR(255) NULL ,
  `meta_description` VARCHAR(255) NULL ,
  `description` TEXT NULL ,
  PRIMARY KEY (`manufacturer_id`) ,
  UNIQUE INDEX `unique_url_key` (`url_key` ASC) )
ENGINE=InnoDB  DEFAULT CHARSET=utf8;

");

$setup = new Mage_Eav_Model_Entity_Setup('core_setup');
$setup->updateAttribute(Mage_Catalog_Model_Product::ENTITY, 'manufacturer', 'source_model', 'divante_manufacturer/entity_attribute_source_manufacturer');

$installer->endSetup();
