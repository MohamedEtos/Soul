<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|max:1000',
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
        ]);

        $review = Review::create([
            'product_id' => $request->product_id,
            'user_id' => Auth::id(), // ID or null
            'rating' => $request->rating,
            'comment' => $request->comment,
            'name' => $request->name,
            'phone' => $request->phone,
            'is_approved' => true, // Auto-approve
        ]);

        return response()->json([
            'success' => true,
            'message' => 'تم إضافة تقييمك بنجاح!',
            'review' => $review
        ]);
    }
}
