<?php
class Mycircle_Events_Model_Mysql4_Circles extends Mage_Core_Model_Mysql4_Abstract
{
    protected function _construct()
    {
        $this->_init("events/circles", "customer_circle_id");
    }
}