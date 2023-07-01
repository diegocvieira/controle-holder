@extends('layouts/master')

@section('content')

<main class="main" id="login-page">
    <alert-message-component ref="alertMessage"></alert-message-component>

    <div class="main-content">
        <div class="left-content">

            <a href="#">
                <img src="{{ Vite::asset('resources/images/logo.png') }}" width="300px" />
            </a>
        </div>

        <div class="right-content">
            <form @submit.prevent="formSubmit" id="form-login" class="form">
                @csrf

                <div class="field-container">
                    <input type="input" v-model="email" placeholder="E-mail" class="input-field" />
                </div>

                <div class="field-container">
                    <input type="password" v-model="password" placeholder="Senha" class="input-field" />
                </div>

                <div class="field-container is-justify-content-flex-end">
                    <a href="#" class="link">Esqueci a senha</a>
                </div>

                <div class="field-container">
                    <button type="submit" class="button button-submit" v-bind:disabled="submitButtonIsDisabled">ENTRAR</button>
                </div>
            </form>
        </div>
    </div>
</main>

@endsection

@section('script')

<script type="module" src="{{ Vite::asset('resources/js/auth/login.js') }}"></script>

@endsection
