<?php
class Mycircle_Events_Block_Adminhtml_Circles_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
		protected function _prepareForm()
		{

				$form = new Varien_Data_Form();
				$this->setForm($form);
				$fieldset = $form->addFieldset("events_form", array("legend"=>Mage::helper("events")->__("Item information")));

				
						$fieldset->addField("circle_id", "text", array(
						"label" => Mage::helper("events")->__("ID Circle"),
						"name" => "circle_id",
						));
					

				if (Mage::getSingleton("adminhtml/session")->getCirclesData())
				{
					$form->setValues(Mage::getSingleton("adminhtml/session")->getCirclesData());
					Mage::getSingleton("adminhtml/session")->setCirclesData(null);
				} 
				elseif(Mage::registry("circles_data")) {
				    $form->setValues(Mage::registry("circles_data")->getData());
				}
				return parent::_prepareForm();
		}
}
