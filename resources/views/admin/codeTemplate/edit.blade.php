@extends('layouts.app')

@section("title", $data['title'])

@section('content')
<div class="container">


    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
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
                <div class="card-header">{{__('labels.edit_code')}}</div>
                <div class="card-body">
                    {{__('labels.editing').$data['name']}}
                    <form method="POST" action="{{ route('codeTemplate.saveUpdate') }}">
                        @csrf
                        <input type="hidden" class="form-control" name="id" value="{{$data['code']->getId()}}" />

                        <div class="row align-items-center mb-2">
                            <div class="col-sm-7">
                                <input type="text" class="form-control" name="code" value="{{$data['code']->getCode()}}" />
                            </div>
                            <div class="col-sm">
                                <select class="form-select" name="used">
                                    <option value='0'>{{__('labels.unused')}}</option>
                                    <option value="1" {{ $data['code']->getUsed() ? 'selected' : '' }}>{{__('labels.used')}}</option>
                                </select>
                            </div>
                            <div class="col-sm">
                                <button type="submit" class="btn btn-primary" title="{{__('labels.add')}}"><i class="fas fa-save"></i></button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection