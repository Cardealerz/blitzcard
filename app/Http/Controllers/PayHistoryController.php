<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\PayHistory;
use Exception;
use App\Http\PostCaller;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Carbon\Carbon;

class PayHistoryController extends Controller{

    public function createPayment(Request $request){
        if (! Auth::check()) {
            return redirect()->route('home.index')->withErrors([__('messages.no_permission')]);
        }

        $viewData = [];
        $paymentData = [];
        $paymentData = $request->all();
        
        if (!array_key_exists('order_id', $paymentData)){
            $paymentData["order_id"] = 0;
        }else{
            $paymentData["order_id"] = $request->input("order_id");
        }

        PayHistory::validateCreatePaymentData($request);

        $viewData["title"] = "Payment Form";
        $viewData["payment"] = $paymentData;

        if($paymentData["payment_type"] == "order"){

            $paymentData["payment_method"] = "Wallet";
            $paymentData["billing_address"] = "ASdasjkdsadas";

            $post = new PostCaller(
                PayHistoryController::class,
                'finishPayment',
                Request::class,
                $paymentData
            );
            $response = $post->call();

            return $response;

        }else if ($paymentData["payment_type" == "wallet"]){
            return view('payHistory.createPayment')->with('data', $viewData);
        }   
        
        return redirect()->route('cart.index')->withErrors([__('messages.no_permission')]); 
    }
    

    public function finishPayment(Request $request) {
        
        if (! Auth::check()) {
            return redirect()->route('home.index')->withErrors([__('messages.no_permission')]);
        }
        
        $paymentData = $request->only([
            "uuid",
            "user_id",
            "order_id",
            "amount",
            "billing_address",
            "payment_method",
            "payment_type",
        ]);

        $currentTime = Carbon::now();
        $paymentData["payment_date"] = $currentTime;
        PayHistory::validateFinishPaymentData($request);
        try{
            PayHistory::validateOtherData($paymentData);
        }catch(Exception $error){
            return redirect()->route('cart.index')->withErrors($error->getMessage());
        }
                            
        $payment = PayHistory::create($paymentData);
        $user_id = Auth::user()->id;
        
        $user = User::findOrFail($user_id);

        if($paymentData["payment_type"] == "order"){
            if ($user->SubtractFunds($paymentData['amount'])){
                $payment->setPaymentStatus("accepted");
                $payment->save();
            }else{
                $payment->setPaymentStatus("failed");
                $payment->save();
                return redirect()->route('home.index')->withErrors([__('messages.no_funds')]);
            }
        }else if ($paymentData["payment_type" == "wallet"]){
            //check if paypal payment was approved
            $user->AddFunds($paymentData['amount']);
            $payment->setStatus("accepted");
            $payment->save();
            
        }

        return $request["callback"];
    }

   
}
