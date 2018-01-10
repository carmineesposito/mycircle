<?php

class Mycircle_Events_Model_Groups extends Mage_Core_Model_Abstract
{

    protected $_product;
    protected $_date;
    protected $_last_group_number = null;

    protected function _construct(){

       $this->_init("events/groups");

    }

    public function getListUsers() {

        $model_circle_customer = Mage::getModel('events/circles');

        if (!$this->getId())
            return null;

        $collection = $model_circle_customer
            ->getCollection()
            ->addFieldToFilter('circle_id',$this->getId());

        $collection
            ->getSelect()
            ->join('customer_profile as cf','cf.customer_id = main_table.customer_id')
            ->limit(8);

        if ($collection->count()) {

            foreach($collection as $item) {
                $customers_list[$item->getData('customer_id')] = $item;
            }

            return $customers_list;
        }

        else return null;

    }

    public function getLastGroupNumber($active = 1) {

        $product = $this->getProduct();
        $date = $this->getDate();

        if (!$this->getProduct()->getId() || !$date)
            throw new Exception('no product or date set');

        $product_id = $product->getId();
        $collection = $this->getCollection();

        $collection
            ->addFieldToFilter('product_id',$product_id)
            ->addFieldToFilter('date',$date)
            ->addFieldToFilter('state',$active)
            ->getSelect()->order('group_number DESC')->limit(1);

        if (!$collection->count()) {
            return 0;
        }

        return (int) $collection->getFirstItem()->getData('group_number');

    }

    public function getDate() {

        return $this->_date;

    }

    public function setDate($date) {

        $this->_date = $date;

    }

    public function setProduct(Mage_Catalog_Model_Product $product) {

        if (!$product->getId())
            throw new Exception('not valid product');

        $this->_product = Mage::getModel('catalog/product')->load($product->getId());

    }

    public function getProduct() {

        return $this->_product;

    }

    //restituisce l'ultimo cerchio attivo dato un prodotto e un giorno

    public function loadLastCircle() {

        $product = $this->getProduct();
        $date = $this->getDate();

        if (!$this->getProduct()->getId() || !$date)
            throw new Exception('no product or date set');

        $product_id = $product->getId();
        $collection = $this->getCollection();

        $collection
            ->addFieldToFilter('product_id',$product_id)
            ->addFieldToFilter('date',$date)
            ->addFieldToFilter('state',0)
            ->getSelect()->order('group_number DESC')->limit(1);

        if (!$collection->count()) {
            $this->_last_group_number = (int) $this->getLastGroupNumber();
            return 0;
        }

        $this->load($collection->getFirstItem()->getId());
        $this->_last_group_number = (int) $collection->getFirstItem()->getData('group_number');


        return true;

    }

    //apre un nuovo cerchio

    public function openCircle() {

        $product = $this->getProduct();
        $date = $this->getDate();

        if (!$product->getId() || !$date)
            throw new Exception('no product or date set');

        if ($this->_last_group_number === null)
            throw new Exception('no last group number set, call lastCircleCheck');

        $this->setData('circle_id',null);
        $next_circle_group = (int) $this->_last_group_number + 1;

        $this->setData('product_id',$product->getId());
        $this->setData('date',date('Y-m-d',strtotime($date)));
        $this->setData('order_count',0);
        $this->setData('guest_count',0);
        $this->setData('group_number',(String) $next_circle_group);
        $this->setData('status',0);
        $this->setData('state',0);

        try {

            $this->save();

        } catch (Exception $e) {

            throw new Exception($e->getMessage());

        }


    }

    // aggiunge un utente a un cerchio dato un giorno e un cerchio

    public function addCustomer(&$customer,&$order,$preferences = null) {

        if (!$this->getData('circle_id'))
            throw new Exception('circle must be loaded');

        if (!($customer instanceof Mage_Customer_Model_Customer) || (!$customer->getId()))
            throw new Exception('cannot load model customer');

        $model_customers = Mage::getModel('events/circles');

        $model_customers->setData('circle_id',$this->getData('circle_id'));
        $model_customers->setData('customer_id',$customer->getId());
        $model_customers->setData('order_id',$order->getId());
        $model_customers->setData('status',1);

        if ($preferences) {

            $model_customers->setData('tour_preferences',(isset($preferences['tour_preferences'])  ?  $preferences['tour_preferences'] : '' ));
            $model_customers->setData('prov_preferences',(isset($preferences['prov_preferences'])  ?  $preferences['prov_preferences'] : '' ));

        }

        try {

            $model_customers->save();
            $this->setData('order_count',(int) $this->getData('order_count') + 1);
            $this->save();

        } catch (Exception $e) {

            throw new Exception($e->getMessage());

        }


    }

    // controlla se un cerchio può essere chiuso

    public function checkCircleState() {

        $product = $this->getProduct();
        $date = $this->getDate();

        if (!$this->getData('circle_id'))
            throw new Exception('circle must be loaded');

        if (!$product->getId() || !$date)
            throw new Exception('product or date must be loaded');


        $min_circle_number = (int) $product->getData('circle_limit');
        $max_circle_number = (int) $product->getData('circle_limit_max');

        if (!$min_circle_number || !$max_circle_number)
            throw new Exception('circle min or max must be loaded');


        $total_in_circle = (int) $this->getData('order_count');

         if ($total_in_circle >= $max_circle_number)
            return true;
         else
            return false;

    }

    // chiude un cerchio e valida la chiusura

    public function closeCircle() {

        if (!$this->getData('circle_id'))
            throw new Exception('circle must be loaded');

        $this->setData('state',1);

        try {

            $this->save();

        } catch (Exception $e) {

            throw new Exception($e->getMessage());

        }

    }

    // aggiunge un cerchio alla coda di invio

    public function addCircleInQueue() {



    }

    public function getCirclesforCustomer($customer_id) {

        $collection = $this->getCollection();

        $collection->getSelect()
            ->join('customer_circles as cc','main_table.circle_id = cc.circle_id')
            ->where('customer_id = ?',$customer_id)
            ->group('main_table.circle_id')
            ->order('date DESC')->limit(20);

        if ($collection->count())
            return $collection;

        return false;

    }

    public function getCircleforCustomer($customer_id,$circle_id = null) {

        if (!$circle_id) {

            $collection = $this->getCollection();

            $collection->getSelect()
                ->join('customer_circles as cc','main_table.circle_id = cc.circle_id')
                ->where('customer_id = ?',$customer_id)
                ->group('main_table.circle_id')
                ->order('date DESC')
                ->limit(1);

            if (!$collection->count())
                return false;

            $circle_id = $collection->getFirstItem()->getId();

        }


        $this->load($circle_id);

        return $this;

    }



}
	 