<?php

/**
 Snowdog_NonZero_Model_Resource_Notification_Collection

 */
class Snowdog_NonZero_Model_Resource_Notification_Collection extends Mage_Core_Model_Resource_Db_Collection_Abstract {

	public function _construct() {
		$this->_init("snownonzero/notification");
	}

}