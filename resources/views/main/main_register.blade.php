@extends('layouts.main.main_layout')

@section('main_content')


<main class="row justify-content-center">
    <div class="col-md-6 mt-5">
        <div class="card">
            <div class="card-header">{{ __('Register') }}</div>

            <div class="card-body">
                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    <div class="form-group row">
                        <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>

                        <div class="col-md-6">
                            <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                            @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                        <div class="col-md-6">
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                            @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>

                    {{-- Known languages selector --}}
                    <div class="form-group row">
                        <label for="lang_known" class="col-md-4 col-form-label text-md-right"><b>I know</b></label>

                        <div class="col-md-6">

                            <select class="selectpicker" name="lang_known[]" id="lang_known" data-live-search="true"  data-width="100%" multiple required>

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
                    {{-- Known languages selector end--}}


                    {{-- Studied languages selector --}}
                    <div class="form-group row">
                        <label for="lang_learn" class="col-md-4 col-form-label text-md-right"><b>I want to learn</b></label>

                        <div class="col-md-6">

                            <select class="selectpicker" name="lang_learn[]" id="lang_learn" data-live-search="true" data-width="100%" multiple required>

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
                    {{-- Studied languages selector end--}}


                    <div class="form-group row">
                        <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                        <div class="col-md-6">
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                            @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>

                        <div class="col-md-6">
                            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                        </div>
                    </div>

                    <div class="form-group row mb-0">
                        <div class="col-md-6 offset-md-4">
                            <button type="submit" class="btn btn-primary">
                                {{ __('Register') }}
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</main>



@endsection