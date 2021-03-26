@extends('layouts.app')

@section("title", $payHistory->getUuid())

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                @if($errors->any())
                <div class="alert alert-danger">
                    <ul id="errors">
                        @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif
                <div class="card-header">{{ $payHistory->getUuid() }}</div>
                <div class="card-body">
                    <b>{{__('labels.amount')}}:</b> ${{ $payHistory->getAmount() }}<br />
                    <b>{{__('labels.type')}}:</b> {{ $payHistory->getPaymentType() }}<br />
                    <b>{{__('labels.order')}}:</b> {{ $payHistory->getOrderId() }}<br />
                    <b>{{__('labels.status')}}:</b> {{ $payHistory->getPaymentStatus() }}<br />
                    <b>{{__('labels.date')}}:</b> {{ $payHistory->getPaymentDate() }}<br />
                    @if ($payHistory->getPaymentType() == "order")
                    <b>{{__('labels.codes')}}: </b><br />

                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th scope="col">{{__('labels.name')}}</th>
                                <th scope="col">{{__('labels.code')}}</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse($payHistory->codes() as $code)
                            <tr>
                                <td>{{$code["name"]}}</td>
                                <td>{{$code["code"]}}</td>
                            </tr>
                            @empty
                            <b>{{__('messages.no_codes')}}</b><br />
                            @endforelse
                        </tbody>
                    </table>
                    @else
                    <b>{{__('labels.payment_method')}}:</b> {{ $payHistory->getPaymentMethod() }}<br />
                    @endif

                    <a class="btn btn-primary" href="{{ route('payhistory.showAll') }}">{{__('labels.back')}}</a><br /><br />

                </div>
            </div>
        </div>
    </div>
</div>
@endsection