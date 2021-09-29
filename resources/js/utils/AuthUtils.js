function isLoggedIn() {
    return localStorage.getItem('token')
}

function requestCurrentUser() {
    let currentUser = [];
    axios
        .post('/api/v1/user/')
        .then((response) => {
            if (response.status == 200) {
                currentUser.push(response.data.data);
            }
        })
        .catch((e) => {
            errorRequestState(e);
        });
    return currentUser;
}

function requestRole() {
    let roles = [];
    axios
        .post('/api/v1/role/')
        .then((response) => {
            if (response.status == 200) {
                response.data.data.forEach(function (data) {
                    roles.push(data["name"]);
                });
            }
        })
        .catch((e) => {
            errorRequestState(e);
        });
    return roles;
}

function redirectIfNotHaveAccess(data, currentPath) {
    let web = {}
    data.forEach((response, index) => {
        if (response.path == currentPath && response.read == 1) {
            web.create = response.create;
            web.read = response.read;
            web.update = response.update;
            web.delete = response.delete;
            web.print = response.print;
            web.filterOpen = false;
            web.isTableLoad = false;
        }
        if (response.is_home == 1) {
            web.home = response.slug
        }
    });
    return web;
}

export const AuthUtils = {
    install(Vue, options) {
        Vue.prototype.requestCurrentUser = () => requestCurrentUser(),
            Vue.prototype.requestRole = () => requestRole(),
            Vue.prototype.isLoggedIn = () => isLoggedIn(),
            Vue.prototype.redirectIfNotHaveAccess = (data, currentPath) => redirectIfNotHaveAccess(data, currentPath)
    },
}
