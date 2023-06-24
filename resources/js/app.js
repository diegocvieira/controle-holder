import Vue from 'vue';
import axios from 'axios';

window.Vue = Vue;
window.axios = axios;
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

export const numberFormat = (number, currency = 'BRL') => {
    const numericValue = number.toString().replace(/\D/g, '');
    const locale = currency === 'BRL' ? 'pt-BR' : 'en-US';

    return new Intl.NumberFormat(locale, {
        style: 'currency',
        currency: currency,
        minimumFractionDigits: 2
    }).format(numericValue / 100);
};
