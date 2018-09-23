<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Transformers\TransactionTransformer;

class Transaction extends Model
{
    use SoftDeletes;
    public $transformer = TransactionTransformer::class;
    protected $dates = ['deleted_at'];
    protected $fillable = [
        'quantaty',
        'product_id',
        'buyer_id',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function buyer()
    {
        return $this->belongsTo(Buyer::class);
    }
}
