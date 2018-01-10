<?php
/**
 * Magento
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@magento.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Magento to newer
 * versions in the future. If you wish to customize Magento for your
 * needs please refer to http://www.magento.com for more information.
 *
 * @category    Mage
 * @package     Mage_Catalog
 * @copyright  Copyright (c) 2006-2014 X.commerce, Inc. (http://www.magento.com)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

/**
 * Catalog product api V2
 *
 * @category   Mage
 * @package    Mage_Catalog
 * @author     Magento Core Team <core@magentocommerce.com>
 */
class Mycircle_Events_Model_Catalog_Product_Api_V2 extends Mage_Catalog_Model_Product_Api_V2
{

    /**
     * Retrieve list of products with basic info (id, sku, type, set, name)
     *
     * @param null|object|array $filters
     * @param string|int $store
     * @return array
     */
    public function items($filters = null, $store = null)
    {
        $collection = Mage::getModel('catalog/product')->getCollection()
            ->addStoreFilter($this->_getStoreId($store))
            ->addAttributeToSelect('name');

        /** @var $apiHelper Mage_Api_Helper_Data */
        $apiHelper = Mage::helper('api');
        $filters = $apiHelper->parseFilters($filters, $this->_filtersMap);
        $attribute = Mage::getSingleton('eav/config')->getAttribute('catalog_product', 'availability');

        if (isset($filters['availability']) && $attribute) {

            $date = $filters['availability']['eq'];
            $date_day = $this->getFilterDate($date);

            $collection->getSelect()->join(
                'catalog_product_entity_text as at_availability',
                "at_availability.entity_id = e.entity_id AND (at_availability.attribute_id = ".$attribute->getId().") AND (at_availability.store_id = 0)",
                array('at_availability.value')
            );

            $collection->getSelect()->where(new Zend_Db_Expr("substring(at_availability.value,?,1) = 0"),$date_day);

            unset($filters['availability']);

        }

        try {
            foreach ($filters as $field => $value) {
                $collection->addFieldToFilter($field, $value);
            }
        } catch (Mage_Core_Exception $e) {
            $this->_fault('filters_invalid', $e->getMessage());
        }
        $result = array();
        foreach ($collection as $product) {
            $result[] = array(
                'product_id' => $product->getId(),
                'sku'        => $product->getSku(),
                'name'       => $product->getName(),
                'set'        => $product->getAttributeSetId(),
                'type'       => $product->getTypeId(),
                'category_ids' => $product->getCategoryIds(),
                'website_ids'  => $product->getWebsiteIds(),
                'short_description'  =>$product->getShortDescription(),
                'selected_date'  => $date,
                'in_circles'     =>  Mage::helper('events')->getTotalinCircle($product->getId())

            );
        }
        return $result;
    }

    protected function getFilterDate($date) {

        $helper = Mage::helper('events');

        $checknow = time();
        $checkdate_ts = Mage::getModel('core/date')->timestamp(strtotime($date));

        if ($checkdate_ts > $checknow)
            return ((int) date('z',$checkdate_ts)) + 1;
        else
            return false;

    }

    public function mapyItems($filters)
    {
        //let's log a message from here
        Mage::log('Hello from extended API call', null, true, 'success.log');
    }

}
