try {
    window.Popper = require('popper.js').default;
    window.$ = window.jQuery = require('jquery');
    require('bootstrap-v4-rtl');
    window.persianDate = require('persian-date/dist/persian-date.min.js');
    require('persian-datepicker/dist/js/persian-datepicker.js');
} catch (e) {}
window.Swal = require('sweetalert2');

window.axios = require('axios');
require('select2');
window.NProgress = require('nprogress');
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
require('./persiannumber.js');

window.clearForm = function clearForm(fields) {
    fields.forEach(function (field) {
        $('#' + field).val('');
    });
};

window.clearErrors = function clearErrors(fields) {
    fields.forEach(function (field) {
        $('#' + field).removeClass('is-invalid');
        $('#' + field + '-error').text('');
    });
};
/**
 * Next we will register the CSRF Token as a common header with Axios so that
 * all outgoing HTTP requests automatically have it attached. This is just
 * a simple convenience so we don't have to attach every token manually.
 */

// let token = document.head.querySelector('meta[name="csrf-token"]');
//
// if (token) {
//     window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
// } else {
//     console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
// }
