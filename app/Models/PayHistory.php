<?php

namespace App\Models;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Exception;

class PayHistory extends Model
{
    use HasFactory;

    /*
        Atributes:
            id
            uuid: Will be the name of a PayHistory element
            userID: Foreign key to an user
            orderID: Id of an order, is not a foreign key because it could be null
            amount: Must be greather than 0
            billing_Address
            payment_type: It could be from buying an order or from charging to wallet
            payment_status: It could be accepted, pending, failed
            payment_method
            created_at 
            updated_at
    */

    public static function validateFinishPaymentData($paymentData)
    {

        if (!array_key_exists('uuid', $paymentData)) {
            throw new Exception('uuid is required for a new PayHistory');
        }
        if (!array_key_exists('user_id', $paymentData)) {
            throw new Exception('user_id is required for a new PayHistory');
        }
        if (!array_key_exists('order_id', $paymentData)) {
            throw new Exception('order_id is required for a new PayHistory');
        }
        if (!array_key_exists('amount', $paymentData)) {
            throw new Exception('amount is required for a new PayHistory');
        }
        if (!array_key_exists('billing_address', $paymentData)) {
            throw new Exception('billing_address is required for a new PayHistory');
        }
        if (!array_key_exists('payment_method', $paymentData)) {
            throw new Exception('payment_method is required for a new PayHistory');
        }
        if (!array_key_exists('payment_type', $paymentData)) {
            throw new Exception('payment_type is required for a new PayHistory');
        }
        if (!array_key_exists('callback', $paymentData)) {
            throw new Exception('callback is required for a new PayHistory');
        }
    }

    public static function validateCreatePaymentData($paymentData)
    {

        if (!array_key_exists('uuid', $paymentData)) {
            throw new Exception('uuid is required for a new PayHistory');
        }
        if (!array_key_exists('user_id', $paymentData)) {
            throw new Exception('user_id is required for a new PayHistory');
        }
        if (!array_key_exists('order_id', $paymentData)) {
            throw new Exception('order_id is required for a new PayHistory');
        }
        if (!array_key_exists('amount', $paymentData)) {
            throw new Exception('amount is required for a new PayHistory');
        }
        if (!array_key_exists('payment_type', $paymentData)) {
            throw new Exception('payment_type is required for a new PayHistory');
        }
        if (!array_key_exists('callback', $paymentData)) {
            throw new Exception('callback is required for a new PayHistory');
        }
    }

    public static function validateOtherData($request_data)
    {

        if (!array_key_exists('payment_date', $request_data)) {
            throw new Exception('Payment Date is required for a new PayHistory');
        }

        if (!array_key_exists('payment_type', $request_data)) {
            throw new Exception('Payment Type is required for a new PayHistory');
        } else {
            if ($request_data['payment_type'] != "order" && $request_data['payment_type'] != "wallet") {
                throw new Exception('Payment Type must be order or wallet');
            }
            if ($request_data['payment_type'] == "order" && !array_key_exists('order_id', $request_data)) {
                throw new Exception('Payment of an order must have an order id');
            }
        }

        if (array_key_exists('payment_status', $request_data)) {
            throw new Exception('Payment status can\'t be setted from a form');
        }
    }

    protected $fillable = ['uuid', 'user_id', 'order_id', 'amount', 'billing_address', 'payment_method', 'payment_type', 'payment_date'];

    public function getId()
    {
        return $this->attributes['id'];
    }

    public function setId($id)
    {
        $this->attributes['id'] = $id;
    }

    public function getUuid()
    {
        return $this->attributes['uuid'];
    }

    public function setUserId($userID)
    {
        $this->attributes['user_id'] = $userID;
    }

    public function getUserId()
    {
        return $this->attributes['user_id'];
    }

    public function setOrderId($orderID)
    {
        $this->attributes['order_id'] = $orderID;
    }

    public function getOrderId()
    {
        return $this->attributes['order_id'];
    }

    public function setUuid($uuid)
    {
        $this->attributes['uuid'] = $uuid;
    }

    public function getAmount()
    {
        return $this->attributes['amount'];
    }

    public function setAmount($amount)
    {
        $this->attributes['amount'] = $amount;
    }

    public function getBillingAddress()
    {
        return $this->attributes['billing_address'];
    }

    public function setBillingAddress($billingAddress)
    {
        $this->attributes['billing_address'] = $billingAddress;
    }

    public function getPaymentMethod()
    {
        return $this->attributes['payment_method'];
    }

    public function setPaymentMethod($paymentMethod)
    {
        $this->attributes['payment_method'] = $paymentMethod;
    }

    public function getPaymentStatus()
    {
        return $this->attributes['payment_status'];
    }

    public function setPaymentStatus($paymentStatus)
    {

        $this->attributes['payment_status'] = $paymentStatus;
    }

    public function getPaymentDate()
    {
        return $this->attributes['payment_date'];
    }

    public function setPaymentDate($paymentDate)
    {
        $this->attributes['payment_date'] = $paymentDate;
    }

    public function getPaymentType()
    {
        return $this->attributes['payment_type'];
    }

    public function setPaymentType($paymentType)
    {
        $this->attributes['payment_type'] = $paymentType;
    }

    public function codes()
    {
        $items = Item::where('order_id', '=', $this->getOrderId())->get();
        $codes = array();

        foreach ($items as $item) {
            $codeInfo = [];

            $itemCodes = Code::where('item_id', '=', $item->getId())->get();

            foreach ($itemCodes as $code) {
                $codeInfo["code"] = $code->getCode();

                $codeTemplate = CodeTemplate::where('id', '=', $code->getCodeTemplateId())->get()->first();
                $codeInfo["name"] = $codeTemplate->toString();

                array_push($codes, $codeInfo);
            }
        }
        return $codes;
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
