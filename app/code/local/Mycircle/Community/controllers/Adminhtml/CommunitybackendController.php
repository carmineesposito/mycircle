<?php
class Mycircle_Community_Adminhtml_CommunitybackendController extends Mage_Adminhtml_Controller_Action
{
	public function indexAction()
    {
       $this->loadLayout();
	   $this->_title($this->__("Circles"));
	   $this->renderLayout();
    }
}