<?php


class Mycircle_Community_Block_Adminhtml_Circle extends Mage_Adminhtml_Block_Widget_Grid_Container{

	public function __construct()
	{

	$this->_controller = "adminhtml_circle";
	$this->_blockGroup = "community";
	$this->_headerText = Mage::helper("community")->__("Circle Manager");
	$this->_addButtonLabel = Mage::helper("community")->__("Add New Item");
	parent::__construct();
	
	}

}