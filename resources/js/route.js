import Vue from 'vue'
import VueRouter from 'vue-router'

Vue.use(VueRouter)

const pages = require.context('./', true, /\.vue$/i);

let routes = [
    {path: '/', component: () => import(/* webpackChunkName: "[request]" */ `./page/auth/Login`) }
]

pages.keys().forEach((element, i) => {
    if(element.split('/')[1] == 'page') {
        let urlSplit = element.split('.')
        let urlSlug = urlSplit[1].split('/')[2]
        let urlPath = element.split('/').pop().split('.')[0]
        let urlPathLowerCase = urlPath.match(/[A-Z][a-z]+/g).join('-').toLowerCase()
        let fixUrl = '/'+urlSlug+'/'+urlPathLowerCase

        routes.push({
            path: fixUrl,
            name: urlPathLowerCase,
            component: () => import(/* webpackChunkName: "[request]" */ `${element}`)
        })
    }
});

console.log(routes);

export const router = new VueRouter({
    mode: 'history',
    routes: routes
})
