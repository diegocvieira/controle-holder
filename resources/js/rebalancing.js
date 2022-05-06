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
                                idealPercentage: ((ticket.ideal_percentage / 100) * (data.ideal_percentage / 100)) * 100
                            })
                        })

                        this.wallet.push(wallet)
                    })

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
