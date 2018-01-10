<?php

class Mycircle_Community_Model_Customer_Api_V2 extends Mage_Customer_Model_Customer_Api_V2
{

    public function mapyItems($filters)
    {
        //let's log a message from here
        Mage::log('Hello from extended API call', null, true, 'success.log');
    }

}