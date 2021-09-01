require('./bootstrap');

window.Vue = require('vue').default;

// import Vue from 'vue';
// Library
import { router } from './route'
// import vuetify from './plugin/vuetify' // path to vuetify export

// Layout
import Base from './layout/Base'

// Use

const app = new Vue({
    el:'#app',
    router,
    render (h) { return h(Base) }
    // vuetify,
})
