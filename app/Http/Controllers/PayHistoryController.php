<?php

namespace App\Http\Controllers;
use App\Models\PayHistory;
use Illuminate\Support\Facades\Auth;
use PDF;

class PayHistoryController extends Controller{

        public function showAll(){
        if (! Auth::check()) {
            return redirect()->route('cart.index')->withErrors([__('messages.no_permission')]);
        }

        $data = [];
        $data["title"] = "User Payments";

        $payHistory = PayHistory::where('user_id', '=', Auth::user()->id)->latest()->get();
        $data['pay_history'] = $payHistory;
        return view('payHistory.showAll')->with('data', $data);
    }

    public function showOne($payment_id){
        if (! Auth::check()) {
            return redirect()->route('cart.index')->withErrors([__('messages.no_permission')]);
        }
        
        $payHistory = [];
        $payHistory = PayHistory::findOrFail($payment_id);

        return view('payHistory.showOne')->with('payHistory', $payHistory);
    }

    public function createPDF($payment_id){
        if (! Auth::check()) {
            return redirect()->route('cart.index')->withErrors([__('messages.no_permission')]);
        }

        $payHistory = [];
        $payHistory = PayHistory::findOrFail($payment_id);
        
        view()->share('payHistory',$payHistory);
        $pdf = PDF::loadView('payHistory.pdfview');

        $fileName ='invoice '.$payHistory->getUuid() . ' ' . '.pdf';
        return $pdf->download($fileName);
    }


    


   
}
