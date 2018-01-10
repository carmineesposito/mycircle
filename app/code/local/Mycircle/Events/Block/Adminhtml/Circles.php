<?php


class Mycircle_Events_Block_Adminhtml_Circles extends Mage_Adminhtml_Block_Widget_Grid_Container{

	public function __construct()
	{

	$this->_controller = "adminhtml_circles";
	$this->_blockGroup = "events";
	$this->_headerText = Mage::helper("events")->__("Circles Manager");
	$this->_addButtonLabel = Mage::helper("events")->__("Add New Item");
	parent::__construct();
	
	}

}