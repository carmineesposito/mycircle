<?php

class Mycircle_Events_Block_Adminhtml_Circles_Grid extends Mage_Adminhtml_Block_Widget_Grid
{

		public function __construct()
		{
				parent::__construct();
				$this->setId("circlesGrid");
				$this->setDefaultSort("circle_id");
				$this->setDefaultDir("DESC");
				$this->setSaveParametersInSession(true);
		}

		protected function _prepareCollection()
		{
				$collection = Mage::getModel("events/circles")->getCollection();
				$this->setCollection($collection);
				return parent::_prepareCollection();
		}
		protected function _prepareColumns()
		{
				$this->addColumn("circle_id", array(
				"header" => Mage::helper("events")->__("ID"),
				"align" =>"right",
				"width" => "50px",
			    "type" => "number",
				"index" => "circle_id",
				));
                
			$this->addExportType('*/*/exportCsv', Mage::helper('sales')->__('CSV')); 
			$this->addExportType('*/*/exportExcel', Mage::helper('sales')->__('Excel'));

				return parent::_prepareColumns();
		}

		public function getRowUrl($row)
		{
			   return $this->getUrl("*/*/edit", array("id" => $row->getId()));
		}


		
		protected function _prepareMassaction()
		{
			$this->setMassactionIdField('circle_id');
			$this->getMassactionBlock()->setFormFieldName('circle_ids');
			$this->getMassactionBlock()->setUseSelectAll(true);
			$this->getMassactionBlock()->addItem('remove_circles', array(
					 'label'=> Mage::helper('events')->__('Remove Circles'),
					 'url'  => $this->getUrl('*/adminhtml_circles/massRemove'),
					 'confirm' => Mage::helper('events')->__('Are you sure?')
				));
			return $this;
		}
			

}