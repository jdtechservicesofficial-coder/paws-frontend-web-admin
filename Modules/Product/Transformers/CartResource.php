<?php

namespace Modules\Product\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\User;
use Carbon\Carbon;

class CartResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {

        $user = User::find($this->product->created_by);

        $today = Carbon::today();
        $discount_value = 0;
        if (optional($this->product)->discount_start_date && optional($this->product)->discount_end_date && $today->gte(Carbon::createFromTimestamp(optional($this->product)->discount_start_date)) &&
                    $today->lte(Carbon::createFromTimestamp(optional($this->product)->discount_end_date))) {
            $discount_value = optional($this->product)->discount_value;
        }
        else{
            $discount_value = 0;
        }

        if ($this->product_variation) {
            $productVariationData = new ProductVariationResource($this->product_variation);
        } else {
            $unitPrice = optional($this->product)->min_price ?? 0;
            $stockQty = optional($this->product)->stock_qty ?? 0;
            $productVariationData = [
                'id' => 0,
                'variation_key' => 0,
                'sku' => null,
                'code' => null,
                'location_id' => 1,
                'product_stock_qty' => $stockQty,
                'is_stock_avaible' => $stockQty > 0 ? 1 : 0,
                'combination' => [],
                'product_amount' => $unitPrice,
                'in_cart' => 1,
                'tax_include_product_price' => $unitPrice,
                'discounted_product_price' => getDiscountedProductPrice($unitPrice, $this->product_id),
            ];
        }

        return [
            'id' => $this->id,
            'user_id' => $this->user_id,   
            'product_id' => $this->product_id,
            'product_variation_id' => $this->product_variation_id,
            'qty' => $this->qty,
            'unit_name'=>optional(optional($this->product)->unit)->name,
            'product_name'=>optional($this->product)->name,
            'product_image' => optional(optional($this->product)->media)->pluck('original_url')->first() ?: optional($this->product)->feature_image,
            'product_description'=>optional($this->product)->short_description,
            'discount_value'=>$discount_value,
            'discount_type'=>optional($this->product)->discount_type,
            'product_variation'=>$productVariationData,
            'product_variation_type' =>optional(optional(optional($this->product_variation)->combination)->variation_combination_data)->name ?? null,
            'product_variation_name' => optional(optional(optional($this->product_variation)->combination)->variation_combination_value)->name ?? null,
            'product_variation_value' => optional(optional(optional($this->product_variation)->combination)->variation_combination_value)->value ?? null,
            'sold_by'=>$user ? $user->first_name . ' ' . $user->last_name : 'Unknown',
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'deleted_at' => $this->deleted_at,
        ];
    }
}
