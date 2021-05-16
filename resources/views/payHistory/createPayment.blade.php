@extends('layouts.app')

@section("title", $data["title"])

@section('content')
<div class="container">

    

    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{__('messages.create_payment')}}</div>
                <div class="card-body">
                    @if($errors->any())
                    <div class="alert alert-danger">
                        <ul id="errors">
                            @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    <form method="POST" action="{{ route('payhistory.finish') }}">
                        @csrf
                        @php
                            $paymentData = $data["payment"];
                        @endphp
                        <input type="hidden" name="uuid" value="{{ $paymentData["uuid"]}}" />
                        <input type="hidden" name="user_id" value="{{ $paymentData["user_id"]}}" />
                        <input type="hidden" name="order_id" value="{{ $paymentData["order_id"]}}" />
                        <input type="hidden" name="payment_type" value="{{ $paymentData["payment_type"]}}" />
                        <input type="hidden" name="callback" value="{{ $paymentData["callback"]}}" />

                        <div class="row">
                            <div class="col">
                                <label>{{__('labels.enter'). ' '.__('labels.billing_address')}}:</label>

                            </div>
                            <div class="col">
                                <input type="text" class="form-control" placeholder={{__('labels.billing_address')}} name="billing_address" value="{{ old('billing_address') }}" />
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <input type="radio" class="form-control" name="payment_method" value="PayPal">
                                <label for="PayPal">PayPal</label>                            
                                <input type="radio" class="form-control" name="payment_method" value="PSE">
                                <label for="PSE">PSE</label>  
                            </div>
                        </div>
                        
                        <div class="col text-center pt-2">
                            <input type="submit" value={{__('labels.add')}} type="button" class="btn btn-primary" />
                        </div>
                    </form>

                </div>
            </div>
            <br />
            <a href="{{url()->previous()}}" class="btn btn-primary">{{__('labels.back')}}</a><br />
        </div>
    </div>
</div>
@endsection