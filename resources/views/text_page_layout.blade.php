<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <!-- App CSS -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/icofont.min.css') }}">

    <title>WexLang</title>

</head>
<body>


<div class="container-fluid">

    <!-- HEADER START-->
    <header class="row border-bottom sticky-top header">

        <div class="container align-self-center nopadding">

            <div class="row align-items-center">

                <div class="col-md-12 col-lg-2">
                    <a href="/" class="logo">
                        WexLang
                    </a>
                </div>

            </div>

        </div>

    </header>

    <!-- HEADER END-->


    <!-- MAIN CONTENT START-->
    <main class="row">

        <div class="container-fluid">

            <div class="row">


                <div class="col reader_main_content">

                    @yield('content')

                </div>

            </div>
        </div>

    </main>
    <!-- MAIN CONTENT END-->



</div>

<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.10/dist/js/bootstrap-select.min.js"></script>


<!-- App JavaScript -->
<script src="{{asset('js/reader.js')}}"></script>
<script src="{{asset('js/js.cookie.js')}}"></script>



@yield('js')

</body>
</html>
