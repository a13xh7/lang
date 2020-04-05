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

    <title>WexLang</title>
</head>
<body>


@include("header")


<!-- Bootstrap row -->
<div class="row" id="body-row">
    <!-- Sidebar -->
    <div id="sidebar-container" class="sidebar-expanded col-2">

        <ul class="list-group sticky-top sticky-offset">

            <br>

            <a href="{{route('texts')}}" class="bg-dark list-group-item list-group-item-action"><i class="icofont-book"></i> My Texts</a>

            <a href="{{route('add_text_page')}}" class="bg-dark list-group-item list-group-item-action"><i class="icofont-plus-square"></i> Add text</a>

            <a href="{{route('words')}}" class="bg-dark list-group-item list-group-item-action"><i class="icofont-file-text"></i> My words</a>

            <a href="{{route('words_upload_dictionary')}}" class="bg-dark list-group-item list-group-item-action"><i class="icofont-upload"></i> Upload dictionary</a>

            <a href="{{route('settings')}}" class="bg-dark list-group-item list-group-item-action"><i class="icofont-gears"></i> Settings</a>

            <a href="" class="bg-dark list-group-item list-group-item-action"><i class="icofont-upload"></i> FAQ</a>

            <a href="{{route('settings')}}" class="bg-dark list-group-item list-group-item-action"><i class="icofont-mail"></i> Feedback</a>

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
