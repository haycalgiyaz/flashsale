# Flash Sale

Flash Sale is a function to add special discount, by product and user tier level.

This library are compatible with Mineral Store CMS series,

## Installing Flash Sale CRUD to Mineral CMS

Add following code to your root composer.json 

```json
    "require": {
    	....
    	"haycalgiyaz/flashsale": "dev-master",
    },
    ...
	"repositories":[
	    {
	        "type": "vcs",
	        "url": "git@github.com:haycalgiyaz/flashsale.git"
	    }
	],
```

and then run:

```bash
composer update
```

publish the packages with:

```bash
php artisan vendor:publish
```

and then select the FlashSale service provider.
it will copying Config file and the views to your project laravel

## Configure
### Database Migration

Run migration by this command

```bash
php artisan migrate
```

### Relations to Product

Add FlashSale relations to Product Model

```php
    public function flashsale()
    {
        return $this->morphedByMany(Flashsale::class, 'flash_sale', 'flash_sale_products');
    }
```
