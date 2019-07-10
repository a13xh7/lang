@extends('layouts.reader.reader_layout')

@section('reader_content')

    <h1>MY WORDS</h1>

    {{--<div>--}}
        {{--<button type="button" class="btn btn-primary noradius">--}}
            {{--<span class="h2">Total: <span class="badge badge-dark">11</span> </span>--}}
        {{--</button>--}}

        {{--<button type="button" class="btn btn-primary noradius">--}}
            {{--<span class="h2">To study: <span class="badge badge-warning">11</span> </span>--}}
        {{--</button>--}}

        {{--<button type="button" class="btn btn-primary noradius">--}}
            {{--<span class="h2">Known: <span class="badge badge-success">11</span> </span>--}}
        {{--</button>--}}
    {{--</div>--}}



    <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">

        <li class="nav-item" style="margin-right: 50px;">
            <button type="button" class="btn btn-primary noradius active" id="pills-home-tab" data-toggle="pill" href="#pills-home" role="tab" aria-controls="pills-home" aria-selected="true">
                <span class="h2">Total: <span class="badge badge-light">{{ $totalWords }}</span> </span>
            </button>
        </li>

        <li class="nav-item" style="margin-right: 50px;">
            <button type="button" class="btn btn-primary noradius" id="pills-profile-tab" data-toggle="pill" href="#pills-profile" role="tab" aria-controls="pills-profile" aria-selected="false">
                <span class="h2">To study: <span class="badge badge-warning">{{ $totalNewWords }} </span> </span>
            </button>
        </li>

        <li class="nav-item">
            <button type="button" class="btn btn-primary noradius" id="pills-contact-tab" data-toggle="pill" href="#pills-contact" role="tab" aria-controls="pills-contact" aria-selected="false">
                <span class="h2">Known: <span class="badge badge-success">{{ $totalKnownWords }}</span> </span>
            </button>
        </li>

    </ul>
    <div class="tab-content" id="pills-tabContent">

        <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
            <table class="table">
                <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">First</th>
                    <th scope="col">Last</th>
                    <th scope="col">Handle</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <th scope="row">1</th>
                    <td>Mark</td>
                    <td>Otto</td>
                    <td>@mdo</td>
                </tr>
                <tr>
                    <th scope="row">2</th>
                    <td>Jacob</td>
                    <td>Thornton</td>
                    <td>@fat</td>
                </tr>
                <tr>
                    <th scope="row">3</th>
                    <td>Larry</td>
                    <td>the Bird</td>
                    <td>@twitter</td>
                </tr>
                </tbody>
            </table>
        </div>

        <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">

            <table class="table">
                <thead class="thead-dark">
                <tr>
                    <th scope="col">Controls</th>
                    <th scope="col">Word</th>
                    <th scope="col">Google translation</th>
                    <th scope="col">Comminity translation</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <th scope="row" style="width: 20%;">

                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" id="customRadioInline1" name="customRadioInline1" class="custom-control-input">
                            <label class="custom-control-label" for="customRadioInline1">Known</label>
                        </div>

                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" id="customRadioInline2" name="customRadioInline1" class="custom-control-input">
                            <label class="custom-control-label" for="customRadioInline2">To study</label>
                        </div>

                    </th>

                    <td>Mark</td>
                    <td>Otto</td>
                    <td>@mdo</td>
                </tr>
                <tr>
                    <th scope="row">2</th>
                    <td>Jacob</td>
                    <td>Thornton</td>
                    <td>@fat</td>
                </tr>
                <tr>
                    <th scope="row">3</th>
                    <td>Larry</td>
                    <td>the Bird</td>
                    <td>@twitter</td>
                </tr>
                </tbody>
            </table>

        </div>

        <div class="tab-pane fade" id="pills-contact" role="tabpanel" aria-labelledby="pills-contact-tab">
            3
        </div>

    </div>







    {{--<ul class="nav nav-pills mb-3 w-100" id="pills-tab" role="tablist">--}}
        {{--<li class="nav-item">--}}
            {{--<a class="nav-link active" style="border-radius: 0" id="pills-home-tab" data-toggle="pill" href="#pills-home" role="tab" aria-controls="pills-home" aria-selected="true">Home</a>--}}
        {{--</li>--}}
        {{--<li class="nav-item">--}}
            {{--<a class="nav-link" style="border-radius: 0" id="pills-profile-tab" data-toggle="pill" href="#pills-profile" role="tab" aria-controls="pills-profile" aria-selected="false">Profile</a>--}}
        {{--</li>--}}
        {{--<li class="nav-item">--}}
            {{--<a class="nav-link" style="border-radius: 0" id="pills-contact-tab" data-toggle="pill" href="#pills-contact" role="tab" aria-controls="pills-contact" aria-selected="false">Contact</a>--}}
        {{--</li>--}}
    {{--</ul>--}}
    {{--<div class="tab-content" id="pills-tabContent">--}}
        {{--<div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">home </div>--}}
        {{--<div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">2</div>--}}
        {{--<div class="tab-pane fade" id="pills-contact" role="tabpanel" aria-labelledby="pills-contact-tab">3</div>--}}
    {{--</div>--}}






    @foreach($words as $word)



        <p>word - {{$word->word}} </p>
        <p>state - {{$word->pivot->state}} </p>
        <p>google translation - {{$word->googleTranslation->translation}}</p>

        <p>community  translation -
            @foreach($word->communityTranslations as $translation)
                <span> {{ $translation->translation }} </span> ,
            @endforeach
        </p>

        <hr>

    @endforeach


@endsection

