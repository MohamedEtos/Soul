<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Orders;

class OrdersController extends Controller
{
    public function success( Request $request)
    {
        // حماية الصفحة
        if (!session()->has('can_view_success')) {
            abort(404);
        }

        $order = Orders::findOrFail(session('success_order_id'));

        // امنع الرجوع تاني
        session()->forget(['can_view_success', 'success_order_id']);

        return view('store.successOrder', [
            'order' => $order,
        ]);
    }
}
