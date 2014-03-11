<?php

/**
 Snowdog_NonZero_Model_Notification
 @method Snowdog_NonZero_Model_Notification setNotificationId($notification_id)
 @method integer getNotificationId()
 @method Snowdog_NonZero_Model_Notification setType($type)
 @method integer getType()
 @method Snowdog_NonZero_Model_Notification setQuoteId($quote_id)
 @method integer getQuoteId()
 @method Snowdog_NonZero_Model_Notification setProductId($product_id)
 @method integer getProductId()
 @method Snowdog_NonZero_Model_Notification setAdditonalData($additonal_data)
 @method text getAdditonalData()
 @method Snowdog_NonZero_Model_Notification setCreatedAt($created_at)
 @method timestamp getCreatedAt()

 */
class Snowdog_NonZero_Model_Notification extends Mage_Core_Model_Abstract {
	protected $_eventObject = 'notification';
	protected $_eventPrefix = 'snownonzero_notification';

	public function _construct() {
		$this->_init("snownonzero/notification");
		parent::_construct();
	}
	
	protected function _beforeSave() {
		parent::_beforeSave();
		$data = $this->getAdditonalData();
		$data = json_encode($data);
		$this->setAdditonalData($data);
		if(!$this->getCreatedAt()) {
			$this->setCreatedAt(gmdate("Y-m-d H:i:s", time()));
		}
		return $this;
	}
	
	protected function _afterSave() {
		$data = $this->getAdditonalData();
		$data = json_decode($data, true);
		$this->setAdditonalData($data);
		return parent::_afterSave();
	}
	
	protected function _afterLoad() {
		$data = $this->getAdditonalData();
		$data = json_decode($data, true);
		$this->setAdditonalData($data);
		return parent::_afterLoad();
	}
	
}