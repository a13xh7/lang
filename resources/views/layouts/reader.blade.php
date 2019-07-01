
@include('layouts.header')

<main style="min-height: 700px">


    <main style="min-height: 700px">
        <div class="w3-row">


            <div class="w3-container w3-quarter">
                <ul class="w3-ul w3-border">
                    <li><a href="{{ route('reader_add_text_page') }}">ADD TEXT</a></li>
                    <li><a href="{{ route('reader_texts') }}">MY TEXTS</a></li>
                    <li><a href="{{ route('reader_words') }}">MY WORDS</a></li>

                    <hr>
                    <hr>

                    <li><a href="">FIND GROUPS</a></li>
                    <li><a href="{{ route('reader_my_groups') }}">MY GROUPS</a></li>
                    <li><a href="">GROUP TEXTS</a></li>
                    <li><a href="">GROUP QUESTIONS</a></li>
                    <li><a href="">CREATE GROUP</a></li>

                    <hr>
                    <li><a href="{{ route('reader_faq') }}">FAQ</a></li>

                </ul>

            </div>

            <div class="w3-container w3-half">
                @yield('content')
            </div>

            <div class="w3-container w3-quarter">
                @yield('right_sidebar')
            </div>
        </div>

    </main>

</main>

@include('layouts.footer')

