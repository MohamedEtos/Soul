<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\FabricType;
use Illuminate\Support\Facades\DB;
class FabrictypeController extends Controller
{
    public function index(){

         $fabrics = FabricType::get();


        return view('admin.fabric_type.fabricList',[
            'fabrics'=>$fabrics,
        ]);
    }

    public function create(Request $request)
    {

        // dd($request->all());

        DB::transaction(function () use ($request) {


            $FabricType = FabricType::create([
                "name" => $request->name,
            ]);

        });

        return redirect()->back()->with(['success'=>'اضافه ']);


        
    }



    public function destroy($id){

        $fabric = FabricType::find($id);
        $fabric->delete();
        return redirect()->back()->with(['success'=>'تم الحذف بنجاح']);
        
    }   
}
