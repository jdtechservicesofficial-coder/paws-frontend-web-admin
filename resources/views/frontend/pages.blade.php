@extends('frontend.''layouts.frontend')

@section('content')


    @if($sections != null)
        @foreach(json_decode($sections) as $sec)
            @include('frontend.''sections.'.$sec)
        @endforeach
    @endif
@endsection
