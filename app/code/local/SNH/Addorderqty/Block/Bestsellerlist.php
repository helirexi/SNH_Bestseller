<?php

class SNH_Addorderqty_Block_Bestsellerlist extends Mage_Catalog_Block_Product_List
{

    public function getCollection()
    {
        $storeId = Mage::app()->getStore()->getId();

		// Date
		$date = new Zend_Date();
		$toDate = $date->setDay(1)->getDate()->get('Y-MM-dd');
		$fromDate = $date->subMonth(1)->getDate()->get('Y-MM-dd');
		
		$collection = Mage::getResourceModel('reports/product_collection')
            ->addOrderedQty($fromDate, $toDate, true, false, false)
            ->setStoreId($storeId)
            ->addStoreFilter($storeId)
            ->setOrder('ordered_qty', 'desc');

		if (Mage::helper('catalog/product_flat')->isEnabled()) {
            $collection->getSelect()
                ->joinInner(array('e2' => 'catalog_product_flat_' . $storeId), 'e2.entity_id = e.entity_id');
        } else {
            $collection->addAttributeToSelect('*')
                ->addAttributeToSelect(array('name', 'price', 'small_image'));
        }

		/** $_category = (int)$this->getCategory() ?: null;
		if ($_category) {
			$category = Mage::getModel('catalog/category')->load($_category);
            $collection->addCategoryFilter($category); // gives no result, blank page
        }
		**/

        Mage::getSingleton('catalog/product_status')->addVisibleFilterToCollection($collection);
        Mage::getSingleton('catalog/product_visibility')->addVisibleInCatalogFilterToCollection($collection);
		Mage::getSingleton('cataloginventory/stock')->addInStockFilterToCollection($collection);

        $_limit = (int)$this->getLimit() ?: 3;
		$collection->setPage(1, $_limit);

		die($collection->getSelect()); 

		return $collection;
    }

}

