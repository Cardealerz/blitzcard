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
            orderID: Foreign key to an order, unique
            amount: Must be greather than 0
            billing_Address
            payment_type: It could be from buying an order or from charging to wallet
            payment_status: It could be accepted, pending, failed
            payment_method
            created_at 
            updated_at
    */


    public static function validate($request_data){

        if (!array_key_exists('uuid', $request_data)){
            throw new Exception('valid uuid is required for a new PayHistory');
        }else{
            if ($request_data['uuid'] == ""){
                throw new Exception('uuid can\'t be empty for a new PayHistory');
            }
        }

        if (!array_key_exists('user_id', $request_data)){
            throw new Exception('Valid user is required for this PayHistory');
        }else{
            if ($request_data['user_id'] < 1){
                throw new Exception('Valid user is required for this PayHistory');
            }
        }

        if (!array_key_exists('order_id', $request_data)){
            throw new Exception('Valid order is required for this PayHistory');
        }else{
            if ($request_data['order_id'] < 1){
                throw new Exception('Valid order is required for this PayHistory');
            }
        }

        if (!array_key_exists('payment_type', $request_data)){
            throw new Exception('Payment Type is required for a new PayHistory');
        }else{
            if ($request_data['payment_type'] != "order" || $request_data['payment_type'] != "wallet"){
                throw new Exception('Payment Type must be order or wallet');
            }
        }

        if (!array_key_exists('amount', $request_data)){
            throw new Exception('amount is required for a new PayHistory');
        }else{
            if ($request_data['amount'] <= 0){
                throw new Exception('amount must be greater than 0');
            }
        }

        if (!array_key_exists('billing_address', $request_data)){
            throw new Exception('Billing Address is required for a new PayHistory');
        }else{
            if ($request_data['billing_address'] == ""){
                throw new Exception('Billing Address is required for a new PayHistory');
            }
        }

        if (!array_key_exists('payment_method', $request_data)){
            throw new Exception('Payment Method is required for a new PayHistory');
        }else{
            if ($request_data['payment_method'] == ""){
                throw new Exception('Payment Method is required for a new PayHistory');
            }
        }

        if (array_key_exists('payment_status', $request_data)){
            throw new Exception('Payment status can\'t be setted from a form');
        }

        if (!array_key_exists('payment_date', $request_data)){
            throw new Exception('Payment date is required for a new PayHistory');
        }else{
            if ($request_data['payment_date'] == ""){
                throw new Exception('Payment Date is required for a new PayHistory');
            }
        }
    }

    protected $fillable = ['uuid', 'user_id', 'order_id', 'amount','billing_address','payment_type','payment_method','payment_status','payment_date'];

    public function getId(){
        return $this->attributes['id'];
    }

    public function setId($id){
        $this->attributes['id'] = $id;
    }

    public function getUuid(){
        return $this->attributes['uuid'];
    }

    public function setUserID($userID){
        $this->attributes['user_id'] = $userID;
    }

    public function getUserID(){
        return $this->attributes['user_id'];
    }

    public function setOrderID($orderID){
        $this->attributes['order_id'] = $orderID;
    }

    public function getOrderID(){
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

}
