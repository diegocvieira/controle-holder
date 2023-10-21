@extends('layouts.dashboard', [
    'page' => 'terms-of-service',
    'isLogged' => auth()->check(),
    'headerComponent' => true,
    'metaTitle' => 'Termos de Serviço'
])

@section('content')
    @include('partials.page-header-title', [
        'page' => 'terms',
        'title' => 'Termos de Serviço'
    ])

    <div class="terms">
        <div class="item">
            <h2>1. Introdução</h2>

            <p>Bem-vindo ao {{ config('app.legal_name') }} ("Empresa", "nós", "nosso")! Como você acabou de clicar em nossos Termos de Serviço, por favor, faça uma pausa, pegue uma xícara de café e leia cuidadosamente as páginas seguintes. Isso vai levar aproximadamente 10 minutos.</p>

            <p>Estes Termos de Serviço regem o seu uso das nossas páginas da web localizadas em {{ config('app.url') }} operadas pela {{ config('app.legal_name') }}</p>

            <p>Nossa Política de Privacidade também rege o seu uso do nosso Serviço e explica como coletamos, protegemos e divulgamos informações resultantes do seu uso das nossas páginas da web. Por favor, leia-a aqui <a href="{{ route('legal.privacy-policy') }}">{{ route('legal.privacy-policy') }}</a>.</p>

            <p>O seu acordo conosco inclui estes Termos e a nossa Política de Privacidade. Você reconhece que leu e compreendeu os Acordos, e concorda em ficar vinculado por eles.</p>

            <p>Se você não concorda (ou não pode cumprir) com os Acordos, então você não pode usar o Serviço, mas por favor nos avise por e-mail em {{ config('mail.from.address') }} para que possamos tentar encontrar uma solução. Estes Termos se aplicam a todos os visitantes, usuários e outras pessoas que desejam acessar ou usar o Serviço.</p>

            <p>Obrigado por ser responsável.</p>
        </div>

        <div class="item">
            <h2>2. Cadastro e Conta de Usuário</h2>

            <p>Para acessar certas funcionalidades, você pode ser solicitado a criar uma conta de usuário. As informações fornecidas devem ser precisas e atualizadas.</p>
            <p>Você é responsável pela segurança de suas credenciais de login. Caso haja qualquer uso não autorizado, notifique-nos imediatamente.</p>
        </div>

        <div class="item">
            <h2>3. Uso Permitido</h2>

            <p>Você concorda em usar o Serviço apenas para os fins permitidos por estes Termos e em conformidade com todas as leis e regulamentos aplicáveis.</p>
            <p>Não é permitido utilizar o Serviço para atividades ilegais, prejudiciais, abusivas, difamatórias ou de qualquer forma que possa interferir na operação do site.</p>
        </div>

        <div class="item">
            <h2>4. Propriedade Intelectual</h2>

            <p>Todo o conteúdo disponibilizado no Serviço é de propriedade da {{ config('app.legal_name') }} e está protegido por leis de propriedade intelectual.</p>
            <p>Você concorda em não reproduzir, distribuir ou criar obras derivadas sem a autorização prévia por escrito da {{ config('app.legal_name') }}</p>
        </div>

        <div class="item">
            <h2>5. Limitação de Responsabilidade</h2>

            <p>O uso do Serviço é por sua conta e risco. Não nos responsabilizamos por perdas ou danos decorrentes do uso do Serviço.</p>
            <p>Não garantimos a precisão ou integridade das informações disponíveis no Serviço.</p>
            <p>A funcionalidade de captura de preços de ativos de outros sites é fornecida apenas como uma conveniência para os usuários. Não nos responsabilizamos pela precisão ou atualidade dessas informações. Recomendamos verificar sempre as informações diretamente nos sites de origem antes de tomar qualquer decisão de investimento.</p>
        </div>

        <div class="item">
            <h2>6. Acesso Gratuito e Assinatura Paga</h2>

            <p>Oferecemos acesso gratuito ao Serviço com funcionalidades limitadas. Além disso, disponibilizamos uma assinatura paga, processada através do serviço de pagamento fornecido pelo Mercado Pago, que oferece acesso a recursos adicionais e aprimorados.</p>
            <p>Ao optar pela assinatura paga, você concorda em fornecer informações de pagamento válidas e autoriza o Mercado Pago a processar o pagamento das taxas associadas ao plano selecionado.</p>
        </div>

        <div class="item">
            <h2>7. Privacidade e Dados</h2>

            <p>Ao utilizar o Serviço, você concorda com nossa Política de Privacidade, disponível em <a href="{{ route('legal.privacy-policy') }}">{{ route('legal.privacy-policy') }}</a>.</p>
            <p>Respeitamos sua privacidade e tomamos medidas para proteger seus dados, conforme descrito em nossa Política de Privacidade.</p>
        </div>

        <div class="item">
            <h2>8. Modificações nos Termos</h2>

            <p>Podemos atualizar estes Termos periodicamente. As alterações entrarão em vigor após a publicação da versão revisada.</p>
            <p>Recomendamos que você revise regularmente estes Termos.</p>
        </div>

        <div class="item">
            <h2>9. Rescisão</h2>

            <p>Podemos encerrar ou suspender seu acesso ao Serviço a qualquer momento, por qualquer motivo, sem aviso prévio.</p>
        </div>

        <div class="item">
            <h2>10. Legislação Aplicável</h2>

            <p>Estes Termos são regidos pelas leis do Brasil, sem considerar conflitos de disposições legais.</p>
        </div>

        <div class="item">
            <h2>11. Aceitação</h2>

            <p>AO USAR O SERVIÇO OU OUTROS SERVIÇOS FORNECIDOS POR NÓS, VOCÊ RECONHECE QUE LEU ESTES TERMOS DE SERVIÇO E CONCORDA EM ESTAR VINCULADO(A) A ELES.</p>
        </div>

        <div class="item">
            <h2>12. Contato</h2>

            <p>Por favor, envie seus comentários, sugestões, solicitações de suporte técnico para nosso e-mail: <a href="mailto:{{ config('mail.from.address') }}">{{ config('mail.from.address') }}</a>.</p>
        </div>
    </div>
@endsection
