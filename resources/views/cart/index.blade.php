@extends('layouts.app')

@section("title", $data["title"])

@section('content')
<div class="container">
    @if($errors->any())
    <div class="alert alert-danger">
        <ul id="errors">
            @foreach($errors->all() as $error)
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
                    <tr class="table-primary">
                        <th scope="col">{{__('labels.product')}}</th>
                        <th scope="col">{{__('labels.value')}}</th>
                        <th scope="col">{{__('labels.quantity')}}</th>
                        <th scope="col">{{__('labels.subtotal')}}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($data["productsInCart"] as $product)
                    <tr>
                        <td><a href="{{ route('code.details', ['id'=> $product->getId()]) }}">{{$product->getPlatform()." ". $product->getType()}}</a></td>
                        <td>${{$product->getValue()}}</td>
                        <td>{{$data["quantities"][$product->getId()]}}</td>
                        <td>${{$data["quantities"][$product->getId()]*$product->getValue()}}</td>
                        <td style="width:1%"><a href="{{ route('cart.removeItem', ['id' => $product->getId()]) }}" class="btn btn-outline-danger"><i class="fas fa-times"></i></a></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <a href="{{ route('cart.removeAll') }}">{{__('labels.remove_all_cart')}}</a><br />
            @else
            {{__('messages.empty_cart')}}<br />
            @endif
            <br />
            <h5>{{__('labels.total_price')}}: ${{$data["total"]}}</h5>
            <a href="{{ route('cart.buy') }}" class="btn btn-primary  btn-lg mb-1">{{__('labels.buy')}}</a><br />
            <a href="{{ route('code.list') }}" class="btn btn-secondary  btn">{{__('labels.continue_shopping')}}</a>
        </div>
    </div>
</div>
@endsection