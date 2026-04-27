<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
// use Intervention\Image\ImageManager;
// use Intervention\Image\Drivers\Gd\Driver;
use App\Models\Product;
use App\Models\Prodimg;
use App\Models\FabricType;
use App\Models\Category;
use Intervention\Image\ImageManagerStatic ;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;




class ProductController extends Controller
{
    public function index(Request $request)
    {

        $Productlist = Product::with(['sizes', 'colors'])->get();
        $fabrics = FabricType::get();
        $categories =  Category::get();

        return view('admin.product.productlist',[
            'Productlist' => $Productlist,
            'fabrics' => $fabrics,
            'categories' => $categories
        ]);

    }


    public function create(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'name'=>'required|string',
            'cat' => 'required|numeric|exists:App\Models\Category,id',
            'fabric_type'=>'required|string',
            'price'=>'required|numeric',
            'stock'=>'required|numeric',
            'desc'=>'required|string',
            'mainImage'=>'required|mimes:jpeg,png,jpg,gif,webp|max:51200',
        ],[
            'mainImage.required'=>'يرجي اضافه صور',
            'mainImage.mimes'=>'الامتدادات المسموح بها فقط (jpeg,png,jpg,gif,webp)',
            'mainImage.max'=>'يجب الا يكون حجم الصوره اكبر من 50 MB',
            'name.required'=>'الاسم مطلوب',
            'price.required'=>'السعر مطلوب',
            'stock.numeric'=>'يجب ان يكون الكميه رقم',
        ]);

        DB::transaction(function () use ($request) {
            
            // Helper function to process images efficiently
            $main_image = $this->processImage($request->file('mainImage'));
            $img2 = $request->hasFile('img2') ? $this->processImage($request->file('img2')) : null;
            $img3 = $request->hasFile('img3') ? $this->processImage($request->file('img3')) : null;
            $img4 = $request->hasFile('img4') ? $this->processImage($request->file('img4')) : null;
            $img5 = $request->hasFile('img5') ? $this->processImage($request->file('img5')) : null;
            $img6 = $request->hasFile('img6') ? $this->processImage($request->file('img6')) : null;

            $product = Product::create([
                "name" => $request->name,
                "cat_id" => $request->cat,
                'width' => '75',
                'height' => '180',
                "productDetalis" => $request->desc,
                "price" => $request->price,
                "stock" => $request->stock,
                "fabric_id" => $request->fabric_type,
            ]);

            $product->product_img_p()->create([
                "mainImage" => $main_image,
                "img2" => $img2,
                "img3" => $img3,
                "img4" => $img4,
                "img5" => $img5,
                "img6" => $img6,
                'alt3' => $request->alt3,
                'alt4' => $request->alt4,
                'alt5' => $request->alt5,
                'alt6' => $request->alt6,
            ]);

            // Save Sizes
            if ($request->has('sizes') && is_array($request->sizes)) {
                foreach ($request->sizes as $index => $size) {
                    if (!empty($size)) {
                        $product->sizes()->create([
                            'size' => $size,
                            'stock' => $request->sizes_stock[$index] ?? 0,
                        ]);
                    }
                }
            }

            // Save Colors
            if ($request->has('colors') && is_array($request->colors)) {
                foreach ($request->colors as $index => $color) {
                    if (!empty($color)) {
                        $product->colors()->create([
                            'color' => $color,
                            'color_code' => $request->colors_code[$index] ?? '#000000',
                            'stock' => $request->colors_stock[$index] ?? 0,
                        ]);
                    }
                }
            }

            // Save Meta Data
            $product->meta_title = $request->meta_title;
            $product->meta_description = $request->meta_description;
            $product->meta_keywords = $request->meta_keywords;
            $product->save();
        });

        return redirect()->back()->with(['success'=>'اضافه منتج']);
    }

    // Optimized image processing method
    private function processImage($file)
    {
        $sizes = [
            1200, // Process largest first to potentially use downscaling if needed (though Image::make uses original resource)
            800,
            480,
            320,
        ];

        $imageName = Str::random(20);
        $paths = [];

        // Create image instance ONCE from source
        $image = ImageManagerStatic::make($file);

        foreach ($sizes as $width) {
            // BACKUP the current state (clone) so resizing doesn't affect next iterations
            // (If we resize 1200 -> 800 -> 480 -> 320 sequentially on the SAME instance it's faster, 
            // but we need to be careful about aspect ratio accumulation errors. Since we're just resizing down, sequential is fine and fastest!)
            // However, to be safe and simple: clone.
            $img = clone $image;
            
            $img->resize($width, null, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            })
            ->encode('webp', 70);

            $fileName = "{$imageName}-{$width}.webp";
            $path = "storage/images/{$fileName}";

            $img->save(public_path($path));

            $paths[$width] = $path;
        }

        // Return path for main usage (800px)
        return $paths[800];
    }


    public function edit_product(Request $request)
    {


        $request->validate([
            'name'=>'required|string',
            'cat' => 'required|numeric|exists:App\Models\Category,id',
            'fabric_type'=>'required|string',
            'price'=>'required|numeric',
            'stock'=>'required|numeric',
            'desc'=>'required|string',
            'mainImage'=>'mimes:jpeg,png,jpg,gif,webp|max:51200',
        ],[
            'mainImage.mimes'=>'الامتدادات المسموح بها فقط (jpeg,png,jpg,gif,webp)',
            'mainImage.max'=>'يجب الا يكون حجم الصوره اكبر من 50 MB',
            'name.required'=>'الاسم مطلوب',
            'price.required'=>'السعر مطلوب',
            'stock.numeric'=>'يجب ان يكون الكميه رقم',
        ]);


        DB::transaction(function () use ($request) {

            $oldimgname = prodimg::where('product_id',$request->product_id)->first();

            // Use the processImage helper for consistent responsive image generation
            $main_image = $request->hasFile('mainImage') ? $this->processImage($request->file('mainImage')) : $oldimgname->mainImage;
            $img2 = $request->hasFile('img2') ? $this->processImage($request->file('img2')) : $oldimgname->img2;
            $img3 = $request->hasFile('img3') ? $this->processImage($request->file('img3')) : $oldimgname->img3;
            $img4 = $request->hasFile('img4') ? $this->processImage($request->file('img4')) : $oldimgname->img4;
            $img5 = $request->hasFile('img5') ? $this->processImage($request->file('img5')) : $oldimgname->img5;
            $img6 = $request->hasFile('img6') ? $this->processImage($request->file('img6')) : $oldimgname->img6;

            $product = Product::find($request->product_id);

            $product->update([
                "name" => $request->name,
                "cat_id" => $request->cat,
                "fabric_id" => $request->fabric_type,
                "productDetalis" => $request->desc,
                "price" => $request->price,
                "stock" => $request->stock,
                "meta_title" => $request->meta_title,
                "meta_description" => $request->meta_description,
                "meta_keywords" => $request->meta_keywords,
            ]);


            $product->product_img_p()->update([
                "mainImage" => $main_image,
                "img2" => $img2,
                "img3" => $img3,
                "img4" => $img4,
                "img5" => $img5,
                "img6" => $img6,
                'alt5' => $request->alt5,
                'alt6' => $request->alt6,
            ]);

            // Sync Sizes (Delete old and re-create)
            $product->sizes()->delete();
            if ($request->has('sizes') && is_array($request->sizes)) {
                foreach ($request->sizes as $index => $size) {
                     if (!empty($size)) {
                        $product->sizes()->create([
                            'size' => $size,
                            'stock' => $request->sizes_stock[$index] ?? 0,
                        ]);
                    }
                }
            }

            // Sync Colors (Delete old and re-create)
            $product->colors()->delete();
            if ($request->has('colors') && is_array($request->colors)) {
                foreach ($request->colors as $index => $color) {
                     if (!empty($color)) {
                        $product->colors()->create([
                            'color' => $color,
                            'color_code' => $request->colors_code[$index] ?? '#000000',
                            'stock' => $request->colors_stock[$index] ?? 0,
                        ]);
                    }
                }
            }

        });

        return redirect()->back()->with(['success'=>'اضافه منتج']);




    }

    public function destroy($productId)
    {
        $Product = Product::findOrFail($productId);
        $Product->delete();

        return redirect()->back()->with('success', 'تم الحذف بنجاح');
    }

    public function toggleStatus($id)
    {
        $product = Product::findOrFail($id);
        $product->append = $product->append == 1 ? 0 : 1;
        $product->save();

        return response()->json([
            'success' => true,
            'message' => $product->append == 1 ? 'تم تفعيل المنتج بنجاح' : 'تم إيقاف المنتج بنجاح',
            'append' => $product->append,
            'stock' => $product->stock
        ]);
    }





    public function multideleteProducts(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'integer',
        ]);

        foreach($request->ids as $id){
            Product::findOrFail($id)->delete();
        };
        
        return redirect()->back()->with(['success'=>'تم حذف المنتجات بنجاح']);
    }



}
