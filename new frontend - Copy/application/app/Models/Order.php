<?php

namespace App\Models;

use App\Models\Product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory;
    protected $table = 'orders';

    public function products(){
        return $this->belongsToMany(Product::class, 'order_product')
                    ->withPivot('product_quantity');
    }

    public function user() {
        return $this->belongsTo(\App\Models\User::class, 'user_id');
    }

    public function orderGroup() {
        return $this->belongsTo(\App\Models\OrderGroup::class, 'order_group_id');
    }

    public function getFirstnameAttribute() {
        return $this->user ? $this->user->firstname : 'Guest ';
    }

    public function getLastnameAttribute() {
        return $this->user ? $this->user->lastname : 'User';
    }

    public function getOrderNumberAttribute() {
        return $this->orderGroup ? $this->orderGroup->order_code : $this->id;
    }

    public function getProductPriceAttribute() {
        return $this->orderGroup ? $this->orderGroup->grand_total_amount : 0;
    }

    public function getStatusAttribute() {
        // Map Pawlly delivery_status back to ViserLab status index
        if ($this->delivery_status == 'pending' || $this->delivery_status == 'order_placed') return 0;
        if ($this->delivery_status == 'processing') return 1;
        if ($this->delivery_status == 'shipped') return 2;
        if ($this->delivery_status == 'delivered') return 3;
        return 4; // Cancelled
    }

    public function getAddressAttribute() {
        return $this->orderGroup ? $this->orderGroup->pos_order_address : 'Address N/A';
    }

    public function getEmailAttribute() {
        return $this->user ? $this->user->email : 'N/A';
    }

    public function getPhoneAttribute() {
        return $this->orderGroup ? $this->orderGroup->phone_no : 'N/A';
    }

    public function setStatusAttribute($value) {
        if ($value == 0) $this->attributes['delivery_status'] = 'pending';
        elseif ($value == 1) $this->attributes['delivery_status'] = 'processing';
        elseif ($value == 2) $this->attributes['delivery_status'] = 'shipped';
        elseif ($value == 3) $this->attributes['delivery_status'] = 'delivered';
        else $this->attributes['delivery_status'] = 'cancelled';
    }

    public function statusBadge($status){
        $html = '';
        if($this->status == 0){
            $html = '<span class="badge badge--warning">'.trans('Pending').'</span>';
        }
        elseif($this->status == 1){
            $html = '<span class="badge badge--success">'.trans('Processing').'</span>';
        }
        elseif($this->status == 2){
            $html = '<span class="badge badge--danger">'.trans('Shipped').'</span>';
        }
        elseif($this->status == 3){
            $html = '<span class="badge badge--dark">'.trans('Delivered').'</span>';
        }
       else{
            $html = '<span><span class="badge badge--danger">'.trans('Cancel').'</span></span>';
        }
        return $html;
    }
}
