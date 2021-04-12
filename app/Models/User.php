<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username',
        'address',
        // 'birthday',
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /*
        Atributes:
            id
            username: Name of the user
            address: Home address of the user
            birthday: User's birthday
            name: User's name
            email: User's email
            role: User's role, defines clearance in the platform
            funds: User's current available funds
            created_at
            updated_at
    */

    public function getId()
    {
        return $this->attributes['id'];
    }

    public function setId($id)
    {
        return $this->attributes['id'] = $id;
    }

    public function getUsername()
    {
        return $this->attributes['username'];
    }

    public function setUsername($username)
    {
        return $this->attributes['username'] = $username;
    }

    public function getAddress()
    {
        return $this->attributes['address'];
    }

    public function setAddress($address)
    {
        return $this->attributes['address'] = $address;
    }

    public function getBirthday()
    {
        return $this->attributes['birthday'];
    }

    public function setBirthday($birthday)
    {
        return $this->attributes['birthday'] = $birthday;
    }

    public function getName()
    {
        return $this->attributes['name'];
    }

    public function setName($name)
    {
        return $this->attributes['name'] = $name;
    }

    public function getEmail()
    {
        return $this->attributes['email'];
    }

    public function setEmail($email)
    {
        return $this->attributes['email'] = $email;
    }

    public function getRole()
    {
        return $this->attributes['role'];
    }

    public function setRole($role)
    {
        return $this->attributes['role'] = $role;
    }

    public function getFunds()
    {
        return $this->attributes['funds'];
    }

    public function setFunds($funds)
    {
        return $this->attributes['funds'] = $funds;
    }

    public function addFunds($amount)
    {
        $current_funds = $this->getFunds();
        $this->setFunds($current_funds + $amount);
    }

    public function subtractFunds($amount)
    {
        $current_funds = $this->getFunds();
        $new_funds = $current_funds - $amount;
        if ($new_funds < 0) {
            return false;
        }

        $this->setFunds($new_funds);
        $this->save();

        return true;
    }

    public function orders()
    {
        return $this->HasMany(Order::class);
    }

    public function payments()
    {
        return $this->HasMany(PayHistory::class);
    }
}
