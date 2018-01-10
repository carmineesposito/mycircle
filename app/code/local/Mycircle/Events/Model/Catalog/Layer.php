<?php
/**
 * Created by PhpStorm.
 * User: carmineesposito
 * Date: 20/11/14
 * Time: 23:00
 */
class Mycircle_Events_Model_Catalog_Layer extends Mage_Catalog_Model_Layer
{

    /**
     * Initialize product collection
     *
     * @param Mage_Catalog_Model_Resource_Eav_Mysql4_Product_Collection $collection
     * @return Mage_Catalog_Model_Layer
     */
    public function prepareProductCollection($collection)
    {
        $param = $this->getFilterDate();
        $attribute = Mage::getSingleton('eav/config')->getAttribute('catalog_product', 'availability');
        $filter_date = MAge::registry('allow_filter_date');

        if ($param !== false && $attribute &&  Mage::registry('current_category')->getIsAnchor()) {

            $collection->getSelect()->join(
                'catalog_product_entity_text as at_availability',
                "at_availability.entity_id = e.entity_id AND (at_availability.attribute_id = ".$attribute->getId().") AND (at_availability.store_id = 0)",
                array('at_availability.value')
            );

            $collection->getSelect()->where(new Zend_Db_Expr("substring(at_availability.value,?,1) = 0"),$param);

        }

        return parent::prepareProductCollection($collection);

    }

    public function getFilterDate() {

        $helper = Mage::helper('events');

        $checknow = time();
        $checkdate_ts = $helper->getValidDate();

        if ($checkdate_ts > $checknow)
            return ((int) date('z',$checkdate_ts)) + 1;
        else
            return false;

    }

}