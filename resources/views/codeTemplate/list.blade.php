@extends('layouts.app')

@section("title", $data["title"])

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th scope="col">{{__('labels.id')}}</th>
                        <th scope="col">{{__('labels.platform')}}</th>
                        <th scope="col">{{__('labels.available')}}</th>
                        <th scope="col">{{__('labels.details')}}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($data["codeTemplates"] as $codeTemplate)
                    <tr>
                        <th scope="row">{{$codeTemplate->getId()}}</th>
                        <td>{{$codeTemplate->getPlatform()}}</td>
                        <td>{{$codeTemplate->codes_count}}</button></td>
                        <td><button type=" button" class="btn btn-primary" onclick="window.location='{{ route("codeTemplate.details",['id' => $codeTemplate->getId()]) }}'">{{__('labels.details')}}</button></td>
                    </tr>
                    @empty
                    <b>{{__('messages.no_code_templates')}}</b>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection