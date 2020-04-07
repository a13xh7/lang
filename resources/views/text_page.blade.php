@extends('text_page_layout')

@section('content')

    {{-- PAGE CONTENT START--}}
    <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab" style="text-align: center;">

        <div class="page_text_wrapper">
            {!! $pageContent !!}
        </div>

        <div class="mt-3">
            {{$pages->links()}}
        </div>

    </div>
    {{-- PAGE CONTENT END--}}


@endsection
