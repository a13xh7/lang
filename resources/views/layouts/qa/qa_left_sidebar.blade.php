<aside class="col-3 nopadding qa_sidebar" style="background-color: #f3f3f3;">


        <h4 class="px-3 mt-4 mb-1 reader_sidebar_block_name">
            <span>Q & A</span>
        </h4>

        <div class="q_lang_filter">

            <label for="lang_from">I know</label>
            <select class="selectpicker" name="lang_from" id="lang_from" data-live-search="true" data-width="100%">

                @foreach(\App\Config\Lang::all() as $lang)

                    <option
                            value="{{$lang['id']}}"
                            data-subtext="{{$lang['eng_title']}}"
                            data-content="<img src='{{asset('img/flags/'.$lang['code'].'.svg')}}' class='text_flag' alt=''> {{$lang['title']}} <small class='text-muted'>{{$lang['eng_title']}}</small>"


                            @auth

                                <?php

                                    if(\Illuminate\Support\Facades\Cookie::get('q_lang_id') != null && \Illuminate\Support\Facades\Cookie::get('q_lang_id') == $lang['id'] ) {
                                        echo 'selected';
                                    } else if(auth()->user()->getFirstKnownLanguage() == $lang['id']) {
                                        echo 'selected';
                                    }

                                    ?>

                             @endauth
                    >
                    </option>

                @endforeach

            </select>

            <br><br>
            <label for="lang_to">I want to learn</label>

            <select class="selectpicker" name="lang_to" id="lang_to" data-live-search="true" data-width="100%">

                @foreach(\App\Config\Lang::all() as $lang)

                    <option
                            value="{{$lang['id']}}"
                            data-subtext="{{$lang['eng_title']}}"
                            data-content="<img src='{{asset('img/flags/'.$lang['code'].'.svg')}}' class='text_flag' alt=''> {{$lang['title']}} <small class='text-muted'>{{$lang['eng_title']}}</small>"

                    @auth

                        <?php

                            if(\Illuminate\Support\Facades\Cookie::get('q_about_lang_id') != null && \Illuminate\Support\Facades\Cookie::get('q_about_lang_id') == $lang['id'] ) {
                                echo 'selected';
                            } else if(auth()->user()->getFirstStudiedLanguage() == $lang['id']) {
                                echo 'selected';
                            }

                            ?>

                    @endauth

                    >
                    </option>

                @endforeach

            </select>

            <button type="submit" class="btn w-100 btn-primary noradius" style="margin: 15px 0;" id="q_filter_btn"><b>FILTER</b></button>

        </div>

    @auth()
        <div class="list-group list-group-flush">
            <a href="{{route('qa_add_question_page')}}" class="list-group-item list-group-item-action bg-light sidebar_menu_link"><i class="icofont-question-square"></i> Ask Question</a>
            <a href="{{route('qa_index')}}" class="list-group-item list-group-item-action bg-light sidebar_menu_link"><i class="icofont-world"></i> All questions</a>
            <a href="{{route('qa_my_questions')}}" class="list-group-item list-group-item-action bg-light sidebar_menu_link"><i class="icofont-search-user"></i> My questions</a>
        </div>

    @endauth



</aside>
