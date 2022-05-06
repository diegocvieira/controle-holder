@extends('layouts/master')

@section('content')

<main id="app">
    <div class="container">
        <div class="columns">
            <div class="column is-12">
                <div class="table-container">
                    <table class="table is-fullwidth is-hoverable">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>CÓDIGO</th>
                                <th>CLASSE</th>
                                <th>COTAÇÃO</th>
                                <th>QUANTIDADE</th>
                                <th>VALOR INVESTIDO</th>
                                <th>% ATUAL</th>
                                <th>% IDEAL</th>
                            </tr>
                        </thead>

                        <tbody>
                            <template v-for="(walletItem, walletKey) in wallet">
                                <tr v-for="(ticket, ticketKey) in walletItem.tickets">
                                    <td>@{{ (walletKey * wallet.length + ticketKey) + 1 }}</td>
                                    <td>@{{ ticket.code }}</td>
                                    <td><span class="ticket-class" :class="getClassColor(walletItem.class)">@{{ walletItem.class }}</span></td>
                                    <td>@{{ ticket.price ? 'R$ ' + formatPrice(ticket.price) : 'carregando' }}</td>
                                    <td>@{{ ticket.quantity }}</td>
                                    <td>@{{ ticket.investedAmount ? 'R$ ' + formatPrice(ticket.investedAmount) : 'carregando' }}</td>
                                    <td>@{{ ticket.currentPercentage ? ticket.currentPercentage + '%' : 'carregando' }}</td>
                                    <td>@{{ ticket.idealPercentage }}%</td>
                                </tr>
                            </template>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</main>

@endsection

@section('script')

<script type="text/javascript" src="{{ mix('js/rebalancing.js') }}"></script>

@endsection
