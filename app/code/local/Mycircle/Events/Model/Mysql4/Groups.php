<?php
class Mycircle_Events_Model_Mysql4_Groups extends Mage_Core_Model_Mysql4_Abstract
{
    protected function _construct()
    {
        $this->_init("events/groups", "circle_id");
    }
}