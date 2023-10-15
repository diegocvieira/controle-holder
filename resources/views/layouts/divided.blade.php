@extends('layouts.template')

@section('template_content')
    <div class="main-divided-content">
        <div class="left-content">
            <a href="{{ route('home') }}">
                <img src="{{ Vite::asset('resources/images/logo.png') }}" class="logo" />
            </a>
        </div>

        <div class="right-content">
            @yield('content')
        </div>
    </div>
@endsection
