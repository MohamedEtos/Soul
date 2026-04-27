<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ErrorLog;
use Illuminate\Http\Request;

class ErrorLogController extends Controller
{
    public function index()
    {
        $errorLogs = ErrorLog::latest()->paginate(20);
        return view('admin.errors.index', compact('errorLogs'));
    }

    public function destroy($id)
    {
        ErrorLog::destroy($id);
        return redirect()->back()->with('success', 'تم حذف السجل بنجاح');
    }

    public function clear()
    {
        ErrorLog::truncate();
        return redirect()->back()->with('success', 'تم تنظيف سجل الأخطاء بنجاح');
    }
}
