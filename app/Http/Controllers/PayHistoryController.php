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
        $viewData = [];
        $paymentData = [];
        $responseData = [];

        $paymentData = $request->all();

        if (! Auth::check()) {
            $responseData["redirect"] = redirect()->route('cart.index')->withErrors([__('messages.no_permission')]);
            $responseData["success"] = false;
            return PayHistoryController::responseFor($paymentData, $responseData);
        }
        
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

            $responseData["redirect"] = view('payHistory.createPayment')->with('data', $viewData);
            $responseData["success"] = true;
            
            return PayHistoryController::responseFor($paymentData, $responseData);
        }  
        
        $responseData["redirect"] = redirect()->route('cart.index')->withErrors([__('messages.no_permission')]);
        $responseData["success"] = false;
            
        return PayHistoryController::responseFor($paymentData, $responseData);
    }
    

    public function finishPayment(Request $request) {
        $responseData = [];

        if (! Auth::check()) {
            $responseData["redirect"] = redirect()->route('cart.index')->withErrors([__('messages.no_permission')]);
            $responseData["success"] = false;
            return PayHistoryController::responseFor($request->all(), $responseData);
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
            $responseData["redirect"] = redirect()->route('cart.index')->withErrors($error->getMessage());
            $responseData["success"] = false;    
            return PayHistoryController::responseFor($request->all(), $responseData);
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
                
                $responseData["redirect"] = redirect()->route('cart.index')->withErrors([__('messages.no_funds')]);
                $responseData["success"] = false;    
                return PayHistoryController::responseFor($request->all(), $responseData);
            }
        }else if ($paymentData["payment_type" == "wallet"]){
            //check if paypal payment was approved
            $user->AddFunds($paymentData['amount']);
            $payment->setStatus("accepted");
            $payment->save();
            
        }

        $responseData["redirect"] = $request["callback"];
        $responseData["success"] = true;    
        return PayHistoryController::responseFor($request->all(), $responseData);

    }

    private static function responseFor($requestData, $responseData){
        if (array_key_exists('comming_from', $requestData)){
            return $responseData;
        }else{
            return $responseData["redirect"];
        }
    }

   
}
