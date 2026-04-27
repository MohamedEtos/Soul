<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\FabricType;
use App\Models\Categotry;
class ProductController extends Controller
{

    public function index(Request $request)
    {
        $products = Product::with(['Category', 'FabricType'])->paginate(12);
        $fabrics = FabricType::inRandomOrder()->limit(7)->get();

        $query = Product::query()->where('append', 1);

        $search = trim((string) $request->input('search', ''));
        $sort = $request->input('sort');
        $min_price = $request->input('min_price');
        $max_price = $request->input('max_price');

        $relations = ['category', 'fabricType'];

        $query->where(function ($q) use ($search, $relations) {

            //  أعمدة المنتج نفسها
            $q->where('name', 'LIKE', "%{$search}%")
            ->orWhere('price', 'LIKE', "%{$search}%")
            ->orWhere('productDetalis', 'LIKE', "%{$search}%")
            ->orWhere('meta_title', 'LIKE', "%{$search}%")
            ->orWhere('meta_description', 'LIKE', "%{$search}%")
            ->orWhere('slug', 'LIKE', "%{$search}%");

            //  أعمدة العلاقات (حسب اللي موجود فعلاً في جداولهم)
            foreach ($relations as $relation) {
                $q->orWhereHas($relation, function ($q2) use ($search) {
                    $q2->where(function ($x) use ($search) {
                        $x->where('name', 'LIKE', "%{$search}%");
                        // ->orWhere('slug', 'LIKE', "%{$search}%"); // لو موجودة
                    });
                });
            }
        });

        // Price Filter
        if ($min_price !== null && $max_price !== null) {
            $query->whereBetween('price', [(float)$min_price, (float)$max_price]);
        } elseif ($min_price !== null) {
            $query->where('price', '>=', (float)$min_price);
        } elseif ($max_price !== null) {
            $query->where('price', '<=', (float)$max_price);
        }

        // Sorting
        switch ($sort) {
            case 'popularity':
                // Assuming we have a 'views' or 'sales_count' column, otherwise default to latest
                 $query->orderBy('views', 'desc'); 
                break;
            case 'rating':
                // Assuming rating column logic
                 $query->latest();
                break;
            case 'newness':
                $query->latest();
                break;
            case 'price_low':
                $query->orderBy('price', 'asc');
                break;
            case 'price_high':
                $query->orderBy('price', 'desc');
                break;
            default:
                $query->latest();
                break;
        }

        $products = $query->paginate(12)->appends($request->all());

        if ($request->ajax()) {
            return view('store.parts.product_loop', compact('products'));
        }

        return view('store.product', [
            'products' => $products,
            'fabrics' => $fabrics,
            'title' => 'LunaBlu|لونا بلو | متجر ملابس طرح عصرية – خامات فاخرة وأسعار مناسبة',
            'description'=>'تسوّق أحدث المنتجات بجودة عالية وأسعار مميزة. اكتشف تشكيلتنا المتنوعة التي تناسب جميع الأذواق مع تجربة شراء سهلة وآمنة.',
            'image' =>  asset('store/images/icons/favicon.png'),
            'url' => url()->current(),
        ]);
    }

    public function show(Product $product)
    {
        $product->increment('views');
        $product->load('sizes');
        $products = Product::where('append', 1)->with(['Category', 'FabricType'])->get();



        return view('store.productshow',[
            'product' => $product,
            'products' => $products,
            'title' => $product->name . ' | LunaBlu|لونا بلو',
            'description' =>$product->slug . '||' . $product->productDetalis,
            'image' =>  $product->product_img_p->mainImage,
            'url' => url()->current(),
        ]);

    }



}
