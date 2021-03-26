@extends('layouts.app')

@section("title", $data["title"])

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            @if(isset($data["search"]))
            <span class="align-bottom">
                {{__('messages.viewing_results')}}<a href="{{route('code.list')}}" style="color: red"> {{$data["search"]}} <i class="fas fa-times"></i> </a>
            </span>
            @endif
            @forelse($data["codeTemplates"] as $codeTemplate)
            <div class="card mb-2">
                <div class="card-body">
                    <p class="card-text">
                    <h4>{{$codeTemplate->getName()}}</h4>
                    </p>
                    <a href="{{ route('code.details', ['id'=> $codeTemplate->getId()]) }}" class="btn btn-secondary float-right ">{{__('labels.view_details')}}</a>
                    <a href="{{ route('cart.addOne', ['id'=> $codeTemplate->getId()]) }}" class="btn btn-primary float-right mr-1">{{__('labels.add_cart')}}</a>
                </div>
            </div>
            @empty
            <b>{{__('messages.no_codes')}}</b><br />
            @endforelse
            <a href="{{route('home.index')}}" class="btn btn-primary">{{__('labels.back_home')}}</a><br />
        </div>
    </div>
</div>
@endsection