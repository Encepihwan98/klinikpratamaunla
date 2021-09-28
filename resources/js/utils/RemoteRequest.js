import Vue from 'vue'
import axios from 'axios';
import VueSweetalert2 from 'vue-sweetalert2';
import 'sweetalert2/dist/sweetalert2.min.css';

axios.defaults.headers.common[
    "Authorization"
  ] = `Bearer ${localStorage.getItem("token")}`;

// Use
Vue.use(VueSweetalert2);

function makeDefaultNotification(status, message) {
    Vue.swal({
        icon: status,
        title: message,
        position: "top-right",
        iconColor: "white",
        customClass: {
            popup: "colored-toast",
        },
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
    });
}

function errorRequestState(e) {
    if (e.response.status == 400 || e.response.status == 403) {
        makeDefaultNotification(
            e.response.data.status,
            e.response.data.message
        );
    } else if (e.response.status == 500) {
        makeDefaultNotification(
            'error',
            'Ada masalah di Server'
        );
    }
}

function requestModule() {
    let defaultModule = []

    axios
        .post('/api/v1/my-modules/')
        .then((response) => {
            if (response.status == 200) {
                response.data.data.forEach((v) => {
                    let splitPath = v.url.split('/')
                    let path = splitPath.slice(3, splitPath.length).join('/').toLowerCase()
                    v.path = v.slug == '#' ? v.slug : `/${path}`
                    defaultModule.push(v)
                })
            }
        })
        .catch((e) => {
            errorRequestState(e);
        });

    return defaultModule;
}

export const RRUtils = {
    install(Vue, options) {
        Vue.prototype.requestModule = () => requestModule(),
        Vue.prototype.errorRequestState = (e) => errorRequestState(e),
        Vue.prototype.makeDefaultNotification = (status, message) => makeDefaultNotification(status, message)
    },
}
