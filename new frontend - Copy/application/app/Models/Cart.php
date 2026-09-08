<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $table = 'carts';

    protected $fillable = [
        'user_id',
        'guest_user_id',
        'location_id',
        'product_id',
        'product_variation_id',
        'qty'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
