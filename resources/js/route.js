import Vue from 'vue'
import VueRouter from 'vue-router'

Vue.use(VueRouter)

function isLoggedIn() {
    return localStorage.getItem('token')
}

const pages = require.context('./', true, /\.vue$/i);

let routes = [
    { path: '*', component: () => import(/* webpackChunkName: "[request]" */ `./pages/PageNotFound`), name: 'pagenotfound' },
    { path: '/', component: () => import(/* webpackChunkName: "[request]" */ `./pages/auth/Login`), name: 'index' },
    { path: '/login', component: () => import(/* webpackChunkName: "[request]" */ `./pages/auth/Login`), name: 'login' },
    {
        path: '/dashboard', component: () => import(/* webpackChunkName: "[request]" */ `./pages/Dashboard`), name: 'dashboard', beforeEnter: (to, from, next) => {
            if (isLoggedIn()) {
                next()
            } else {
                next('/')
            }
        }
    }
]

pages.keys().forEach((element, i) => {
    if (element.split('/')[1] == 'pages') {
        let urlSplit = element.split('.')
        let urlSlug = urlSplit[1].split('/')[2]
        let urlPath = element.split('/').pop().split('.')[0]
        let urlPathLowerCase = urlPath.match(/[A-Z][a-z]+/g).join('-').toLowerCase()
        let fixUrl = '/' + urlSlug + '/' + urlPathLowerCase
        if (urlSlug != 'auth' && urlSlug != 'Dashboard' && urlSlug != 'PageNotFound') {
            routes.push({
                path: fixUrl,
                name: urlPathLowerCase,
                component: () => import(/* webpackChunkName: "[request]" */ `${element}`),
                beforeEnter: (to, from, next) => {
                    if (isLoggedIn()) {
                        next()
                    } else {
                        next('/')
                    }
                }
            })
        }
    }
});

console.log(routes);

export const router = new VueRouter({
    mode: 'history',
    routes: routes
})
