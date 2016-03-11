# SNH_Addorderqty
Magento Bestsellers for configurable (actually all) product types

# Rationale
Magento doesn't support a bestsellers collection by default so this needs to be coded. Some efforts have been made before - but they seem to capture only simple products and simple products (as a child of a configurable product).  

A question was asked at stackexchange to develop a method to work around this: http://magento.stackexchange.com/questions/105698/magento-getting-store-bestsellers-configurable-products-only-from-current-stor

# Goals of this extension
- Return a list of configurable bestsellers (or at least the real parent)
- with sales order qty summed per store view (store) (so sales made in other stores are exclude)
- with sales order qty summed per category (optional; only include product belonging to category X - applies to parent products only because simple products may not be a member of the category)
- with an optional command to lag limit the sales qty over time (like last month only, or last 60 days)
- and if someone feels enthusiastic: create a temp table and cronjob to log the results to speed up things (optional optional)

# Usage
You may need to code your own phtml file - but it then may rely on this model. Example code below:
`{{block type="addorderqty/bestsellerlist" header="Bestselling products" limit=20 category=76 template="catalog/product/bestsellerlist.phtml"}}`

# References
Other blogs related to this issue (But solve only for simple products)
- http://inchoo.net/magento/bestseller-products-in-magento/comment-page-2/#comment-431917
- https://blog.amasty.com/how-to-display-bestselling-products-in-magento-source-code/
- https://www.zodiacmedia.co.uk/blog/magento-bestselling-products
- http://magento.stackexchange.com/questions/105698/magento-getting-store-bestsellers-configurable-products-only-from-current-stor
