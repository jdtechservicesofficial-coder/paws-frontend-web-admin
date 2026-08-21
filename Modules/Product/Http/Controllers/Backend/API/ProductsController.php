<?php

namespace Modules\Product\Http\Controllers\Backend\API;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Product\Models\Product;
use Modules\Product\Models\ProductCategory;
use Modules\Product\Models\ProductGallery;
use Modules\Product\Transformers\ProductResource;
use Modules\Product\Transformers\ProductDetailResource;
use App\Models\User;

class ProductsController extends Controller
{

     public function ProductList(Request $request){

        $perPage = $request->input('per_page', 10);
        $employee_id = $request->input('employee_id');        
        $productQuery = Product::query()->checkMultivendor();

        // $productQuery=Product::where('status',1)->with('media','categories','brand','unit','product_variations','product_review');

        $productQuery->whereHas('user', function ($query) {
            $query->whereHas('roles', function ($query) {
                $query->whereIn('name', ['pet_store', 'admin', 'demo_admin']);
            });
        });

        $user = User::find($employee_id);
        if($request->has('employee_id')) {
            $productQuery = $productQuery->where('created_by', $employee_id);
        }else{
            $productQuery->with('media','categories','brand','unit','product_variations','product_review','user');
        }

        if (!$request->has('is_admin') || $request->is_admin != 1) {
            $productQuery->where('status', 1);
        }

        if($request->has('category_id') && $request->category_id != '') {
            $category_id = $request->category_id;

            $productQuery->whereHas('categories', function ($query) use ($category_id) {
                $query->where('category_id', $category_id);
            });
         }


         if ($request->has('search') && $request->search != '') {

            $productQuery=$productQuery->where('name', 'like', "%{$request->search}%");
        }


        if($request->has('is_featured') && $request->is_featured != '') {
            $is_featured = $request->is_featured;
           
            // $productQuery=$productQuery->where('is_featured',1)->inRandomOrder(); 
            $productQuery=$productQuery->where('is_featured',1); 
         }

         if($request->has('best_seller') && $request->best_seller != '') {

            $productQuery=$productQuery->orderBy('total_sale_count', 'desc'); 
         }

         if($request->has('best_discount') && $request->best_discount != '') {

            $productQuery=$productQuery->where('discount_type','percent')->orderBy('discount_value', 'desc'); 
         }         

         $productQuery = $productQuery->paginate($perPage);

         $productCollection = ProductResource::collection($productQuery);

          return response()->json([
              'status' => true,
              'data' => $productCollection,
              'message' => __('product.product_list'),
          ], 200);

     }

     public function product_detail(Request $request){

        $id=$request->id;

        $productdetails=Product::where('id',$id)->with('media','categories','brand','unit','product_variations','gallery','product_review')->first();


        if ($productdetails == null) {
            $message = __('product.product_not_found');

            return response()->json([
                'status' => false,
                'message' => $message,
            ], 200);
        }

        $productDetailCollection= new ProductDetailResource($productdetails);

        $categoryIds = $productdetails->categories->pluck('id')->toArray();
        $relatedProducts = Product::whereHas('categories', function ($query) use ($categoryIds) {
            $query->whereIn('product_categories.id', $categoryIds);
        })
        ->where('id', '!=', $id)
        ->with('media','categories','brand','unit','product_variations')
        ->get();

        $relatedproductCollection = ProductResource::collection($relatedProducts);

        return response()->json([
            'status' => true,
            'data' => $productDetailCollection,
            'related-product'=> $relatedproductCollection,
            'message' => __('product.product_detail'),
        ], 200);

    }

    public function ProductGallery(Request $request)
    {
        $productId = $request->input('product_id');

        // Retrieve service-wise gallery
        if ($productId) {
            $product = Product::find($productId);

            if (!$product) {
                return response()->json([
                    'status' => false,
                    'message' => __('product.product_not_found'),
                ], 404);
            }

            $data = ProductGallery::where('product_id', $productId)->get();

            $gallery = ['gallery' => $data, 'product' => $product];

            return response()->json([
                'status' => true,
                'data' => $gallery,
                'message' => __('product.product_gal_retrived'),
            ], 200);
        }

        // Retrieve all gallery
        $allData = ProductGallery::all();

        return response()->json([
            'status' => true,
            'data' => $allData,
            'message' => __('product.product_gallery'),
        ], 200);
    }

