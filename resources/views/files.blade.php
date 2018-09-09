<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel Media Manager</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">

        <!-- Styles -->
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    </head>
    <body>
        <h2>Laravel Media Manager with Filesystem</h2>
        <p class="lead">You can upload any types of files<b>JPG,PNG,DOC,MP4,MP3, etc</b></p>

        <!-- Upload  -->
        <form action="/files/add" method="POST" id="file-upload-form" class="uploader" enctype="multipart/form-data">
            {{csrf_field()}}
            @include('includes.fields')
        </form>

        <div class="cards">
            @foreach ($files as $file)
                @include('includes.card')
            @endforeach
        </div>
    </body>
</html>
