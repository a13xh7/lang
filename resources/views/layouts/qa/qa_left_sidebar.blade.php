<aside class="col-3 sidebar">

    @auth()
        <h4 class="px-3 mt-4 mb-1 reader_sidebar_block_name">
            <span>Q & A</span>
        </h4>

        <div class="list-group list-group-flush">
            <a href="{{route('qa_add_question_page')}}" class="list-group-item list-group-item-action bg-light"><i class="icofont-question-square"></i> Ask Question</a>
            <a href="{{route('qa_index')}}" class="list-group-item list-group-item-action bg-light"><i class="icofont-world"></i> All questions</a>
            <a href="{{route('qa_my_questions')}}" class="list-group-item list-group-item-action bg-light"><i class="icofont-search-user"></i> My questions</a>
        </div>

    @endauth



</aside>