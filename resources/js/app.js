require('./bootstrap');

window.Vue = require('vue').default;

// Library
import { router } from './route'
import Vue from 'vue';
// import vuetify from './plugin/vuetify' // path to vuetify export

// Component

import Base from './layout/Base'
// import Header from './inc/LayoutHeader.vue'

// Use

// Vue.component('layout-header', Header)


const components = require.context('./', true, /\.vue$/i);

components.keys().map(
    key => {
        if(key.split('/')[1] != 'page') {
            console.log(key);
            Vue.component(key.split('/').pop().split('.')[0], () => import(/* webpackChunkName: "[request]" */ `${key}`))
        }
    }
);

const app = new Vue({
    el:'#app',
    router,
    render (h) { return h(Base) }
    // vuetify,
})
