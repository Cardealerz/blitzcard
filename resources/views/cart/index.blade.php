@extends('layouts.app')

@section("title", $data["title"])

@section('content')
<div class="container">
    @if(count($errors) > 0)
    <div class="alert alert-danger">
        <ul id="errors">
            @foreach($errors as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
    <div class="row justify-content-center">
        <div class="col-md-12">
            <h1>{{__('labels.products_cart')}}</h1>
            @if (count($data["productsInCart"]) > 0)
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th scope="col">{{__('labels.product')}}</th>
                        <th scope="col">{{__('labels.value')}}</th>
                        <th scope="col">{{__('labels.quantity')}}</th>
                        <th scope="col">{{__('labels.subtotal')}}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($data["productsInCart"] as $product)
                    <tr>
                        <td>{{$product->getPlatform()." ". $product->getType()}}</td>
                        <td>${{$product->getValue()}}</td>
                        <td>{{$data["quantities"][$product->getId()]}}</td>
                        <td>${{$data["quantities"][$product->getId()]*$product->getValue()}}</td>
                        <td><a href="{{ route('cart.removeItem', ['id' => $product->getId()]) }}" class="btn btn-outline-danger">&#10060;</a></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @else
            {{__('messages.empty_cart')}}
            @endif
            <a href="{{ route('cart.removeAll') }}">{{__('labels.remove_all_cart')}}</a><br /><br />
            <h5>{{__('labels.total_price')}}: ${{$data["total"]}}</h5>
            <a href="{{ route('cart.buy') }}" class="btn btn-primary  btn-lg">{{__('labels.buy')}}</a>
        </div>
    </div>
</div>
@endsection