(window["webpackJsonp"] = window["webpackJsonp"] || []).push([[14],{

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/src/views/Page-1-1.vue?vue&type=script&lang=js&":
/*!******************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/src/views/Page-1-1.vue?vue&type=script&lang=js& ***!
  \******************************************************************************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
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
//
//
//
//
//
//
/* harmony default export */ __webpack_exports__["default"] = ({
  data: function data() {
    return {
      data: [{
        label: '회사명',
        value: ''
      }, {
        label: '사업자등록번호',
        value: ''
      }, {
        label: '대표명',
        value: ''
      }, {
        label: '전화번호',
        value: ''
      }, {
        label: '팩스번호',
        value: ''
      }, {
        label: '홈페이지',
        value: ''
      }],
      address: {
        disabled1: '',
        disabled2: '',
        addressDetails: ''
      }
    };
  }
});

/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/src/views/Page-1-1.vue?vue&type=template&id=59c11501&":
/*!**********************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/src/views/Page-1-1.vue?vue&type=template&id=59c11501& ***!
  \**********************************************************************************************************************************************************************************************************/
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
  return _c(
    "div",
    [
      _c("h4", [_vm._v("회사 정보")]),
      _vm._v(" "),
      _c("vs-breadcrumb", {
        attrs: {
          separator: _vm.$vs.rtl ? "chevron_left" : "chevron_right",
          items: [
            {
              title: "정보관리",
              url: "/1"
            },
            {
              title: "기업정보 수정",
              url: "/1/1",
              active: true
            }
          ]
        }
      }),
      _vm._v(" "),
      _c(
        "vx-card",
        { staticClass: "mt-5" },
        [
          _c("h2", { staticClass: "mb-5" }, [_vm._v("기본정보")]),
          _vm._v(" "),
          _c(
            "vs-table",
            { attrs: { stripe: "", data: _vm.data } },
            [
              _c(
                "vs-tr",
                [
                  _c("vs-th", { staticClass: "h5 py-5 text-center" }, [
                    _vm._v("회사명")
                  ]),
                  _vm._v(" "),
                  _c("vs-td", [
                    _vm._v(
                      "Lorem ipsum dolor, sit amet consectetur adipisicing elit. Cupiditate laboriosam id hic natus quo dolorum voluptas"
                    )
                  ])
                ],
                1
              ),
              _vm._v(" "),
              _c(
                "vs-tr",
                [
                  _c("vs-th", { staticClass: "h5 py-5 text-center" }, [
                    _vm._v("사업자등록번호")
                  ]),
                  _vm._v(" "),
                  _c("vs-td", [
                    _vm._v(
                      "Lorem ipsum dolor, sit amet consectetur adipisicing elit. Cupiditate laboriosam id hic natus quo dolorum voluptas"
                    )
                  ])
                ],
                1
              ),
              _vm._v(" "),
              _c(
                "vs-tr",
                [
                  _c("vs-th", { staticClass: "h5 py-5 text-center" }, [
                    _vm._v("대표명")
                  ]),
                  _vm._v(" "),
                  _c("vs-td", [
                    _vm._v(
                      "Lorem ipsum dolor, sit amet consectetur adipisicing elit. Cupiditate laboriosam id hic natus quo dolorum voluptas"
                    )
                  ])
                ],
                1
              ),
              _vm._v(" "),
              _c(
                "vs-tr",
                [
                  _c("vs-th", { staticClass: "h5 py-5 text-center" }, [
                    _vm._v("전화번호")
                  ]),
                  _vm._v(" "),
                  _c("vs-td", [
                    _vm._v(
                      "Lorem ipsum dolor, sit amet consectetur adipisicing elit. Cupiditate laboriosam id hic natus quo dolorum voluptas"
                    )
                  ])
                ],
                1
              ),
              _vm._v(" "),
              _c(
                "vs-tr",
                [
                  _c("vs-th", { staticClass: "h5 py-5 text-center" }, [
                    _vm._v("팩스번호")
                  ]),
                  _vm._v(" "),
                  _c("vs-td", [
                    _vm._v(
                      "Lorem ipsum dolor, sit amet consectetur adipisicing elit. Cupiditate laboriosam id hic natus quo dolorum voluptas"
                    )
                  ])
                ],
                1
              ),
              _vm._v(" "),
              _c(
                "vs-tr",
                [
                  _c("vs-th", { staticClass: "h5 py-5 text-center" }, [
                    _vm._v("홈페이지")
                  ]),
                  _vm._v(" "),
                  _c("vs-td", [
                    _vm._v(
                      "Lorem ipsum dolor, sit amet consectetur adipisicing elit. Cupiditate laboriosam id hic natus quo dolorum voluptas"
                    )
                  ])
                ],
                1
              )
            ],
            1
          ),
          _vm._v(" "),
          _c("div", { staticClass: "mt-5" }, [
            _c("h5", [_vm._v("주소")]),
            _vm._v(" "),
            _c("form", [
              _c("div", { staticClass: "vx-row" }, [
                _c(
                  "div",
                  { staticClass: "vx-col" },
                  [
                    _c("vs-input", {
                      attrs: { "label-placeholder": "", disabled: "" },
                      model: {
                        value: _vm.address.disabled1,
                        callback: function($$v) {
                          _vm.$set(_vm.address, "disabled1", $$v)
                        },
                        expression: "address.disabled1"
                      }
                    })
                  ],
                  1
                ),
                _vm._v(" "),
                _c(
                  "div",
                  { staticClass: "vx-col" },
                  [
                    _c("vs-button", { attrs: { type: "border" } }, [
                      _vm._v("주소첮기")
                    ])
                  ],
                  1
                )
              ]),
              _vm._v(" "),
              _c("div", { staticClass: "vx-row" }, [
                _c(
                  "div",
                  { staticClass: "vx-col" },
                  [
                    _c("vs-input", {
                      attrs: { "label-placeholder": "", disabled: "" },
                      model: {
                        value: _vm.address.disabled2,
                        callback: function($$v) {
                          _vm.$set(_vm.address, "disabled2", $$v)
                        },
                        expression: "address.disabled2"
                      }
                    })
                  ],
                  1
                )
              ]),
              _vm._v(" "),
              _c("div", { staticClass: "vx-row" }, [
                _c(
                  "div",
                  { staticClass: "vx-col" },
                  [
                    _c("vs-input", {
                      attrs: { "label-placeholder": "상세주소" },
                      model: {
                        value: _vm.address.addressDetails,
                        callback: function($$v) {
                          _vm.$set(_vm.address, "addressDetails", $$v)
                        },
                        expression: "address.addressDetails"
                      }
                    })
                  ],
                  1
                )
              ])
            ])
          ])
        ],
        1
      )
    ],
    1
  )
}
var staticRenderFns = []
render._withStripped = true



/***/ }),

