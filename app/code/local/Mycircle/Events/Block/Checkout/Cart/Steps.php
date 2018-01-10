<?php   
class Mycircle_Events_Block_Checkout_Cart_Steps extends Mage_Core_Block_Template{


    protected function _construct()
    {
        parent::_construct();

        $this->setTemplate('mycircle/checkout/cart/steps.phtml');
    }

    public function getCustomerData() {

        return Mage::getSingleton('customer/session')->getCustomer()->getData();

    }

}