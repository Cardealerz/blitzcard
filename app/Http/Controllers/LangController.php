<?php

namespace App\Http\Controllers;

class LangController extends Controller {
    public function setLocale($locale) {
        \Session::put('locale', $locale);

        return redirect()->back();
    }
}
