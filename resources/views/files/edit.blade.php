@extends('layout')

@section('content')
<form action="{{url('files', [$file->id])}}" method="POST" id="file-upload-form" class="uploader" enctype="multipart/form-data">
    {{csrf_field()}}
    {{method_field('PATCH')}}
    @include('files.fields')
</form>
@endsection
