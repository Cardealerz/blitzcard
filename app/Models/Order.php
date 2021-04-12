<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    /*
        Atributes:
            id
            user_id: Id of the associated user
            total: Total price of order in USD
            created_at
            updated_at
    */

    protected $fillable = ['total'];

    public function getId()
    {
        return $this->attributes['id'];
    }

    public function setId($id)
    {
        $this->attributes['id'] = $id;
    }

    public function getUserId()
    {
        return $this->attributes['user_id'];
    }

    public function setUserId($user_id)
    {
        $this->attributes['user_id'] = $user_id;
    }

    public function getPayHistoryId()
    {
        return $this->attributes['payhistory_id'];
    }

    public function setPayHistoryId($payHistory_id)
    {
        $this->attributes['payhistory_id'] = $payHistory_id;
    }

    public function getTotal()
    {
        return $this->attributes['total'];
    }

    public function setTotal($total)
    {
        $this->attributes['total'] = $total;
    }

    public function items()
    {
        return $this->hasMany(Item::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function payment()
    {
        return $this->hasOne(PayHistory::class);
    }
}
