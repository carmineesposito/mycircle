<?php
class Mycircle_Events_Model_Customer_Observer
{

    public function updateProfile($observer) {

        $model = Mage::getModel('events/customerprofile');

        $customer = $observer->getCustomer();
        $customer_id = $customer->getId();

        $model->load($customer_id,'customer_id');

        if (!$model->getId())
            $model->setData('customer_id',$customer_id);

        $model->setData('name',$customer->getFirstname() . ' ' . $customer->getLastname());
        $model->setData('dob',$customer->getDob());
        $model->setData('gender',$customer->getGender());

        try {
            $model->save();
        } catch (Exception $e) {
            exit($e->getMessage());
        }

    }

}