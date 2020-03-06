@extends('main_layout')

@section('content')

  <h1 class="uc">{{__('My texts')}}</h1>

    @foreach($texts as $text)

        @php

        $currentPage = $text->current_page > 1 ? $text->current_page : 1;
        $readingProgress = $text->current_page / $text->total_pages * 100;

        @endphp

        <div class="text_item border-bottom text_item_wrapper">

            <span class="text_title">
               <a class="h4" href="{{route('read_text_page', $text->id)}}?page={{$currentPage}}">{{$text->title}}</a>
            </span>

            <div class="progress">
                <div class="progress-bar" role="progressbar" style="width:{{$readingProgress}}%" aria-valuenow="2" aria-valuemin="0" aria-valuemax="100"></div>
            </div>

            <div style="padding-top: 5px;">
                {{__('Symbols')}}: <span class="badge badge-dark">{{ $text->total_symbols}}</span> <b>|</b>
                {{__('Words')}}: <span class="badge badge-dark">{{ $text->total_words}}</span> <b>|</b>
                {{__('Unique words')}}: <span class="badge badge-dark">{{ $text->unique_words}}</span>
                {{__('Known words')}}: <span class="badge badge-success">{{ count($text->getKnownWords()) }}</span> <b>|</b>
                {{__('Unknown Words')}}: <span class="badge badge-warning">{{ count($text->getUnknownWords()) }}</span> <b>|</b>
                {{__('Total Pages')}}: <span class="badge badge-dark">{{ $text->total_pages}}</span> <b>|</b>
                {{__('Current page')}}: <span class="badge badge-dark">{{ $text->current_page}}</span>

                <span class="text_controls" >
                    <a class="btn btn-primary text-light noradius" href="{{route('read_text_page', $text->id)}}?page={{$currentPage}}">
                        <i class="icofont-read-book"></i> {{__('Read')}}
                    </a>

                    <a class="btn btn-primary text-light noradius" href="{{ route('text_stats', $text->id) }}">
                        <i class="icofont-info-square"></i> {{__('Text stats')}}
                    </a>

                    <a class="btn btn-primary text-light noradius text_edit_btn" data-toggle="modal" data-target="#text_edit_modal"
                       data-text_id="{{$text->id}}"
                       data-text_title="{{$text->title}}">
                        <i class="icofont-ui-edit"></i> Edit
                    </a>

                    <a class="btn btn-primary text-light noradius" href="{{route('delete_text', $text->id)}}">
                        <i class="icofont-ui-delete"></i> Delete
                    </a>
                </span>

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

                      <button type="submit" class="btn w-100 btn-primary noradius"><b>{{__('Save')}}</b></button>

                  </form>

              </div>
          </div>
      </div>
  </div>

@endsection


