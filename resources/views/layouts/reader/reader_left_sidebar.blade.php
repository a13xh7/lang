<aside class="col-3 sidebar">

    <h4 class="px-3 mt-4 mb-1 reader_sidebar_block_name">
        <span>{{__('Reader')}}</span>
    </h4>

    <div class="list-group list-group-flush">
        <a href="{{route('reader_texts')}}" class="list-group-item list-group-item-action bg-light"><i class="icofont-book"></i> {{__('My Texts')}}</a>
        <a href="{{route('reader_add_text_page')}}" class="list-group-item list-group-item-action bg-light"><i class="icofont-plus-square"></i> {{__('Add text')}}</a>
    </div>


    <h4 class="px-3 mt-4 mb-1 reader_sidebar_block_name">
        <span>{{__('Words')}}</span>
    </h4>

    <div class="list-group list-group-flush">
        <a href="{{route('reader_words')}}" class="list-group-item list-group-item-action bg-light"><i class="icofont-file-text"></i> {{__('My words')}}</a>
    </div>



</aside>