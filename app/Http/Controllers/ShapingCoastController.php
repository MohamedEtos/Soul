<?php

namespace App\Http\Controllers;

use App\Models\Shaping_Coast;
use Illuminate\Http\Request;

class ShapingCoastController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $shaping_coast = Shaping_Coast::all();
        return view('admin.Shaping.shaping_coast', compact('shaping_coast'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name_ar' => 'required|string|max:255',
            'name_en' => 'required|string|max:255',
            'shipping_cost' => 'required|numeric|min:0',
        ]);

        $coast = new Shaping_Coast();
        $coast->name_ar = $request->name_ar;
        $coast->name_en = $request->name_en;
        $coast->shipping_cost = $request->shipping_cost;
        $coast->save();

        return redirect()->back()->with('success', 'تم اضافة المحافظة بنجاح');
    }

    /**
     * Display the specified resource.
     */
    public function show(Shaping_Coast $shaping_Coast)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Shaping_Coast $shaping_Coast)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Shaping_Coast $shaping_Coast)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $coast = Shaping_Coast::findOrFail($id);
        $coast->delete();
        return redirect()->back()->with('success', 'تم حذف المحافظة بنجاح');
    }

    /**
     * Toggle free shipping status
     */
    public function toggleFreeShipping(Request $request, $id)
    {
        $coast = Shaping_Coast::findOrFail($id);

        // Toggle the free_shipping value (0 -> 1, 1 -> 0)
        $coast->free_shipping = !$coast->free_shipping;
        $coast->save();

        // If it's an AJAX request, return JSON response
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'free_shipping' => $coast->free_shipping,
                'message' => $coast->free_shipping ? 'تم تفعيل الشحن المجاني' : 'تم إلغاء الشحن المجاني'
            ]);
        }

        return redirect()->back()->with('success', 'تم التحديث بنجاح');
    }

    /**
     * Update shipping cost
     */
    public function updateShippingCost(Request $request, $id)
    {
        $request->validate([
            'shipping_cost' => 'required|numeric|min:0'
        ]);

        $coast = Shaping_Coast::findOrFail($id);
        $coast->shipping_cost = $request->shipping_cost;
        $coast->save();

        // If it's an AJAX request, return JSON response
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'shipping_cost' => $coast->shipping_cost,
                'message' => 'تم تحديث سعر الشحن بنجاح'
            ]);
        }

        return redirect()->back()->with('success', 'تم تحديث سعر الشحن بنجاح');
    }
}
