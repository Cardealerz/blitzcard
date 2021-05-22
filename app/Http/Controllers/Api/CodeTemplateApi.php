<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CodeTemplate;

class CodeTemplateApi extends Controller {
    public function list() {
        $codeTemplates = CodeTemplate::whereHas('codes', function ($query) {
            $query->where('used', 0);
        })->get();

        return response()->json($codeTemplates);
    }
}
