@extends('layouts.dashboard', [
    'page' => 'target-assets',
    'headerComponent' => true,
    'loaderComponent' => true,
    'alertComponent' => true,
    'modalComponent' => true
])

@section('content')
    @include ('partials.page-header-title', [
        'page' => 'target',
        'title' => 'Ativos'
    ])

    <form method="POST" class="form form-inline" @submit.prevent="addAsset">
        <div class="field-container">
            <input type="text" v-model="form.ticker" placeholder="Ticker" class="input-field" />
        </div>

        <div class="field-container">
            <input type="text" v-model="form.rating" placeholder="Nota" class="input-field" />
        </div>

        <div class="field-container">
            <input type="text" v-model="form.quantity" placeholder="Quantidade" class="input-field" />
        </div>

        <div class="field-container">
            <button type="submit" class="button button-submit">ADICIONAR</button>
        </div>
    </form>

    <div v-if="filteredWallet.length === 0">
        @include('partials.empty-results', [
            'message' => 'Você ainda não tem nenhum ativo cadastrado...'
        ])
    </div>
    <div v-else>
        <nav class="is-flex mb-20">
            <ul class="is-flex">
                <li v-for="filterOption in filterOptions">
                    <a href="#" @click.prevent="filterTickets(filterOption.slug)" :class="'link ' + (filterOption.slug === classFilter ? 'is-active' : '')">@{{ filterOption.name }}</a>
                </li>
            </ul>
        </nav>

        <div class="table" v-cloak>
            <table>
                <thead>
                    <tr>
                        <th style="width: 50px;">#</th>
                        <th>CLASSE</th>
                        <th>TICKER</th>
                        <th>QUANTIDADE</th>
                        <th>NOTA</th>
                        <th>% CLASSE</th>
                        <th>AÇÕES</th>
                    </tr>
                </thead>

                <tbody>
                    <tr v-for="(asset, assetKey) in filteredWallet">
                        <td>@{{ assetKey + 1 }}</td>
                        <td>
                            <span :class="'asset-class ' + asset.asset_class.slug">@{{ asset.asset_class.name }}</span>
                        </td>
                        <td>@{{ asset.ticker }}</td>
                        <td>
                            <input v-if="asset.showInputs" type="text" v-model="asset.quantity" class="input-field" />
                            <span v-else>@{{ asset.quantity }}</span>
                        </td>
                        <td>
                            <input v-if="asset.showInputs" type="text" v-model="asset.rating" class="input-field" />
                            <span v-else>@{{ asset.rating }}</span>
                        </td>
                        <td>@{{ asset.idealPercentage }}%</td>
                        <td>
                            <button type="button" title="Salvar" @click="saveEditAsset(asset.ticker)" class="button button-save" v-if="asset.showInputs">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48">
                                    <g data-name="Layer 2">
                                        <path d="M24 0a24 24 0 1 0 24 24A24 24 0 0 0 24 0Zm0 44a20 20 0 1 1 20-20 20 20 0 0 1-20 20Z"/>
                                        <path d="m20 29.17-6.59-6.58-2.82 2.82L20 34.83l17.41-17.42-2.82-2.82L20 29.17z"/>
                                    </g>
                                </svg>
                            </button>
                            <button type="button" title="Editar" @click="editAsset(asset.ticker)" class="button button-edit" v-else>
                                <svg aria-hidden="true" focusable="false" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512">
                                    <path fill="currentColor" d="M402.6 83.2l90.2 90.2c3.8 3.8 3.8 10 0 13.8L274.4 405.6l-92.8 10.3c-12.4 1.4-22.9-9.1-21.5-21.5l10.3-92.8L388.8 83.2c3.8-3.8 10-3.8 13.8 0zm162-22.9l-48.8-48.8c-15.2-15.2-39.9-15.2-55.2 0l-35.4 35.4c-3.8 3.8-3.8 10 0 13.8l90.2 90.2c3.8 3.8 10 3.8 13.8 0l35.4-35.4c15.2-15.3 15.2-40 0-55.2zM384 346.2V448H64V128h229.8c3.2 0 6.2-1.3 8.5-3.5l40-40c7.6-7.6 2.2-20.5-8.5-20.5H48C21.5 64 0 85.5 0 112v352c0 26.5 21.5 48 48 48h352c26.5 0 48-21.5 48-48V306.2c0-10.7-12.9-16-20.5-8.5l-40 40c-2.2 2.3-3.5 5.3-3.5 8.5z"></path>
                                </svg>
                            </button>

                            <button type="button" title="Excluir" @click="deleteAsset(asset.ticker)" class="button button-delete">
                                <svg aria-hidden="true" focusable="false" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
                                    <path fill="currentColor" d="M32 464a48 48 0 0 0 48 48h288a48 48 0 0 0 48-48V128H32zm272-256a16 16 0 0 1 32 0v224a16 16 0 0 1-32 0zm-96 0a16 16 0 0 1 32 0v224a16 16 0 0 1-32 0zm-96 0a16 16 0 0 1 32 0v224a16 16 0 0 1-32 0zM432 32H312l-9.4-18.7A24 24 0 0 0 281.1 0H166.8a23.72 23.72 0 0 0-21.4 13.3L136 32H16A16 16 0 0 0 0 48v32a16 16 0 0 0 16 16h416a16 16 0 0 0 16-16V48a16 16 0 0 0-16-16z" class=""></path>
                                </svg>
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
@endsection
