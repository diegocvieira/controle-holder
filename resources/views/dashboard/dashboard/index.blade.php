@extends('layouts.dashboard', [
    'page' => 'dashboard',
    'headerComponent' => true
])

@section('content')
    @include('partials.page-header-title', [
        'page' => 'dashboard',
        'title' => 'Dashboard'
    ])

    @include('partials.page-section-title', [
        'icon' => 'graph',
        'title' => 'Gráficos'
    ])

    <nav class="is-flex mb-20">
        <ul class="is-flex">
            <li v-for="filterOption in filterOptions">
                <a href="#" @click.prevent="applyFilter(filterOption.slug)" :class="'link ' + (filterOption.slug === filter ? 'is-active' : '')">@{{ filterOption.name }}</a>
            </li>
        </ul>
    </nav>

    <div class="charts">
        <div class="chart">
            <pie-component :data="chartCurrent"></pie-component>
        </div>

        <hr class="line vertical">

        <div class="chart">
            <pie-component :data="chartIdeal"></pie-component>
        </div>
    </div>
@endsection
