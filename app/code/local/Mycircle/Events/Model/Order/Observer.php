<?php

class Mycircle_Events_Model_Order_Observer
{

    public function addtocircle($observer)
    {

        $customer = Mage::getSingleton('customer/session')->getCustomer();
        $session = Mage::getSingleton('core/session');
        $model = Mage::getModel('events/groups');
        $order = $observer->getEvent()->getOrder();

        if (!$customer->getId())
            throw new Exception('cannot load model customer');

        $idsblock = array();
        $is = $order->getAllItems();

        foreach ($is as $i) {

            $product = $i->getProduct();
            $model->setProduct($product);

            $selected_date = $i->getBuyRequest()->selected_date;

            $model->setDate($selected_date);

            // controllo esistenza cerchio aperto

            $has_circle = $model->loadLastCircle();

            // no apro cerchio

            if (!$has_circle)
                $model->openCircle();

            // carico model cerchio

            //aggiungo utente

            $preferences = $session->getData('current_preferences',false);

            $model->addCustomer($customer, $order , $preferences);

            // controllo stato count cerchio

            $state = $model->checkCircleState();

            // si chiudo cerchio

            if ($state)
                $model->closeCircle();

        }

        return true;
    }

    public function sendInvitationEmails(Varien_Event_Observer $observer)
    {

        $template = 'invite_email_template';

        $session = Mage::getSingleton('core/session');
        $currentUsers = $session->getData('current_invitation');

        if (!count($currentUsers))
            return false;

        $mailTemplate  = Mage::getModel('core/email_template')->loadDefault($template);

        $orderid = Mage::getSingleton('checkout/session')->getLastOrderId();

        $order = Mage::getModel('sales/order')->load($orderid);

        $ordered_items = $order->getItemsCollection();
        $item = $ordered_items->getFirstItem();

        $sender['name'] = Mage::getStoreConfig(Mage_Core_Model_Store::XML_PATH_STORE_STORE_NAME);
        $sender['email'] = Mage::getStoreConfig('trans_email/ident_support/email');

        $sender['name'] = Mage::getStoreConfig(Mage_Core_Model_Store::XML_PATH_STORE_STORE_NAME);
        $sender['email'] = Mage::getStoreConfig('trans_email/ident_general/email');

        // Get Store ID
        $store = Mage::app()->getStore()->getStoreId();

        // Set variables that can be used in email template
        $vars = array('customer_name' => $order->getCustomerName(),
                      'customer_email' => $order->getCustomerEmail(),
                      'event_name' => $item->getName(),
                      'event_img' => $item->getProduct()->getImageUrl(),
                      'event_link' => $item->getProduct()->getProductUrl()
        );

        $translate  = Mage::getSingleton('core/translate');

        foreach($currentUsers as $user) {

            // Set recepient information
            $recepientEmail = $user;
            $recepientName = $user;

            $vars['guest_email'] = $recepientEmail;

            $mailTemplate->sendTransactional($mailTemplate->getId(), $sender, $recepientEmail, $recepientName, $vars, $store);

        }

        $translate->setTranslateInline(true);

        $session->unsetData('current_invitation');

        return $this;
    }

}