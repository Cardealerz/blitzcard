<?php

namespace App\Util;

use App\Interfaces\Mailer;
use App\Mail\PaymentMail;
use App\Models\PayHistory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class LaravelMailer implements Mailer {
    public function sendSuccess($request) {
        Mail::to(Auth::user()->email)->send(new PaymentMail(PayHistory::find($request['payment_id']), __('messages.thanks')));
    }

    public function sendError($request) {
        Mail::to(Auth::user()->email)->send(new PaymentMail(PayHistory::find($request['payment_id']), __('messages.purchase_error')));
    }
}
