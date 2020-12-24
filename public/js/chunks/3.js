(window["webpackJsonp"] = window["webpackJsonp"] || []).push([[3],{

/***/ "./node_modules/@babel/runtime/core-js/get-iterator.js":
/*!*************************************************************!*\
  !*** ./node_modules/@babel/runtime/core-js/get-iterator.js ***!
  \*************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! core-js/library/fn/get-iterator */ "./node_modules/core-js/library/fn/get-iterator.js");

/***/ }),

/***/ "./node_modules/@babel/runtime/core-js/object/entries.js":
/*!***************************************************************!*\
  !*** ./node_modules/@babel/runtime/core-js/object/entries.js ***!
  \***************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! core-js/library/fn/object/entries */ "./node_modules/core-js/library/fn/object/entries.js");

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/src/views/pages/ResetPassword.vue?vue&type=script&lang=js&":
/*!*****************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/src/views/pages/ResetPassword.vue?vue&type=script&lang=js& ***!
  \*****************************************************************************************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _babel_runtime_core_js_get_iterator__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @babel/runtime/core-js/get-iterator */ "./node_modules/@babel/runtime/core-js/get-iterator.js");
/* harmony import */ var _babel_runtime_core_js_get_iterator__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_core_js_get_iterator__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _babel_runtime_core_js_object_entries__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @babel/runtime/core-js/object/entries */ "./node_modules/@babel/runtime/core-js/object/entries.js");
/* harmony import */ var _babel_runtime_core_js_object_entries__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_core_js_object_entries__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var axios__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! axios */ "./node_modules/axios/index.js");
/* harmony import */ var axios__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(axios__WEBPACK_IMPORTED_MODULE_2__);
/* harmony import */ var _services_config__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! @/services/config */ "./resources/js/src/services/config.js");



function _slicedToArray(arr, i) { return _arrayWithHoles(arr) || _iterableToArrayLimit(arr, i) || _nonIterableRest(); }

function _nonIterableRest() { throw new TypeError("Invalid attempt to destructure non-iterable instance"); }

function _iterableToArrayLimit(arr, i) { var _arr = []; var _n = true; var _d = false; var _e = undefined; try { for (var _i = _babel_runtime_core_js_get_iterator__WEBPACK_IMPORTED_MODULE_0___default()(arr), _s; !(_n = (_s = _i.next()).done); _n = true) { _arr.push(_s.value); if (i && _arr.length === i) break; } } catch (err) { _d = true; _e = err; } finally { try { if (!_n && _i["return"] != null) _i["return"](); } finally { if (_d) throw _e; } } return _arr; }

function _arrayWithHoles(arr) { if (Array.isArray(arr)) return arr; }

//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//


/* harmony default export */ __webpack_exports__["default"] = ({
  data: function data() {
    return {
      resError: false,
      resMsg: '',
      password: {
        email: null,
        password: null,
        password_confirmation: null,
        token: null
      },
      errors: {
        email: null,
        password: null,
        password_confirmation: null
      }
    };
  },
  computed: {
    urlParameters: function urlParameters() {
      return this.$route.query;
    }
  },
  methods: {
    btnLoading: function btnLoading() {
      var loading = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : true;

      if (loading) {
        this.$vs.loading({
          background: 'primary',
          color: '#fff',
          container: "#reset-btn",
          scale: 0.45
        });
      } else {
        this.$vs.loading.close("#reset-btn > .con-vs-loading");
      }
    },
    clearErrors: function clearErrors() {
      this.$set(this, 'errors', {
        email: null,
        password: null,
        password_confirmation: null
      });
    },
    displayErrors: function displayErrors(errors) {
      var _arr = _babel_runtime_core_js_object_entries__WEBPACK_IMPORTED_MODULE_1___default()(errors);

      for (var _i = 0; _i < _arr.length; _i++) {
        var _arr$_i = _slicedToArray(_arr[_i], 2),
            key = _arr$_i[0],
            value = _arr$_i[1];

        this.$set(this.errors, key, Array.isArray(value) ? value[0] : value);
      }
    },
    reset: function reset() {
      var _this = this;

      this.clearErrors();
      this.btnLoading(true);
      this.resError = false;
      axios__WEBPACK_IMPORTED_MODULE_2___default.a.post("".concat(_services_config__WEBPACK_IMPORTED_MODULE_3__["default"].baseUrl, "/auth/reset-password"), this.password).then(function (res) {
        _this.btnLoading(false);

        if (res.data.success) {
          _this.$vs.dialog({
            title: 'Password successfully reset',
            position: "top-right",
            color: "success",
            text: 'Your password has been successfully reset. Login with your new password.',
            acceptText: 'Go to Login',
            accept: function accept() {
              return _this.$router.push('/login');
            }
          });
        } else {
          _this.resError = true;
          _this.resMsg = err.response.data.message; // this.$vs.notify({
          //   title: this.$t("Error"),
          //   position: "top-right",
          //   color: "warning",
          //   iconPack: "feather",
          //   icon: "icon-alert-circle",
          //   text: res.data.message,
          // });
        }
      }).catch(function (err) {
        _this.btnLoading(false);

        _this.resError = true;
        _this.resMsg = err.response.data.message;

        _this.displayErrors(err.response.data.hasOwnProperty("errors") ? err.response.data.errors : null);
      });
    }
  },
  created: function created() {
    var _this2 = this;

    setTimeout(function () {
      _this2.$set(_this2.password, 'token', _this2.urlParameters.token);

      _this2.$set(_this2.password, 'email', _this2.urlParameters.email);
    }, 1000);
  }
});

