@extends('layouts.template')

@section('template_content')
    <div class="main-dashboard-content">
        @yield('content')

        @include('partials.footer')
    </div>
@endsection
