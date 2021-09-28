"use strict";
(self["webpackChunk"] = self["webpackChunk"] || []).push([["index"],{

/***/ "./resources/js/router/index.js":
/*!**************************************!*\
  !*** ./resources/js/router/index.js ***!
  \**************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var vue__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! vue */ "./node_modules/vue/dist/vue.esm.js");
/* harmony import */ var vue_router__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! vue-router */ "./node_modules/vue-router/dist/vue-router.esm.js");
/* harmony import */ var _routes__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./routes */ "./resources/js/router/routes.js");



vue__WEBPACK_IMPORTED_MODULE_1__.default.use(vue_router__WEBPACK_IMPORTED_MODULE_2__.default);
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (Promise.all(_routes__WEBPACK_IMPORTED_MODULE_0__.default).then(function (routes) {
  console.log(routes);
  return new vue_router__WEBPACK_IMPORTED_MODULE_2__.default({
    mode: 'history',
    routes: routes
  });
}));

/***/ })

}]);