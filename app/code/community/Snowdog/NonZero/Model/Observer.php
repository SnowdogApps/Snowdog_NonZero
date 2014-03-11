<?php

/**
 Snowdog_NonZero_Model_Observer

 */
class Snowdog_NonZero_Model_Observer {
	public function notificationSendEmail(Varien_Event_Observer $observer) {
		$event = $observer->getEvent();
		$notification = $event->getNotification();
		
		
	}

	public function salesQuoteCollectTotalsAfter(Varien_Event_Observer $observer) {
		$event = $observer->getEvent();
		$quote = $event->getQuote();
		/* @var $quote Mage_Sales_Model_Quote */
		$items = $quote->getItemsCollection();
		$zeroPriceEnabled = Mage::getStoreConfig("snownonzero/zeroprice/enabled");
		$zeroPriceMsg = Mage::getStoreConfig("snownonzero/zeroprice/msg");
		$smallPriceEnabled = Mage::getStoreConfig("snownonzero/smallprice/enabled");
		$smallPricePrice = Mage::getStoreConfig("snownonzero/smallprice/price");
		$smallPriceMsg = Mage::getStoreConfig("snownonzero/smallprice/msg");
		$bigDiscountEnabled = Mage::getStoreConfig("snownonzero/bigdiscount/enabled");
		$bigDiscountPercent = Mage::getStoreConfig("snownonzero/bigdiscount/percent");
		$bigDiscountMsg = Mage::getStoreConfig("snownonzero/bigdiscount/msg");
		foreach($items as $item) {
			if($item->getParentItemId()) {
				continue;
			}
			if($zeroPriceEnabled) {
				if($item->getPrice() == 0) {
					$quote->setHasError(true);
					$item->addErrorInfo(Snowdog_NonZero_Model_Source_Type::SOURCE_ID, Snowdog_NonZero_Model_Source_Type::ZERO_PRICE, $zeroPriceMsg, array('product_id' => $item->getProductId()));
					try {
						$notification = Mage::getModel("snownonzero/notification");
						/* @var $notification Snowdog_NonZero_Model_Notification */
						$notification->setData(array(
								'type' => Snowdog_NonZero_Model_Source_Type::ZERO_PRICE,
								'quote_id' => $quote->getId(),
								'product_id' => $item->getProductId(),
								'additonal_data' => array(),
						));
						$notification->save();
					} catch(Exception $e) {
						Mage::logException($e);
					}
				}
			}
			if($smallPriceEnabled) {
				if($item->getPrice() < $smallPricePrice) {
					$quote->setHasError(true);
					$item->addErrorInfo(Snowdog_NonZero_Model_Source_Type::SOURCE_ID, Snowdog_NonZero_Model_Source_Type::SMALL_PRICE, $smallPriceMsg, array('min_pirce' => $smallPricePrice, 'price' => $item->getPrice(), 'product_id' => $item->getProductId()));
					try {
						$notification = Mage::getModel("snownonzero/notification");
						/* @var $notification Snowdog_NonZero_Model_Notification */
						$notification->setData(array(
								'type' => Snowdog_NonZero_Model_Source_Type::SMALL_PRICE,
								'quote_id' => $quote->getId(),
								'product_id' => $item->getProductId(),
								'additonal_data' => array(
										'min_pirce' => $smallPricePrice,
										'price' => $item->getPrice(),
								),
						));
						$notification->save();
					} catch(Exception $e) {
						Mage::logException($e);
					}
				}
			}
		}
		if($bigDiscountEnabled) {
			$discount = (1-($quote->getSubtotalWithDiscount() / $quote->getSubtotal())) * 100;
			if($discount > $bigDiscountPercent) {
				$quote->addErrorInfo('error', Snowdog_NonZero_Model_Source_Type::SOURCE_ID, Snowdog_NonZero_Model_Source_Type::BIG_DISCOUNT, $bigDiscountMsg, array('discount' => $discount, 'max_discount' => $bigDiscountPercent));
				try {
					$notification = Mage::getModel("snownonzero/notification");
					/* @var $notification Snowdog_NonZero_Model_Notification */
					$notification->setData(array(
							'type' => Snowdog_NonZero_Model_Source_Type::ZERO_PRICE,
							'quote_id' => $quote->getId(),
							'product_id' => null,
							'additonal_data' => array(
									'discount' => $discount,
									'max_discount' => $bigDiscountPercent,
							),
					));
					$notification->save();
				} catch(Exception $e) {
					Mage::logException($e);
				}
			}
		}
	}
}