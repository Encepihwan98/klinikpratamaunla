require('./bootstrap');

window.Vue = require('vue').default;

// Library
import { router } from './route'
import Vue from 'vue';
import vuetify from './plugins/vuetify' // path to vuetify export

// Component

import Base from './layouts/Base'
// import Header from './inc/LayoutHeader.vue'

// Use

// Vue.component('layout-header', Header)


const components = require.context('./', true, /\.vue$/i);

components.keys().map(
    key => {
        if(key.split('/')[1] != 'pages') {
            console.log(key.split('/').pop().split('.')[0]);
            Vue.component(key.split('/').pop().split('.')[0], () => import(/* webpackChunkName: "[request]" */ `${key}`))
        }
    }
);

const app = new Vue({
    el:'#app',
    router,
    vuetify,
    render (h) { return h(Base) }
})
