<?php
	
class Mycircle_Community_Block_Adminhtml_Circle_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
		public function __construct()
		{

				parent::__construct();
				$this->_objectId = "entity_id";
				$this->_blockGroup = "community";
				$this->_controller = "adminhtml_circle";
				$this->_updateButton("save", "label", Mage::helper("community")->__("Save Item"));
				$this->_updateButton("delete", "label", Mage::helper("community")->__("Delete Item"));

				$this->_addButton("saveandcontinue", array(
					"label"     => Mage::helper("community")->__("Save And Continue Edit"),
					"onclick"   => "saveAndContinueEdit()",
					"class"     => "save",
				), -100);



				$this->_formScripts[] = "

							function saveAndContinueEdit(){
								editForm.submit($('edit_form').action+'back/edit/');
							}
						";
		}

		public function getHeaderText()
		{
				if( Mage::registry("circle_data") && Mage::registry("circle_data")->getId() ){

				    return Mage::helper("community")->__("Edit Item '%s'", $this->htmlEscape(Mage::registry("circle_data")->getId()));

				} 
				else{

				     return Mage::helper("community")->__("Add Item");

				}
		}
}