/***/ }),

/***/ "./node_modules/core-js/library/fn/get-iterator.js":
/*!*********************************************************!*\
  !*** ./node_modules/core-js/library/fn/get-iterator.js ***!
  \*********************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

__webpack_require__(/*! ../modules/web.dom.iterable */ "./node_modules/core-js/library/modules/web.dom.iterable.js");
__webpack_require__(/*! ../modules/es6.string.iterator */ "./node_modules/core-js/library/modules/es6.string.iterator.js");
module.exports = __webpack_require__(/*! ../modules/core.get-iterator */ "./node_modules/core-js/library/modules/core.get-iterator.js");


/***/ }),

/***/ "./node_modules/core-js/library/fn/object/entries.js":
/*!***********************************************************!*\
  !*** ./node_modules/core-js/library/fn/object/entries.js ***!
  \***********************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

__webpack_require__(/*! ../../modules/es7.object.entries */ "./node_modules/core-js/library/modules/es7.object.entries.js");
module.exports = __webpack_require__(/*! ../../modules/_core */ "./node_modules/core-js/library/modules/_core.js").Object.entries;


/***/ }),

/***/ "./node_modules/core-js/library/modules/_object-pie.js":
/*!*************************************************************!*\
  !*** ./node_modules/core-js/library/modules/_object-pie.js ***!
  \*************************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

exports.f = {}.propertyIsEnumerable;


/***/ }),

/***/ "./node_modules/core-js/library/modules/_object-to-array.js":
/*!******************************************************************!*\
  !*** ./node_modules/core-js/library/modules/_object-to-array.js ***!
  \******************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

var getKeys = __webpack_require__(/*! ./_object-keys */ "./node_modules/core-js/library/modules/_object-keys.js");
var toIObject = __webpack_require__(/*! ./_to-iobject */ "./node_modules/core-js/library/modules/_to-iobject.js");
var isEnum = __webpack_require__(/*! ./_object-pie */ "./node_modules/core-js/library/modules/_object-pie.js").f;
module.exports = function (isEntries) {
  return function (it) {
    var O = toIObject(it);
    var keys = getKeys(O);
    var length = keys.length;
    var i = 0;
    var result = [];
    var key;
    while (length > i) if (isEnum.call(O, key = keys[i++])) {
      result.push(isEntries ? [key, O[key]] : O[key]);
    } return result;
  };
};


/***/ }),

/***/ "./node_modules/core-js/library/modules/core.get-iterator.js":
/*!*******************************************************************!*\
  !*** ./node_modules/core-js/library/modules/core.get-iterator.js ***!
  \*******************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

var anObject = __webpack_require__(/*! ./_an-object */ "./node_modules/core-js/library/modules/_an-object.js");
var get = __webpack_require__(/*! ./core.get-iterator-method */ "./node_modules/core-js/library/modules/core.get-iterator-method.js");
module.exports = __webpack_require__(/*! ./_core */ "./node_modules/core-js/library/modules/_core.js").getIterator = function (it) {
  var iterFn = get(it);
  if (typeof iterFn != 'function') throw TypeError(it + ' is not iterable!');
  return anObject(iterFn.call(it));
};


