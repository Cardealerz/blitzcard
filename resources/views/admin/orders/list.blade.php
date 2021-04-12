@extends('layouts.app')

@section("title", $data["title"])

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            @forelse($data["orders"] as $payHistory)
            @php
            $paymentStatus = $payHistory->getPaymentStatus();
            @endphp
            <div class="card mb-2">
                <div class="card-body">
                    <p class="card-text" style="color:blue; font-family: Nunito">{{__('labels.payment_uuid')}}: {{$payHistory->getUuId()}}</p>
                    <p class="card-text" style="color:blue; font-family: Nunito">{{__('labels.user')}}: {{$payHistory->getUserId()}}</p>

                    <p class="card-text">{{__('labels.date')}}: {{$payHistory->getPaymentDate()}}</p>
                    <p class="card-text">{{__('labels.amount')}}: {{$payHistory->getAmount()}}</p>

                    @if ($paymentStatus == "accepted")
                    <p class="card-text" style="color:green; font-family: Nunito">{{__('labels.status')}}: {{$paymentStatus}}</p>
                    @elseif($paymentStatus == "pending")
                    <p class="card-text" style="color:orange; font-family: Nunito">{{__('labels.status')}}: {{$paymentStatus}}</p>
                    @else
                    <p class="card-text" style="color:red; font-family: Nunito">{{__('labels.status')}}: {{$paymentStatus}}</p>
                    @endif

                    <a href="{{ route('payhistory.showOne',['payment_id' => $payHistory->getId()]) }}" class="btn btn-secondary float-right ">{{__('labels.view_details')}}</a>
                    <a href="{{ route('payhistory.createPDF',['payment_id' => $payHistory->getId()]) }}" class="btn btn-primary float-right mr-1"><i class="fas fa-download"></i> {{__('labels.create_pdf')}}</a>
                </div>
            </div>
            @empty
            <b>{{__('messages.no_payments')}}</b>
            @endforelse
            <a href="{{route('home.index')}}" class="btn btn-primary">{{__('labels.back_home')}}</a><br />
        </div>
    </div>
</div>
@endsection