@extends('layouts.app')

@section("title", $data["title"])

@section('content')
<div class="container">

    {{ Breadcrumbs::render('cart.buy') }}

    <div class="row justify-content-center">
        <div class="col-md-12">
            {{__('messages.thanks')}}
        </div>
    </div>
</div>
@endsection