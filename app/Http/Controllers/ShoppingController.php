<?php

namespace App\Http\Controllers;

use App\Models\Code;
use App\Models\CodeTemplate;
use App\Models\Item;
use App\Models\Order;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\PayHistory;
use Exception;
use App\Http\PostCaller;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Carbon\Carbon;


class ShoppingController extends Controller
{
    public function index(Request $request)
    {
        $data = [];
        $total = 0;
        $listProductsInCart = [];
        $ids = $request->session()->get('products');
        if ($ids) {
            $listProductsInCart = CodeTemplate::findMany(array_keys($ids));
            foreach ($listProductsInCart as $product) {
                $total = $total + $product->getValue() * $ids[$product->getId()];
            }
        }
        $data['title'] = 'Cart';
        $data['productsInCart'] = $listProductsInCart;
        $data['quantities'] = $ids;
        $data['total'] = $total;

        return view('cart.index')->with('data', $data);
    }

    public function add_one($id, Request $request)
    {
        $products = $request->session()->get('products');
        $products[$id] = 1;
        $request->session()->put('products', $products);

        return back();
    }

    public function add(Request $request)
    {
        $id = $request->input('id');
        $quantity = $request->input('quantity');
        $products = $request->session()->get('products');
        $products[$id] = $quantity;
        $request->session()->put('products', $products);

        return redirect()->route('cart.index');
    }

    public function removeAll(Request $request)
    {
        $request->session()->forget('products');

        return back();
    }

    public function removeItem($id, request $request)
    {
        $products = $request->session()->get('products');
        unset($products[$id]);
        $request->session()->put('products', $products);

        return back();
    }

    public function buy(Request $request)
    {
        if (! Auth::check()) {
            return redirect()->route('login')->withErrors([__('messages.please_log_in')]);
        }

        $data = [];
        $data['title'] = 'Buy';

        $order = new Order();
        $order->setUserId(Auth::user()->id);
        $order->setTotal(0);
        $order->save();
        
        $order_codes = array();
        $total = 0;
        $success = true;
        
        $ids = $request->session()->get('products');
        if ($ids) {
            $listProductsInCart = CodeTemplate::findMany(array_keys($ids));
            foreach ($listProductsInCart as $product) {
                $item = new Item();
                $item->setSubTotal(0);
                $item->setQuantity($ids[$product->getId()]);
                $item->setCodeTemplateId($product->getId());
                $item->setOrderId($order->getId());
                $item->save();

                $codes = Code::where(['code_template_id' => $product->getId(), 'used' => 0])->take($item->getQuantity())->get();
                if (count($codes) < $item->getQuantity()) {
                    $success = false;
                    break;
                }

                //$order_codes = array_merge($order_codes, $codes->toArray());        
                $item->setSubTotal($product->getValue() * $item->getQuantity());

                foreach ($codes as $code) {
                    $code->setItemId($item->getId());
                    $code->setUsed(1);
                    array_push($order_codes, $code);
                }
                $item->save();
                $total = $total + $item->getSubTotal();
            }
        }

        $order->setTotal($total);
        if ($total > 0) {
            $order->save();
        } else {
            $order->delete();
            return redirect()->route('cart.index')->withErrors([__('messages.no_items_in_cart')]);
        }

        if(!$success){
            Item::where('order_id','=',$order->getId())->delete();
            return redirect()->route('cart.index')->withErrors([__('messages.insufficient_stock')]);
        }

        $paymentData = [];

        $paymentData["uuid"] = Str::uuid()->toString();
        $paymentData["user_id"] = Auth::user()->id;
        $paymentData["order_id"] = $order->getId();
        $paymentData["amount"] = $total;
        $paymentData["payment_type"] = "order";
        $paymentData["callback"] = view('cart.buy')->with('data', $data);
        $paymentData["comming_from"] = "ShoppingCar";

        $response = ShoppingController::createPayment($paymentData);

        $order->setPayHistoryId($response["payment_id"]);
        $order->save();
        
        if ($response["success"]){
            foreach ($order_codes as $code){
                $code->save();
                $request->session()->forget('products'); 
            }
        }else{
            Item::where('order_id','=',$order->getId())->delete();
        }
           
        return $response["redirect"];

    }

    public static function createPayment($paymentData){
        $viewData = [];
        $responseData = [];

        if (! Auth::check()) {
            $responseData["redirect"] = redirect()->route('cart.index')->withErrors([__('messages.no_permission')]);
            $responseData["success"] = false;
            return $responseData;
        }
        
        if (!array_key_exists('order_id', $paymentData)){
            $paymentData["order_id"] = 0;
        }
        
        try{
            PayHistory::validateCreatePaymentData($paymentData);
        }catch(Exception $error){
            $responseData["redirect"] = redirect()->route('cart.index')->withErrors($error->getMessage());
            $responseData["success"] = false;    
            return $responseData;
        }
        

        $viewData["title"] = "Payment Form";
        $viewData["payment"] = $paymentData;
        

        if($paymentData["payment_type"] == "order"){

            $paymentData["payment_method"] = "Wallet";
            $paymentData["billing_address"] = "ASdasjkdsadas";

            $response = ShoppingController::finishPayment($paymentData);
            return $response;

        }else if ($paymentData["payment_type" == "wallet"]){

            $responseData["redirect"] = view('payHistory.createPayment')->with('data', $viewData);
            $responseData["success"] = true;
            
            return $responseData;
        }  
        
        $responseData["redirect"] = redirect()->route('cart.index')->withErrors([__('messages.no_permission')]);
        $responseData["success"] = false;
            
        return $responseData;
    }
    

    public static function finishPayment($paymentData) {
        $responseData = [];

        if (! Auth::check()) {
            $responseData["redirect"] = redirect()->route('cart.index')->withErrors([__('messages.no_permission')]);
            $responseData["success"] = false;
            return $responseData;
        }
        
        $currentTime = Carbon::now();
        $paymentData["payment_date"] = $currentTime;

        try{
            PayHistory::validateFinishPaymentData($paymentData);
        }catch(Exception $error){
            $responseData["redirect"] = redirect()->route('cart.index')->withErrors($error->getMessage());
            $responseData["success"] = false;    
            return $responseData;
        }
        
        try{
            PayHistory::validateOtherData($paymentData);
        }catch(Exception $error){
            $responseData["redirect"] = redirect()->route('cart.index')->withErrors($error->getMessage());
            $responseData["success"] = false;    
            return $responseData;
        }
                            
        $payment = PayHistory::create($paymentData);
        $responseData["payment_id"] = $payment->getId();  
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
                return $responseData;
            }
        }else if ($paymentData["payment_type" == "wallet"]){
            //check if paypal payment was approved
            $user->AddFunds($paymentData['amount']);
            $payment->setStatus("accepted");
            $payment->save();
            
        }
        
        $responseData["redirect"] = $paymentData["callback"];
        $responseData["success"] = true;  
        
        return $responseData;

    }



}
