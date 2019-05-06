try {
    window.Popper = require('popper.js').default;
    window.$ = window.jQuery = require('jquery');

    require('bootstrap-v4-rtl');
} catch (e) {}



const app = new Vue({
    el: '#app'
});
