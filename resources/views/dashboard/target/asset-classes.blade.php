@extends('layouts/master')

@section('content')

<main class="main" id="target-asset-classes-page">
    <header-component page="target-asset-classes"></header-component>
    <loader-component ref="loader"></loader-component>

    <div class="main-content">
        <div class="columns">
            <div class="column is-12">
                <h2>Sua carteira de investimentos</h2>
                <div class="progress-bar">@{{ progressBar }}%</div>
            </div>
        </div>

        <div class="columns" style="display: flex;">
            <template v-for="assetClass in assetClasses">
                <div class="column is-4">
                    <div class="form-group">
                        <div class="icon" v-html="assetClass.icon"></div>
                        <label :for="assetClass.slug">@{{ assetClass.name }}</label>
                        <input type="number" min="0" max="100" v-model="assetClass.percentage" />
                        <vue-slider :ref="assetClass.slider" v-model="assetClass.percentage" v-bind="sliderOptions"></vue-slider>
                    </div>
                </div>
            </template>
        </div>
    </div>
</main>

@endsection
