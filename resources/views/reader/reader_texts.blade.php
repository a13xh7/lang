@extends('layouts.reader.reader_layout')

@section('reader_sidebar')

    @include('layouts.reader.reader_left_sidebar')

@endsection


@section('reader_content')

  <h1>My texts</h1>

    @foreach($texts as $text)


        <div class="text_item border-bottom text_item_wrapper">

            <span class="text_title">
               <a class="h4" href="{{route('reader_read_text_page', $text->id)}}?page=@if($text->pivot->current_page <= 0){{$text->pivot->current_page + 1}}@else{{$text->pivot->current_page}}@endif">{{$text->title}}</a> <i class="text-muted">({{$text->created_at->format('d-m-Y')}})</i>
            </span>

            <div>
                Text language: <img src="{{asset('img/flags/'. \App\Config\Lang::get($text->lang_id)['code'] .'.svg')}}" class="text_flag" alt=""> <i class="text-muted">({{\App\Config\Lang::get($text->lang_id)['title']}})</i>
                <span class="q_lang_arrow">⟶</span>
                Translate to: <img src="{{asset('img/flags/'. \App\Config\Lang::get($text->pivot->translate_to_lang_id)['code']  .'.svg')}}" class="text_flag" alt=""> <i class="text-muted">({{\App\Config\Lang::get($text->pivot->translate_to_lang_id)['title']}})</i>
            </div>

            <div class="text_stats">
                Symbols: <span class="badge badge-dark">{{ $text->total_symbols}}</span> <b>|</b>
                Words: <span class="badge badge-dark">{{ $text->total_words}}</span> <b>|</b>
                Unique words: <span class="badge badge-dark">{{ $text->unique_words}}</span> <b>|</b>
                Known words: <span class="badge badge-dark">{{ count($text->getKnownWords()) }}</span> <b>|</b>
                Unknown Words: <span class="badge badge-dark">{{ count($text->getUnknownWords()) }}</span>
            </div>

            <div class="text_pages_info">
                Pages: <span class="badge badge-dark">{{ $text->total_pages}}</span> <b>/</b>
                Current page: <span class="badge badge-dark">{{ $text->pivot->current_page}}</span>
            </div>

            <div class="progress">
                <div class="progress-bar" role="progressbar"
                     style="width: @php
                         try {
                             echo $text->pivot->current_page / $text->total_pages  * 100 . "%";
                         } catch (\Exception $e) {
                             echo "0%";
                         }
                     @endphp
                     " aria-valuenow="2" aria-valuemin="0" aria-valuemax="100">
                </div>
            </div>

            <div class="text_controls">

                <a class="btn btn-primary text-light noradius" href="{{route('reader_read_text_page', $text->id)}}?page=@if($text->pivot->current_page <= 0){{$text->pivot->current_page + 1}}@else{{$text->pivot->current_page}}@endif">
                    <i class="icofont-read-book"></i> Read
                </a>

                <a class="btn btn-primary text-light noradius" href="{{ route('reader_text_stats', $text->id) }}">
                    <i class="icofont-info-square"></i> Full Info
                </a>

                <a class="btn btn-primary text-light noradius text_edit_btn" data-toggle="modal" data-target="#text_edit_modal"
                   data-text_id="{{$text->id}}"
                   data-text_title="{{$text->title}}"
                   data-text_lang="{{$text->lang_id}}"
                   data-translate_to_lang_id="{{$text->pivot->translate_to_lang_id}}">

                    <i class="icofont-ui-edit"></i> Edit
                </a>

                <a class="btn btn-primary text-light noradius" href="{{route('reader_delete_text', $text->id)}}">
                    <i class="icofont-ui-delete"></i> Delete
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
                  <h5 class="modal-title" id="exampleModalLongTitle">EDIT TEXT</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                  </button>
              </div>
              <div class="modal-body">


                  <form action=" {{route('reader_update_text') }}" method="POST" enctype="multipart/form-data">
                      @csrf

                      <input type="hidden" name="text_id" id="text_id" value="">

                      <div class="form-group row">
                          <label for="text_title" class="col-sm-2 col-form-label">Title</label>
                          <div class="col-sm-10">
                              <input type="text" class="form-control" name="text_title" id="text_title" placeholder="Text title" maxlength="254" required>
                          </div>
                      </div>


                      <div class="form-group row">
                          <label class="col-sm-2 col-form-label" for="lang_from">Translate from</label>
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
                          <label class="col-sm-2 col-form-label" for="lang_to">Translate to</label>
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


                      <button type="submit" class="btn w-100 btn-primary noradius"><b>SAVE</b></button>

                  </form>

              </div>
          </div>
      </div>
  </div>

@endsection


