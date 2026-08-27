# Corals Subscriptions

### Articles
- [Recurring Product Management](#recurring-product-management)
- [Feature Management](#feature-management)
- [Plans Management](#plans-management)
- [Membership Content](#membership-content)
- [Usage](#usage)

## Installation

You can install the package via composer:

```bash
composer require corals/subscriptions
```

## Recurring Product Management
With Laraship you can have multiple recurring products, each product has its own features and plans, you can embed product pricing table which will be generated automatically using the associated plans and features  easily inside your theme or CMS content using the shortcode :

<pre class="lang:default decode:true">@pricing(<div class="woocommerce ">
<div class="products elements-grid wd-products-holder  wd-spacing-20 grid-columns-3 pagination-pagination align-items-start row" data-source="main_loop" data-min_price="" data-max_price="" data-columns="3">
<div class="product-grid-item wd-with-labels product wd-hover-tiled  col-lg-4 col-md-4 col-6 first  type-product post-9220 status-publish instock product_cat-platforms has-post-thumbnail sale sold-individually shipping-taxable purchasable product-type-variable" data-loop="1" data-id="9220">
	
	
<div class="product-wrapper">
	<div class="product-element-top wd-quick-shop">
		<a href="https://www.laraship.com/product/laraship-laravel-marketplace/" class="product-image-link">
			<div class="product-labels labels-rectangular"><span class="onsale product-label">-40%</span></div><img src="https://www.laraship.com/wp-content/uploads/2018/11/marketplace-430x248.png" alt=""></a>

					<div class="hover-img">
				<a href="https://www.laraship.com/product/laraship-laravel-marketplace/">
					<img src="https://www.laraship.com/wp-content/uploads/2018/11/marketplace-pro-theme-430x1519.png" alt="" ></a>
			</div>	
	</div>
</div>
</div>
</div></div>)</pre>


, the shortcode will be available on the product page too.

<p><img src="https://www.laraship.com/wp-content/uploads/2018/01/products.png" alt=""></p>


## Feature Management
Once you define the recurring product, you need to setup features for the product, this feature basically what benefits user will get when he subscribed to that product, also it can be used to track usage and define quantities the user will get for each plan.

 

Features & plans will be rendered to build the pricing plan as shown in the picture below:

<p><img src="https://www.laraship.com/wp-content/uploads/2018/10/recurring-product-pricing.png" alt=""></p>

- Once you click on the feature’s icon you will see the features table where you can drag and drop to specify the order of the display in the pricing table.
  
- there are 3 types of features you can define

  1.Quantity feature: for example max number of the ads you can display

  
  2.Boolean: a feature that can be either yes or no, like can post ads or not.

  
  3.Text Feature: Just informative text.  



- Also, You can connect a feature with a specific model (Object) into your system to measure usage, for example, specify how many products this plan can create, this is a very nice feature to convert your objects to usage-based with limits

<p><img src="https://www.laraship.com/wp-content/uploads/2018/10/subscription-feature-usage-1024x666.png" alt=""></p>

- As you can see from the screenshot above you select The model ( for example “Product”), and then define the message to the subscriber when he reaches the limit: for example: “You have reached your limit of products please upgrade your plan!”

- Quotas can be calculated on usage-based per cycle (day., week, month) or a lifetime.

- Also, You can protect specific URLs with the feature, which means, this page can be accessed if the user has this feature in his plan and so on.
 

- We have introduced new options for Feature Management as well:

  1.Ability to customize Plan Feature Caption
  
  2.Ability to use hidden features and not showing in the pricing table

  3.Add a new feature type called config: it may be from different sources (settings, config, list of values) for example check intervals and notification 
 supported channels the config options will be visible at feature plan assignment so users can select different options for different plans.


- To add a Model to the usage of a subscription feature You need to add the below code to the boot function of the Module Service Provider

    ```php
    SubscriptionProducts::addToFeatureModels([You Model Class], [Model Description]);
    ```

    for example
    
    ```php
    public function boot()
    {
    .
    .
    SubscriptionProducts::addToFeatureModels(Contact::class, 'Monitor Contact');
    ```



## Plans Management
After defining Features, plan definition is next, which basically the time to define what packages you have, and what is the difference between each package, whether the quantity or extra features that don’t exist on another package.

<p><img src="https://www.laraship.com/wp-content/uploads/2018/10/recurring-product-plans-listing.png" alt=""></p>

<p><img src="https://www.laraship.com/wp-content/uploads/2018/10/plans_sync_laravel-scaled.jpg" alt="" ></p>


in addition to that, Plans need to be synced with online payments as the data will be used by payment providers like Stripe, so once you define your plan you will have an option to sync with your payment gateway to be defined here.

Below is the Plan creation Form which Basically defines the following attributes:

- Plan Name.
- Plan Code: it’s a unique Key for Plan Identifciation
- Plan a Recurring Amount.
- Plan Charge Frequency: Every week, month, or year.
- Plan frequency amount: for example every 2 weeks, 3 months. 4 years.
- Does that plan has a trial and Trial period.
- is this Plan features or recommended plan, this will make the plan to show as dominant in the pricing table.
- Visible: you can define plans used for internal use without showing it in the pricing table.
- Free Plan: this plan does not require Payment synchronization and it will be entirely managed at Laraship and payment won’t be requested.

<p><img src="https://www.laraship.com/wp-content/uploads/2018/10/plan-creation-screen.png" alt=""></p>


## Membership Content
One of the very powerful features Laraship subscriptions provides is the ability to assign specific content to be accessible by members with specific plans, this can be done easily by assigning categories to subscription plans.

<p><img decoding="async" class="alignnone size-full wp-image-7606 lazyloaded" src="https://www.laraship.com/wp-content/uploads/2018/06/laraship-subscriptions-prmuim-contentpng.png" alt="" width="1338" height="469" sizes="(max-width: 1338px) 100vw, 1338px" srcset="https://www.laraship.com/wp-content/uploads/2018/06/laraship-subscriptions-prmuim-contentpng.png 1338w, https://www.laraship.com/wp-content/uploads/2018/06/laraship-subscriptions-prmuim-contentpng-430x151.png 430w, https://www.laraship.com/wp-content/uploads/2018/06/laraship-subscriptions-prmuim-contentpng-150x53.png 150w, https://www.laraship.com/wp-content/uploads/2018/06/laraship-subscriptions-prmuim-contentpng-700x245.png 700w, https://www.laraship.com/wp-content/uploads/2018/06/laraship-subscriptions-prmuim-contentpng-300x105.png 300w, https://www.laraship.com/wp-content/uploads/2018/06/laraship-subscriptions-prmuim-contentpng-768x269.png 768w, https://www.laraship.com/wp-content/uploads/2018/06/laraship-subscriptions-prmuim-contentpng-1024x359.png 1024w, https://www.laraship.com/wp-content/uploads/2018/06/laraship-subscriptions-prmuim-contentpng-600x210.png 600w" data-ll-status="loaded"></p>


this will make all posts attached to that category to be accessible for members who have Silver or Bronze Plans.

- You can assign some content to logged in users only by using the private flag in post management.
  
- Laraship has both internal and external blog sections.


## Usage
Subscription Cycles and Plan Usage are Reports to display how much the user has consumed from his features, for example: how many SMS were sent, how many products were created, and so on.

and you can use the Plan usage for other actions that are not related to a specific model. for example how many SMS messages are sent.

<p><img src="https://www.laraship.com/wp-content/uploads/2020/06/picturemessage_bpscglej.vkh_.png" alt=""></p>


- To record a new usage:
```php
UsageManager::recordAUsage($model, $usageDetails, $product = null, $plan = null, $user = null)
```

- To check if a limit reached or not:
```php
UsageManager::isModelUsageReachedLimit(Service::class)
```

## Testing

```bash
vendor/bin/phpunit vendor/corals/subscriptions/tests 
```
## Demo
You can see Subscription Demo by following this link https://demo.laraship.com/

## Questions & Answers
If you faced any issue you can check our questions center, and you can post your question from the following link
[Questions & Answers](https://www.laraship.com/laraship-questions/)  


## Online Docs 
follow this [Docs](https://www.laraship.com/docs/laraship/subscriptions-module/) to see more about this module 

## Hire Us
Looking for a professional team to build your success and start driving your business forward.
Laraship team ready to start with you [Hire Us](https://www.laraship.com/contact)