    public function addProduct(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'min_price' => 'required|numeric',
            'stock_qty' => 'required|numeric',
            'status' => 'required|boolean',
        ]);

        $product = new Product();
        $product->name = $request->name;
        $product->slug = \Str::slug($request->name) . '-' . time();
        $product->min_price = $request->min_price;
        $product->max_price = $request->min_price;
        $product->stock_qty = $request->stock_qty;
        $product->status = $request->status ? 1 : 0;
        $product->description = $request->description;
        $product->short_description = $request->short_description;
        $product->created_by = auth()->id() ?? 1; // Fallback to 1 for now if no auth
        
        $product->save();

        // Category association
        $categoryIds = [];
        if ($request->has('category_id')) {
            $cat = $request->input('category_id');
            if (is_array($cat)) {
                $categoryIds = $cat;
            } elseif (is_string($cat)) {
                $categoryIds = explode(',', $cat);
            } else {
                $categoryIds = [$cat];
            }
        } elseif ($request->has('category_ids')) {
            $cat = $request->input('category_ids');
            if (is_array($cat)) {
                $categoryIds = $cat;
            } elseif (is_string($cat)) {
                $decoded = json_decode($cat, true);
                $categoryIds = is_array($decoded) ? $decoded : explode(',', $cat);
            } else {
                $categoryIds = [$cat];
            }
        }
        
        if (!empty($categoryIds)) {
            $categoryIds = array_filter(array_map('intval', $categoryIds));
            $product->categories()->sync($categoryIds);
        }

        if ($request->hasFile('image')) {
            $product->addMediaFromRequest('image')->toMediaCollection('feature_image');
        } elseif ($request->hasFile('feature_image')) {
            $product->addMediaFromRequest('feature_image')->toMediaCollection('feature_image');
        }

        $product->load('categories', 'media');

        return response()->json([
            'status' => true,
            'data' => new ProductDetailResource($product),
            'message' => 'Product added successfully',
        ], 200);
    }

    public function updateProduct(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string',
            'min_price' => 'required|numeric',
            'stock_qty' => 'required|numeric',
            'status' => 'required|boolean',
        ]);

        $product = Product::find($id);
        if (!$product) {
            return response()->json([
                'status' => false,
                'message' => 'Product not found',
            ], 404);
        }

        $product->name = $request->name;
        // Optional: update slug only if name changes, but doing this is fine
        // $product->slug = \Str::slug($request->name) . '-' . time();
        $product->min_price = $request->min_price;
        $product->max_price = $request->min_price;
        $product->stock_qty = $request->stock_qty;
        $product->status = $request->status ? 1 : 0;
        $product->description = $request->description;
        $product->short_description = $request->short_description;
        
        $product->save();

        // Category association
        $categoryIds = [];
        if ($request->has('category_id')) {
            $cat = $request->input('category_id');
            if (is_array($cat)) {
                $categoryIds = $cat;
            } elseif (is_string($cat)) {
                $categoryIds = explode(',', $cat);
            } else {
                $categoryIds = [$cat];
            }
        } elseif ($request->has('category_ids')) {
            $cat = $request->input('category_ids');
            if (is_array($cat)) {
                $categoryIds = $cat;
            } elseif (is_string($cat)) {
                $decoded = json_decode($cat, true);
                $categoryIds = is_array($decoded) ? $decoded : explode(',', $cat);
            } else {
                $categoryIds = [$cat];
            }
        }
        
        if (!empty($categoryIds)) {
            $categoryIds = array_filter(array_map('intval', $categoryIds));
            $product->categories()->sync($categoryIds);
        }

        if ($request->hasFile('image')) {
            $product->clearMediaCollection('feature_image');
            $product->addMediaFromRequest('image')->toMediaCollection('feature_image');
        } elseif ($request->hasFile('feature_image')) {
            $product->clearMediaCollection('feature_image');
            $product->addMediaFromRequest('feature_image')->toMediaCollection('feature_image');
        }

        $product->load('categories', 'media');

        return response()->json([
            'status' => true,
            'data' => new ProductDetailResource($product),
            'message' => 'Product updated successfully',
        ], 200);
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|boolean',
        ]);

        $product = Product::find($id);
        if (!$product) {
            return response()->json([
                'status' => false,
                'message' => 'Product not found',
            ], 404);
        }

        $product->status = $request->status ? 1 : 0;
        $product->save();

        return response()->json([
            'status' => true,
            'data' => new ProductDetailResource($product),
            'message' => 'Product status updated successfully',
        ], 200);
    }
}
