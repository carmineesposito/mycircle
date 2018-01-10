<?php
class Mycircle_Events_Model_Checkout_Cart_Observer
{

    public function emptyCart() {

        foreach( Mage::getSingleton('checkout/session')->getQuote()->getItemsCollection() as $item ){

            Mage::getSingleton('checkout/cart')->removeItem( $item->getId());
        }

    }

//    public function applySelectedDate(Varien_Event_Observer $observer) {

//        $date = Mage::app()->getRequest()->getParam('selected_date', 0);
//
//        /* @var $item Mage_Sales_Model_Quote_Item */
//        $item = $observer->getQuoteItem();
//        if ($item->getParentItem()) {
//
//            $a_options = array(
//                'options1' => array(
//                    'label' => 'Selected Date',
//                    'value' => $date,
//                )
//            );
//
//        }
//
//        $item->addOption(new Varien_Object(
//            array(
//                'product' => $item->getProduct(),
//                'code' => 'additional_options',
//                'value' => serialize($a_options)
//            )
//        ));

//    }

}