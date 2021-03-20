<?php

namespace App\Http\Controllers;

use App\Models\CodeTemplate;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class CodeTemplateController extends Controller
{
    public function details($id)
    {
        $codeTemplate = [];

        try {
            $codeTemplate = CodeTemplate::withCount(['codes' => function ($query) {
                $query->where('used', 0);
            }])->findOrFail($id);
        } catch (ModelNotFoundException $e) {
            return redirect()->route('home.index')->with('error', __('messages.codeTemplate_notfound'));
        }

        return view('code.details')->with('codeTemplate', $codeTemplate);
    }

    public function details_admin($id)
    {
        $codeTemplate = [];

        try {
            $codeTemplate = CodeTemplate::with('codes')->findOrFail($id);
        } catch (ModelNotFoundException $e) {
            return redirect()->route('home.index')->with('error', __('messages.codeTemplate_notfound'));
        }

        return view('codeTemplate.details')->with('codeTemplate', $codeTemplate);
    }

    public function list_admin()
    {
        $codeTemplates = CodeTemplate::orderBy('id', 'ASC')->withCount(['codes' => function ($query) {
            $query->where('used', 0);
        }])->get();

        $data = [];
        $data['title'] = 'All code templates';
        $data['codeTemplates'] = $codeTemplates;

        return view('codeTemplate.list')->with('data', $data);
    }

    public function list()
    {
        $codeTemplates = CodeTemplate::whereHas('codes', function ($query) {
            $query->where('used', 0);
        })->get();

        $data = [];
        $data['title'] = 'All codes';
        $data['codeTemplates'] = $codeTemplates;

        return view('code.list')->with('data', $data);
    }

    public function create()
    {
        $data = [];
        $data['title'] = 'Add code template';

        return view('codeTemplate.create')->with('data', $data);
    }

    public function save(Request $request)
    {
        CodeTemplate::validate($request);
        CodeTemplate::create($request->all());

        return redirect()->route('home.index')->with('success', __('messages.add_success'));
    }

    public function delete($id)
    {
        CodeTemplate::find($id)->delete();

        return redirect()->route('home.index')->with('success', __('messages.delete_success'));
    }
}
