@extends('layouts.app')

@section("title", $data["title"])

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            {{__('messages.thanks')}}
        </div>
    </div>
</div>
@endsection