(window["webpackJsonp"] = window["webpackJsonp"] || []).push([[15],{

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/src/views/Page-1-3.vue?vue&type=script&lang=js&":
/*!******************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/src/views/Page-1-3.vue?vue&type=script&lang=js& ***!
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
    return {// 
    };
  }
});

/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/src/views/Page-1-3.vue?vue&type=template&id=59dd4403&":
/*!**********************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/src/views/Page-1-3.vue?vue&type=template&id=59dd4403& ***!
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
      _c("vs-breadcrumb", {
        attrs: {
          separator: _vm.$vs.rtl ? "chevron_left" : "chevron_right",
          items: [
            {
              title: "업무담당자 관리",
              url: "/1"
            },
            {
              title: "담당자 정보 등록",
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
            { attrs: { stripe: "", data: [0] } },
            [
              _c(
                "vs-tr",
                [
                  _c("vs-th", { staticClass: "h5 py-5 self-center" }, [
                    _vm._v("휴대폰 번호(ID)")
                  ]),
                  _vm._v(" "),
                  _c("vs-td", [_c("vs-input")], 1)
                ],
                1
              ),
              _vm._v(" "),
              _c(
                "vs-tr",
                [
                  _c("vs-th", { staticClass: "h5 py-5 self-center" }, [
                    _vm._v("비밀번호")
                  ]),
                  _vm._v(" "),
                  _c("vs-td", [_c("vs-input")], 1)
                ],
                1
              ),
              _vm._v(" "),
              _c(
                "vs-tr",
                [
                  _c("vs-th", { staticClass: "h5 py-5 self-center" }, [
                    _vm._v("비밀번호 헉인")
                  ]),
                  _vm._v(" "),
                  _c("vs-td", [_c("vs-input")], 1)
                ],
                1
              ),
              _vm._v(" "),
              _c(
                "vs-tr",
                [
                  _c("vs-th", { staticClass: "h5 py-5 self-center" }, [
                    _vm._v("이름")
                  ]),
                  _vm._v(" "),
                  _c("vs-td", [_c("vs-input")], 1)
                ],
                1
              ),
              _vm._v(" "),
              _c(
                "vs-tr",
                [
                  _c("vs-th", { staticClass: "h5 py-5 self-center" }, [
                    _vm._v("이메일")
                  ]),
                  _vm._v(" "),
                  _c("vs-td", [_c("vs-input")], 1)
                ],
                1
              ),
              _vm._v(" "),
              _c(
                "vs-tr",
                [
                  _c("vs-th", { staticClass: "h5 py-5 self-center" }, [
                    _vm._v("메뉴접근 권한")
                  ]),
                  _vm._v(" "),
                  _c("vs-td", [
                    _c(
                      "div",
                      { staticClass: "flex flex-row flex-wrap" },
                      [
                        _c(
                          "vs-button",
                          {
                            staticClass: "px-3 ml-1 mt-1",
                            attrs: {
                              color: "primary",
                              type: "border",
                              "icon-pack": "feather",
                              icon: "icon-check"
                            }
                          },
                          [_vm._v("정보관리")]
                        ),
                        _vm._v(" "),
                        _c(
                          "vs-button",
                          {
                            staticClass: "px-3 ml-1 mt-1",
                            attrs: {
                              color: "primary",
                              type: "border",
                              "icon-pack": "feather",
                              icon: "icon-check"
                            }
                          },
                          [_vm._v("생산정보관리")]
                        ),
                        _vm._v(" "),
                        _c(
                          "vs-button",
                          {
                            staticClass: "px-3 ml-1 mt-1",
                            attrs: {
                              color: "primary",
                              type: "border",
                              "icon-pack": "feather",
                              icon: "icon-check"
                            }
                          },
                          [_vm._v("원/부자재관리")]
                        ),
                        _vm._v(" "),
                        _c(
                          "vs-button",
                          {
                            staticClass: "px-3 ml-1 mt-1",
                            attrs: {
                              color: "dark",
                              disabled: "",
                              type: "border"
                            }
                          },
                          [_vm._v("생산관리")]
                        ),
                        _vm._v(" "),
                        _c(
                          "vs-button",
                          {
                            staticClass: "px-3 ml-1 mt-1",
                            attrs: {
                              color: "dark",
                              disabled: "",
                              type: "border"
                            }
                          },
                          [_vm._v("품질관리")]
                        ),
                        _vm._v(" "),
                        _c(
                          "vs-button",
                          {
                            staticClass: "px-3 ml-1 mt-1",
                            attrs: {
                              color: "dark",
                              disabled: "",
                              type: "border"
                            }
                          },
                          [_vm._v("수주/출하관리")]
                        ),
                        _vm._v(" "),
                        _c(
                          "vs-button",
                          {
                            staticClass: "px-3 ml-1 mt-1",
                            attrs: {
                              color: "primary",
                              type: "border",
                              "icon-pack": "feather",
                              icon: "icon-check"
                            }
                          },
                          [_vm._v("OEM관리")]
                        ),
                        _vm._v(" "),
                        _c(
                          "vs-button",
                          {
                            staticClass: "px-3 ml-1 mt-1",
                            attrs: {
                              color: "dark",
                              disabled: "",
                              type: "border"
                            }
                          },
                          [_vm._v("전자문서")]
                        )
                      ],
                      1
                    )
                  ])
                ],
                1
              ),
              _vm._v(" "),
              _c(
                "vs-tr",
                [
                  _c("vs-th", { staticClass: "h5 py-5 self-center" }, [
                    _vm._v("담당업무")
                  ]),
                  _vm._v(" "),
                  _c("vs-td", [
                    _c(
                      "div",
                      { staticClass: "flex flex-row flex-wrap" },
                      [
                        _c(
                          "vs-button",
                          {
                            staticClass: "px-3 ml-1 mt-1",
                            attrs: {
                              color: "primary",
                              type: "border",
                              "icon-pack": "feather",
                              icon: "icon-check"
                            }
                          },
                          [_vm._v("원/부자재")]
                        ),
                        _vm._v(" "),
                        _c(
                          "vs-button",
                          {
                            staticClass: "px-3 ml-1 mt-1",
                            attrs: {
                              color: "primary",
                              type: "border",
                              "icon-pack": "feather",
                              icon: "icon-check"
                            }
                          },
                          [_vm._v("생산관리")]
                        ),
                        _vm._v(" "),
                        _c(
                          "vs-button",
                          {
                            staticClass: "px-3 ml-1 mt-1",
                            attrs: {
                              color: "dark",
                              disabled: "",
                              type: "border"
                            }
                          },
                          [_vm._v("HACCP 이행관리")]
                        ),
                        _vm._v(" "),
                        _c(
                          "vs-button",
                          {
                            staticClass: "px-3 ml-1 mt-1",
                            attrs: {
                              color: "dark",
                              disabled: "",
                              type: "border"
                            }
                          },
                          [_vm._v("출하관리")]
                        )
                      ],
                      1
                    )
                  ])
                ],
                1
              ),
              _vm._v(" "),
              _c(
                "vs-tr",
                [
                  _c("vs-th", { staticClass: "h5 py-5 self-center" }, [
                    _vm._v("업무 권한")
                  ]),
                  _vm._v(" "),
                  _c("vs-td", [
                    _c(
                      "div",
                      { staticClass: "flex flex-row flex-wrap" },
                      [
                        _c(
                          "vs-button",
                          {
                            staticClass: "px-3 ml-1 mt-1",
                            attrs: {
                              color: "dark",
                              disabled: "",
                              type: "border"
                            }
                          },
                          [_vm._v("업무담당자")]
                        ),
                        _vm._v(" "),
                        _c(
                          "vs-button",
                          {
                            staticClass: "px-3 ml-1 mt-1",
                            attrs: {
                              color: "primary",
                              type: "border",
                              "icon-pack": "feather",
                              icon: "icon-check"
                            }
                          },
                          [_vm._v("중간승인자(생산팀장)")]
                        ),
                        _vm._v(" "),
                        _c(
                          "vs-button",
                          {
                            staticClass: "px-3 ml-1 mt-1",
                            attrs: {
                              color: "dark",
                              disabled: "",
                              type: "border"
                            }
                          },
                          [_vm._v("최종승인자(대표이사)")]
                        )
                      ],
                      1
                    )
                  ])
                ],
                1
              ),
              _vm._v(" "),
              _c(
                "vs-tr",
                [
                  _c("vs-th", { staticClass: "h5 py-5 self-center" }, [
                    _vm._v("게정상태")
                  ]),
                  _vm._v(" "),
                  _c(
                    "vs-td",
                    [_c("vs-select", { attrs: { placeholder: "사용" } })],
                    1
                  )
                ],
                1
              )
            ],
            1
          )
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

/***/ "./resources/js/src/views/Page-1-3.vue":
/*!*********************************************!*\
  !*** ./resources/js/src/views/Page-1-3.vue ***!
  \*********************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _Page_1_3_vue_vue_type_template_id_59dd4403___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./Page-1-3.vue?vue&type=template&id=59dd4403& */ "./resources/js/src/views/Page-1-3.vue?vue&type=template&id=59dd4403&");
/* harmony import */ var _Page_1_3_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./Page-1-3.vue?vue&type=script&lang=js& */ "./resources/js/src/views/Page-1-3.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport *//* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _Page_1_3_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _Page_1_3_vue_vue_type_template_id_59dd4403___WEBPACK_IMPORTED_MODULE_0__["render"],
  _Page_1_3_vue_vue_type_template_id_59dd4403___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/src/views/Page-1-3.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/src/views/Page-1-3.vue?vue&type=script&lang=js&":
/*!**********************************************************************!*\
  !*** ./resources/js/src/views/Page-1-3.vue?vue&type=script&lang=js& ***!
  \**********************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Page_1_3_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib??ref--4-0!../../../../node_modules/vue-loader/lib??vue-loader-options!./Page-1-3.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/src/views/Page-1-3.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Page_1_3_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/src/views/Page-1-3.vue?vue&type=template&id=59dd4403&":
/*!****************************************************************************!*\
  !*** ./resources/js/src/views/Page-1-3.vue?vue&type=template&id=59dd4403& ***!
  \****************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Page_1_3_vue_vue_type_template_id_59dd4403___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../node_modules/vue-loader/lib??vue-loader-options!./Page-1-3.vue?vue&type=template&id=59dd4403& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/src/views/Page-1-3.vue?vue&type=template&id=59dd4403&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Page_1_3_vue_vue_type_template_id_59dd4403___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Page_1_3_vue_vue_type_template_id_59dd4403___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ })

}]);