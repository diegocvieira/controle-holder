@extends('layouts.dashboard', [
    'page' => 'dashboard',
    'headerComponent' => true
])

@section('content')

<pie-component :chartdata="chartdata"></pie-component>

@endsection
