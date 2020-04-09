<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="stylesheet" href="{{asset('css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/style.css')}}">
    <link rel="stylesheet" href="{{asset('css/icofont.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/bootstrap-select.min.css')}}">

    <title>WexLang Reader</title>
</head>
<body>


@include("header")


<!-- Bootstrap row -->
<div class="row" id="body-row">
    <!-- Sidebar -->
    <div id="sidebar-container" class="sidebar-expanded col-2">

        <ul class="list-group sticky-top sticky-offset">

            <br>

            <a href="{{route('texts')}}" class="bg-dark list-group-item list-group-item-action"><i class="icofont-book"></i> {{__('My texts')}}</a>

            <a href="{{route('words')}}" class="bg-dark list-group-item list-group-item-action"><i class="icofont-file-text"></i> {{__('My words')}}</a>

            <br>

            <a href="{{route('add_text_page')}}" class="bg-dark list-group-item list-group-item-action"><i class="icofont-plus-square"></i> {{__('Add text')}}</a>

            <br>

            <a href="{{route('words_upload_dictionary')}}" class="bg-dark list-group-item list-group-item-action"><i class="icofont-upload"></i> {{__('Upload dictionary')}}</a>

            <br>

            <a href="{{route('settings')}}" class="bg-dark list-group-item list-group-item-action"><i class="icofont-gears"></i> {{__('Settings')}}</a>

            <a href="{{route('feedback')}}" class="bg-dark list-group-item list-group-item-action"><i class="icofont-mail"></i> {{__('Feedback')}}</a>

        </ul>

    </div>
    <!-- sidebar-container END -->

    <!-- MAIN -->
    <div class="col py-3">

        @yield('content')

    </div>
    <!-- Main Col END -->

</div>
<!-- body-row END -->


<div class="alert alert-success fade show" id="alert" style="position: fixed; top: 57px; right: 0; z-index: 9999999 !important; display: none;" >

    <strong>      Saved      </strong>

</div>


<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="{{ asset('js/jquery-3.4.1.min.js')}}"></script>
<script src="{{ asset('js/popper.min.js')}}"></script>
<script src="{{ asset('js/bootstrap.min.js')}}"></script>
<script src="{{ asset('js/bootstrap-select.min.js')}}"></script>

<!-- App JavaScript -->
<script src="{{asset('js/reader.js')}}"></script>
<script src="{{asset('js/js.cookie.js')}}"></script>

</body>
</html>
