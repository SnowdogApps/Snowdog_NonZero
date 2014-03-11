<?php

/**
 Snowdog_NonZero_Model_Source_Type
 
*/
class Snowdog_NonZero_Model_Source_Type extends Mage_Core_Model_Abstract {
	const ZERO_PRICE = 1;
	const SMALL_PRICE = 2;
	const BIG_DISCOUNT = 3;
	
	const SOURCE_ID = 'snowdog_nonzero';
	
	public function toOptionArray() {
		return array(
				self::ZERO_PRICE => Mage::helper("snownonzero")->__("Zero Price"),
				self::SMALL_PRICE => Mage::helper("snownonzero")->__("Small Price"),
				self::BIG_DISCOUNT => Mage::helper("snownonzero")->__("Big Discount"),
		);
	}
}