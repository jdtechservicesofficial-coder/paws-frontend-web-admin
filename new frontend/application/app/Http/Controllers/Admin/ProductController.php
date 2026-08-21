<?php

namespace App\Http\Controllers\Admin;

use App\Models\Brand;
use App\Models\Product;
use App\Models\Category;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use App\Rules\FileTypeValidate;
use App\Http\Controllers\Controller;

class ProductController extends Controller
{
    public function index(){

        $pageTitle = 'All Products';
        $products = Product::with(['categories'])->orderBy('id','desc')->paginate(getPaginate(20));
        return view('admin.products.index',compact('products','pageTitle'));
     }

     public function create (){
        $pageTitle ='Add Product';
        $categories = Category::where('status',1)->get();

        return view('admin.products.create',compact('pageTitle','categories'));
     }

     public function store(Request $request){
        $request->validate([
            'name' => 'required|max:255',
            'price' => 'required',
            'category_id' => 'required',
            'quantity' => 'required',
            'images.*' => ['required', 'image', new FileTypeValidate(['jpg', 'jpeg', 'png'])],
        ]);
      

        $product = new Product();
        // $product->category_id = $request->category_id; // Handled below via relationships
        $product->name = $request->name;
        $product->slug = \Illuminate\Support\Str::slug($request->name);
        $product->product_type = 'single';
        $product->has_variation = 0;
        
        $product->price = $request->price;
        $product->discount = $request->discount;
        $product->quantity = $request->quantity;

        $product->short_desc = $request->short_desc;
        $product->status = 1;

        if( $request->is_featured){
            Product::where('is_featured',1)->update(['is_featured'=> 0]);
            $product->is_featured = $request->is_featured;
        }

        $product->save();

        // Sync category mapping
        \Illuminate\Support\Facades\DB::table('product_category_mappings')->insert([
            'product_id' => $product->id,
            'category_id' => $request->category_id
        ]);

        foreach ($request->images as $image) {
            if ($image->isValid()) {

                try {
                    $mediaId = \Illuminate\Support\Facades\DB::table('media')->insertGetId([
                        'model_type' => 'Modules\Product\Models\Product',
                        'model_id' => $product->id,
                        'uuid' => (string) \Illuminate\Support\Str::uuid(),
                        'collection_name' => 'feature_image',
                        'name' => pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME),
                        'file_name' => $image->getClientOriginalName(),
                        'mime_type' => $image->getMimeType(),
                        'disk' => 'public',
                        'conversions_disk' => 'public',
                        'size' => $image->getSize(),
                        'manipulations' => '[]',
                        'custom_properties' => '[]',
                        'generated_conversions' => '[]',
                        'responsive_images' => '[]',
                        'order_column' => 1,
                        'created_at' => now(),
                        'updated_at' => now()
                    ]);
                    
                    $path = public_path('pawlly_storage/' . $mediaId);
                    if (!file_exists($path)) {
                        mkdir($path, 0777, true);
                    }
                    $image->move($path, $image->getClientOriginalName());
                } catch (\Exception $exp) {
                    $notify[] = ['error', 'Couldn\'t upload your image'];
                    return back()->withNotify($notify);
                }
            }
        }

           $notify[] = ['success', 'Product has been  created successfully'];
           return back()->withNotify($notify);

     }

     public function edit($id){
        $pageTitle = 'Update';
        $product = Product::find($id);
        $productImage = ProductImage::where('product_id', $id)->get();
        $categories = Category::where('status',1)->get();
        return view('admin.products.edit',compact('pageTitle','productImage','categories','product'));
     }

     public function update(Request $request, $id){

        $request->validate([
            'name' => 'required|max:255',
            'price' => 'required',
            'category_id' => 'required',
            'quantity' => 'required',
            'images.*' => ['required', 'image', new FileTypeValidate(['jpg', 'jpeg', 'png'])],
        ]);

        $product = Product::findOrFail($id);
        // $product->category_id = $request->category_id; // Handled below via relationships
        $product->name = $request->name;
        $product->slug = \Illuminate\Support\Str::slug($request->name);
        
        $product->price = $request->price;
        $product->discount = $request->discount;
        $product->quantity = $request->quantity;

        $product->short_desc = $request->short_desc;
        $product->status = $request->status ? 1: 0;
        if( $request->is_featured){
            Product::where('is_featured',1)->update(['is_featured'=> 0]);
            $product->is_featured = $request->is_featured;
        }
        $product->save();

        // Sync category mapping
        \Illuminate\Support\Facades\DB::table('product_category_mappings')->updateOrInsert(
            ['product_id' => $product->id],
            ['category_id' => $request->category_id]
        );

        if ($request->hasFile('images')) {

            foreach ($request->images as $image) {
                if ($image->isValid()) {

                    try {
                        $mediaId = \Illuminate\Support\Facades\DB::table('media')->insertGetId([
                            'model_type' => 'Modules\Product\Models\Product',
                            'model_id' => $product->id,
                            'uuid' => (string) \Illuminate\Support\Str::uuid(),
                            'collection_name' => 'feature_image',
                            'name' => pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME),
                            'file_name' => $image->getClientOriginalName(),
                            'mime_type' => $image->getMimeType(),
                            'disk' => 'public',
                            'conversions_disk' => 'public',
                            'size' => $image->getSize(),
                            'manipulations' => '[]',
                            'custom_properties' => '[]',
                            'generated_conversions' => '[]',
                            'responsive_images' => '[]',
                            'order_column' => 1,
                            'created_at' => now(),
                            'updated_at' => now()
                        ]);
                        
                        $path = public_path('pawlly_storage/' . $mediaId);
                        if (!file_exists($path)) {
                            mkdir($path, 0777, true);
                        }
                        $image->move($path, $image->getClientOriginalName());
                    } catch (\Exception $exp) {
                        $notify[] = ['error', 'Couldn\'t upload your image'];
                        return back()->withNotify($notify);
                    }
                }
            }
        }
        $notify[] = ['success', 'Product has been  updated successfully'];
        return back()->withNotify($notify);

     }


     public function imageRemove(Request $request){
        $request->validate([
          'id' => 'required'
      ]);

      $image =  ProductImage::findOrFail($request->id);

      $path  = getFilePath('product').'/'.$image->image;
      fileManager()->removeFile($path);
      $image->delete();

      $notify[] = ['success','Product Image has been deleted'];
      return back()->withNotify($notify);

    }



}
