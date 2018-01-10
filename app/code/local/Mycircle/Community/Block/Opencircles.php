<?php   
class Mycircle_Community_Block_Opencircles extends Mage_Core_Block_Template{

    public function getCircles() {

        $customer = Mage::getSingleton('customer/session');
        $customer_id = $customer->getId();

        $model = Mage::getModel('events/groups');
        $collection = $model->getCirclesforCustomer($customer_id);

        return $collection;

    }

    public function getParticipants() {

        $customer = Mage::getSingleton('customer/session');
        $customer_id = $customer->getId();

        $model = Mage::getModel('events/groups');
        $collection = $model->getCirclesforCustomer($customer_id);

        return $collection;

    }

}