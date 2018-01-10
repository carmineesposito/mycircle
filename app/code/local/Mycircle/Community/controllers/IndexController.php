<?php
class Mycircle_Community_IndexController extends Mage_Core_Controller_Front_Action{

    public function IndexAction() {

        if(!Mage::getSingleton('customer/session')->isLoggedIn())
        {
            $this->_forward('defaultNoRoute');
        }

        $customer = Mage::getSingleton('customer/session');

        $model_groups = Mage::getModel('events/groups');

        $current_circle = $model_groups->getCircleforCustomer($customer->getId());

        Mage::register('current_circle',$current_circle);

        $this->loadLayout();
        $this->renderLayout();
    }
}