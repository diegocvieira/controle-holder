export default {
    install(app, options) {
        app.config.globalProperties.$moneyFormat = function (number, currency = 'BRL') {
            const numericValue = number.toString().replace(/\D/g, '');
            const locale = currency === 'BRL' ? 'pt-BR' : 'en-US';

            return new Intl.NumberFormat(locale, {
                style: 'currency',
                currency: currency,
                minimumFractionDigits: 2
            }).format(numericValue / 100);
        }
    }
};