/***/ }),

/***/ "./node_modules/core-js/library/modules/es7.object.entries.js":
/*!********************************************************************!*\
  !*** ./node_modules/core-js/library/modules/es7.object.entries.js ***!
  \********************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

// https://github.com/tc39/proposal-object-values-entries
var $export = __webpack_require__(/*! ./_export */ "./node_modules/core-js/library/modules/_export.js");
var $entries = __webpack_require__(/*! ./_object-to-array */ "./node_modules/core-js/library/modules/_object-to-array.js")(true);

$export($export.S, 'Object', {
  entries: function entries(it) {
    return $entries(it);
  }
});


/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/src/views/pages/ResetPassword.vue?vue&type=template&id=2e0cad45&":
/*!*********************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/src/views/pages/ResetPassword.vue?vue&type=template&id=2e0cad45& ***!
  \*********************************************************************************************************************************************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "render", function() { return render; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return staticRenderFns; });
var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c("div", { staticClass: "h-screen flex w-full bg-img" }, [
    _c(
      "div",
      {
        staticClass:
          "vx-col sm:w-3/5 md:w-3/5 lg:w-3/4 xl:w-3/5 mx-auto self-center"
      },
      [
        _c("vx-card", [
          _c(
            "div",
            {
              staticClass: "full-page-bg-color",
              attrs: { slot: "no-body" },
              slot: "no-body"
            },
            [
              _c("div", { staticClass: "vx-row" }, [
                _c(
                  "div",
                  {
                    staticClass:
                      "vx-col hidden sm:hidden md:hidden lg:block lg:w-1/2 mx-auto self-center"
                  },
                  [
                    _c("img", {
                      staticClass: "mx-auto",
                      attrs: {
                        src: __webpack_require__(/*! @assets/images/pages/reset-password.png */ "./resources/assets/images/pages/reset-password.png"),
                        alt: "login"
                      }
                    })
                  ]
                ),
                _vm._v(" "),
                _c(
                  "div",
                  {
                    staticClass:
                      "vx-col sm:w-full md:w-full lg:w-1/2 mx-auto self-center d-theme-dark-bg"
                  },
                  [
                    _c(
                      "div",
                      { staticClass: "p-8" },
                      [
                        _c("div", { staticClass: "vx-card__title mb-8" }, [
                          _c("h4", { staticClass: "mb-4" }, [
                            _vm._v("Reset Password")
                          ]),
                          _vm._v(" "),
                          _c("p", [_vm._v("Please enter your new password.")])
                        ]),
                        _vm._v(" "),
                        _c(
                          "vs-alert",
                          {
                            staticClass: "mb-4",
                            attrs: {
                              active: _vm.resError,
                              color: "danger",
                              "icon-pack": "feather",
                              icon: "icon-info"
                            }
                          },
                          [
                            _c("span", {
                              domProps: { textContent: _vm._s(_vm.resMsg) }
                            })
                          ]
                        ),
                        _vm._v(" "),
                        _c("vs-input", {
                          staticClass: "w-full mb-6",
                          attrs: {
                            type: "email",
                            "label-placeholder": "Email",
                            danger: _vm.errors["email"] != null,
                            "danger-text": _vm.errors["email"],
                            readonly: ""
                          },
                          model: {
                            value: _vm.password.email,
                            callback: function($$v) {
                              _vm.$set(_vm.password, "email", $$v)
                            },
                            expression: "password.email"
                          }
                        }),
                        _vm._v(" "),
                        _c("vs-input", {
                          staticClass: "w-full mb-6",
                          attrs: {
                            type: "password",
                            "label-placeholder": "Password",
                            danger: _vm.errors["password"] != null,
                            "danger-text": _vm.errors["password"],
                            autofocus: ""
                          },
                          model: {
                            value: _vm.password.password,
                            callback: function($$v) {
                              _vm.$set(_vm.password, "password", $$v)
                            },
                            expression: "password.password"
                          }
                        }),
                        _vm._v(" "),
                        _c("vs-input", {
                          staticClass: "w-full mb-8",
                          attrs: {
                            type: "password",
                            "label-placeholder": "Confirm Password",
                            danger: _vm.errors["password_confirmation"] != null,
                            "danger-text": _vm.errors["password_confirmation"]
                          },
                          model: {
                            value: _vm.password.password_confirmation,
                            callback: function($$v) {
                              _vm.$set(
                                _vm.password,
                                "password_confirmation",
                                $$v
                              )
                            },
                            expression: "password.password_confirmation"
                          }
                        }),
                        _vm._v(" "),
                        _c(
                          "div",
                          {
                            staticClass:
                              "flex flex-wrap justify-between flex-col-reverse sm:flex-row"
                          },
                          [
                            _c(
                              "vs-button",
                              {
                                staticClass:
                                  "w-full sm:w-auto mb-8 sm:mb-auto mt-3 sm:mt-auto",
                                attrs: { type: "border", to: "/login" }
                              },
                              [_vm._v("Go Back To Login")]
                            ),
                            _vm._v(" "),
                            _c(
                              "vs-button",
                              {
                                staticClass:
                                  "w-full sm:w-auto vs-con-loading__container",
                                attrs: { id: "reset-btn" },
                                on: {
                                  click: function($event) {
                                    return _vm.reset()
                                  }
                                }
                              },
                              [_vm._v("Reset")]
                            )
                          ],
                          1
                        )
                      ],
                      1
                    )
                  ]
                )
              ])
            ]
          )
        ])
      ],
      1
    )
  ])
}
var staticRenderFns = []
render._withStripped = true



