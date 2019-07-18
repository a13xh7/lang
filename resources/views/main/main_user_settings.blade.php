@extends('layouts.main.main_layout')

@section('main_content')

    <main class="row qa_main">

        <div class="container" > {{--style="max-width: 1440px !important;"--}}

            <div class="row">

                @include('layouts.qa.qa_left_sidebar')

                <div class="col-9">
                    <h1>User settings</h1>


                    <form action="{{route('main_user_settings_update')}}" method="POST">
                        @csrf

                        <div class="form-group">
                            <label for="nickname">Nickname</label>
                            <input type="text" class="form-control" id="nickname" name="nickname" placeholder="Nickname" value="{{$user->name}}">
                        </div>

                        <div class="form-group">
                            <label for="user_email">Email</label>
                            <input type="email" class="form-control" id="user_email" name="user_email" placeholder="E-mail" value="{{$user->email}}">
                        </div>

                        <div class="form-group">
                            <label for="exampleInputPassword1">Known languages</label>

                            <select class="selectpicker" name="lang_from[]" id="lang_from" data-live-search="true"  data-width="100%" multiple>

                                @foreach(\App\Config\Lang::all() as $lang)

                                    <option
                                            value="{{$lang['id']}}"
                                            data-subtext="{{$lang['eng_title']}}"
                                            data-content="<img src='{{asset('img/flags/'.$lang['code'].'.svg')}}' class='text_flag' alt=''> {{$lang['title']}} <small class='text-muted'>{{$lang['eng_title']}}</small>" >
                                    </option>

                                @endforeach

                            </select>

                        </div>


                        <div class="form-group">
                            <label for="exampleInputPassword1">Studied languages</label>

                            <select class="selectpicker" name="lang_to[]" id="lang_from" data-live-search="true" data-width="100%" multiple>

                                @foreach(\App\Config\Lang::all() as $lang)

                                    <option
                                            value="{{$lang['id']}}"
                                            data-subtext="{{$lang['eng_title']}}"
                                            data-content="<img src='{{asset('img/flags/'.$lang['code'].'.svg')}}' class='text_flag' alt=''> {{$lang['title']}} <small class='text-muted'>{{$lang['eng_title']}}</small>" >
                                    </option>

                                @endforeach

                            </select>

                        </div>



                        <button type="submit" class="btn w-100 btn-primary noradius" style="margin-bottom: 30px;"><b>SAVE</b></button>

                    </form>





                    <h2>Change password</h2>
                    <hr>

                    <form>

                        <div class="form-group">
                            <label for="exampleInputPassword1">Old password</label>
                            <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
                        </div>

                        <div class="form-group">
                            <label for="exampleInputPassword1">New password</label>
                            <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
                        </div>

                        <div class="form-group">
                            <label for="exampleInputPassword1">Repeat password</label>
                            <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
                        </div>




                        <button type="submit" class="btn w-100 btn-primary noradius" style="margin-bottom: 30px;"><b>SAVE</b></button>

                    </form>


                </div>


            </div>
        </div>

    </main>

@endsection