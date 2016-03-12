# SNH_Bestseller
Magento Bestsellers for configurable (actually all) product types (originally SNH_Addorderqty)

# Rationale
Magento doesn't support a bestsellers collection by default so this needs to be coded. Some efforts have been made before - but they seem to capture only simple products and simple products (as a child of a configurable product).  

A question was asked at stackexchange to develop a method to work around this: http://magento.stackexchange.com/questions/105698/magento-getting-store-bestsellers-configurable-products-only-from-current-stor

# Goals of this extension
- [DONE] Return a list of configurable bestsellers (or at least the real parent)
- [DONE] with sales order qty summed per store view (store) (so sales made in other stores are exclude)
- [DONE] with sales order qty summed per category (optional; only include product belonging to category X - applies to parent products only because simple products may not be a member of the category)
- [DONE] with an optional command to lag limit the sales qty over time (like last month only, or last 60 days)
- [DONE] option to set header title
- [TODO] add a default magento compatible template file that works for everyone (my own is themed) 
- [*TODO*] create option to inject distinct variable like `distinct=brand` where the brand column in the result is used to olny list the first bestseller appearance per brand (to prevent 1 popular brand from hogging bestsellers - so in other words, show the bestsellers, but then the 1 bestseller per brand) 
- and if someone feels enthusiastic: create a temp table and cronjob to log the results to speed up things (optional optional)

# Help needed
- in perfecting the code
- testing this on multiple installations
- adding the items under [TODO]

# Usage
You may need to code your own phtml file - but it then may rely on this model. Example code below:
`{{block type="bestseller/bestseller" header="My Popular products" daysback=60 limit=8 category=6 template="catalog/product/bestsellerlist.phtml"}}`

Where
- `type="bestseller/bestseller"` calls the block code and method
- `header="My Popular products"` injects the header (empty = "Bestsellers")
- `daysback=60` calculates bestsellers and looking back 60 days (empty = 60)
- `limit=8` returns the 8 best selling products (empty = 3)
- `category=6` returns best selling products that are a member of category (empty = root category)
- `template="catalog/product/bestsellerlist.phtml"` your own coded template file doing magic with the resulting collection

In the template you can retrieve the collection like `$_productCollection = $this->getCollection();` and the header or other variables like so `$_header = $this->getHeader() ?: "Bestseller";`. By looping over the products a list is made `foreach ($_productCollection as $_product)`. Best is to copy the list or category list template depending on your needs. Some coding is required.

# References
Other blogs related to this issue (But solve only for simple products)
- http://inchoo.net/magento/bestseller-products-in-magento/comment-page-2/#comment-431917
- https://blog.amasty.com/how-to-display-bestselling-products-in-magento-source-code/
- https://www.zodiacmedia.co.uk/blog/magento-bestselling-products
- http://magento.stackexchange.com/questions/105698/magento-getting-store-bestsellers-configurable-products-only-from-current-stor
