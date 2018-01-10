<?php   
class Mycircle_Community_Block_Left extends Mage_Core_Block_Template{   


        public function getParticipants() {

            if (!Mage::registry('current_circle'))
                return false;

            $current_circle = Mage::registry('current_circle');

            return $collection;


        }

}