<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Transformers\ProductTransformer;

class Product extends Model
{
    use SoftDeletes;
    const UNAVAILABLE_PRODUCT = 'unavaliable';
    const AVAILABLE_PRODUCT = 'available';
    public $transformer = ProductTransformer::class;
    protected $dates = ['deleted_at'];
    protected $hidden = ['pivot'];
    protected $fillable = [
        'name',
        'description',
        'quantaty',
        'status',
        'image',
        'seller_id', ];

    public function isAvailable()
    {
        return $this->status == Product::AVAILABLE_PRODUCT;
    }

    public function seller()
    {
        return $this->belongsTo(Seller::class);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
}
