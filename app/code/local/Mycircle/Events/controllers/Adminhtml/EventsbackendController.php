<?php
class Mycircle_Events_Adminhtml_EventsbackendController extends Mage_Adminhtml_Controller_Action
{
	public function indexAction()
    {
       $this->loadLayout();
	   $this->_title($this->__("Cerchi"));
	   $this->renderLayout();
    }
}