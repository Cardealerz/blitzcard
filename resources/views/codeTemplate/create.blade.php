@extends('layouts.app')

@section("title", $data["title"])

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{__('messages.add_code_template')}}</div>
                <div class="card-body">
                    @if($errors->any())
                    <div class="alert alert-danger">
                        <ul id="errors">
                            @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                    <form method="POST" action="{{ route('codeTemplate.save') }}">
                        @csrf
                        <div class="row">
                            <div class="col">
                                <label>{{__('labels.enter'). ' '.__('labels.platform')}}:</label>

                            </div>
                            <div class="col">
                                <input type="text" class="form-control" placeholder={{__('labels.platform')}} name="platform" value="{{ old('platform') }}" />
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <label>{{__('labels.enter'). ' '.__('labels.value')}}:</label>
                            </div>
                            <div class="col">
                                <input type="number" min="0" class="form-control" placeholder={{__('labels.value')}} name="value" value="{{ old('value') }}" />
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <label>{{__('labels.enter'). ' '.__('labels.type')}}:</label>
                            </div>
                            <div class="col">
                                <input type="text" class="form-control" placeholder={{__('labels.type')}} name="type" value="{{ old('type') }}" />
                            </div>
                        </div>
                        <div class="col text-center pt-2">
                            <input type="submit" value={{__('labels.add')}} type="button" class="btn btn-primary" />
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection