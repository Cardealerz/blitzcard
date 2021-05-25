@extends('layouts.app')

@section('content')


<div class="container">
    {{ Breadcrumbs::render('responses.animes') }}

    <h1>{{__('messages.animes_list')}} </h1>

    <div class="row">
        @if(count($animes->anime) > 0)
        @foreach ($animes->anime as $anime)
        <div class="col-sm-3 m-1">
            <div class="card">
                <div class="card-body">
                    {{ $anime->title }}
                </div>
            </div>
        </div>
        @endforeach
        @else
        <div class="col-sm-12 m-1">
            <div class="card">
                <div class="card-body">
                    {{__('messages.no_anime')}}
                </div>
            </div>
        </div>
        @endif

    </div>

</div>
@endsection