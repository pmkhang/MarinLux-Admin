<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Skipper\StoreRequest;
use App\Http\Requests\Skipper\UpdateRequest;
use App\Models\Booking;
use App\Models\Skipper;
use Illuminate\Http\Request;

class SkipperController extends Controller
{
    public function index(){
        $skipper = Skipper::all();
        return view('admin.modules.skipper.index',[
            'skippers'=>$skipper
        ]);
    }



    public function create(){
        
        return view('admin.modules.skipper.create')
            
        ;
    }


    public function store(StoreRequest $request){
        
        $skipper=[
            
            'name'=>$request->name,
            'phone'=>$request->phone,
            'email'=>$request->email,
          'supplier'=>$request->supplier,
        ];
        
        // $skipper->bookings = 1;

        Skipper::create($skipper);
        return redirect()->route('admin.skipper.index')->with('success','Create A New Skipper Success');
    }


    public function edit($id){
        $skipper = Skipper::findOrfail($id);
        return view('admin.modules.skipper.edit',[
            'skippers'=>$skipper
        ]);

    }

    public function update(UpdateRequest $request,$id){
        $skipper= Skipper::findOrFail($id);
        $skipper->name=$request->name;
        $skipper->phone=$request->phone;
        $skipper->email=$request->email;
        $skipper->supplier=$request->supplier;
        $skipper->save();
        return redirect()->route('admin.skipper.index')->with('success','Update The Skipper Info Successfully!');
    }

    public function destroy($id){
        $skipper = Skipper::findOrFail($id);
        $skipper->delete();
        return redirect()->route('admin.skipper.index')->with('success','Delete Skipper Success');
    }


}
