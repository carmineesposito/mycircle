<?php
class Mycircle_Events_Model_Admin_Catalog_Observer
{

    public function saveAvailabilty($observer) {
        $product = $observer->getEvent()->getProduct();

        try {

            $availability =  $observer->getEvent()->getRequest()->getParam('availability');

            if ($availability)
                $product->setData('availability',$availability);

            }
        catch (Exception $e) {
            Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
        }


    }
    /*
    public function lockProductAttributes($observer) {
        $event = $observer->getEvent();
        $c = $event->getProduct();
        $c->lockAttribute('availability');
    }
    */

}