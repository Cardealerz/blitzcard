<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\PayHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller{

    public static function AddFunds($user_id, $amount){

        $user = User::findOrFail($user_id);
        $user_funds = $user->getFunds();

        $user->setFunds($user_funds + $amount);
        
        return true;

    }

    public static function SubtractFunds($user_id, $amount){

        $user = User::findOrFail($user_id);
        $user_funds = $user->getFunds();

        $new_funds = $user_funds - $amount;
        if($new_funds < 0){
            return false;
        }

        $user->setFunds($new_funds);
        return true;
    }
}
