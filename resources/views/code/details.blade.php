@extends('layouts.app')

@section("title", $codeTemplate->getPlatform())

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">${{$codeTemplate->getValue()." ". $codeTemplate->getPlatform()." ". $codeTemplate->getType()}}</div>

                <div class="card-body">

                    <b>{{__('labels.value')}}:</b> ${{ $codeTemplate->getValue() }}<br />
                    <b>{{__('labels.platform')}}:</b> {{ $codeTemplate->getPlatform() }}<br />
                    <b>{{__('labels.type')}}:</b> {{ $codeTemplate->getType() }}<br />
                    <b>{{__('labels.available')}}:</b> {{ $codeTemplate->codes_count}}<br /><br />
                    <form method="POST" action="{{ route('cart.add') }}">
                        @csrf
                        <input type="hidden" name="id" value="{{$codeTemplate->getId()}}">
                        <div class="row align-items-center mb-2">
                            <div class="col-sm-2">
                                <input class="form-control" type="number" name="quantity" value="1" min="1" max="{{$codeTemplate->codes_count}}">
                            </div>
                            <div class="col-sm-2">
                                <input type="submit" value="{{__('labels.add_cart')}}" type="button" class="btn btn-primary" />
                            </div>
                        </div>
                    </form>
                    <a href="{{ route('code.list') }}" class="btn btn-primary">{{__('labels.back')}}</a><br /><br />

                </div>
            </div>
        </div>
    </div>
</div>
@endsection