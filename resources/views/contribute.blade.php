@extends('layouts.dashboard', [
    'page' => 'contribute',
    'isLogged' => auth()->check(),
    'headerComponent' => true,
    'metaTitle' => 'Nos compre um café'
])

@section('content')
    @include('partials.page-header-title', [
        'page' => 'coffee',
        'title' => 'Nos compre um café'
    ])

    <div class="description">
        <h2>Nos ajude a manter a plataforma ativa</h2>
        <p>Contribua com um valor de sua escolha.</p>
        <p>O valor de um café já ajuda demais!</p>
    </div>

    <div class="payment-info">
        <div class="qr-data">
            <h3>Use o QR Code do Pix</h3>
            <p>Abra o app em que vai fazer a<br>transferência, escaneie a imagem<br>ou cole o código do QR Code</p>
            <img src="{{ Vite::asset('resources/images/pix.png') }}" alt="QR Code Pix" />
            <button type="button" class="button" @click.prevent="copyToClipboard('00020126580014BR.GOV.BCB.PIX0136b94b0e51-48d9-48b3-845d-31a60d949a155204000053039865802BR5912Diego Vieira6009SAO PAULO61080540900062150511HolderFolio63041A61')"  title="Copiar">
                <span>Copiar código do QR Code</span>

                <svg viewBox="0 0 32 32" class="icon">
                    <path d="M28,10H12a2,2,0,0,0-2,2V28a2,2,0,0,0,2,2H28a2,2,0,0,0,2-2V12A2,2,0,0,0,28,10ZM12,28V12H28V28Z"></path>
                    <path d="M7,20H4V4H20V7a1,1,0,0,0,2,0V4a2,2,0,0,0-2-2H4A2,2,0,0,0,2,4V20a2,2,0,0,0,2,2H7a1,1,0,0,0,0-2Z"></path>
                </svg>
            </button>
        </div>

        <div class="pix-data">
            <p>Ou use a <b>chave Pix</b></p>

            <hr class="line">

            <div class="bank-data">
                <div class="item">
                    <span>Chave PIX</span>
                    <span>
                        <button type="button" class="button" @click.prevent="copyToClipboard('b94b0e51-48d9-48b3-845d-31a60d949a15')" title="Copiar">
                            <span>Chave Aleatória</span>

                            <svg viewBox="0 0 32 32" class="icon">
                                <path d="M28,10H12a2,2,0,0,0-2,2V28a2,2,0,0,0,2,2H28a2,2,0,0,0,2-2V12A2,2,0,0,0,28,10ZM12,28V12H28V28Z"></path>
                                <path d="M7,20H4V4H20V7a1,1,0,0,0,2,0V4a2,2,0,0,0-2-2H4A2,2,0,0,0,2,4V20a2,2,0,0,0,2,2H7a1,1,0,0,0,0-2Z"></path>
                            </svg>
                        </button>
                    </span>
                </div>

                <div class="item">
                    <span>Nome</span>
                    <span>Diego Vieira</span>
                </div>

                <div class="item">
                    <span>CPF</span>
                    <span>•••.842.440-••</span>
                </div>

                <div class="item">
                    <span>Banco</span>
                    <span>260 - Nu Pagamentos S.A. - Instituição de Pagamento</span>
                </div>

                <div class="item">
                    <span>Identificador</span>
                    <span>HolderFolio</span>
                </div>
            </div>
        </div>
    </div>
@endsection
