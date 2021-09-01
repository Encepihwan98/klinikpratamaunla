import Vue from 'vue'
import VueRouter from 'vue-router'

// import BASE from './layout/base'
// import Login from './page/auth/Login'
const Login = () => import('./page/auth/Login')
import MMenu from './page/system/MenuManagement'
import MRole from './page/system/RolesManagement'
import MUser from './page/system/UserManagement'

Vue.use(VueRouter)

const pages = require.context('./', true, /\.vue$/i);

let routes = []
pages.keys().forEach((element, i) => {
    if(element.split('/')[1] == 'page') {
        console.log(element);
        let urlSplit = element.split('.')
        let urlSlug = urlSplit[1].split('/')[1]
        let urlPath = element.split('/').pop().split('.')[0]
        let fixUrl = '/'+urlSlug+'/'+urlPath.match(/[A-Z][a-z]+/g).join('-').toLowerCase()
        const module = () => import(element)
        routes.push({
            path: fixUrl,
            component: module
        })
    }
});

// components.keys().map(
//     // key => Vue.component(key.split('/').pop().split('.')[0], components(key))
//     console.log(key)
// );


// let routes = [
//     { path: '/', component: Login },
//     { path: '/login', component: Login },
//     { path: '/administrator/menu-management', component: MMenu },
//     { path: '/administrator/role-management', component: MRole },
//     { path: '/administrator/user-management', component: MUser }
// ]

console.log(routes);

export const router = new VueRouter({
    // mode: 'history',
    routes
})
