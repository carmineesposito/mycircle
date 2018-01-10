<?php

class Mycircle_Community_Adminhtml_CircleController extends Mage_Adminhtml_Controller_Action
{
		protected function _initAction()
		{
				$this->loadLayout()->_setActiveMenu("community/circle")->_addBreadcrumb(Mage::helper("adminhtml")->__("Circle  Manager"),Mage::helper("adminhtml")->__("Circle Manager"));
				return $this;
		}
		public function indexAction() 
		{
			    $this->_title($this->__("Community"));
			    $this->_title($this->__("Manager Circle"));

				$this->_initAction();
				$this->renderLayout();
		}
		public function editAction()
		{			    
			    $this->_title($this->__("Community"));
				$this->_title($this->__("Circle"));
			    $this->_title($this->__("Edit Item"));
				
				$id = $this->getRequest()->getParam("id");
				$model = Mage::getModel("community/circle")->load($id);
				if ($model->getId()) {
					Mage::register("circle_data", $model);
					$this->loadLayout();
					$this->_setActiveMenu("community/circle");
					$this->_addBreadcrumb(Mage::helper("adminhtml")->__("Circle Manager"), Mage::helper("adminhtml")->__("Circle Manager"));
					$this->_addBreadcrumb(Mage::helper("adminhtml")->__("Circle Description"), Mage::helper("adminhtml")->__("Circle Description"));
					$this->getLayout()->getBlock("head")->setCanLoadExtJs(true);
					$this->_addContent($this->getLayout()->createBlock("community/adminhtml_circle_edit"))->_addLeft($this->getLayout()->createBlock("community/adminhtml_circle_edit_tabs"));
					$this->renderLayout();
				} 
				else {
					Mage::getSingleton("adminhtml/session")->addError(Mage::helper("community")->__("Item does not exist."));
					$this->_redirect("*/*/");
				}
		}

		public function newAction()
		{

		$this->_title($this->__("Community"));
		$this->_title($this->__("Circle"));
		$this->_title($this->__("New Item"));

        $id   = $this->getRequest()->getParam("id");
		$model  = Mage::getModel("community/circle")->load($id);

		$data = Mage::getSingleton("adminhtml/session")->getFormData(true);
		if (!empty($data)) {
			$model->setData($data);
		}

		Mage::register("circle_data", $model);

		$this->loadLayout();
		$this->_setActiveMenu("community/circle");

		$this->getLayout()->getBlock("head")->setCanLoadExtJs(true);

		$this->_addBreadcrumb(Mage::helper("adminhtml")->__("Circle Manager"), Mage::helper("adminhtml")->__("Circle Manager"));
		$this->_addBreadcrumb(Mage::helper("adminhtml")->__("Circle Description"), Mage::helper("adminhtml")->__("Circle Description"));


		$this->_addContent($this->getLayout()->createBlock("community/adminhtml_circle_edit"))->_addLeft($this->getLayout()->createBlock("community/adminhtml_circle_edit_tabs"));

		$this->renderLayout();

		}
		public function saveAction()
		{

			$post_data=$this->getRequest()->getPost();


				if ($post_data) {

					try {

						

						$model = Mage::getModel("community/circle")
						->addData($post_data)
						->setId($this->getRequest()->getParam("id"))
						->save();

						Mage::getSingleton("adminhtml/session")->addSuccess(Mage::helper("adminhtml")->__("Circle was successfully saved"));
						Mage::getSingleton("adminhtml/session")->setCircleData(false);

						if ($this->getRequest()->getParam("back")) {
							$this->_redirect("*/*/edit", array("id" => $model->getId()));
							return;
						}
						$this->_redirect("*/*/");
						return;
					} 
					catch (Exception $e) {
						Mage::getSingleton("adminhtml/session")->addError($e->getMessage());
						Mage::getSingleton("adminhtml/session")->setCircleData($this->getRequest()->getPost());
						$this->_redirect("*/*/edit", array("id" => $this->getRequest()->getParam("id")));
					return;
					}

				}
				$this->_redirect("*/*/");
		}



		public function deleteAction()
		{
				if( $this->getRequest()->getParam("id") > 0 ) {
					try {
						$model = Mage::getModel("community/circle");
						$model->setId($this->getRequest()->getParam("id"))->delete();
						Mage::getSingleton("adminhtml/session")->addSuccess(Mage::helper("adminhtml")->__("Item was successfully deleted"));
						$this->_redirect("*/*/");
					} 
					catch (Exception $e) {
						Mage::getSingleton("adminhtml/session")->addError($e->getMessage());
						$this->_redirect("*/*/edit", array("id" => $this->getRequest()->getParam("id")));
					}
				}
				$this->_redirect("*/*/");
		}

		
}
