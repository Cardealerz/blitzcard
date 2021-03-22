<?php

namespace App\Models;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Exception;

class PayHistory extends Model{
    use HasFactory;

    /*
        Atributes:
            id
            uuid: Will be the name of a PayHistory element
            userID: Foreign key to an user
            orderID: id of an order, is not a foreign key because it could be null
            amount: Must be greather than 0
            billing_Address
            payment_type: It could be from buying an order or from charging to wallet
            payment_status: It could be accepted, pending, failed
            payment_method
            created_at 
            updated_at
    */

    public static function validateFinishPaymentData(Request $request){
        $request->validate([
            "uuid" => "required",
            "user_id" => "required",
            "order_id" => "required",
            "amount" => "required|gt:0",
            "billing_address" => "required",
            "payment_method" => "required",
            "payment_type" => "required",
            "callback" => "required"
        ]);
    }

    public static function validateCreatePaymentData(Request $request){
        $request->validate([
            "uuid" => "required",
            "user_id" => "required",
            "order_id" => "required",
            "amount" => "required|gt:0",
            "payment_type" => "required",
            "callback" => "required"
        ]);
    }

    public static function validateOtherData($request_data){

        if (!array_key_exists('payment_date', $request_data)){
            throw new Exception('Payment Date is required for a new PayHistory');
        }
        
        if (!array_key_exists('payment_type', $request_data)){
            throw new Exception('Payment Type is required for a new PayHistory');
        }else{
            if ($request_data['payment_type'] != "order" && $request_data['payment_type'] != "wallet"){
                throw new Exception('Payment Type must be order or wallet');
            }
            if ($request_data['payment_type'] == "order" && !array_key_exists('order_id', $request_data)){
                throw new Exception('Payment of an order must have an order id');
            }
        }

        if (array_key_exists('payment_status', $request_data)){
            throw new Exception('Payment status can\'t be setted from a form');
        }

    }

    protected $fillable = ['uuid', 'user_id', 'order_id', 'amount','billing_address','payment_method', 'payment_type','payment_date'];

    public function getId(){
        return $this->attributes['id'];
    }

    public function setId($id){
        $this->attributes['id'] = $id;
    }

    public function getUuid(){
        return $this->attributes['uuid'];
    }

    public function setUserId($userID){
        $this->attributes['user_id'] = $userID;
    }

    public function getUserId(){
        return $this->attributes['user_id'];
    }

    public function setOrderId($orderID){
        $this->attributes['order_id'] = $orderID;
    }

    public function getOrderId(){
        return $this->attributes['order_id'];
    }

    public function setUuid($uuid){
        $this->attributes['uuid'] = $uuid;
    }

    public function getAmount(){
        return $this->attributes['amount'];
    }

    public function setAmount($amount){
        $this->attributes['amount'] = $amount;
    }

    public function getBillingAddress(){
        return $this->attributes['billing_address'];
    }

    public function setBillingAddress($billingAddress){
        $this->attributes['billing_address'] = $billingAddress;
    }

    public function getPaymentMethod(){
        return $this->attributes['payment_method'];
    }

    public function setPaymentMethod($paymentMethod){
        $this->attributes['payment_method'] = $paymentMethod;
    }

    public function getPaymentStatus(){
        return $this->attributes['payment_status'];
    }

    public function setPaymentStatus($paymentStatus){
        
        $this->attributes['payment_status'] = $paymentStatus;
    }

    public function getPaymentDate(){
        return $this->attributes['payment_date'];
    }

    public function setPaymentDate($paymentDate){
        $this->attributes['payment_date'] = $paymentDate;
    }

    public function getPaymentType(){
        return $this->attributes['payment_type'];
    }

    public function setPaymentType($paymentType){
        $this->attributes['payment_type'] = $paymentType;
    } 

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function codes(){
        $items = Item::where('order_id', '=', $this->getOrderId())->get();
        $codes = array();

        foreach($items as $item){
            $codeInfo = [];

            $code = Code::where('item_id', '=', $item->getId())->get()->first();
            $codeInfo["code"] = $code->getCode();

            $codeTemplate = CodeTemplate::where('id', '=', $code->getCodeTemplateId())->get()->first();
            $codeInfo["name"] = $codeTemplate->getName();
            
            array_push($codes, $codeInfo);
        }
        return $codes;
    }
}
