import Vue from 'vue'
import VueSweetalert2 from 'vue-sweetalert2';
import 'sweetalert2/dist/sweetalert2.min.css';

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

export const SAUtils = {
    install(Vue, options) {
        Vue.prototype.makeDefaultNotification = (status, message) => makeDefaultNotification(status, message)
    },
}
