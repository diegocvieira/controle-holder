import { numberFormat } from '../app'

export default {
    name: 'wallet-component',
    template: `
        <div>
            <nav>
                <ul>
                    <li>
                        <a href="#" v-on:click.prevent="filterTickets('Ações')">Ações</a>
                        <a href="#" v-on:click.prevent="filterTickets('FIIs')">FIIs</a>
                    </li>
                </ul>
            </nav>
            <div class="table-container">
                <table class="table is-fullwidth is-hoverable">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>CÓDIGO</th>
                            <th>QUANTIDADE</th>
                            <th>% CLASSE</th>
                        </tr>
                    </thead>

                    <tbody>
                        <template v-for="(walletItem, walletKey) in filteredWallet">
                            <tr v-for="(ticket, ticketKey) in walletItem.tickets">
                                <td>{{ (walletKey * wallet.length + ticketKey) + 1 }}</td>
                                <td>{{ ticket.code }}</td>
                                <td>{{ ticket.quantity }}</td>
                                <td>{{ ticket.idealPercentage }}%</td>
                            </tr>
                        </template>
                    </tbody>
                </table>
            </div>
        </div>
    `,
    data () {
        return {
            classFilter: null,
            wallet: []
        }
    },
    methods: {
        filterTickets: function(val) {
            this.classFilter = val;
        },
        getTickets() {
            axios
                .get('/api/tickets')
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
                                idealPercentage: ticket.ideal_percentage
                            })
                        })

                        this.wallet.push(wallet)
                    })

                    this.classFilter = this.wallet[0].class

                    this.getTicketsPrice()
                })
                .catch(error => console.log(error))
        },
        getTicketsPrice() {
            this.wallet.map(wallet => {
                wallet.tickets.map(ticket => {
                    if (!ticket.price) {
                        axios
                            .get('/api/prices/' + ticket.code)
                            .then(response => {
                                ticket.price = response.data
                                ticket.investedAmount = ticket.quantity * response.data
                            })
                            .catch(error => console.log(error))
                    }
                })
            })
        }
    },
    created () {
        this.getTickets()
    },
    computed: {
        filteredWallet() {
            return this.wallet.filter(item => item.class == this.classFilter)
        }
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
        },
        // classFilter() {
        //     console.log('ok')
        //     this.wallet.filter(item => item.class == this.classFilter)
        // }
    }
}
