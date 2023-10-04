@extends('layouts.dashboard', [
    'page' => 'profile',
    'headerComponent' => true,
    'loaderComponent' => true,
    'alertComponent' => true
])

@section('content')

@include('partials.page-header-title', [
    'page' => 'profile',
    'title' => 'Perfil'
])

<div class="form-content">
    <form class="form" @submit.prevent="saveData">
        <div class="fields-container">
            <div class="field-container">
                <label for="name" class="label">Nome</label>
                <div class="input-has-label">
                    <input type="text" name="name" placeholder="" id="name" class="input-field" v-model="name" />
                    <span class="field-icon-container">
                        <svg viewBox="0 0 24 24" class="field-icon">
                            <path fill="currentColor" d="M12,4A4,4 0 0,1 16,8A4,4 0 0,1 12,12A4,4 0 0,1 8,8A4,4 0 0,1 12,4M12,14C16.42,14 20,15.79 20,18V20H4V18C4,15.79 7.58,14 12,14Z"></path>
                        </svg>
                    </span>
                </div>
            </div>

            <div class="field-container">
                <label for="email" class="label">E-mail</label>
                <div class="input-has-label">
                    <input type="email" name="email" placeholder="" id="email" class="input-field" v-model="email" />
                    <span class="field-icon-container">
                        <svg viewBox="0 0 24 24" class="field-icon">
                            <path fill="currentColor" d="M20,4H4C2.89,4 2,4.89 2,6V18A2,2 0 0,0 4,20H20A2,2 0 0,0 22,18V6C22,4.89 21.1,4 20,4M17,17H7V15H17M17,13H7V11H17M20,9H17V6H20"></path>
                        </svg>
                    </span>
                </div>
            </div>
        </div>

        <div class="mt-50">
            <button type="submit" class="button">SALVAR</button>
        </div>
    </form>

    <form class="form" @submit.prevent="saveData('password')">
        <div class="fields-container">
            <div class="field-container">
                <label for="current-password" class="label">Senha atual</label>
                <div class="input-has-label">
                    <input type="password" name="current_password" placeholder="" id="current-password" class="input-field" v-model="currentPassword" />
                    <span class="field-icon-container">
                        <svg viewBox="0 0 24 24" class="field-icon">
                            <path fill="currentColor" d="M21 13H14.4L19.1 17.7L17.7 19.1L13 14.4V21H11V14.3L6.3 19L4.9 17.6L9.4 13H3V11H9.6L4.9 6.3L6.3 4.9L11 9.6V3H13V9.4L17.6 4.8L19 6.3L14.3 11H21V13Z"></path>
                        </svg>
                    </span>
                </div>
            </div>

            <hr class="line">

            <div class="field-container">
                <label for="new-password" class="label">Nova senha</label>
                <div class="input-has-label">
                    <input type="password" name="new_password" placeholder="" id="new-password" class="input-field" v-model="newPassword" />
                    <span class="field-icon-container">
                        <svg viewBox="0 0 24 24" class="field-icon">
                            <path fill="currentColor" d="M17,7H22V17H17V19A1,1 0 0,0 18,20H20V22H17.5C16.95,22 16,21.55 16,21C16,21.55 15.05,22 14.5,22H12V20H14A1,1 0 0,0 15,19V5A1,1 0 0,0 14,4H12V2H14.5C15.05,2 16,2.45 16,3C16,2.45 16.95,2 17.5,2H20V4H18A1,1 0 0,0 17,5V7M2,7H13V9H4V15H13V17H2V7M20,15V9H17V15H20M8.5,12A1.5,1.5 0 0,0 7,10.5A1.5,1.5 0 0,0 5.5,12A1.5,1.5 0 0,0 7,13.5A1.5,1.5 0 0,0 8.5,12M13,10.89C12.39,10.33 11.44,10.38 10.88,11C10.32,11.6 10.37,12.55 11,13.11C11.55,13.63 12.43,13.63 13,13.11V10.89Z"></path>
                        </svg>
                    </span>
                </div>
            </div>

            <div class="field-container">
                <label for="confirm-password" class="label">Confirmar senha</label>
                <div class="input-has-label">
                    <input type="password" name="confirm_password" placeholder="" id="confirm-password" class="input-field" v-model="confirmPassword" />
                    <span class="field-icon-container">
                        <svg viewBox="0 0 24 24" class="field-icon">
                            <path fill="currentColor" d="M17,7H22V17H17V19A1,1 0 0,0 18,20H20V22H17.5C16.95,22 16,21.55 16,21C16,21.55 15.05,22 14.5,22H12V20H14A1,1 0 0,0 15,19V5A1,1 0 0,0 14,4H12V2H14.5C15.05,2 16,2.45 16,3C16,2.45 16.95,2 17.5,2H20V4H18A1,1 0 0,0 17,5V7M2,7H13V9H4V15H13V17H2V7M20,15V9H17V15H20M8.5,12A1.5,1.5 0 0,0 7,10.5A1.5,1.5 0 0,0 5.5,12A1.5,1.5 0 0,0 7,13.5A1.5,1.5 0 0,0 8.5,12M13,10.89C12.39,10.33 11.44,10.38 10.88,11C10.32,11.6 10.37,12.55 11,13.11C11.55,13.63 12.43,13.63 13,13.11V10.89Z"></path>
                        </svg>
                    </span>
                </div>
            </div>
        </div>

        <div class="mt-50">
            <button type="submit" class="button">SALVAR</button>
        </div>
    </form>
</div>

@endsection