/***/ "./resources/js/src/views/Page-1-1.vue":
/*!*********************************************!*\
  !*** ./resources/js/src/views/Page-1-1.vue ***!
  \*********************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _Page_1_1_vue_vue_type_template_id_59c11501___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./Page-1-1.vue?vue&type=template&id=59c11501& */ "./resources/js/src/views/Page-1-1.vue?vue&type=template&id=59c11501&");
/* harmony import */ var _Page_1_1_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./Page-1-1.vue?vue&type=script&lang=js& */ "./resources/js/src/views/Page-1-1.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport *//* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _Page_1_1_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _Page_1_1_vue_vue_type_template_id_59c11501___WEBPACK_IMPORTED_MODULE_0__["render"],
  _Page_1_1_vue_vue_type_template_id_59c11501___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/src/views/Page-1-1.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/src/views/Page-1-1.vue?vue&type=script&lang=js&":
/*!**********************************************************************!*\
  !*** ./resources/js/src/views/Page-1-1.vue?vue&type=script&lang=js& ***!
  \**********************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Page_1_1_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib??ref--4-0!../../../../node_modules/vue-loader/lib??vue-loader-options!./Page-1-1.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/src/views/Page-1-1.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Page_1_1_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/src/views/Page-1-1.vue?vue&type=template&id=59c11501&":
/*!****************************************************************************!*\
  !*** ./resources/js/src/views/Page-1-1.vue?vue&type=template&id=59c11501& ***!
  \****************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Page_1_1_vue_vue_type_template_id_59c11501___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../node_modules/vue-loader/lib??vue-loader-options!./Page-1-1.vue?vue&type=template&id=59c11501& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/src/views/Page-1-1.vue?vue&type=template&id=59c11501&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Page_1_1_vue_vue_type_template_id_59c11501___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Page_1_1_vue_vue_type_template_id_59c11501___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ })

}]);