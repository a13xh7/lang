<aside class="col-3 sidebar">

    <h4 class="px-3 mt-4 mb-1 reader_sidebar_block_name">
        <span>{{__('Read Together')}}</span>
    </h4>

    <div class="list-group list-group-flush">
        <a href="{{route('rt_my_texts')}}" class="list-group-item list-group-item-action bg-light"><i class="icofont-book"></i> {{__('My texts')}}</a>
        <a href="{{route('rt_public_texts')}}" class="list-group-item list-group-item-action bg-light"><i class="icofont-search-1"></i> {{__('Find text')}}</a>
        <a href="{{route('reader_add_text_page')}}?public=1" class="list-group-item list-group-item-action bg-light"><i class="icofont-plus-square"></i> {{__('Add text')}}</a>
    </div>

    <h4 class="px-3 mt-4 mb-1 reader_sidebar_block_name">
        <span>{{__('Questions')}}</span>
    </h4>

    <div class="list-group list-group-flush">
        <a href="{{route('rt_my_questions')}}" class="list-group-item list-group-item-action bg-light"><i class="icofont-file-text"></i> {{__('My questions')}}</a>
    </div>

    <h4 class="px-3 mt-4 mb-1 reader_sidebar_block_name">
        <span>{{__('Words')}}</span>
    </h4>

    <div class="list-group list-group-flush">
        <a href="{{route('reader_words')}}?public=1" class="list-group-item list-group-item-action bg-light"><i class="icofont-file-text"></i> {{__('My words')}}</a>
    </div>



</aside>
