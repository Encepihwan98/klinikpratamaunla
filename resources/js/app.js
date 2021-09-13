require('./bootstrap');

window.Vue = require('vue').default;

// Library
import { router } from './route'
import Vue from 'vue';
import vuetify from './plugins/vuetify'
import {SAUtils} from './utils/SweetalertUtils'

// Component
import Base from './layouts/Base'

// Use
Vue.use(SAUtils)

const components = require.context('./', true, /\.vue$/i);

components.keys().map(
    key => {
        if(key.split('/')[1] != 'pages') {
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
