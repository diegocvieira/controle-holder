@extends('layouts.divided', [
    'page' => 'login',
    'alertComponent' => true
])

@section('content')
    @include('partials.page-header-title', [
        'page' => 'login',
        'title' => 'Acesse sua conta'
    ])

    <form @submit.prevent="formSubmit" id="form-login" class="form">
        <div class="field-container">
            <input type="input" v-model="email" placeholder="holder@gmail.com" class="input-field" />
        </div>

        <div class="field-container">
            <input type="password" v-model="password" placeholder="********" class="input-field" />
        </div>

        <div class="field-container is-justify-content-flex-end">
            <a href="#" class="link">Esqueci a senha</a>
        </div>

        <div class="field-container">
            <button type="submit" class="button button-submit" v-bind:disabled="submitButtonIsDisabled">ENTRAR NA MINHA CONTA</button>
        </div>

        <div class="field-container is-justify-content-center">
            <a href="#" class="link">Criar minha conta</a>
        </div>
    </form>
@endsection
