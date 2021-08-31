require('./bootstrap');

window.Vue = require('vue');
import Myheader from'./components/Myheader'


const app = new Vue({
    el: '#app',
        Myheader
});
