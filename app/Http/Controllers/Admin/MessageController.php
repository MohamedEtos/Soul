<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Message;

class MessageController extends Controller
{
    public function index()
    {
        $messages = Message::latest()->paginate(10);
        return view('admin.messages.index', compact('messages'));
    }

    public function destroy($id)
    {
        Message::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'تم حذف الرسالة بنجاح');
    }
}
