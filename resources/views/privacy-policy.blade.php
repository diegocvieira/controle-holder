@extends('layouts.dashboard', [
    'page' => 'privacy-policy',
    'isLogged' => auth()->check(),
    'headerComponent' => true,
    'metaTitle' => 'Política de Privacidade'
])

@section('content')
    @include('partials.page-header-title', [
        'page' => 'terms',
        'title' => 'Política de Privacidade'
    ])

    <div class="terms">
        <div class="item">
            <h2>1. Introdução</h2>

            <p>Bem-vindo ao {{ config('app.legal_name') }} ("Empresa", "nós", "nosso")! Como você acabou de clicar em nossa Política de Privacidade, por favor, faça uma pausa, pegue uma xícara de café e leia cuidadosamente as páginas seguintes. Isso vai levar aproximadamente 10 minutos.</p>

            <p>Nossa Política de Privacidade rege a sua visita ao {{ config('app.url') }} e explica como coletamos, protegemos e divulgamos informações resultantes do seu uso do nosso Serviço.</p>

            <p>Utilizamos seus dados para fornecer e melhorar o Serviço. Ao utilizar o Serviço, você concorda com a coleta e uso de informações de acordo com esta política. A menos que definido de outra forma nesta Política de Privacidade, os termos utilizados têm os mesmos significados que em nossos Termos de Serviço.</p>

            <p>Nossos Termos de Serviço regulam todo o uso do nosso Serviço e, juntamente com a Política de Privacidade, constituem o seu acordo conosco.</p>

            <p>Obrigado por ser responsável.</p>
        </div>

        <div class="item">
            <h2>2. Informações Coletadas</h2>

            <p>Coletamos informações fornecidas por você durante o processo de registro e uso do Serviço, incluindo nome, e-mail, e informações de ativos financeiros.</p>
            <p>Podemos também coletar informações automaticamente, como endereço IP, tipo de navegador, sistema operacional, e outras informações de uso.</p>
        </div>

        <div class="item">
            <h2>3. Uso das Informações</h2>

            <p>Utilizamos suas informações para fornecer os serviços do Serviço, incluindo o gerenciamento de ativos.</p>
            <p>Podemos utilizar suas informações para comunicações sobre atualizações, notícias e promoções.</p>
        </div>

        <div class="item">
            <h2>4. Compartilhamento de Informações</h2>

            <p>Não compartilhamos suas informações pessoais com terceiros sem seu consentimento, exceto quando exigido por lei.</p>
        </div>

        <div class="item">
            <h2>5. Segurança de Dados</h2>

            <p>Implementamos medidas de segurança para proteger suas informações contra acesso não autorizado ou alteração.</p>
        </div>

        <div class="item">
            <h2>6. Cookies e Tecnologias Semelhantes</h2>

            <p>Utilizamos cookies e tecnologias semelhantes para melhorar a experiência do usuário e personalizar o conteúdo.</p>
        </div>

        <div class="item">
            <h2>7. Links para Outros Sites</h2>

            <p>Nosso Serviço pode conter links para sites de terceiros. Não somos responsáveis pelas práticas de privacidade desses sites.</p>
        </div>

        <div class="item">
            <h2>8. Menores de Idade</h2>

            <p>Nosso Serviço não é destinado a menores de idade. Não coletamos intencionalmente informações de menores.</p>
        </div>

        <div class="item">
            <h2>9. Alterações na Política de Privacidade</h2>

            <p>Podemos atualizar esta Política de Privacidade periodicamente. Recomendamos que você reveja regularmente.</p>
        </div>

        <div class="item">
            <h2>10. Contato</h2>

            <p>Se você tiver alguma dúvida sobre esta Política de Privacidade, por favor, entre em contato através do nosso e-mail: <a href="mailto:{{ config('mail.from.address') }}">{{ config('mail.from.address') }}</a>.</p>
        </div>
    </div>
@endsection
