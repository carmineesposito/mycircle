<?php   
class Mycircle_Events_Block_Community_Opencircles extends Mage_Core_Block_Template{

    public function getParticipants() {

        $model = Mage::registry('current_circle_data');

        if (!$model)
            return null;

        if (!$model->getId())
            return null;

        $participants = $model->getListUsers();

        if (count($participants))
            return $participants;
        else
            return null;

    }

}