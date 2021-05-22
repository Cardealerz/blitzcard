<?php

namespace App\Interfaces;

use Illuminate\Http\Request;

interface Mailer {
    public function sendSuccess(Request $request);

    public function sendError(Request $request);
}
