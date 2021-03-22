<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\PayHistory;
use Exception;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class PayHistoryController extends Controller{

    
    public function createPayment(Request $request) {
        
        if (! Auth::check()) {
            return redirect()->route('home.index')->withErrors([__('messages.no_permission')]);
        }
        
        PayHistory::validatePostData($request);

        $generatedData = [];
        $generatedData["uuid"] = Str::uuid()->toString();
        $mergedData = array_merge($request->only(["amount","billing_address","payment_method","payment_date","payment_type"]), $generatedData);
            
        try{
            PayHistory::validateOtherData($request);
        }catch(Exception $error){
            
        }
        
        $payment = PayHistory::create($mergedData);
        $user_id = Auth::user()->id;

        $user = User::findOrFail($user_id);
        if ($user->SubtractFunds($mergedData['amount'])){
            $payment->setStatus("accepted");
        }else{
            $payment->setStatus("failed");
            return redirect()->route('home.index')->withErrors([__('messages.no_funds')]);
        }
        
        return $request["callback"];
    }

   
}
