(self["webpackChunk"] = self["webpackChunk"] || []).push([["router-routes"],{

/***/ "./resources/js/router/routes.js":
/*!***************************************!*\
  !*** ./resources/js/router/routes.js ***!
  \***************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var axios__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! axios */ "./node_modules/axios/index.js");
/* harmony import */ var axios__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(axios__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var vue__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! vue */ "./node_modules/vue/dist/vue.esm.js");
/* harmony import */ var vue_router__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! vue-router */ "./node_modules/vue-router/dist/vue-router.esm.js");



vue__WEBPACK_IMPORTED_MODULE_1__.default.use(vue_router__WEBPACK_IMPORTED_MODULE_2__.default);

function isLoggedIn() {
  return localStorage.getItem('token');
}

(axios__WEBPACK_IMPORTED_MODULE_0___default().defaults.headers.common.Authorization) = "Bearer ".concat(localStorage.getItem('token'));
var routes = [{
  path: '*',
  component: function component() {
    return Promise.resolve(/*! import() */).then(__webpack_require__.bind(__webpack_require__, /*! ./../pages/PageNotFound */ "./resources/js/pages/PageNotFound.vue"));
  },
  name: 'pagenotfound'
}, {
  path: '/',
  component: function component() {
    return Promise.resolve(/*! import() */).then(__webpack_require__.bind(__webpack_require__, /*! ./../pages/auth/Login.vue */ "./resources/js/pages/auth/Login.vue"));
  },
  name: 'index'
}, {
  path: '/login',
  component: function component() {
    return Promise.resolve(/*! import() */).then(__webpack_require__.bind(__webpack_require__, /*! ./../pages/auth/Login */ "./resources/js/pages/auth/Login.vue"));
  },
  name: 'login'
}];

var pages = __webpack_require__("./resources/js/router sync recursive \\.vue$/");

pages.keys().forEach(function (element, i) {
  if (element.split('/')[1] == 'pages') {
    var urlSplit = element.split('.');
    var urlSlug = urlSplit[1].split('/')[2];
    var urlPath = element.split('/').pop().split('.')[0];
    var urlPathLowerCase = urlPath.match(/[A-Z][a-z]+/g).join('-').toLowerCase();
    var fixUrl = '/' + urlSlug + '/' + urlPathLowerCase;

    if (urlSlug != 'auth') {
      routes.push({
        path: fixUrl,
        name: urlPathLowerCase,
        component: function component() {
          return __webpack_require__("./resources/js/router lazy recursive ^.*$")("".concat(element));
        },
        beforeEnter: function beforeEnter(to, from, next) {
          if (isLoggedIn()) {
            next();
          } else {
            next('/');
          }
        }
      });
    }
  }
});
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (routes);

/***/ }),

/***/ "./resources/js/router lazy recursive ^.*$":
/*!******************************************************************************!*\
  !*** ./resources/js/router/ lazy ^.*$ chunkName: [request] namespace object ***!
  \******************************************************************************/
/***/ ((module, __unused_webpack_exports, __webpack_require__) => {

var map = {
	".": [
		"./resources/js/router/index.js",
		"index"
	],
	"./": [
		"./resources/js/router/index.js",
		"index"
	],
	"./index": [
		"./resources/js/router/index.js",
		"index"
	],
	"./index.js": [
		"./resources/js/router/index.js",
		"index"
	],
	"./routes": [
		"./resources/js/router/routes.js"
	],
	"./routes.js": [
		"./resources/js/router/routes.js"
	]
};
function webpackAsyncContext(req) {
	if(!__webpack_require__.o(map, req)) {
		return Promise.resolve().then(() => {
			var e = new Error("Cannot find module '" + req + "'");
			e.code = 'MODULE_NOT_FOUND';
			throw e;
		});
	}

	var ids = map[req], id = ids[0];
	return Promise.all(ids.slice(1).map(__webpack_require__.e)).then(() => {
		return __webpack_require__(id);
	});
}
webpackAsyncContext.keys = () => (Object.keys(map));
webpackAsyncContext.id = "./resources/js/router lazy recursive ^.*$";
module.exports = webpackAsyncContext;

/***/ }),

/***/ "./resources/js/router sync recursive \\.vue$/":
/*!*******************************************!*\
  !*** ./resources/js/router/ sync \.vue$/ ***!
  \*******************************************/
/***/ ((module) => {

function webpackEmptyContext(req) {
	var e = new Error("Cannot find module '" + req + "'");
	e.code = 'MODULE_NOT_FOUND';
	throw e;
}
webpackEmptyContext.keys = () => ([]);
webpackEmptyContext.resolve = webpackEmptyContext;
webpackEmptyContext.id = "./resources/js/router sync recursive \\.vue$/";
module.exports = webpackEmptyContext;

/***/ })

}]);