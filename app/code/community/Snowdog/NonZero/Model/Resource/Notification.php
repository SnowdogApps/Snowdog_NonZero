<?php

/**
 Snowdog_NonZero_Model_Resource_Notification

 */
class Snowdog_NonZero_Model_Resource_Notification extends Mage_Core_Model_Resource_Db_Abstract {
	public function _construct() {
		$this->_init("snownonzero/notification", "notification_id");
	}
}