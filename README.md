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

### Product Tree

Make new Resources at App\Http\Resources and save as ProductCollection

``` php
<?php

namespace App\Http\Resources;


use Illuminate\Http\Resources\Json\JsonResource;

class ProductCollection extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'parent' => (!$this->parent_id ? '#' : $this->parent_id),
            'text' => '<span class="badge badge-'.($this->is_publish ? 'success' : 'secondary').' badge-pill" style="width:10px; height:10px; line-height:2px">'.($this->is_publish ? 'Published' : 'Unpublished').'</span>&nbsp;'.$this->name,
            'state' => ['opened' => true, 'selected' => (bool) $this->flashsale_count]

        ];
    }
}

```