@extends('layouts.app')

@section('content')


<div class="container">

    {{ Breadcrumbs::render('home.index') }}

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
                    <a href="{{ route('code.list') }}" class="btn btn-primary btn-lg mt-2 mb-2"><i class="fas fa-store"></i> {{__('messages.see_shop')}}</a>
                    <a href="{{ route('code.random') }}" class="btn btn-primary btn-lg mt-2 mb-2"><i class="fas fa-question"></i> {{__('labels.lucky')}}</a><br />
                    @if(Auth::user()->role == "admin")
                    <i class="fas fa-users-cog"></i>{{__('labels.admin_zone')}}<br />
                    <a href="{{ route('codeTemplate.list') }}" class="btn btn-info btn-lg mt-2 mb-2"><i class="fas fa-tools"></i> {{__('messages.see_templates')}}</a>
                    <a href="{{ route('orders.list') }}" class="btn btn-info btn-lg mt-2 mb-2"><i class="fas fa-tools"></i> {{__('messages.see_orders')}}</a>

                    @endif
                </div>
                <a href="{{ route('home.locale', ['locale'=> 'en']) }}" class="btn btn-secondary float-right ">ENGLISH</a>
                <a href="{{ route('home.locale', ['locale'=> 'es']) }}" class="btn btn-secondary float-right ">SPANISH</a>
            </div>
        </div>
    </div>
</div>
@endsection