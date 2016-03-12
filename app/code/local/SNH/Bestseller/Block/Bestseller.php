<?php
/**
 * @package SNH_Bestseller
*/
class SNH_Bestseller_Block_Bestseller extends Mage_Catalog_Block_Product_List
{  	
	 public function getCollection()
	 {
       
		$_daysback = $this->getDaysback() ?: 60;

		$date = new Zend_Date();
		$toDate = $date->get('Y-MM-dd');
		$fromDate = $date->subDay((int)$_daysback)->getDate()->get('Y-MM-dd');

		$_category = $this->getCategory() ?: Mage::app()->getStore()->getRootCategoryId();

		$_limit = $this->getLimit() ?: 3;

	    $storeId = Mage::app()->getStore()->getId();
        $products = Mage::getResourceModel('reports/product_collection')
            ->addOrderedQty($fromDate,$toDate)
            ->setStoreId($storeId)
            ->addStoreFilter($storeId)
			->SetPageSize((int)$_limit)
            ->setOrder('ordered_qty', 'desc');			
		
		if (Mage::helper('catalog/product_flat')->isEnabled()) {
            $products->getSelect()
                ->joinInner(array('e2' => 'catalog_product_flat_' . $storeId), 'e2.entity_id = e.entity_id');
        } else {
            $products->addAttributeToSelect('*')
			->addAttributeToSelect(array('name', 'price', 'small_image'));
        }

		Mage::getSingleton('catalog/product_status')->addVisibleFilterToCollection($products);
        Mage::getSingleton('catalog/product_visibility')->addVisibleInCatalogFilterToCollection($products);
		Mage::getSingleton('cataloginventory/stock')->addInStockFilterToCollection($products);

		if ($_category) {
			$category = Mage::getModel('catalog/category')->load($_category);
            $products->addCategoryFilter($category); // gives no result, blank page
        }

		// $products->getSelect()->group('manufacturer');

		// die($products->getSelect()); 

		$this->setProductCollection($products);
		
		return $products;
    }	
}
