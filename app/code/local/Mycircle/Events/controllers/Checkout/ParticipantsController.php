<?php
class Mycircle_Events_Checkout_ParticipantsController extends Mage_Core_Controller_Front_Action
{

    public function addAction()
    {

        $session = Mage::getSingleton('core/session');
        $request = $this->getRequest();
        $currentData = $session->getData('current_invitation');

        $validator = new Zend_Validate_EmailAddress();

        if ($email = $request->getParam('email',false)) {
            if ($validator->isValid($email) && count($currentData) <= 10) {
                $currentData[] = $email;
                $currentData = array_unique($currentData);
                $session->setData('current_invitation',$currentData);
            }
        }

        echo $this->getPartecipants($currentData);

    }

    private function getPartecipants($currentData) {

        if (!count($currentData))
            return '';

        $html = '<ul id="partecipants-list">';

        $url = Mage::getDesign()->getSkinBaseUrl() . '/images/assets/people/unk.png';

        foreach($currentData as $part) {

            $html  .= '<li class="item-participant" id="partecipant0">
                            <div class="img-profile">
                                <a href="#" class="remove-participants" data-email="'.$part.'">X</a>
                                <input class="part-text" type="hidden"name="part[]"/>
                                <img src="'.$url.'" />
                            </div>
                            <div class="detail-profile">
                                <p class="part-name">'.$part.'</p>
                            </div>
                        </li>';

        }

        $html .= '</ul>';

        return $html;


    }

    public function removeAction()
    {

        $session = Mage::getSingleton('core/session');
        $request = $this->getRequest();
        $currentData = $session->getData('current_invitation');

        $validator = new Zend_Validate_EmailAddress();

        if ($email = $request->getParam('email',false)) {
            if ($validator->isValid($email) && count($currentData) <= 10) {
                $to_remove = array_search($email,$currentData);
                if ($to_remove !== false)
                    unset($currentData[$to_remove]);
                $session->setData('current_invitation',$currentData);
            }
        }

        echo $this->getPartecipants($currentData);

    }

    public function setpreferencesAction()
    {

        $session = Mage::getSingleton('core/session');
        $request = $this->getRequest();

        $session->setData('current_preferences',$request->getParams());

    }

}