"use strict";
(self["webpackChunk"] = self["webpackChunk"] || []).push([["utils"],{

/***/ "./resources/js/utils/index.js":
/*!*************************************!*\
  !*** ./resources/js/utils/index.js ***!
  \*************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "useRouter": () => (/* binding */ useRouter),
/* harmony export */   "_": () => (/* binding */ _)
/* harmony export */ });
/* harmony import */ var _vue_composition_api__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @vue/composition-api */ "./node_modules/@vue/composition-api/dist/vue-composition-api.esm.js");
function ownKeys(object, enumerableOnly) { var keys = Object.keys(object); if (Object.getOwnPropertySymbols) { var symbols = Object.getOwnPropertySymbols(object); if (enumerableOnly) { symbols = symbols.filter(function (sym) { return Object.getOwnPropertyDescriptor(object, sym).enumerable; }); } keys.push.apply(keys, symbols); } return keys; }

function _objectSpread(target) { for (var i = 1; i < arguments.length; i++) { var source = arguments[i] != null ? arguments[i] : {}; if (i % 2) { ownKeys(Object(source), true).forEach(function (key) { _defineProperty(target, key, source[key]); }); } else if (Object.getOwnPropertyDescriptors) { Object.defineProperties(target, Object.getOwnPropertyDescriptors(source)); } else { ownKeys(Object(source)).forEach(function (key) { Object.defineProperty(target, key, Object.getOwnPropertyDescriptor(source, key)); }); } } return target; }

function _defineProperty(obj, key, value) { if (key in obj) { Object.defineProperty(obj, key, { value: value, enumerable: true, configurable: true, writable: true }); } else { obj[key] = value; } return obj; }

// eslint-disable-next-line object-curly-newline
 // Thanks: https://medium.com/better-programming/reactive-vue-routes-with-the-composition-api-18c1abd878d1

var useRouter = function useRouter() {
  var vm = (0,_vue_composition_api__WEBPACK_IMPORTED_MODULE_0__.getCurrentInstance)().proxy;
  var state = (0,_vue_composition_api__WEBPACK_IMPORTED_MODULE_0__.reactive)({
    route: vm.$route
  });
  (0,_vue_composition_api__WEBPACK_IMPORTED_MODULE_0__.watch)(function () {
    return vm.$route;
  }, function (r) {
    state.route = r;
  });
  return _objectSpread(_objectSpread({}, (0,_vue_composition_api__WEBPACK_IMPORTED_MODULE_0__.toRefs)(state)), {}, {
    router: vm.$router
  });
};
var _ = null;

/***/ })

}]);