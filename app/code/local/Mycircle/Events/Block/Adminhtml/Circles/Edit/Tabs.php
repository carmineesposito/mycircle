<?php
class Mycircle_Events_Block_Adminhtml_Circles_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{
		public function __construct()
		{
				parent::__construct();
				$this->setId("circles_tabs");
				$this->setDestElementId("edit_form");
				$this->setTitle(Mage::helper("events")->__("Item Information"));
		}
		protected function _beforeToHtml()
		{
				$this->addTab("form_section", array(
				"label" => Mage::helper("events")->__("Item Information"),
				"title" => Mage::helper("events")->__("Item Information"),
				"content" => $this->getLayout()->createBlock("events/adminhtml_circles_edit_tab_form")->toHtml(),
				));
				return parent::_beforeToHtml();
		}

}
