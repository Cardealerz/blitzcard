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
                        <td>{{$codeTemplate->getName()}}</td>
                        <td>{{$codeTemplate->codes_count}}</button></td>
                        <td><a class="btn btn-primary" href="{{ route('codeTemplate.details',['id' => $codeTemplate->getId()]) }}">{{__('labels.details')}}</a></td>
                    </tr>
                    @empty
                    <b>{{__('messages.no_code_templates')}}</b>
                    @endforelse
                </tbody>
            </table>
            <a href="{{route('codeTemplate.create')}}" class="btn btn-primary">{{__('messages.add_code_template')}}</a><br /><br />
            <a href="{{route('home.index')}}" class="btn btn-primary">{{__('labels.back_home')}}</a><br />
        </div>
    </div>
</div>
@endsection