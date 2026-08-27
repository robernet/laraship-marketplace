# Corals Marketplace
- Laraship Marketplace Module is a multi-vendor e-commerce platform, It integrates seamlessly and packaged with many other Laraship modules and packages
Like Referrals, Advertisement, Subscriptions,…

- With Laraship Marketplace you configure it with  Subscription Business Model, Commission Based Module or both.


 ### Articles
- [Configuration](#configuration)

- [Product Management](#product-management)

- [Transactions](#transactions)

- [Category Hierarchy](#category-hierarchy)

- [Abandoned Cart Notifications](#abandoned-cart-notifications)

- [Cross Device Carts](#cross-device-carts)

- [Shipping Management](#shipping-management)

- [Shipping Packages](#shipping-packages)

- [Flate Rate Shipping](#flate-rate-shipping)

- [Shippo Setup](#shippo-setup)

- [Payout Configuration](#payout-configuration)



## Installation

You can install the package via composer:

```bash
composer require corals/marketplace
```

## Testing

```bash
vendor/bin/phpunit vendor/corals/marketplace/tests 
```


## Configuration
Under Marketplace -> Settings there are a few tabs with configurations, the General tab basically define your business model and revenue setup

<p><img src="https://www.laraship.com/wp-content/uploads/2019/05/laravel_marketplace_settings.png" alt="" width="650px" height="350px"></p>


1.<strong>Vendor Role</strong>: This specifies the role that the user will be assigned once he completes the seller enrollment, we have created a role called “vendor” and by default, it  will show up once you installed the module, and it’s attached to the necessary permissions for the vendor to manage their permissions, however you create your own role and restrict the vendor the access or give him a wider range of permissions.

2.<strong>Agreement Text</strong>: this text will show once a user starts the seller enrollment, you add more text about your privacy, policy .. and the user has to accept the agreement text before he proceeds with the enrollment.

3.<strong>Subscription Required for Vendor Enrollment</strong>: this specifies if the user is required to subscribe to a recurring plan in order to become a vendor.

4.<strong>Fixed Commission Percentage</strong>: if you’re looking to charge vendors and fixed commission percentage on their sales, you can set this flag to true.

5.<strong>Recurring Product</strong>: if you checked the Subscription required option, then you need to point out the recurring product under the subscription module, where you can define the plans available for vendor enrollment.

6.<strong>Commission Recurring Product feature</strong>: if the commission is different from recurring plan to another, then you need to define a numeric feature value to the subscription product and assign the commission percentage on the plan level.

7.<strong>Fallback Plan</strong>: if the user canceled his subscription, or subscription got canceled for no payment reason, for example, you can define the fallback plan and the user will be downgraded to that roles.


## Product Management
Laraship Support 3 Product Types

- <strong>Simple Product</strong>: This is a physical or virtual item with a single SKU.

- <strong>Variable Product</strong> appears to be a single product with lists of options for each variation. However, each option represents a separate, simple product with a distinct SKU, which makes it possible to track inventory for each variation.

- <strong>Downloadable Product</strong>: Simple Products can be configured as Digital item which means customer will be able to download an product as digital copy like ebook, vouchers , …


### Variations:
Variations can be added for Variable products; in the product list table, click on the actions menu for the product and you will 3 options related to variations, list them, create one variation, or use a bulk variations generator, which is a nice tool where you have the ability to edit variations at one place and generate them based on available attributes, this can save you hours of configuration.

- choose the attributes that are different across each variation

  <p><img src="https://www.laraship.com/wp-content/uploads/2022/09/variaable-pruct-variations-setup.png" alt=""></p>


- choose whether prices, images, same or different

  <p><img src="https://www.laraship.com/wp-content/uploads/2022/09/variations-generator-bulk.png" alt="" width="650px" height="350px"></p>


- Click Generate
  
- Variations will be created based on selected criteria, and then you have the option to edit them in one place.

  <p><img src="https://www.laraship.com/wp-content/uploads/2022/09/generated-variations.png" alt="" width="650px" height="350px"></p>

  
## Transactions
Once an Order made for a vendor, the payment will go to the marketplace owner payment account, with a breakdown on commission deducted, and if the Marketplace owner is going to ship the package, then another transaction will be added to deduct the shipping fees from the order.

- The vendor can see his store transactions from the store transactions menu, he can see his available balance and request withdrawal.

- the Billing details will be prefilled automatically on the transactions withdrawn, and the maximum withdrawal amount is his balance.

- A Transactions with pending status will be created and the admin will be notified with the withdrawal request.

- once the admin completed the transfer, an email will be sent to the end user that his transaction has proceeded.


<p><img src="https://www.laraship.com/wp-content/uploads/2019/05/store_transactions.png" alt="" width="650px" height="350px"></p>

<p><img src="https://www.laraship.com/wp-content/uploads/2019/05/store_transactions-1.png" alt="" width="650px" height="350px"></p>


## Category Hierarchy
If your business requires multiple category levels, the Marketplace category designer gives you the ability to design the category structure in a drag-drop design

- to implement that you need to go to Marketplace => Categories => And Select The Hierarchy button from the top right

  <p><img src="https://www.laraship.com/wp-content/uploads/2020/06/category-heirarchy-marketplace-1024x479.jpg" alt="" width="650px" height="350px"></p>

  <p><img src="https://www.laraship.com/wp-content/uploads/2020/06/category-designer-marketplace-1024x398.jpg" alt="" width="650px" height="350px"></p>



## Abandoned Cart Notifications
Abandoned Cart is used for setting up email notification for users who started the checkout process then bounces during the process without completing their orders.

To Configure abandoned Cart email functionality:

- Under Settings -> Marketplace ->
```php
Marketplace abandoned cart email after (hours)
```
set the period to wait before sending the email in hours (set 0 to disable it)

- Under Settings -> Notification Templates: Modify the content of the Email template: <strong>Marketplace Abandoned Cart</strong>

- Add the following corn job to your server to check the abandoned cart emails to be sent

```php
*/5 * * * /path/to/your/php /path/to/your/laraship/artisan marketplace:send-abandoned-carts-notification
```

## Cross Device Carts

- You can configure cross-device carts for users, this will load cart current to users when they login to other browsers from different devices.

- To enable this feature to add the below variable to the environment file .env and then clear the config cache

```bash
MARKETPLACE_SHOPPING_CART_SAVE=true
```

- To Clear Config cache:

 ```php
php artisan config:clear
``` 


## Shipping Management
Shipping is a very tricky piece when dealing with Marketplace, users usually bounce on the shipping calculation step, due to high shipping costs caused of dealing with multiple vendors, Laraship worked hard to come up with the best and acceptable shipping costs by applying the following:

1.Advanced Flat Rate Setup: shipping flat rates prices are not just based on one vendor, but also based what other items added from other vendors, to get more details on how flat rate shipping works check the Flate Rate Shipping

2.Global and Vendor Shippo Accounts: You can configure your store to have one Shippo account across all vendors or allowing vendors to config their Shippo Accounts.

3.Shipping Rate Calculation Display: at the checkout shipping steps, shipping rates can be aggregated to show one rate for each vendor, or a drill-down for each product price under the same vendor.

4.Shipping Packages: if you have predefined shipping packages, you can re-use these packages on different products.

5.Shipping Rules on a Product level: shipping rates can be added under the product setup, you can have specific rates on the country level.


### Importing Shipping Rules
You can import shipping rules using a predefined excel template to the system. this will delete exiting rules and replace them with the rules in the file.

<p><img src="https://www.laraship.com/wp-content/uploads/2020/09/laravel_import_shipping_rules.jpg" alt="" width="650px" height="350px"></p>


## Shipping Packages
You can have a predefined shipping template, and they will be synchronized with Your shippo account, If you find you’re using the same package size(s) often, you may want to consider setting up a Package Template. This will save you the time of entering the specific dimensions and weight for every label each time you’re using the same size box or envelope.

 
<p><img src="https://www.laraship.com/wp-content/uploads/2020/09/laravel-shippo-package-predefined-packages.jpg" alt="" width="650px" height="350px"></p>


During label creation, the default package template will be the first choice in the drop-down list under Package Type. However, if you would like to use a different template or package type for that particular label, just click on that drop-down menu and choose the one you wish to use for that package.


<p><img src="https://www.laraship.com/wp-content/uploads/2020/09/laravel-shippo-package-definition.jpg" alt="" width="650px" height="350px"></p>


<strong>Note</strong>: If weights are imported with your orders from your e-commerce store, the imported weight will override the template package weight.

 

 

<p><img src="https://www.laraship.com/wp-content/uploads/2020/09/laravel-shippo-package-templates-scaled.jpg" alt="" width="650px" height="350px"></p>


 ## Flate Rate Shipping
Flat Rate shipping prices can be defined on Product level or global rule on vendor level or even on the entire Marketplace level.

of course, the Free Shipping option is available too

### Product Shipping Rules
Flat Shipping Rules can be configured on the country level and you can specify Flat / Free rates, in addition to which provider will be used and the cost of the additional item.

<p><img src="https://www.laraship.com/wp-content/uploads/2020/09/flat_rate_shipping_product_level.jpg" alt="" width="650px" height="350px"></p>

### Global Shipping Rules
Global shipping rules have more options, for example, you can define the priority of execution, set rules as exclusive, and apply conditions. like what is the maximum total weight for all items, or what is the minimum order total, these conditions apply here because they are applied on vendor cart level.

 <p><img src="https://www.laraship.com/wp-content/uploads/2020/09/global_shipping_rules.jpg" alt="" width="650px" height="350px"></p>


### Primary and secondary shipping
When listing an item in your shop, you must enter <strong>primary</strong> and <strong>secondary shipping</strong> costs.

<strong>Primary shipping cost</strong>: This is the cost of shipping the item alone.

<strong>Secondary shipping cost</strong>: This is the additional cost of shipping another purchased item.

The secondary cost <strong>applies when a buyer purchases multiple, different listings</strong> within your shop at the same time. This also applies when <strong>multiple quantities of the same item</strong> are purchased.

- When creating a listing, enter the secondary cost in the Each additional item field. If you want to offer shipping discounts for purchasing multiple items, this price should be lower than the One item cost. See examples below.

- If you don’t want to offer a discounted combined shipping rate, just enter the same amount for the primary and secondary shipping costs.

- If you want additional items to ship at no extra charge, enter $0.00 as the secondary shipping cost.


### Combined shipping examples
<strong>Item A</strong>:

- Primary shipping cost (One item) = $2.00

- Secondary shipping cost (Each additional item) = $0.50


<strong>Item B</strong>:

- Primary shipping cost = $1.00

- Secondary shipping cost = $0.75
  
If <strong>Item A</strong> and <strong>Item B</strong> are purchased together, the total combined shipping cost would equal the greater primary shipping cost of the two items (<strong>Item A</strong>: $2.00), plus the secondary shipping cost of the remaining item(s) (<strong>Item B</strong>: $0.75).

If three of Item A are purchased together, the total combined shipping cost to the buyer would equal the primary shipping cost for the first item ($2.00), plus $.50 each for the two additional items. The total combined shipping cost to the buyer in this situation would be $3.00. 


## Shippo Setup
Shippo: The Best Multi-carrier Shipping Software for E-commerce, Shippo is the best multi-carrier shipping software for e-commerce businesses. Find the best shipping rates, integrate with e-commerce platforms, print shipping labels, track package delivery, and verify addresses with either our shipping API or web app.

under the store Admin account, there is a tab for shipping settings where admin can set their shippo accounts, also default shipping units, and most importantly if you need to have one account per vendor or a global shippo account for all vendors.


<p><img src="https://www.laraship.com/wp-content/uploads/2020/09/laravel-shippo-shippo-account-per-store.jpg" alt="" width="650px" height="350px"></p>


### Shippo Rates at checkout:

<p><img src="https://www.laraship.com/wp-content/uploads/2020/09/shippo-rates-checkout-scaled.jpg" alt="" width="650px" height="350px"></p>


### Order Shipping Details

<p><img src="https://www.laraship.com/wp-content/uploads/2020/09/laravel-order-shipping-details.jpg" alt="" width="650px" height="450px"></p>

### Shipping Tracking History:

<p><img src="https://www.laraship.com/wp-content/uploads/2020/09/laravel-shipping-tracking-history.jpg" alt="" width="650px" height="350px"></p>


### Printing Shipping Label:

<p><img src="https://www.laraship.com/wp-content/uploads/2020/09/laravel-shipping-label-scaled.jpg" alt="" width="650px" height="350px"></p>



## Payout Configuration
Within Laraship Marketplace, payouts can be transferred from platform owners using 3 methods

<p><img src="https://www.laraship.com/wp-content/uploads/2021/04/laraship_marketplace_payout_transfer-1024x378.png" alt="" width="650px" height="350px"></p>


1.Manual Withdrawl Requests:

Vendors can see their Transactions and available balances under store transaction, they can request a withdrawal by filling the form with details and payment details, the admin will receive the request, do the transfer manually, and then mark the transactions as pending

<p><img src="https://www.laraship.com/wp-content/uploads/2021/04/marketplace_trenasctions-1024x540.png" alt="" width="650px" height="350px"></p>

<p><img src="https://www.laraship.com/wp-content/uploads/2021/04/marketplace_trenasctions-1024x540.png" alt="" width="650px" height="350px"></p>


2. Immediate Transfer on Order Payment: This will require Stripe connect account associated with vendors, once payment is made to the order, the order amount minus the commission of the store will be deducted and transferred to the vendor.

3. Periodic Transfer: in this case you attach a scheduled job to send the transfers, it will pick the last execution date and find all order that has been with transaction date old than the minimum age configured on the payout setting settings. also, you need to add the following cron job

0 0 * * * PHP path/to/your/installation/artisan marketplace:transfer-payout

 

This will check orders every day. you can configure it weekly, monthly, .. according to your preference

## Demo
You Can See Marketplace Demos by following these links 
- https://marketplace.laraship.com/ 
- https://marketplace3.laraship.com/
- https://marketplace2.laraship.com/
- https://marketplace4.laraship.com/


## Questions & Answers
If you faced any issue you can check our questions center, and you can post your question from the following link
[Questions & Answers](https://www.laraship.com/laraship-questions/)  


## Online Docs 
for more details follow this [online documentation](https://www.laraship.com/docs/laraship/marketplace-module/) to see more about this module 


## Hire Us
Looking for a professional team to build your success and start driving your business forward.
Laraship team ready to start with you [Hire Us](https://www.laraship.com/contact)
