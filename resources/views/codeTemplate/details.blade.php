@extends('layouts.app')

@section("title", $codeTemplate->getPlatform())

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
                <div class="card-header">{{ $codeTemplate->getPlatform() }}</div>
                <div class="card-body">
                    <b>{{__('labels.value')}}:</b> ${{ $codeTemplate->getValue() }}<br />
                    <b>{{__('labels.type')}}:</b> {{ $codeTemplate->getType() }}<br />
                    <b>{{__('labels.codes')}}: </b><br />

                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th scope="col">{{__('labels.code')}}</th>
                                <th scope="col">{{__('labels.status')}}</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse($codeTemplate->codes as $code)
                            <tr>
                                <td>{{$code->getCode()}}</td>
                                <td>{{$code->getUsed() ? __('labels.used') : __('labels.unused')}}</td>
                            </tr>

                            @empty
                            <b>{{__('messages.no_codes')}}</b><br />
                            @endforelse
                        </tbody>
                    </table>

                    {{__('labels.add_new_code')}}
                    <form method="POST" action="{{ route('codeTemplate.add_code') }}">
                        @csrf
                        <input type="hidden" class="form-control" name="code_template_id" value="{{$codeTemplate->getId()}}" />
                        <div class="row align-items-center mb-2">
                            <div class="col-sm-7">
                                <input type="text" class="form-control" name="code" value="{{old('value')}}" />
                            </div>
                            <div class="col-sm">
                                <button type="submit" class="btn btn-primary" title="{{__('labels.add')}}"><i class="fas fa-plus"></i></button>
                            </div>
                        </div>
                    </form>

                    <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#exampleModal">
                        {{__('labels.delete')}}
                    </button><br /><br />

                    <a class="btn btn-primary" href="{{ route('codeTemplate.list') }}">{{__('labels.back')}}</a><br /><br />

                    <!-- Delete confirmation modal -->
                    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">{{__('messages.confirmation')}}</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    {{__('messages.cannot_undo')}}
                                </div>
                                <div class="modal-footer">
                                    <form id="delete-form" method="POST" action="{{ route('codeTemplate.delete', ['id' => $codeTemplate->getId()]) }}">
                                        {{ csrf_field() }}
                                        {{ method_field('DELETE') }}
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('labels.cancel')}}</button>
                                        <input type="submit" class="btn btn-danger" value="{{__('labels.delete')}}">
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection