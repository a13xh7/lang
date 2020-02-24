@extends('main_layout')


@section('content')

  <h1 class="uc">{{__('My texts')}}</h1>

    @foreach($texts as $text)

        <div class="text_item border-bottom text_item_wrapper">

            <span class="text_title">
               <a class="h4" href="{{route('read_text_page', $text->id)}}?page=@if($text->current_page <= 0){{$text->current_page + 1}}@else{{$text->current_page}}@endif">{{$text->title}}</a> <i class="text-muted">({{$text->created_at->format('d-m-Y')}})</i>
            </span>

            <div>
                {{__('Text language')}}: <img src="{{asset('img/flags/'. \App\Config\Lang::get($text->lang_id)['code'] .'.svg')}}" class="text_flag" alt=""> <i class="text-muted">({{\App\Config\Lang::get($text->lang_id)['title']}})</i>
                <span class="q_lang_arrow">⟶</span>
                {{__('Translate to')}}: <img src="{{asset('img/flags/'. \App\Config\Lang::get($text->translate_to_lang_id)['code']  .'.svg')}}" class="text_flag" alt=""> <i class="text-muted">({{\App\Config\Lang::get($text->translate_to_lang_id)['title']}})</i>
            </div>

            <div class="text_stats">
                {{__('Symbols')}}: <span class="badge badge-dark">{{ $text->total_symbols}}</span> <b>|</b>
                {{__('Words')}}: <span class="badge badge-dark">{{ $text->total_words}}</span> <b>|</b>
                {{__('Unique words')}}: <span class="badge badge-dark">{{ $text->unique_words}}</span>
                {{--{{__('Known words')}}: <span class="badge badge-dark">{{ count($text->getKnownWords()) }}</span> <b>|</b>--}}
                {{--{{__('Unknown Words')}}: <span class="badge badge-dark">{{ count($text->getUnknownWords()) }}</span>--}}
            </div>

            <div class="text_pages_info">
                {{__('Pages')}}: <span class="badge badge-dark">{{ $text->total_pages}}</span> <b>/</b>
                {{__('Current page')}}: <span class="badge badge-dark">{{ $text->current_page}}</span>
            </div>

            <div class="progress">
                <div class="progress-bar" role="progressbar"
                     style="width: @php
                         try {
                             echo $text->current_page / $text->total_pages  * 100 . "%";
                         } catch (\Exception $e) {
                             echo "0%";
                         }
                     @endphp
                     " aria-valuenow="2" aria-valuemin="0" aria-valuemax="100">
                </div>
            </div>

            <div class="text_controls" align="right">

                <a class="btn btn-primary text-light noradius" href="{{route('read_text_page', $text->id)}}?page=@if($text->current_page <= 0){{$text->current_page + 1}}@else{{$text->current_page}}@endif">
                    <i class="icofont-read-book"></i> {{__('Read')}}
                </a>

                <a class="btn btn-primary text-light noradius" href="{{ route('text_stats', $text->id) }}">
                    <i class="icofont-info-square"></i> {{__('Full Info')}}
                </a>

                <a class="btn btn-primary text-light noradius text_edit_btn" data-toggle="modal" data-target="#text_edit_modal"
                   data-text_id="{{$text->id}}"
                   data-text_title="{{$text->title}}"
                   data-text_lang="{{$text->lang_id}}"
                   data-translate_to_lang_id="{{$text->translate_to_lang_id}}">

                    <i class="icofont-ui-edit"></i> {{__('Edit')}}
                </a>

                <a class="btn btn-primary text-light noradius" href="{{route('delete_text', $text->id)}}">
                    <i class="icofont-ui-delete"></i> {{__('Delete')}}
                </a>
            </div>

        </div>

    @endforeach

    <br>
    {{ $texts->links() }}

  <!-- Modal -->
  <div class="modal fade" id="text_edit_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
      <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
          <div class="modal-content">
              <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLongTitle">{{__('EDIT TEXT')}}</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                  </button>
              </div>
              <div class="modal-body">


                  <form action=" {{route('update_text') }}" method="POST" enctype="multipart/form-data">
                      @csrf

                      <input type="hidden" name="text_id" id="text_id" value="">

                      <div class="form-group row">
                          <label for="text_title" class="col-sm-2 col-form-label">{{__('Title')}}</label>
                          <div class="col-sm-10">
                              <input type="text" class="form-control" name="text_title" id="text_title" placeholder="Text title" maxlength="254" required>
                          </div>
                      </div>


                      <div class="form-group row">
                          <label class="col-sm-2 col-form-label" for="lang_from">{{__('Text language')}}</label>
                          <div class="col-sm-10">
                              <select class="selectpicker" name="lang_from" id="lang_from" data-live-search="true" data-width="100%">

                                  @foreach(\App\Config\Lang::all() as $lang)

                                      <option
                                              value="{{$lang['id']}}"
                                              data-subtext="{{$lang['eng_title']}}"
                                              data-content="<img src='{{asset('img/flags/'.$lang['code'].'.svg')}}' class='text_flag' alt=''> {{$lang['title']}} <small class='text-muted'>{{$lang['eng_title']}}</small>" >
                                      </option>

                                  @endforeach

                              </select>
                          </div>
                      </div>

                      <div class="form-group row">
                          <label class="col-sm-2 col-form-label" for="lang_to">{{__('Translate to')}}</label>
                          <div class="col-sm-10">

                              <select class="selectpicker" name="lang_to" id="lang_to" data-live-search="true" data-width="100%">

                                  @foreach(\App\Config\Lang::all() as $lang)

                                      <option
                                              value="{{$lang['id']}}"
                                              data-subtext="{{$lang['eng_title']}}"
                                              data-content="<img src='{{asset('img/flags/'.$lang['code'].'.svg')}}' class='text_flag' alt=''> {{$lang['title']}} <small class='text-muted'>{{$lang['eng_title']}}</small>" >
                                      </option>

                                  @endforeach

                              </select>

                          </div>
                      </div>


                      <button type="submit" class="btn w-100 btn-primary noradius"><b>{{__('Save')}}</b></button>

                  </form>

              </div>
          </div>
      </div>
  </div>

@endsection

