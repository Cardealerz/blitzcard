<?php

namespace App\Http\Controllers;

use App\Models\Code;
use App\Models\CodeTemplate;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
            return redirect()->route('home.index')->withErrors([__('messages.codeTemplate_notfound')]);
        }

        return view('code.details')->with('codeTemplate', $codeTemplate);
    }

    public function details_admin($id)
    {
        if (! Auth::check() || Auth::user()->role != 'admin') {
            return redirect()->route('home.index')->withErrors([__('messages.no_permission')]);
        }

        $codeTemplate = [];

        try {
            $codeTemplate = CodeTemplate::with('codes')->findOrFail($id);
        } catch (ModelNotFoundException $e) {
            return redirect()->route('home.index')->withErrors([('messages.codeTemplate_notfound')]);
        }

        return view('codeTemplate.details')->with('codeTemplate', $codeTemplate);
    }

    public function list_admin()
    {
        if (! Auth::check() || Auth::user()->role != 'admin') {
            return redirect()->route('home.index')->withErrors([__('messages.no_permission')]);
        }

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
        if (! Auth::check() || Auth::user()->role != 'admin') {
            return redirect()->route('home.index')->withErrors([__('messages.no_permission')]);
        }
        CodeTemplate::validate($request);
        CodeTemplate::create($request->all());

        return redirect()->route('home.index')->with('success', __('messages.add_success'));
    }

    public function add_code(Request $request)
    {
        if (! Auth::check() || Auth::user()->role != 'admin') {
            return redirect()->route('home.index')->withErrors([__('messages.no_permission')]);
        }
        Code::validate($request);
        Code::create($request->all());

        return back();
    }

    public function delete($id)
    {
        if (! Auth::check() || Auth::user()->role != 'admin') {
            return redirect()->route('home.index')->withErrors([__('messages.no_permission')]);
        }
        CodeTemplate::find($id)->delete();

        return redirect()->route('home.index')->with('success', __('messages.delete_success'));
    }
}