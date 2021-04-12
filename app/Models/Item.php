<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    /*
        Atributes:
            id
            subtotal: Subtotal of the item in USD
            quantity: Quantity of codes in the item
            order_id: Id of the associated order
            created_at
            updated_at
    */

    protected $fillable = ['subtotal', 'quantity'];

    public function getId()
    {
        return $this->attributes['id'];
    }

    public function setId($id)
    {
        $this->attributes['id'] = $id;
    }

    public function getQuantity()
    {
        return $this->attributes['quantity'];
    }

    public function setQuantity($quantity)
    {
        $this->attributes['quantity'] = $quantity;
    }

    public function getOrderId()
    {
        return $this->attributes['order_id'];
    }

    public function setOrderId($order_id)
    {
        $this->attributes['order_id'] = $order_id;
    }

    public function getSubTotal()
    {
        return $this->attributes['subtotal'];
    }

    public function setSubTotal($subtotal)
    {
        $this->attributes['subtotal'] = $subtotal;
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function codes()
    {
        return $this->hasMany(Code::class);
    }
}
