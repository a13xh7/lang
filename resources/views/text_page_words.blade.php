@extends('text_page_layout')

@section('content')

<div>

    <h2>Unique words on this page ({{count($words)}})</h2>

    <table class="table">
        <thead class="thead-light">
        <tr>
            <th scope="col" style="width:20%">State</th>
            <th scope="col" style="width:25%">Word</th>
            <th scope="col" style="width:30%">Translation</th>
            <th scope="col" style="width:25%">Usage frequency</th>
        </tr>
        </thead>
        <tbody>

        @foreach($words as $word)

            <tr>
                <td>

                    @if($word['id'] == null)
                        <button type="button" class="btn btn-warning btn-sm word_btn"
                                data-word="{{$word['word']}}"
                                data-state="{{\App\Config\WordConfig::TO_STUDY}}">To study</button>

                        <button type="button" class="btn btn-success btn-sm word_btn"
                                data-word="{{$word['word']}}"
                                data-state="{{\App\Config\WordConfig::KNOWN}}">Known</button>
                    @else

                        @if($word['state'] == \App\Config\WordConfig::TO_STUDY)
                            <span class="badge badge-warning h4">To study</span>
                            <button type="button" class="btn btn-success btn-sm word_btn" data-word_id="{{$word['id']}}" data-state="{{\App\Config\WordConfig::KNOWN}}">Known</button>
                        @else
                            <button type="button" class="btn btn-warning btn-sm word_btn" data-word_id="{{$word['id']}}" data-state="{{\App\Config\WordConfig::TO_STUDY}}">To study</button>
                            <span class="badge badge-success h4">Known</span>
                        @endif

                    @endif



                </td>

                <td>{{$word['word']}}</td>

                <td>

                    @if($word['translation'] != null)
                        {{$word['translation']}}
                    @else
                        -
                    @endif
                </td>

                <td>{{$word['usage']}} <span class="small text-muted">({{$word['usage_percent']}}%)</span> </td>
            </tr>

        @endforeach

        </tbody>
    </table>

</div>




@endsection
