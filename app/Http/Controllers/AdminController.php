<?php

namespace App\Http\Controllers;

use App\Models\Code;
use App\Models\CodeTemplate;
use App\Models\PayHistory;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller {
    public function details($id) {
        if (! Auth::check() || Auth::user()->role != 'admin') {
            return redirect()->route('home.index')->withErrors([__('messages.no_permission')]);
        }

        $codeTemplate = [];

        try {
            $codeTemplate = CodeTemplate::with('codes')->findOrFail($id);
        } catch (ModelNotFoundException $e) {
            return redirect()->route('home.index')->withErrors([('messages.codeTemplate_notfound')]);
        }

        return view('admin.codeTemplate.details')->with('codeTemplate', $codeTemplate);
    }

    public function list() {
        if (! Auth::check() || Auth::user()->role != 'admin') {
            return redirect()->route('home.index')->withErrors([__('messages.no_permission')]);
        }

        $codeTemplates = CodeTemplate::orderBy('id', 'ASC')->withCount(['codes' => function ($query) {
            $query->where('used', 0);
        }])->get();

        $data = [];
        $data['title'] = __('labels.all_code_templates');
        $data['codeTemplates'] = $codeTemplates;

        return view('admin.codeTemplate.list')->with('data', $data);
    }

    public function listOrders() {
        if (! Auth::check() || Auth::user()->role != 'admin') {
            return redirect()->route('home.index')->withErrors([__('messages.no_permission')]);
        }

        $data = [];
        $data['title'] = __('labels.all_orders');

        $payHistory = PayHistory::where('payment_type', '=', 'order')->latest()->get();
        $data['orders'] = $payHistory;

        return view('admin.orders.list')->with('data', $data);
    }

    public function orderDetails($payment_id) {
        if (! Auth::check()) {
            return redirect()->route('cart.index')->withErrors([__('messages.no_permission')]);
        }

        $payHistory = [];
        $payHistory = PayHistory::findOrFail($payment_id);

        return view('admin.orders.details')->with('payHistory', $payHistory);
    }

    public function create() {
        if (! Auth::check() || Auth::user()->role != 'admin') {
            return redirect()->route('home.index')->withErrors([__('messages.no_permission')]);
        }
        $data = [];
        $data['title'] = __('labels.add_code_template');

        return view('admin.codeTemplate.create')->with('data', $data);
    }

    public function save(Request $request) {
        if (! Auth::check() || Auth::user()->role != 'admin') {
            return redirect()->route('home.index')->withErrors([__('messages.no_permission')]);
        }
        CodeTemplate::validate($request);
        CodeTemplate::create($request->all());

        return redirect()->route('home.index')->with('success', __('messages.add_success'));
    }

    public function addCode(Request $request) {
        if (! Auth::check() || Auth::user()->role != 'admin') {
            return redirect()->route('home.index')->withErrors([__('messages.no_permission')]);
        }
        Code::validate($request);
        Code::create($request->all());

        return back();
    }

    public function update(Request $request) {
        if (! Auth::check() || Auth::user()->role != 'admin') {
            return redirect()->route('home.index')->withErrors([__('messages.no_permission')]);
        }
        $code = $request->get('code');
        $data = [];
        $data['title'] = __('labels.edit_code');
        $data['code'] = Code::with('codeTemplate')->where('id', '=', $code)->get()->first();
        $data['name'] = $data['code']->codeTemplate->toString();

        return view('admin.codeTemplate.edit')->with('data', $data);
    }

    public function saveUpdate(Request $request) {
        if (! Auth::check() || Auth::user()->role != 'admin') {
            return redirect()->route('home.index')->withErrors([__('messages.no_permission')]);
        }

        $codeId = $request->get('id');
        $code = Code::where('id', '=', $codeId)->get()->first();
        Code::validateChange($request, $code);
        $code->setUsed($request->get('used'));
        $code->setCode($request->get('code'));
        $code->save();

        $data = [];
        $data['title'] = __('labels.edit_code');

        return back()->with('success', __('messages.update_success'));
    }

    public function delete($id) {
        if (! Auth::check() || Auth::user()->role != 'admin') {
            return redirect()->route('home.index')->withErrors([__('messages.no_permission')]);
        }
        CodeTemplate::find($id)->delete();

        return redirect()->route('home.index')->with('success', __('messages.delete_success'));
    }
}
