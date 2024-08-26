<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $table = 'cart';

    protected $fillable = [
        'user_id',
        'user_email',
        'product_id',
        'product_name',
        'product_quantity',
        'price_per_product',
    ];
}
