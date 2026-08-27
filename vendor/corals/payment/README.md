# Corals Payment

- [Currency Configuration](#currency-configuration)

## Installation

You can install the package via composer:

```bash
composer require corals/payment
```

## Testing

```bash
vendor/bin/phpunit vendor/corals/payment/tests 
```

## Currency Configuration

Please make sure to clear cache on currency configuration changes to take effect, this can be done from <a href="https://www.laraship.com/docs/laraship/laraship-configuration/cache-clear/">settings=&gt; Cache management</a>

### System Currency (Admin) :
Prices within products and plans setup will be using the system (admin) currency configuration, this can be configured under Settings

<p><img src="https://www.laraship.com/wp-content/uploads/2017/12/laraship_payments_settings.png"></p>
<p>&nbsp;</p>

### Website( Frontend Currency)
Laraship does support multiple currencies in your store, you can configure active currencies under Payments => Currencies

<p><img src="https://www.laraship.com/wp-content/uploads/2017/12/laraship_payments_currency_edit.png" alt="" width="470" height="380" ></p>
<p>&nbsp;</p>

<p><img src="https://www.laraship.com/wp-content/uploads/2017/12/laraship_payments_currencies.png"></p>
<p>&nbsp;</p>

### Default Currency
The default currency is the one that will be auto-selected when user access the site first time, it can be adjusted inside .env file

```php
DEFAULT_CURRENCY=USD
```
<p>&nbsp;</p>

### Updating Exchange
Update exchange rates from OpenExchangeRates.org. An API key is needed to use OpenExchangeRates.org. Add yours to the config file.

```php
php artisan currency:update
```

### Cleanup
Used to clean the Laravel cached exchanged rates and refresh it from the database. Note that cached exchanged rates are cleared after they are updated using one of the commands above.

```php
php artisan currency:cleanup
```

## Questions & Answers
If you faced any issue you can check our questions center, and you can post your question from the following link
[Questions & Answers](https://www.laraship.com/laraship-questions/)  


## Online Documentation 
follow the [Online Docs](https://www.laraship.com/docs/laraship/payment-modules/) to see more about this module


## Hire Us
Looking for a professional team to build your success and start driving your business forward.
Laraship team ready to start with you [Hire Us](https://www.laraship.com/contact)
