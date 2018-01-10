<?php   
class Mycircle_Events_Block_Catalog_Toolbar extends Mage_Core_Block_Template{


    /**
     * Return current URL with rewrites and additional parameters
     *
     * @param array $params Query parameters
     * @return string
     */
    public function getPagerUrl($params=array())
    {
        $urlParams = array();
        $urlParams['_current']  = true;
        $urlParams['_escape']   = true;
        $urlParams['_use_rewrite']   = true;
        $urlParams['_query']    = $params;
        return $this->getUrl('*/*/*', $urlParams);
    }

    public function getDaysUrl()
    {
        return $this->getUrl('*/toolbar/days');
    }

    public function getDayMonth($month,$year) {

        if ($month < 1 || $month > 12)
            return array();

        $day_list = array();
        $days = cal_days_in_month(CAL_GREGORIAN, $month, $year);

        for ($i = 1; $i <= $days; $i++) {

            $day_list[] = array('number'=>$i,'day'=>strtolower(date('D',mktime(0,0,0,$month,$i,$year))));

        }
        return $day_list;

    }


}