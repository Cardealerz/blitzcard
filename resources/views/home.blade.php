@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">

            @if($errors->any())
            <div class="alert alert-danger">
                <ul id="errors">
                    @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            @if(Session::has('success'))
            <div class="alert alert-info">
                {{Session::get('success')}}
            </div>
            @endif

            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>
                <div class="card-body">
                    @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                    @endif

                    {{ __('messages.welcome').", ". Auth::user()->name }}<br />
                    <a href="{{ route('code.list') }}" class="btn btn-primary">{{__('messages.see_shop')}}</a>
                    <a href="{{ route('code.random') }}" class="btn btn-primary">{{__('labels.lucky')}}</a>
                    @if(Auth::user()->role == "admin")
                    <a href="{{ route('codeTemplate.list') }}" class="btn btn-primary">{{__('messages.see_templates')}}</a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection