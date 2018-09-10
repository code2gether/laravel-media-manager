@extends('layout')

@section('content')
<form action="{{ url('files/store') }}" method="POST" id="file-upload-form" class="uploader" enctype="multipart/form-data">
    {{csrf_field()}}
    @include('files.fields')
</form>
@endsection
