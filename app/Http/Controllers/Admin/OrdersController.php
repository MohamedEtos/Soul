<?php

namespace App\Http\Controllers\Admin;

use DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Orders;
use App\Models\Product;
use App\Models\Shaping_Coast;
use App\Models\Order_addresses;
use App\Models\Order_items;


class OrdersController extends Controller
{
    public function index()
    {

        $Orderlist = Orders::with('items')->get();
        $ProductList = Product::get();
        $Shaping_CoastList = Shaping_Coast::get();

        return view('admin.orders.index',[
            'Orderlist' => $Orderlist,
            'ProductList' => $ProductList,
            'Shaping_CoastList' => $Shaping_CoastList,
        ]);
    }
    public function GetProductInfo($id)
    {

        $product = Product::findOrFail($id);

        return response()->json([
            'price' => $product->price,
        ]);

        // $GetProductInfo = Product::where('id', $id)->first();
        // return response()->json($GetProductInfo);

    }

    public function Send_whatsapp(Request $request)
    {
        Orders::where('id', $request->id)->update([
            'payment_status' => 'accepted'
        ]);

        // If it's an AJAX request, return JSON response
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'تم تحديث حالة الدفع بنجاح'
            ]);
        }

        return redirect()->route('Orders');

    }

    public function StoreOrder(Request $request)
    {
        // dd($request->all());

        $request->validate([
            'items'                  => ['required','array','min:1'],
            'items.*.product_id'     => ['required','integer','exists:products,id'],
            'items.*.price'          => ['required','numeric','min:0'],
            'items.*.qty'            => ['required','numeric','min:0'],

            'shipping__coast'         => ['required','integer','exists:shaping__coasts,id'], // عدّل الجدول لو مختلف
            'descount'               => ['nullable','numeric','min:0'],

            'customer'               => ['required','string','max:255'],
            'area'                   => ['required','string','max:255'],
            'address'                => ['required','string','max:1000'],
            'bilding'                => ['nullable','string','max:50'],
            'floor_number'           => ['nullable','string','max:50'],

            'total'                  => ['nullable','numeric','min:0'],
        ]);

        return DB::transaction(function () use ($request) {

            // 1) subtotal من العناصر
            $subtotal = 0;
            foreach ($request->items as $item) {
                $subtotal += (float)$item['price'] * (float)$item['qty'];
            }

            // 2) shipping cost من الداتا بيز
            $shipping = Shaping_Coast::findOrFail($request->shipping__coast);
            $shippingCost = (float)$shipping->shipping_cost;

            // 3) discount
            $discount = (float)($request->descount ?? 0);

            // 4) total النهائي (لا نعتمد على total القادم من الفورم)
            $total = $subtotal + $shippingCost - $discount;
            if ($total < 0) $total = 0;

            // 5) حفظ Order
            $order = Orders::create([

                'user_ip'       => $request->ip(),
                'order_number'       => 'ORD' . time(),
                'subtotal'           => $subtotal,
                'shipping_cost'      => $shippingCost,
                'total'              => $total,
                'status'             => 'done',
                'payment_method'     => 'COD',
                'payment_status'     => 'accepted',
            ]);



            // 6) حفظ Order Items
            foreach ($request->items as $item) {
                Order_items::create([
                    'order_id'   => $order->id,
                    'product_id' => (int)$item['product_id'],
                    'price'      => (float)$item['price'],
                    'quantity'        => (float)$item['qty'],
                    'total'     => (float)$item['price'] * (float)$item['qty'],
                ]);
            }

            $order = Order_addresses::create([
                'order_id'=> $order->id,
                'full_name'=> $request->customer,
                'phone'=> $request->phone,
                'governorate'=> $shipping->name_ar,
                'area'=> $request->area,
                'address'=> $request->address,
                'building'=> $request->bilding,
                'floor_number'=> $request->floor_number,
            ]);

            return redirect()->back()->with(['success'=>'تم حفظ الطلب بنجاح']);
    });


    }

    public function destroyOrder($productId)
    {
        $Orders = Orders::findOrFail($productId);
        $Orders->delete();

        return redirect()->back()->with('success', 'تم الحذف بنجاح');
    }


    public function multideleteOrders(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'integer',
        ]);


        foreach($request->ids as $id){
            Orders::findOrFail($id)->delete();
        };
        return redirect()->back()->with(['success'=>'تم حذف الطلبات بنجاح']);

    }


    public function latestNotifications()
    {
        $notifications = Orders::where('payment_status', 'notaccepted')
            ->orderBy('created_at', 'desc')
            ->get();
            
        return response()->json([
            'count' => $notifications->count(),
            'html' => view('admin.partials.notification_list', ['notifications' => $notifications])->render()
        ]);
    }
}
