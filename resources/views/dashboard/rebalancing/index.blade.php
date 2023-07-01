@extends('layouts/master')

@section('content')

<main class="main" id="rebalancing-page">
    <header-component page="rebalancing"></header-component>
    <alert-message-component ref="alertMessage"></alert-message-component>
    <modal-component ref="modal"></modal-component>

    <div class="main-content">
        <form method="POST" class="form form-inline" @submit.prevent="calculateInvestment">
            <div class="field-container">
                <input type="input" v-model="investmentAmount" @input="formatMoney()" placeholder="Valor do aporte" class="input-field" />
            </div>

            <div class="field-container">
                <button type="submit" class="button button-submit">CALCULAR</button>
            </div>
        </form>

        <div class="table">
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th class="tooltip" data-title="Classe / Categoria do Ativo">CLASSE</th>
                        <th class="tooltip" data-title="Código de negociação do ativo">TICKER</th>
                        <th class="tooltip" data-title="Valor das cotações são referentes ao último fechamento da B3">COTAÇÃO</th>
                        <th class="tooltip" data-title="Quantidade que você tem em custódia">QTD</th>
                        <th class="tooltip" data-title="Valor total investido nesse ativo">VLR INV.</th>
                        <th class="tooltip" data-title="Porcentagem desejada, definida na carteira meta">% META</th>
                        <th class="tooltip" data-title="Porcentagem atual alocado nesse ativo">% ATUAL</th>
                        <th class="tooltip" data-title="Diferença entre a porcenteagem atual e objetivo">% DIF</th>
                        <th class="tooltip" data-title="Quantidade que deve ser aportada nesse ativo">QTD APT</th>
                        <th class="tooltip" data-title="Valor que deve ser aportado">VLR APT</th>
                        <td class="tooltip" data-title="Lançar as operações de entrada e saída. Para lançar a nossa sugestão clique no botão verde">OP</td>
                    </tr>
                </thead>

                <tbody>
                    <tr v-for="(asset, assetKey) in wallet">
                        <td>@{{ assetKey + 1 }}</td>
                        <td><span :class="'asset-class ' + asset.asset_class.slug">@{{ asset.asset_class.name }}</span></td>
                        <td>@{{ asset.ticker }}</td>
                        <td>@{{ asset.price ? formatPrice(asset.price) : '-' }}</td>
                        <td>@{{ asset.quantity }}</td>
                        <td>@{{ asset.investedAmount ? formatPrice(asset.investedAmount) : '-' }}</td>
                        <td>@{{ asset.idealPercentage }}%</td>
                        <td>@{{ asset.currentPercentage ? asset.currentPercentage + '%' : '-' }}</td>
                        <td>@{{ asset.currentPercentage ? (asset.idealPercentage - asset.currentPercentage).toFixed(2) + '%' : '-' }}</td>
                        <td>@{{ asset.investmentQuantity }}</td>
                        <td>@{{ asset.investmentAmount ? formatPrice(asset.investmentAmount) : 'R$ 00,00' }}</td>
                        <td>
                            <button type="button" title="OP" @click="operations(asset.ticker)">OP</button>
                            <button type="button" title="Lançar" @click="invest(asset.ticker)">LANÇAR</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</main>

@endsection

@section('script')

<script type="module" src="{{ Vite::asset('resources/js/rebalancing.js') }}"></script>

@endsection
