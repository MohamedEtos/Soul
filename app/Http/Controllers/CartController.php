<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Orders;
use App\Models\Order_items;
use App\Models\Order_addresses;
use App\Models\Shaping_Coast;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CartController extends Controller
{
    private string $key = 'cart.items';

    public function show(Request $request)
    {
        $items = session($this->key, []);
        return response()->json($this->buildCart($items));
    }

    public function add(Request $request)
    {
        $data = $request->validate([
            'product_id' => ['required','integer','exists:products,id'],
            'qty' => ['nullable','integer','min:1'],
            'size' => ['nullable','string'],
            'color' => ['nullable','string'],
        ]);

        $pid = (int) $data['product_id'];
        $qty = (int) ($data['qty'] ?? 1);
        $size = $data['size'] ?? null;
        $color = $data['color'] ?? null;

        // Backend Validation: Check if product requires size or color
        $product = Product::withCount(['sizes', 'colors'])->find($pid);
        
        if ($product) {
            if ($product->sizes_count > 0 && empty($size)) {
                return response()->json([
                    'message' => 'Please select a size',
                    'errors' => ['size' => ['يرجى اختيار المقاس']]
                ], 422);
            }
            if ($product->colors_count > 0 && empty($color)) {
                return response()->json([
                    'message' => 'Please select a color',
                    'errors' => ['color' => ['يرجى اختيار اللون']]
                ], 422);
            }
        }

        $cart = session($this->key, []);
        
        // Create unique key for product + size + color
        $itemKey = $pid . ($size ? '-' . $size : '') . ($color ? '-' . $color : '');

        if (isset($cart[$itemKey])) {
            $cart[$itemKey]['qty'] += $qty;
        } else {
            $cart[$itemKey] = [
                'product_id' => $pid, 
                'qty' => $qty,
                'size' => $size,
                'color' => $color
            ];
        }

        session([$this->key => $cart]);

        return response()->json([
            'message' => 'added',
            'cart' => $this->buildCart($cart),
        ], 201);
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'product_id' => ['required'], // Can be int ID or string Key
            'qty' => ['required','integer','min:1'],
            'size' => ['nullable','string'],
            'color' => ['nullable','string'],
        ]);

        // Key resolution: If size/color provided, rebuild key. If product_id is already the composite key, use it.
        $pid = $data['product_id'];
        $size = $data['size'] ?? null;
        $color = $data['color'] ?? null;
        
        // If product_id coming from frontend is just ID but we have size/color, construct key
        // Check if $pid is numeric (just ID) or string (composite)
        if (is_numeric($pid) && ($size || $color)) {
            $itemKey = $pid . ($size ? '-' . $size : '') . ($color ? '-' . $color : '');
        } else {
             $itemKey = $pid; // Assume it's already the key passed from frontend
        }

        $qty = (int) $data['qty'];

        $cart = session($this->key, []);

        if (!isset($cart[$itemKey])) {
            return response()->json(['message' => 'item not found'], 404);
        }

        $cart[$itemKey]['qty'] = $qty;
        session([$this->key => $cart]);

        return response()->json([
            'message' => 'updated',
            'cart' => $this->buildCart($cart),
        ]);
    }

    public function remove(Request $request)
    {
        $data = $request->validate([
            'product_id' => ['required'],
        ]);

        $itemKey = $data['product_id'];
        $cart = session($this->key, []);

        unset($cart[$itemKey]);
        session([$this->key => $cart]);

        return response()->json([
            'message' => 'removed',
            'cart' => $this->buildCart($cart),
        ]);
    }

    public function clear()
    {
        session()->forget($this->key);

        return response()->json([
            'message' => 'cleared',
            'cart' => [
                'items' => [],
                'subtotal' => 0,
                'count' => 0
            ]
        ]);
    }



private function shippingCost(?string $gov): float
{
    if (!$gov) return 0;

    $row = Shaping_Coast::where('name_ar', $gov)
        ->first(['shipping_cost','free_shipping']);

    if (!$row) return 0;

    return $row->free_shipping ? 0 : (float)$row->shipping_cost;
}


