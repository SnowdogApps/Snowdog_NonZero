<?php

$installer = $this;
/* @var @installer Mage_Core_Model_Resource_Setup */
$installer->startSetup();

$table = $installer->getConnection()
->newTable($installer->getTable('snownonzero/notification'))
->addColumn('notification_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
		'identity' => true,
		'primary' => true,
		'nullable' => false,
		'unsigned' => true,
), 'Comment for field NotificationId')
->addColumn('type', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
), 'Comment for field Type')
->addColumn('quote_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
), 'Comment for field QuoteId')
->addColumn('product_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
), 'Comment for field ProductId')
->addColumn('additonal_data', Varien_Db_Ddl_Table::TYPE_TEXT, null, array(
), 'Comment for field AdditonalData')
->addColumn('created_at', Varien_Db_Ddl_Table::TYPE_TIMESTAMP, null, array(
), 'Comment for field CreatedAt')
->setComment('Comment for table notification');
$installer->getConnection()->createTable($table);


$installer->endSetup();