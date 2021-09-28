"use strict";
(self["webpackChunk"] = self["webpackChunk"] || []).push([["utils-AuthUtils"],{

/***/ "./resources/js/utils/AuthUtils.js":
/*!*****************************************!*\
  !*** ./resources/js/utils/AuthUtils.js ***!
  \*****************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "SAUtils": () => (/* binding */ SAUtils)
/* harmony export */ });
/* harmony import */ var vue__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! vue */ "./node_modules/vue/dist/vue.esm.js");
/* harmony import */ var vue_sweetalert2__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! vue-sweetalert2 */ "./node_modules/vue-sweetalert2/dist/vue-sweetalert.umd.js");
/* harmony import */ var vue_sweetalert2__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(vue_sweetalert2__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var sweetalert2_dist_sweetalert2_min_css__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! sweetalert2/dist/sweetalert2.min.css */ "./node_modules/sweetalert2/dist/sweetalert2.min.css");


 // Use

vue__WEBPACK_IMPORTED_MODULE_2__.default.use((vue_sweetalert2__WEBPACK_IMPORTED_MODULE_0___default()));

function makeDefaultNotification(status, message) {
  vue__WEBPACK_IMPORTED_MODULE_2__.default.swal({
    icon: status,
    title: message,
    position: "top-right",
    iconColor: "white",
    customClass: {
      popup: "colored-toast"
    },
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true
  });
}

var SAUtils = {
  install: function install(Vue, options) {
    Vue.prototype.makeDefaultNotification = function (status, message) {
      return makeDefaultNotification(status, message);
    };
  }
};

/***/ })

}]);