private function buildCart(array $cart): array
{
    // Extract unique product IDs from cart items
    $productIds = [];
    foreach ($cart as $item) {
        $productIds[] = $item['product_id'];
    }
    $productIds = array_unique($productIds);

    $products = Product::whereIn('id', $productIds)
        ->with(['product_img_p:id,product_id,mainImage'])
        ->get()
        ->keyBy('id');

    $items = [];
    $subtotal = 0;
    $count = 0;

    foreach ($cart as $key => $row) {
        $pid = $row['product_id'];
        $p = $products->get($pid);
        if (!$p) continue;

        $image = $p->product_img_p ? asset($p->product_img_p->mainImage) : null;

        $qty = (int) $row['qty'];
        $line = (float) $p->price * $qty;
        $size = $row['size'] ?? null;
        $color = $row['color'] ?? null;

        $items[] = [
            'key' => $key, // Pass the cart key (composite) for update/remove actions
            'product_id' => $p->id,
            'name' => $p->name,
            'slug' => $p->slug,
            'price' => (float) $p->price,
            'qty' => $qty,
            'size' => $size,
            'color' => $color,
            'line_total' => $line,
            'image' => $image,
            'stock_available' => (int) $p->stock,
        ];

        $subtotal += $line;
        $count += $qty;
    }

    $gov = session('cart.governorate'); // هنخزنها هنا
    $shipping = $this->shippingCost($gov);
    $total = $subtotal + $shipping;

    return [
        'items' => $items,
        'subtotal' => (float) $subtotal,
        'shipping_cost' => (float) $shipping,
        'total' => (float) $total,
        'count' => (int) $count,
        'governorate' => $gov,
    ];
}



    public function shopingcart()
    {
        $cartData = $this->buildCart(session($this->key, []));
        $governorate = Shaping_Coast::pluck('name_ar')->toArray();
        return view('store.shoping-cart', [
            'cartData' => $cartData,
            'governorate' => $governorate,
            'title' => 'LunaBlu|لونا بلو | سلة التسوق',
            'description' => 'استعرض محتويات سلة التسوق الخاصة بك وتحقق من المنتجات التي قمت بإضافتها قبل إتمام عملية الشراء في متجرنا الإلكتروني.',
            'image' =>  asset('store/images/icons/favicon.ico'),
            'url' => url()->current(),
        ]);
    }



        public function setGovernorate(Request $request)
    {
        $data = $request->validate([
            'governorate' => ['required','string','max:100'],
        ]);

        session(['cart.governorate' => $data['governorate']]);

        $cart = session($this->key, []);

        return response()->json([
            'message' => 'governorate_updated',
            'cart' => $this->buildCart($cart),
        ]);
    }

public function prossesCart(Request $request)
{


    Log::info('Processing Cart Request', $request->all());

    $data = $request->validate([
        'items' => ['required','array','min:1'],
        'items.*.id'  => ['required','integer','exists:products,id'],
        'items.*.qty' => ['required','integer','min:1'],
        'items.*.size' => ['nullable','string'],
        'items.*.color' => ['nullable','string'],
        'name' => ['required', 'string', 'max:100'],
        'phone' => ['required', 'string', 'max:11'],
        'governorate' => ['required', 'string', 'max:100', 'exists:shaping__coasts,name_ar'],
        'area' =>  ['required', 'string', 'max:100'],
        'address' => ['required', 'string', 'max:200'],
        'floor_number' => ['required', 'string', 'max:20'],
        'building' => ['required', 'string', 'max:20'],
        'note' => ['nullable', 'string', 'max:200'],
    ], [
        'items.required' => 'السلة فارغة',
        'name.required' => 'يرجى إدخال الاسم',
        'phone.required' => 'يرجى إدخال رقم الهاتف',
        'phone.max' => 'رقم الهاتف يجب أن لا يتجاوز 11 رقم',
        'governorate.required' => 'يرجى اختيار المحافظة',
        'governorate.exists' => 'المحافظة المختارة غير صحيحة',
        'area.required' => 'يرجى إدخال المنطقة',
        'address.required' => 'يرجى إدخال العنوان التفصيلي',
        'floor_number.required' => 'يرجى إدخال رقم الطابق',
        'building.required' => 'يرجى إدخال رقم المبنى',
    ]);

    return DB::transaction(function () use ($request) {

        // 1) جمّع الكميات لنفس المنتج: [product_id => qty]
        // Note: For stock check, we need total qty per product ID regardless of size (unless checking size stock)
        // Here we just aggregate by product_id for price checking and global stock check
        $itemsByProduct = collect($request->items)
            ->groupBy('id') // Group by real product ID, not cart key
            ->map(fn($g) => (int) $g->sum('qty'))
            ->toArray();

        // 2) هات الأسعار: [id => price] + اقفل الصفوف للخصم الآمن
        $prices = Product::whereIn('id', array_keys($itemsByProduct))
            ->lockForUpdate()
            ->pluck('price', 'id')
            ->toArray();

        // (اختياري) تأكد المخزون يكفي
        $stocks = Product::whereIn('id', array_keys($itemsByProduct))
            ->pluck('stock', 'id')
            ->toArray();

        // Check global stock
        foreach ($itemsByProduct as $pid => $qty) {
            if (($stocks[$pid] ?? 0) < $qty) {
            return redirect()->back()->withInput()->with(['error'=>' الكمية المطلوبة غير متوفرة في المخزون من المنتج رقم: ' . $pid . ' ']);
            }
        }

        // 3) احسب subtotal من الداتا
        $subtotal = 0;
        foreach ($request->items as $item) {
             $pid = $item['id']; // Use 'product_id' sent from frontend or derived
             $qty = $item['qty'];
             $subtotal += ((float)($prices[$pid] ?? 0)) * $qty;
        }

        $shipping = 50; // عدّلها حسب نظامك
        $total = $subtotal + $shipping;

        // 4) أنشئ الأوردر
        $order = Orders::create([
            'user_ip' => $request->ip(),
            'order_number' => 'ORD' . time(),
            'subtotal' => $subtotal,
            'shipping_cost' => $shipping,
            'total' => $total,
            'status' => 'done',
            'payment_method' => 'COD',
            'payment_status' => 'notaccepted',
        ]);


        $order_address = Order_addresses::create([
            'order_id' => $order->id,
            'full_name' => $request->name,
            'phone' => $request->phone,
            'governorate' =>  $request->governorate,
            'area' =>  $request->area,
            'address' => $request->address,
            'floor_number' => $request->floor_number,
            'building' => $request->building,
            'note' => $request->note,
        ]);

        // 5) جهّز الـ order items دفعة واحدة
        $rows = [];
        
        // Loop through original request items to capture size
        foreach ($request->items as $item) {
            $pid = (int) $item['id'];
            $qty = (int) $item['qty'];
            $size = $item['size'] ?? null;
            $color = $item['color'] ?? null; // Capture color
            $price = (float)($prices[$pid] ?? 0);

            $rows[] = [
                'order_id'   => $order->id,
                'product_id' => $pid,
                'quantity'   => $qty,
                'price'      => $price,
                'total'      => $price * $qty,
                'size'       => $size,
                'color'      => $color, // Save color
                'created_at' => now(),
                'updated_at' => now(),
            ];

            // 6) خصم المخزون
            
            // Global Stock
            Product::where('id', $pid)->decrement('stock', $qty);
            
            // Size Stock
            if ($size) {
                 DB::table('product_sizes')
                   ->where('product_id', $pid)
                   ->where('size', $size)
                   ->decrement('stock', $qty);
            }

            // Color Stock
            if ($color) {
                 DB::table('product_colors')
                   ->where('product_id', $pid)
                   ->where('color', $color)
                   ->decrement('stock', $qty);
            }
        }

        // إدخال مرة واحدة بدل create داخل loop
        Order_items::insert($rows);
        session()->forget($this->key); // ازاله السيشن عند اكمال الطلب
        $order_id = Orders::latest()->first();


        session()->put('success_order_id', $order->id);
        session()->put('can_view_success', true);

            return view ('store.successOrder',[ 
            'order' => $order_id,
            'title' => 'LunaBlu|لونا بلو | تأكيد الطلب',
            'description' => 'تم تأكيد طلبك بنجاح في متجرنا الإلكتروني. شكرًا لاختيارك لنا!',
            'image' =>  asset('store/images/icons/favicon.ico'),
            'url' => url()->current(),
            ]);


        // return view('store.successOrder', [
        // // 'order_id' => $order_id,
        // 'title' => 'LunaBlu|لونا بلو | تأكيد الطلب',
        // 'description' => 'تم تأكيد طلبك بنجاح في متجرنا الإلكتروني. شكرًا لاختيارك لنا!',
        // 'image' =>  asset('store/images/icons/favicon.ico'),
        // 'url' => url()->current(),
         // ]);


    });
}


}
