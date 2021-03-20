@extends('layouts.app')

@section("title", $codeTemplate->getPlatform())

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ $codeTemplate->getPlatform() }}</div>

                <div class="card-body">
                    <b>{{__('labels.value')}}:</b> ${{ $codeTemplate->getValue() }}<br />
                    <b>{{__('labels.type')}}:</b> {{ $codeTemplate->getType() }}<br />
                    <b>{{__('labels.codes')}}: </b><br />
                    @forelse($codeTemplate->codes as $code)
                    {{__('labels.code'). " ". $code->getCode(). " ". __('labels.used'). " ". $code->getUsed()}}<br />
                    @empty
                    <b>{{__('messages.no_codes')}}</b><br />
                    @endforelse
                    <button type="button" class="btn btn-primary" onclick="window.location='{{ route("codeTemplate.list") }}'">{{__('labels.back')}}</button><br /><br />
                    <form id="delete-form" method="POST" action="{{ route('codeTemplate.delete', ['id' => $codeTemplate->getId()]) }}">
                        {{ csrf_field() }}
                        {{ method_field('DELETE') }}

                        <div class="form-group">
                            <input type="submit" class="btn btn-danger" value={{__('labels.delete')}}>
                        </div>
                    </form>


                </div>
            </div>
        </div>
    </div>
</div>
@endsection