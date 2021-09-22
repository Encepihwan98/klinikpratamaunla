(self["webpackChunk"] = self["webpackChunk"] || []).push([["auth"],{

/***/ "./node_modules/@websanova/vue-auth/src/drivers/auth/bearer.js":
/*!*********************************************************************!*\
  !*** ./node_modules/@websanova/vue-auth/src/drivers/auth/bearer.js ***!
  \*********************************************************************/
/***/ (() => {

throw new Error("Module build failed: Error: ENOENT: no such file or directory, open 'C:\\Users\\arind\\OneDrive\\Desktop\\simrs_rowasiya\\node_modules\\@websanova\\vue-auth\\src\\drivers\\auth\\bearer.js'");

/***/ }),

/***/ "./node_modules/@websanova/vue-auth/src/drivers/http/axios.1.x.js":
/*!************************************************************************!*\
  !*** ./node_modules/@websanova/vue-auth/src/drivers/http/axios.1.x.js ***!
  \************************************************************************/
/***/ (() => {

throw new Error("Module build failed: Error: ENOENT: no such file or directory, open 'C:\\Users\\arind\\OneDrive\\Desktop\\simrs_rowasiya\\node_modules\\@websanova\\vue-auth\\src\\drivers\\http\\axios.1.x.js'");

/***/ }),

/***/ "./node_modules/@websanova/vue-auth/src/drivers/router/vue-router.2.x.js":
/*!*******************************************************************************!*\
  !*** ./node_modules/@websanova/vue-auth/src/drivers/router/vue-router.2.x.js ***!
  \*******************************************************************************/
/***/ (() => {

throw new Error("Module build failed: Error: ENOENT: no such file or directory, open 'C:\\Users\\arind\\OneDrive\\Desktop\\simrs_rowasiya\\node_modules\\@websanova\\vue-auth\\src\\drivers\\router\\vue-router.2.x.js'");

/***/ }),

/***/ "./resources/js/auth.js":
/*!******************************!*\
  !*** ./resources/js/auth.js ***!
  \******************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _websanova_vue_auth_src_drivers_auth_bearer__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @websanova/vue-auth/src/drivers/auth/bearer */ "./node_modules/@websanova/vue-auth/src/drivers/auth/bearer.js");
/* harmony import */ var _websanova_vue_auth_src_drivers_http_axios_1_x__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @websanova/vue-auth/src/drivers/http/axios.1.x */ "./node_modules/@websanova/vue-auth/src/drivers/http/axios.1.x.js");
/* harmony import */ var _websanova_vue_auth_src_drivers_router_vue_router_2_x__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! @websanova/vue-auth/src/drivers/router/vue-router.2.x */ "./node_modules/@websanova/vue-auth/src/drivers/router/vue-router.2.x.js");



var config = {
  auth: _websanova_vue_auth_src_drivers_auth_bearer__WEBPACK_IMPORTED_MODULE_0__.default,
  http: _websanova_vue_auth_src_drivers_http_axios_1_x__WEBPACK_IMPORTED_MODULE_1__.default,
  router: _websanova_vue_auth_src_drivers_router_vue_router_2_x__WEBPACK_IMPORTED_MODULE_2__.default,
  tokenDefaultName: 'laravel-jwt-auth',
  tokenStore: ['localStorage'],
  // API endpoints used in Vue Auth.
  registerData: {
    url: 'auth/register',
    method: 'POST',
    redirect: '/login'
  },
  loginData: {
    url: 'auth/login',
    method: 'POST',
    redirect: '',
    fetchUser: true
  },
  logoutData: {
    url: 'auth/logout',
    method: 'POST',
    redirect: '/',
    makeRequest: true
  },
  fetchData: {
    url: 'auth/user',
    method: 'GET',
    enabled: true
  },
  refreshData: {
    url: 'auth/refresh',
    method: 'GET',
    enabled: true,
    interval: 30
  }
};
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (config);

/***/ })

}]);