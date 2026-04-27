<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'masseage' => 'required|string|max:1000',
        ]);

        \App\Models\Message::create([
            'message' => $request->masseage,
        ]);

        return redirect()->back()->with('success', 'تم ارسال رسالتك بنجاح');
    }
}
