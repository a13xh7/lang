<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="stylesheet" href="{{asset('css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/style.css')}}">
    <link rel="stylesheet" href="{{asset('css/icofont.min.css')}}">
    <link rel="stylesheet" href="{{ asset('css/bootstrap-select.min.css')}}">

    <title>WexLang</title>

</head>
<body>


<!-- Bootstrap NavBar -->
<nav class="navbar navbar-dark bg-dark fixed-top">

    <a class="navbar-brand" href="#">
        <img src="https://v4-alpha.getbootstrap.com/assets/brand/bootstrap-solid.svg" width="30" height="30" class="d-inline-block align-top" alt="">
        <span>WexLang</span>
    </a>

{{--    <ul class="navbar-nav">--}}
{{--        <li class="nav-item">--}}
{{--            <a class="nav-link" href="#">Home</a>--}}
{{--        </li>--}}
{{--    </ul>--}}

</nav>
<!-- NavBar END -->

<!-- Bootstrap row -->
<div class="row" id="body-row">
    <!-- Sidebar -->
    <div id="sidebar-container" class="sidebar-expanded col-2">

        <ul class="list-group sticky-top sticky-offset">

            <br>

            <a href="{{route('texts')}}" class="bg-dark list-group-item list-group-item-action"><i class="icofont-book"></i> {{__('My Texts')}}</a>

            <a href="{{route('add_text_page')}}" class="bg-dark list-group-item list-group-item-action"><i class="icofont-plus-square"></i> {{__('Add text')}}</a>

            <a href="{{route('words')}}" class="bg-dark list-group-item list-group-item-action"><i class="icofont-file-text"></i> {{__('My words')}}</a>

            <a href="" class="bg-dark list-group-item list-group-item-action"><i class="icofont-file-text"></i> {{__('Upload dictionary')}}</a>

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


<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>

<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.10/dist/js/bootstrap-select.min.js"></script>


<!-- App JavaScript -->
<script src="{{asset('js/reader.js')}}"></script>
<script src="{{asset('js/js.cookie.js')}}"></script>


</body>
</html>
