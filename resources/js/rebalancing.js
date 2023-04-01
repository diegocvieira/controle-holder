import { numberFormat } from './app'

new Vue({
    el: '#app',
    data () {
      return {
        wallet: []
      }
    },
    methods: {
        formatPrice(value) {
            return numberFormat(value, 2, ',', '.')
        },
        getClassColor(value) {
            let color = ''

            switch (value) {
                case 'Ações':
                    color = 'red'
                    break
                case 'FIIs':
                    color = 'blue'
                    break
                default:
                    color = 'grey'
                    break
            }

            return 'ticket-class-' + color
        },
        getTickets() {
            axios
                .get('/api/assets')
                .then(response => {
                    response.data.data.map(data => {
                        let wallet = {
                            class: data.class,
                            idealPercentage: data.ideal_percentage,
                            tickets: []
                        }

                        data.tickets.map(ticket => {
                            wallet.tickets.push({
                                code: ticket.code,
                                price: ticket.price ? ticket.price : null,
                                investedAmount: ticket.price ? ticket.quantity * ticket.price : null,
                                quantity: ticket.quantity,
                                currentPercentage: null,
                                class: data.class,
                                idealPercentage: ((ticket.ideal_percentage / 100) * (data.ideal_percentage / 100)) * 100
                            })
                        })

                        this.wallet.push(wallet)
                    })

                    this.getAssetsPrice()
                })
                .catch(error => console.log(error))
        },
        getAssetsPrice() {
            let data = [];

            this.wallet.map(assetClass => {
                assetClass.assets.map(asset => {
                    console.log(asset.price);

                    if (!asset.price) {
                        data.push({
                            'asset_class': assetClass.slug,
                            'ticker': asset.code
                        });
                    }
                });
            });

            if (data.length > 0) {
                axios.post('/api/prices', { data: data }).then(response => {
                    console.log(response.data);
                }).catch(error => console.log(error));
            }
        }
    },
    created () {
        this.getTickets()
    },
    watch: {
        wallet: {
            handler(wallet) {
                wallet.map(wallet => {
                    const totalAmount = wallet.tickets.map(ticket => {
                        return ticket.quantity * ticket.price
                    })
                    .reduce((item1, item2) => item1 + item2, 0)

                    wallet.tickets.map(ticket => {
                        ticket.currentPercentage = (((ticket.quantity * ticket.price) / totalAmount) * 100).toFixed(2)
                    })
                })
            },
            deep: true
        }
    }
})






















// import { numberFormat } from '../app'

// export default {
//     name: 'wallet-component',
//     template: `
//         <div>
//             <nav>
//                 <ul>
//                     <li>
//                         <a href="#" v-on:click.prevent="filterTickets('Ações')">Ações</a>
//                         <a href="#" v-on:click.prevent="filterTickets('FIIs')">FIIs</a>
//                     </li>
//                 </ul>
//             </nav>

//             <form method="POST" id="form-add-asset" v-on:submit.prevent="addAsset">
//                 <input type="text" name="code" placeholder="Código" />
//                 <input type="text" name="classification" placeholder="Nota" />
//                 <input type="text" name="quantity" placeholder="Quantidade" />
//                 <button type="submit">SALVAR</button>
//             </form>

//             <div class="table-container">
//                 <table class="table is-fullwidth is-hoverable">
//                     <thead>
//                         <tr>
//                             <th>#</th>
//                             <th>CÓDIGO</th>
//                             <th>QUANTIDADE</th>
//                             <th>% CLASSE</th>
//                             <th>% ATUAL</th>
//                         </tr>
//                     </thead>

//                     <tbody>
//                         <template v-for="(walletItem, walletKey) in filteredWallet">
//                             <tr v-for="(ticket, ticketKey) in walletItem.tickets">
//                                 <td>{{ (walletKey * wallet.length + ticketKey) + 1 }}</td>
//                                 <td>{{ ticket.code }}</td>
//                                 <td>{{ ticket.quantity }}</td>
//                                 <td>{{ ticket.idealPercentage }}%</td>
//                                 <td>{{ ticket.currentPercentage }}%</td>
//                             </tr>
//                         </template>
//                     </tbody>
//                 </table>
//             </div>
//         </div>
//     `,
//     data () {
//         return {
//             classFilter: null,
//             wallet: []
//         }
//     },
//     methods: {
//         addAsset(event) {
//             this.wallet.map(assetClass => {
//                 if (assetClass.class == this.classFilter) {
//                     assetClass.tickets.push({
//                         code: event.target.elements.code.value,
//                         price: null,
//                         investedAmount: null,
//                         quantity: event.target.elements.quantity.value,
//                         currentPercentage: null,
//                         class: this.classFilter,
//                         idealPercentage: 0,
//                         classification: parseInt(event.target.elements.classification.value)
//                     });
//                 }
//             });

//             this.getTicketsPrice();

//             event.target.reset();
//         },
//         filterTickets: function(val) {
//             this.classFilter = val;
//         },
//         getTickets() {
//             axios
//                 .get('/api/tickets')
//                 .then(response => {
//                     response.data.data.map(data => {
//                         let wallet = {
//                             class: data.class,
//                             idealPercentage: data.ideal_percentage,
//                             tickets: []
//                         }

//                         data.tickets.map(ticket => {
//                             wallet.tickets.push({
//                                 code: ticket.code,
//                                 price: ticket.price ? ticket.price : null,
//                                 investedAmount: ticket.price ? ticket.quantity * ticket.price : null,
//                                 quantity: ticket.quantity,
//                                 currentPercentage: null,
//                                 class: data.class,
//                                 idealPercentage: 0,
//                                 classification: ticket.classification
//                             });
//                         });

//                         this.wallet.push(wallet);
//                     })

//                     this.classFilter = this.wallet[0].class

//                     this.getTicketsPrice();
//                 })
//                 .catch(error => console.log(error))
//         },
//         getTicketsPrice() {
//             this.wallet.map(wallet => {
//                 wallet.tickets.map(ticket => {
//                     if (!ticket.price) {
//                         axios.get('/api/prices/' + ticket.code).then(response => {
//                             ticket.price = response.data
//                             ticket.investedAmount = ticket.quantity * response.data
//                         }).catch(error => console.log(error));
//                     }
//                 })
//             })
//         }
//     },
//     created () {
//         this.getTickets();
//     },
//     computed: {
//         filteredWallet() {
//             return this.wallet.filter(item => item.class == this.classFilter);
//         }
//     },
//     watch: {
//         wallet: {
//             handler(assetClasses) {
//                 assetClasses.map(assetClass => {
//                     let totalAmount = 0;
//                     let sumClassifications = 0;

//                     assetClass.tickets.map(ticket => {
//                         totalAmount += ticket.quantity * ticket.price;
//                         sumClassifications += ticket.classification;
//                     });

//                     assetClass.tickets.map(ticket => {
//                         ticket.idealPercentage = (ticket.classification / sumClassifications * 100).toFixed(2);
//                         ticket.currentPercentage = (ticket.quantity * ticket.price / totalAmount * 100).toFixed(2);
//                     });
//                 })
//             },
//             deep: true
//         }
//     }
// }
