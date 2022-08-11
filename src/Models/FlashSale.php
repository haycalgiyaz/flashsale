<?php

namespace Haycalgiyaz\Flashsale\Models;

use App\Models\MineralModel;
use App\Models\Product;
use App\Models\Interfaces\IImageUpload;
use App\Models\Traits\ImageUpload;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class FlashSale extends MineralModel implements Auditable
{
    use HasSlug, SoftDeletes;
    use \OwenIt\Auditing\Auditable;

    protected $table = 'flash_sales';

    protected $auditExclude = [
        'uuid',
    ];
    
    protected $dates = [
        'created_at',
        'updated_at',
        'published_at',
        'ended_at'
    ];

    public function getSlugOptions() : SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug');
    }

    public function products()
    {
        return $this->morphToMany( Product::class, 'flash_sale', 'flash_sale_products');
    }
}