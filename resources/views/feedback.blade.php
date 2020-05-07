@extends('main_layout')


@section('content')

    <h1 class="uc">{{__('Feedback')}}</h1>

    <p>{{__('Do you have any suggestions or questions? Or maybe you\'ve found a bug?')}}</p>

    <p>{{__('Send me an email then')}} - <a href="mailto:@gmail.com">@gmail.com</a></p>
@endsection

