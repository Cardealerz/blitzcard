<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\PayHistory;
use Exception;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class PayHistoryController extends Controller{

    public function showOne($id){
        $data = [];
        $payHistory = PayHistory::findOrFail($id);

        $data["title"] = $payHistory->getUuid();
        $data["pay_history"] = $payHistory;

        return view('payhistory.showOne')->with("data",$data);
    }

    public function showAll(){
        $data = [];
        $data["title"] = "Showing All Payhistory";
        $data["pay_history"] = PayHistory::orderBy('id')->get();

        return view('payhistory.showAll')->with("data",$data);
    }

    public function create(){
        $data = [];
        $data["title"] = "Create Pay History";
        $data["payhistory"] = PayHistory::all();

        return view('payhistory.create')->with("data",$data);
    }


    public function save($request_data) {
        if (! Auth::check()) {
            return redirect()->route('home.index')->withErrors([__('messages.no_permission')]);
        }

        $request_data["uuid"] = Str::uuid()->toString();
        try{
            PayHistory::validate($request_data);
        }catch(Exception $error){
            return redirect()->route('home.index')->withErrors([__('messages.no_permission')]);
        }
        
        PayHistory::create($request_data);

        return back()->with('success','Item created successfully!');
    }

    public function delete($id){
        $payHistory = PayHistory::findOrFail($id);
        $payHistory->delete();
        return redirect()->route('payhistory.showAll')->with('success','Item deleted successfully!');
    }


}
