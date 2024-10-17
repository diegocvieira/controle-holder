@extends('layouts.dashboard', [
    'page' => 'home',
    'headerComponent' => true
])

@section('content')
    <section class="home-section">
        <div class="home-section__banner">
            <div class="home-section__banner--overlay"></div>
            <img src="{{ Vite::asset('resources/images/investment-banner.webp') }}" alt="Banner" />
        </div>

        <div class="home-section__logo">
            <img src="{{ Vite::asset('resources/images/logo.png') }}" alt="HolderFolio" />
            <h1 class="is-hidden">HolderFolio</h1>
            <h3>A sua plataforma de rebalanceamento</h3>
            <div class="buttons">
                <a href="{{ route('login') }}" class="button bg-filled">ACESSE</a>
                <a href="{{ route('register') }}" class="button bg-filled">CADASTRE-SE</a>
            </div>
        </div>

        <div class="arrow-container">
            <a class="anchor-link" href="#about" title="Sobre nós">
                <svg id="down-arrow" data-name="mouse-arrow" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 26.52 16.52">
                    <path d="M23.32,1.48l-8.84,8.84a1.73,1.73,0,0,1-2.44,0L3.2,1.48a1.7,1.7,0,0,0-2.43,0h0a1.72,1.72,0,0,0,0,2.43L12,15.18a1.71,1.71,0,0,0,2.44,0L25.75,3.91a1.72,1.72,0,0,0,0-2.43h0A1.7,1.7,0,0,0,23.32,1.48Z"/>
                </svg>
            </a>
        </div>
    </section>

    <section id="about">
        <div class="container">
            @include('partials.page-section-title', [
                'icon' => 'graph',
                'title' => 'Sobre nós'
            ])

            <div class="">
                <p>Somos uma equipe apaixonada por finanças e tecnologia, dedicada a simplificar a gestão de ativos financeiros. Nosso objetivo é proporcionar a você uma experiência intuitiva e eficaz para acompanhar e otimizar seus investimentos diversas classes de ativos.</p>
                <p>Acreditamos na importância do controle financeiro e na tomada de decisões informadas. Com o HolderFolio, você terá acesso a uma variedade de ferramentas poderosas e recursos que o ajudarão a alcançar seus objetivos financeiros.</p>
                <p>Junte-se a nós nessa jornada e comece a construir um futuro financeiro mais sólido e promissor.</p>
            </div>
        </div>
    </section>

    <section class="">
        <div class="container">
            @include('partials.page-section-title', [
                'icon' => 'graph',
                'title' => 'Por que devo usar a plataforma?'
            ])

            <div class="">
                <p>Quando se trata de gerenciar seus ativos financeiros, a escolha da plataforma certa faz toda a diferença. O HolderFolio oferece uma abordagem única e intuitiva, projetada para simplificar e otimizar sua experiência de investimento.</p>
                <p>Ao centralizar criptomoedas, fundos imobiliários, ações e investimentos de renda fixa em um único espaço, proporcionamos a você uma visão completa do seu portfólio. Isso significa que tomar decisões informadas e estratégicas se torna mais fácil do que nunca.</p>
                <p>Se você segue a estratégia de Buy and Hold, o HolderFolio se destaca ao oferecer uma ferramenta de rebalanceamento inteligente. Isso permite que você construa uma carteira de investimentos mais alinhada com seus objetivos financeiros de longo prazo.</p>
                <p>Portanto, ao escolher o HolderFolio, você está optando por uma abordagem mais inteligente e eficaz para gerenciar seus ativos financeiros. Junte-se a nós e comece a construir um futuro financeiro mais sólido e promissor hoje mesmo.</p>
            </div>
        </div>
    </section>
@endsection
