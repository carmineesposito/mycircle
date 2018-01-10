<?php
class Mycircle_Community_Model_Mysql4_Circle extends Mage_Core_Model_Mysql4_Abstract
{
    protected function _construct()
    {
        $this->_init("community/circle", "entity_id");
    }
}