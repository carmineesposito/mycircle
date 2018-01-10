<?php
require_once 'Mage/Checkout/controllers/CartController.php';
class Mycircle_Events_Checkout_CartController extends Mage_Checkout_CartController
{


    public function indexAction()
    {

        if (!Mage::getSingleton('customer/session')->getCustomer()->getId()) {
            $this->_redirect('customer/account/login');
        }
        else
            return parent::indexAction();

    }

}