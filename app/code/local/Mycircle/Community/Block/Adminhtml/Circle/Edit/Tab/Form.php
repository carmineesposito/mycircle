<?php
class Mycircle_Community_Block_Adminhtml_Circle_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
		protected function _prepareForm()
		{

				$form = new Varien_Data_Form();
				$this->setForm($form);
				$fieldset = $form->addFieldset("community_form", array("legend"=>Mage::helper("community")->__("Item information")));

				
						$fieldset->addField("entity_id", "text", array(
						"label" => Mage::helper("community")->__("ID"),
						"name" => "entity_id",
						));
					

				if (Mage::getSingleton("adminhtml/session")->getCircleData())
				{
					$form->setValues(Mage::getSingleton("adminhtml/session")->getCircleData());
					Mage::getSingleton("adminhtml/session")->setCircleData(null);
				} 
				elseif(Mage::registry("circle_data")) {
				    $form->setValues(Mage::registry("circle_data")->getData());
				}
				return parent::_prepareForm();
		}
}
