@extends('layouts.app')

@section("title", $data["title"])

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            @forelse($data["codeTemplates"] as $codeTemplate)
            <div class="card mb-2">
                <div class="card-body">
                    <p class="card-text">{{"$". $codeTemplate->getValue()." ". $codeTemplate->getPlatform()." ". $codeTemplate->getType()}}</p>
                    <a href="{{ route('code.details', ['id'=> $codeTemplate->getId()]) }}" class="btn btn-secondary float-right ">{{__('labels.view_details')}}</a>
                    <a href="{{ route('cart.addOne', ['id'=> $codeTemplate->getId()]) }}" class="btn btn-primary float-right mr-1">{{__('labels.add_cart')}}</a>
                </div>
            </div>
            @empty
            <b>{{__('messages.no_code_templates')}}</b>
            @endforelse
        </div>
    </div>
</div>
@endsection