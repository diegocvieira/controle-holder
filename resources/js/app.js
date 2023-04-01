// require('./bootstrap');
import Vue from 'vue'
import axios from 'axios';

window.Vue = Vue;
window.axios = axios;
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

// export const numberFormat = (number, decimal, decimalSeparator, milharSeparator) => {
//     var number = (number + '').replace(/[^0-9+\-Ee.]/g, '');

//     const n = !isFinite(+number) ? 0 : +number;
//     const prec = !isFinite(+decimal) ? 0 : Math.abs(decimal);
//     const sep = (typeof milharSeparator === 'undefined') ? ',' : milharSeparator;
//     const dec = (typeof decimalSeparator === 'undefined') ? '.' : decimalSeparator;
//     let s = '';
//     const toFixedFix = function (n, prec) {
//         const k = Math.pow(10, prec);
//         return '' + Math.round(n * k) / k;
//     };

//     s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');

//     if (s[0].length > 3) {
//         s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
//     }

//     if ((s[1] || '').length < prec) {
//         s[1] = s[1] || '';
//         s[1] += new Array(prec - s[1].length + 1).join('0');
//     }

//     return s.join(dec);
// }
