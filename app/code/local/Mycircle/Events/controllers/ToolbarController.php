<?php
class Mycircle_Events_ToolbarController extends Mage_Core_Controller_Front_Action
{

    public function daysAction()
    {

        $request = $this->getRequest();

        $block = $this->getLayout()->createBlock('events/catalog_toolbar')->setTemplate('mycircle/toolbar/list.phtml');

        echo $block->toHtml();
        exit;

    }

}