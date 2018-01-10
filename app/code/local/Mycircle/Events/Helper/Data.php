<?php
class Mycircle_Events_Helper_Data extends Mage_Core_Helper_Abstract
{

    public function getFirstutilday() {

        return strtotime('+3 day',mktime(0,0,0));

    }

    public function getValidRequest() {

        $current_month = $this->_getRequest()->getParam('month',false);
        $current_day = $this->_getRequest()->getParam('day',date('d'));

        if (!$current_month && !$current_month)
            $dateTimestamp = Mage::getModel('core/date')->timestamp(time());
        else
            $dateTimestamp = Mage::getModel('core/date')->timestamp(strtotime($current_day.'-'.$current_month));

        return 'month='.date('m-Y', $dateTimestamp).'&'.'day='.date('d', $dateTimestamp);


    }

    public function getValidDate() {

        $current_month = $this->_getRequest()->getParam('month',false);
        $current_day = $this->_getRequest()->getParam('day',date('d'));
        $checknow = Mage::getModel('core/date')->timestamp(time());

        // per ora impostato a tre giorni

        $first_util_date = $this->getFirstutilday();

        if (!$current_month && !$current_month)
            return $first_util_date;

        $dateTimestamp = Mage::getModel('core/date')->timestamp(strtotime($current_day.'-'.$current_month));

        if ($first_util_date >= $dateTimestamp)
            return $first_util_date;

        return $dateTimestamp;


    }

    public function getValidMonth() {

        $date = $this->getValidDate();
        return date('m-Y', $date);

    }

    public function getFormattedDate() {

        $date = $this->getValidDate();
        return date('Y-m-d', $date);

    }

    public function getFormattedViewDate() {

        $date = $this->getValidDate();
        return date('d-m-Y', $date);

    }

    public function getTotalinCircle($id,$date = null) {

        $modelgroups = Mage::getModel('events/groups');

        $date_search = $this->getFormattedDate();

        $collection = $modelgroups
                    ->getCollection()
                    ->addFieldToFilter('product_id',$id)
                    ->addFieldToFilter('date',$date_search);
        $collection->getSelect()->limit(1);

        $total = $collection->getFirstItem()->getData('order_count');
        return ($total) ? $total : 0;


    }

    public function getTotalCircles($id,$date = null) {

        $modelgroups = Mage::getModel('events/groups');

        $date = $this->getValidDate();

        return $modelgroups
            ->getCollection()
            ->addFieldToFilter('product_id',$id)
            ->addFieldToFilter('MONTH(date)',date('m',$date))
            ->count();

    }

    public function getCircleData($product_id) {

        $modelgroups = Mage::getModel('events/groups');
        $day = $this->getFormattedDate();

        $collection = $modelgroups
            ->getCollection()
            ->addFieldToFilter('product_id',$product_id)
            ->addFieldToFilter('date',$day);
        $collection->getSelect()->limit(1);

        $id = $collection->getFirstItem()->getId();

        $modelgroups->load($id);

        if ($modelgroups->getId()) {
            Mage::register('current_circle_data',$modelgroups,true);
            return $modelgroups;
        }

        return null;


    }

    public function decodeDaysforEvent($string) {

        $string = trim($string);
        $year=date('Y');
        $data = array();

        if ($string == '') {
            return false;
        }

        //echo(date("m/d/Y", strtotime("january $year +180 day")));

        for ($i = 0;$i<=strlen($string) - 1;$i++) {

            $value = $string{$i};
            $day = $i+1;

            //if ($value)
               // echo $day . ' ' . $value . ' ' . date("m/d/Y", strtotime("january $year +$i day")) . '<br />';
            //else
              //  echo $day . ' ' . $value . '<br />';

            if ($value)
               $data[] = date("m/d/Y", strtotime("january $year +$i day"));

        }

        if (!count($data))
            return false;

        return str_replace('"',"'",json_encode($data,JSON_UNESCAPED_SLASHES));;

    }

}
	 