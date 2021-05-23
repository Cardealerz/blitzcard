@extends('layouts.app')

@section('content')


<div class="container">
    <h1>Animes </h1>

    <div class="row">
        @foreach ($animes->anime as $anime)
            <div class="col-sm-3 m-1">
                <div class="card">
                    <div class="card-body">
                        {{ $anime->title }}
                    </div>
                </div>
            </div>
        @endforeach
    </div>

</div>
@endsection