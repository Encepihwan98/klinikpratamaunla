"use strict";
(self["webpackChunk"] = self["webpackChunk"] || []).push([["utils-RemoteRequest"],{

/***/ "./resources/js/utils/RemoteRequest.js":
/*!*********************************************!*\
  !*** ./resources/js/utils/RemoteRequest.js ***!
  \*********************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "RRUtils": () => (/* binding */ RRUtils)
/* harmony export */ });
/* harmony import */ var vue__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! vue */ "./node_modules/vue/dist/vue.esm.js");
/* harmony import */ var axios__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! axios */ "./node_modules/axios/index.js");
/* harmony import */ var axios__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(axios__WEBPACK_IMPORTED_MODULE_0__);


(axios__WEBPACK_IMPORTED_MODULE_0___default().defaults.headers.common.Authorization) = "Bearer ".concat(localStorage.getItem('token')); // Use

vue__WEBPACK_IMPORTED_MODULE_1__.default.use((axios__WEBPACK_IMPORTED_MODULE_0___default()));

function isLoggedIn() {
  return localStorage.getItem('token');
}

function requestModule() {
  var defaultModule = [{
    path: '*',
    component: function component() {
      return Promise.resolve().then(function webpackMissingModule() { var e = new Error("Cannot find module './pages/PageNotFound'"); e.code = 'MODULE_NOT_FOUND'; throw e; });
    },
    name: 'pagenotfound'
  }, {
    path: '/',
    component: function component() {
      return Promise.resolve().then(function webpackMissingModule() { var e = new Error("Cannot find module './pages/auth/Login'"); e.code = 'MODULE_NOT_FOUND'; throw e; });
    },
    name: 'index'
  }, {
    path: '/login',
    component: function component() {
      return Promise.resolve().then(function webpackMissingModule() { var e = new Error("Cannot find module './pages/auth/Login'"); e.code = 'MODULE_NOT_FOUND'; throw e; });
    },
    name: 'login'
  }];
  var url = window.location.origin + "/api/v1/my-modules/";
  axios__WEBPACK_IMPORTED_MODULE_0___default().post(url).then(function (response) {
    console.log(response);

    if (response.status == 200) {
      console.log(response);
    }
  })["catch"](function (e) {
    console.log(e);
  });
}

var RRUtils = {
  install: function install(Vue, options) {
    Vue.prototype.requestModule = function () {
      return requestModule();
    };
  }
};

/***/ })

}]);