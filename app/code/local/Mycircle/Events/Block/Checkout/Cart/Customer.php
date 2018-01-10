<?php   
class Mycircle_Events_Block_Checkout_Cart_Customer extends Mage_Core_Block_Template{


    protected function _construct()
    {
        parent::_construct();

        $this->setTemplate('mycircle/checkout/cart/customer.phtml');
    }

    public function getCustomerData() {

        return Mage::getSingleton('customer/session')->getCustomer()->getData();

    }

}