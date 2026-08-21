<?php

namespace App\Models;

use App\Models\Review;
use App\Models\Category;
use App\Models\ProductImage;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;

    protected $table = 'products';

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'product_category_mappings', 'product_id', 'category_id');
    }

    public function getCategoryAttribute()
    {
        return $this->categories->first();
    }

    public function getPriceAttribute() {
        return $this->min_price;
    }

    public function setPriceAttribute($value) {
        $this->attributes['min_price'] = $value;
        $this->attributes['max_price'] = $value;
    }

    public function getDiscountAttribute() {
        return $this->discount_value;
    }

    public function setDiscountAttribute($value) {
        $this->attributes['discount_value'] = $value;
        $this->attributes['discount_type'] = 'percent'; 
    }

    public function getQuantityAttribute() {
        return $this->stock_qty;
    }

    public function setQuantityAttribute($value) {
        $this->attributes['stock_qty'] = $value;
    }

    public function getShortDescAttribute() {
        return $this->short_description;
    }

    public function setShortDescAttribute($value) {
        $this->attributes['short_description'] = $value;
    }

    public function getReviewCountAttribute() {
        return 0; 
    }

    public function getAverageRatingAttribute() {
        return 0; 
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function productImages()
    {
        return $this->hasMany(ProductImage::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function statusBadge($status){
        $html = '';
        if($this->status == 1){
            $html = '<span class="badge badge--success">'.trans('Active').'</span>';
        }else{
            $html = '<span class="badge badge--warning">'.trans('Inactive').'</span>';
        }

        return $html;
    }
}
