<header class="row border-bottom sticky-top header">

    <div class="container align-self-center nopadding">

        <div class="row align-items-center">

            <div class="col-md-12 col-lg-2">
                <a href="/" class="logo">
                    WexLang
                    {{--<img src="https://2code.info/demo/themes/Discy/Main/wp-content/themes/discy/images/logo.png" alt="">--}}
                </a>
            </div>

            <nav class="col-md-12 col-lg header-menu">

                <a href="{{ route('reader_texts') }}">{{__('READER')}}</a>


            </nav>

            <div class="col-md-12 col-lg-auto nav-left">


                <div class="row align-items-center">

                    {{--SITE LANGUAGE DROPDOWN --}}

                    <div class="col-auto">

{{--                        <div class="dropdown">--}}
{{--                            <a class="btn btn-secondary dropdown-toggle" href="#" role="button" id="lang_dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">--}}

{{--                                @php $locale = session()->get('locale'); @endphp--}}

{{--                                @switch($locale)--}}
{{--                                    @case('en')--}}
{{--                                    <img src="{{asset('img/flags/'. \App\Config\Lang::get(0)['code'] .'.svg')}}" class="text_flag" alt="">--}}
{{--                                    {{\App\Config\Lang::get(21)['title']}}--}}
{{--                                    @break--}}
{{--                                    @case('ru')--}}
{{--                                    <img src="{{asset('img/flags/'. \App\Config\Lang::get(1)['code'] .'.svg')}}" class="text_flag" alt="">--}}
{{--                                    {{\App\Config\Lang::get(75)['title']}}--}}
{{--                                    @break--}}
{{--                                    @default--}}
{{--                                    <img src="{{asset('img/flags/'. \App\Config\Lang::get(0)['code'] .'.svg')}}" class="text_flag" alt="">--}}
{{--                                    {{\App\Config\Lang::get(21)['title']}}--}}
{{--                                @endswitch--}}

{{--                            </a>--}}

{{--                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="lang_dropdown">--}}
{{--                                <a class="dropdown-item" href="{{route('set_locale', \App\Config\Lang::get(21)['code'])}}">--}}
{{--                                    <img src="{{asset('img/flags/'. \App\Config\Lang::get(21)['code'] .'.svg')}}" class="text_flag" alt="">--}}
{{--                                    {{\App\Config\Lang::get(21)['title']}}--}}
{{--                                </a>--}}
{{--                                <a class="dropdown-item" href="{{route('set_locale', \App\Config\Lang::get(75)['code'])}}">--}}
{{--                                    <img src="{{asset('img/flags/'. \App\Config\Lang::get(75)['code'] .'.svg')}}" class="text_flag" alt="">--}}
{{--                                    {{\App\Config\Lang::get(75)['title']}}--}}
{{--                                </a>--}}
{{--                            </div>--}}
{{--                        </div>--}}

                    </div>




                </div>


            </div>

        </div>

    </div>


</header>