/***/ }),

/***/ "./resources/assets/images/pages/reset-password.png":
/*!**********************************************************!*\
  !*** ./resources/assets/images/pages/reset-password.png ***!
  \**********************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

module.exports = "/images/reset-password.png?965156dace52dc1b319d6363d3040ff2";

/***/ }),

/***/ "./resources/js/src/services/config.js":
/*!*********************************************!*\
  !*** ./resources/js/src/services/config.js ***!
  \*********************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony default export */ __webpack_exports__["default"] = ({
  baseUrl: '/api'
});

/***/ }),

/***/ "./resources/js/src/views/pages/ResetPassword.vue":
/*!********************************************************!*\
  !*** ./resources/js/src/views/pages/ResetPassword.vue ***!
  \********************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _ResetPassword_vue_vue_type_template_id_2e0cad45___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./ResetPassword.vue?vue&type=template&id=2e0cad45& */ "./resources/js/src/views/pages/ResetPassword.vue?vue&type=template&id=2e0cad45&");
/* harmony import */ var _ResetPassword_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./ResetPassword.vue?vue&type=script&lang=js& */ "./resources/js/src/views/pages/ResetPassword.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport *//* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _ResetPassword_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _ResetPassword_vue_vue_type_template_id_2e0cad45___WEBPACK_IMPORTED_MODULE_0__["render"],
  _ResetPassword_vue_vue_type_template_id_2e0cad45___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/src/views/pages/ResetPassword.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/src/views/pages/ResetPassword.vue?vue&type=script&lang=js&":
/*!*********************************************************************************!*\
  !*** ./resources/js/src/views/pages/ResetPassword.vue?vue&type=script&lang=js& ***!
  \*********************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_ResetPassword_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/babel-loader/lib??ref--4-0!../../../../../node_modules/vue-loader/lib??vue-loader-options!./ResetPassword.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/src/views/pages/ResetPassword.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_ResetPassword_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/src/views/pages/ResetPassword.vue?vue&type=template&id=2e0cad45&":
/*!***************************************************************************************!*\
  !*** ./resources/js/src/views/pages/ResetPassword.vue?vue&type=template&id=2e0cad45& ***!
  \***************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_ResetPassword_vue_vue_type_template_id_2e0cad45___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../../node_modules/vue-loader/lib??vue-loader-options!./ResetPassword.vue?vue&type=template&id=2e0cad45& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/src/views/pages/ResetPassword.vue?vue&type=template&id=2e0cad45&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_ResetPassword_vue_vue_type_template_id_2e0cad45___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_ResetPassword_vue_vue_type_template_id_2e0cad45___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ })

}]);