<?php
/**
 * Magento
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@magentocommerce.com so we can send you a copy immediately.
 *
 * @category    Phoenix
 * @package     Phoenix_Moneybookers
 * @copyright   Copyright (c) 2014 Phoenix Medien GmbH & Co. KG (http://www.phoenix-medien.de)
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

$installer = $this;
/* @var $installer Mage_Core_Model_Resource_Setup */

$installer->startSetup();
/**
 * Create table 'admin/assert'
 */
$table = $installer->getConnection()
    ->newTable($installer->getTable('fontera_amier/scraper'))
    ->addColumn('source_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'identity'  => true,
        'unsigned'  => true,
        'nullable'  => false,
        'primary'   => true,
    ), 'Source ID')
    ->addColumn('source_name', Varien_Db_Ddl_Table::TYPE_VARCHAR, 100, array(
        'nullable'  => true,
        'default'   => null,
    ), 'The Source name')
    ->addColumn('source_url', Varien_Db_Ddl_Table::TYPE_VARCHAR, 255, array(
        'nullable'  => true,
        'default'   => null,
    ), 'The url of the source')
    ->addColumn('curl_options', Varien_Db_Ddl_Table::TYPE_TEXT, '64k', array(
        'nullable'  => true,
        'default'   => null,
    ), 'The customized settings of curt options for the source url')
    ->addColumn('list_config', Varien_Db_Ddl_Table::TYPE_TEXT, '64k', array(
        'nullable'  => true,
        'default'   => null,
    ), 'The setting for scraping the list of the source')
    ->addColumn('content_config', Varien_Db_Ddl_Table::TYPE_TEXT, '64k', array(
        'nullable'  => true,
        'default'   => null,
    ), 'The setting for scraping the Content of the source list')
    ->addColumn('images_config', Varien_Db_Ddl_Table::TYPE_TEXT, 20, array(
        'nullable'  => true,
        'default'   => null,
    ), '0:default, use remote_url, 1: scape images and save to local ')
    ->addColumn('created_at', Varien_Db_Ddl_Table::TYPE_TIMESTAMP, null, array(
    ), 'The timestamp of the source url created')
    ->addColumn('updated_at', Varien_Db_Ddl_Table::TYPE_TIMESTAMP, null, array(
    ), 'The timestamp of the source url updated')
    ->addColumn('overwrite', Varien_Db_Ddl_Table::TYPE_TINYINT, 2, array(
        'nullable'  => true,
        'default'   => 0,
    ), '0:default, skip the existing content, 1: overwrite the old content')
    ->addColumn('status', Varien_Db_Ddl_Table::TYPE_TINYINT, 2, array(
        'nullable'  => true,
        'default'   => 0,
    ), 'The status of the source url')
    ->setComment('Scraper sources table');
$installer->getConnection()->createTable($table);

$s_data_tbl = $installer->getTable(array('fontera_amier/scraper', 'data'));

$table = $installer->getConnection()
    ->newTable($s_data_tbl)
    ->addColumn('data_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'identity'  => true,
        'unsigned'  => true,
        'nullable'  => false,
        'primary'   => true,
    ), 'Data ID')
    ->addColumn('source_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'nullable'  => true,
        'default'   => null,
    ), 'The Source url ID')
    ->addColumn('unique_id', Varien_Db_Ddl_Table::TYPE_VARCHAR, 32, array(
        'nullable'  => true,
        'default'   => null,
    ), 'Url Md5, for unique check')
    ->addColumn('store_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'nullable'  => true,
        'default'   => 0,
    ), 'Which store to display')
    ->addColumn('created_at', Varien_Db_Ddl_Table::TYPE_TIMESTAMP, null, array(
    ), 'The timestamp of the record created')
    ->addColumn('updated_at', Varien_Db_Ddl_Table::TYPE_TIMESTAMP, null, array(
    ), 'The timestamp of the record updated')
    ->addColumn('status', Varien_Db_Ddl_Table::TYPE_TINYINT, 2, array(
        'nullable'  => true,
        'default'   => 1,
    ), 'The status of the Record. 0: disabled, 1: enabled')
    ->addIndex($installer->getIdxName($s_data_tbl, array('source_id')),
        array('source_id'))
    ->addIndex($installer->getIdxName($s_data_tbl, array('unique_id'), Varien_Db_Adapter_Interface::INDEX_TYPE_UNIQUE),
        array('unique_id'), array('type' => Varien_Db_Adapter_Interface::INDEX_TYPE_UNIQUE))
    ->addIndex($installer->getIdxName($s_data_tbl, array('store_id')),
        array('store_id'))
    ->setComment('Scraper Data table');
$installer->getConnection()->createTable($table);



$s_d_details_tbl = $installer->getTable(array('fontera_amier/scraper', 'data_details'));
$table = $installer->getConnection()
    ->newTable($s_d_details_tbl)
    ->addColumn('data_details_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'identity'  => true,
        'unsigned'  => true,
        'nullable'  => false,
        'primary'   => true,
    ), 'Details ID')
    ->addColumn('data_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'nullable'  => true,
        'default'   => null,
    ), 'The data ID')
    ->addColumn('short_desc', Varien_Db_Ddl_Table::TYPE_TEXT, '32k', array(
        'nullable'  => true,
        'default'   => null,
    ), 'Short description')
    ->addColumn('description', Varien_Db_Ddl_Table::TYPE_TEXT, '64k', array(
        'nullable'  => true,
        'default'   => null,
    ), 'The main content')
    ->addColumn('additionals', Varien_Db_Ddl_Table::TYPE_TEXT, '64k', array(
        'nullable'  => true,
        'default'   => null,
    ), 'Additional Content')
    ->addIndex($installer->getIdxName($s_d_details_tbl, array('data_id')),
        array('data_id'))
    ->setComment('The details of the scraped Data');
$installer->getConnection()->createTable($table);

$installer->endSetup();


