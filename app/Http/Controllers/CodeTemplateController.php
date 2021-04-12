<?php

namespace App\Http\Controllers;

use App\Models\CodeTemplate;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class CodeTemplateController extends Controller {
    public function search(Request $request) {
        $param = $request->get('param');

        $codeTemplates = CodeTemplate::orderBy('id', 'ASC')->withCount(['codes' => function ($query) use ($param) {
            $query->where('used', 0);
        }])->where('platform', 'LIKE', "%{$param}%")->orWhere('type', 'LIKE', "%{$param}%")->get();

        $data = [];
        $data['title'] = __('labels.search_results');
        $data['codeTemplates'] = $codeTemplates;
        $data['search'] = $param;

        return view('code.list')->with('data', $data);
    }

    public function details($id) {
        $codeTemplate = [];

        try {
            $codeTemplate = CodeTemplate::withCount(['codes' => function ($query) {
                $query->where('used', 0);
            }])->findOrFail($id);
        } catch (ModelNotFoundException $e) {
            return redirect()->route('home.index')->withErrors([__('messages.codeTemplate_notfound')]);
        }

        return view('code.details')->with('codeTemplate', $codeTemplate);
    }

    public function list() {
        $codeTemplates = CodeTemplate::whereHas('codes', function ($query) {
            $query->where('used', 0);
        })->get();

        $data = [];
        $data['title'] = __('labels.all_codes');
        $data['codeTemplates'] = $codeTemplates;

        return view('code.list')->with('data', $data);
    }

    public function random() {
        //CodeTemplate::inRandomOrder()->first();
        $codeTemplate = CodeTemplate::whereHas('codes', function ($query) {
            $query->where('used', 0);
        })->inRandomOrder()->first();

        if ($codeTemplate != null) {
            return redirect()->route('code.details', [$codeTemplate->getId()]);
        } else {
            return redirect()->route('home.index')->withErrors([__('messages.no_codes')]);
        }
    }
}
