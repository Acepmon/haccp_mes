(window["webpackJsonp"] = window["webpackJsonp"] || []).push([[3],{

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/src/components/vx-auto-suggest/VxAutoSuggest.vue?vue&type=script&lang=js&":
/*!********************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/src/components/vx-auto-suggest/VxAutoSuggest.vue?vue&type=script&lang=js& ***!
  \********************************************************************************************************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _babel_runtime_core_js_object_define_property__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @babel/runtime/core-js/object/define-property */ "./node_modules/@babel/runtime/core-js/object/define-property.js");
/* harmony import */ var _babel_runtime_core_js_object_define_property__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_core_js_object_define_property__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _babel_runtime_core_js_object_entries__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @babel/runtime/core-js/object/entries */ "./node_modules/@babel/runtime/core-js/object/entries.js");
/* harmony import */ var _babel_runtime_core_js_object_entries__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_core_js_object_entries__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var _babel_runtime_core_js_get_iterator__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! @babel/runtime/core-js/get-iterator */ "./node_modules/@babel/runtime/core-js/get-iterator.js");
/* harmony import */ var _babel_runtime_core_js_get_iterator__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_core_js_get_iterator__WEBPACK_IMPORTED_MODULE_2__);
/* harmony import */ var _babel_runtime_core_js_object_values__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! @babel/runtime/core-js/object/values */ "./node_modules/@babel/runtime/core-js/object/values.js");
/* harmony import */ var _babel_runtime_core_js_object_values__WEBPACK_IMPORTED_MODULE_3___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_core_js_object_values__WEBPACK_IMPORTED_MODULE_3__);
/* harmony import */ var _babel_runtime_core_js_object_keys__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! @babel/runtime/core-js/object/keys */ "./node_modules/@babel/runtime/core-js/object/keys.js");
/* harmony import */ var _babel_runtime_core_js_object_keys__WEBPACK_IMPORTED_MODULE_4___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_core_js_object_keys__WEBPACK_IMPORTED_MODULE_4__);






function _defineProperty(obj, key, value) { if (key in obj) { _babel_runtime_core_js_object_define_property__WEBPACK_IMPORTED_MODULE_0___default()(obj, key, { value: value, enumerable: true, configurable: true, writable: true }); } else { obj[key] = value; } return obj; }

function _slicedToArray(arr, i) { return _arrayWithHoles(arr) || _iterableToArrayLimit(arr, i) || _nonIterableRest(); }

function _nonIterableRest() { throw new TypeError("Invalid attempt to destructure non-iterable instance"); }

function _iterableToArrayLimit(arr, i) { var _arr = []; var _n = true; var _d = false; var _e = undefined; try { for (var _i = _babel_runtime_core_js_get_iterator__WEBPACK_IMPORTED_MODULE_2___default()(arr), _s; !(_n = (_s = _i.next()).done); _n = true) { _arr.push(_s.value); if (i && _arr.length === i) break; } } catch (err) { _d = true; _e = err; } finally { try { if (!_n && _i["return"] != null) _i["return"](); } finally { if (_d) throw _e; } } return _arr; }

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
/* harmony default export */ __webpack_exports__["default"] = ({
  props: {
    placeholder: {
      type: String,
      default: 'Search..'
    },
    data: {
      type: Object,
      required: true
    },
    initalData: {
      type: Object,
      default: function _default() {
        return new Object();
      }
    },
    inputClassses: {
      type: [String, Object, Array]
    },
    autoFocus: {
      type: Boolean,
      default: false
    },
    showPinned: {
      type: Boolean,
      default: false
    },
    searchLimit: {
      type: Number,
      default: 4
    },
    hideGroupTitle: {
      type: Boolean,
      default: false
    }
  },
  data: function data() {
    return {
      searchQuery: '',
      filteredData: {},
      currentSelected: -1,
      inputFocused: false,
      insideSuggestions: false
    };
  },
  watch: {
    // UPDATE SUGGESTIONS LIST
    searchQuery: function searchQuery(val) {
      var _this = this;

      this.$emit('input', val);

      if (val === '') {
        this.inputInit();
      } else {
        var queried_data = {};

        var data_grps = _babel_runtime_core_js_object_keys__WEBPACK_IMPORTED_MODULE_4___default()(this.data);

        data_grps.forEach(function (grp, i) {
          queried_data[data_grps[i]] = _this.filter_grp(_this.data[grp]);
        }); // Check if any of group has at least one queried item

        if (!_babel_runtime_core_js_object_values__WEBPACK_IMPORTED_MODULE_3___default()(queried_data).some(function (obj) {
          return obj.length;
        })) {
          this.currentSelected = -1;
        }

        this.filteredData = queried_data;
      }
    },
    autoFocus: function autoFocus(val) {
      if (val) this.focusInput();else this.searchQuery = '';
    },
    filteredData: function filteredData(val) {
      // Auto Select first item if it's not item-404
      var grp_index = null;
      var _iteratorNormalCompletion = true;
      var _didIteratorError = false;
      var _iteratorError = undefined;

      try {
        for (var _iterator = _babel_runtime_core_js_get_iterator__WEBPACK_IMPORTED_MODULE_2___default()(_babel_runtime_core_js_object_values__WEBPACK_IMPORTED_MODULE_3___default()(val).entries()), _step; !(_iteratorNormalCompletion = (_step = _iterator.next()).done); _iteratorNormalCompletion = true) {
          var _step$value = _slicedToArray(_step.value, 2),
              index = _step$value[0],
              grp_suggestions = _step$value[1];

          if (grp_suggestions.length) {
            grp_index = index;
            break;
          }
        }
      } catch (err) {
        _didIteratorError = true;
        _iteratorError = err;
      } finally {
        try {
          if (!_iteratorNormalCompletion && _iterator.return != null) {
            _iterator.return();
          }
        } finally {
          if (_didIteratorError) {
            throw _iteratorError;
          }
        }
      }

      if (grp_index !== null) this.currentSelected = "".concat(grp_index, ".0");
    }
  },
  methods: {
    escPressed: function escPressed() {
      this.$emit('closeSearchbar');
      this.searchQuery = '';
    },
    filter_grp: function filter_grp(grp) {
      var _this2 = this;

      var exactEle = grp.data.filter(function (item) {
        return item[grp.key].toLowerCase().startsWith(_this2.searchQuery.toLowerCase());
      });
      var containEle = grp.data.filter(function (item) {
        return !item[grp.key].toLowerCase().startsWith(_this2.searchQuery.toLowerCase()) && item[grp.key].toLowerCase().indexOf(_this2.searchQuery.toLowerCase()) > -1;
      });
      return exactEle.concat(containEle).slice(0, this.searchLimit);
    },
    inputInit: function inputInit() {
      if (_babel_runtime_core_js_object_entries__WEBPACK_IMPORTED_MODULE_1___default()(this.initalData).length === 0 && this.initalData.constructor === Object) {
        this.filteredData = {};
      } else {
        this.filteredData = this.initalData;
      }
    },
    updateInputFocus: function updateInputFocus() {
      var _this3 = this;

      var val = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : true;

      if (val) {
        if (this.searchQuery === '') this.inputInit();
        setTimeout(function () {
          _this3.inputFocused = true;
        }, 100);
      } else {
        if (this.insideSuggestions) return;
        setTimeout(function () {
          _this3.inputFocused = false;
        }, 100);
        this.escPressed();
      }
    },
    suggestionSelected: function suggestionSelected() {
      if (this.currentSelected > -1) {
        var _this$currentSelected = this.currentSelected.split('.'),
            _this$currentSelected2 = _slicedToArray(_this$currentSelected, 2),
            grp_index = _this$currentSelected2[0],
            item_index = _this$currentSelected2[1];

        var grp_of_selected_item = _babel_runtime_core_js_object_keys__WEBPACK_IMPORTED_MODULE_4___default()(this.data)[grp_index];

        var selected_item = this.filteredData[grp_of_selected_item][item_index];
        this.$emit('selected', _defineProperty({}, grp_of_selected_item, selected_item));
        this.searchQuery = '';
      }
    },
    increaseIndex: function increaseIndex() {
      var val = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : true;

      /* eslint-disable no-lonely-if */
      // If there's no matching items
      if (!_babel_runtime_core_js_object_values__WEBPACK_IMPORTED_MODULE_3___default()(this.filteredData).some(function (grp_items) {
        return grp_items.length;
      })) return;

      var _this$currentSelected3 = this.currentSelected.split('.'),
          _this$currentSelected4 = _slicedToArray(_this$currentSelected3, 2),
          grp_i = _this$currentSelected4[0],
          item_i = _this$currentSelected4[1];

      var grp_arr = _babel_runtime_core_js_object_entries__WEBPACK_IMPORTED_MODULE_1___default()(this.filteredData);

      var active_grp_total_items = grp_arr[grp_i][1].length;

      if (val) {
        // If active item is not of last item in grp
        if (active_grp_total_items - 1 > item_i) {
          this.currentSelected = "".concat(grp_i, ".").concat(Number(item_i) + 1); // If active item grp is not last in grp list
        } else if (grp_i < grp_arr.length - 1) {
          for (var i = Number(grp_i) + 1; i < grp_arr.length; i++) {
            // If navigating group have items => Then move in that group
            if (grp_arr[i][1].length > 0) {
              this.currentSelected = "".concat(Number(i), ".0");
              break;
            }
          }
        }
      } else {
        // If active item is not of first item in grp
        if (Number(item_i)) {
          this.currentSelected = "".concat(grp_i, ".").concat(Number(item_i) - 1); // If active item grp  is not first in grp list
        } else if (Number(grp_i)) {
          for (var _i2 = Number(grp_i) - 1; _i2 >= 0; _i2--) {
            // If navigating group have items => Then move in that group
            if (grp_arr[_i2][1].length > 0) {
              this.currentSelected = "".concat(_i2, ".").concat(grp_arr[_i2][1].length - 1);
              break;
            }
          }
        }
      }
      /* eslint-enable no-lonely-if */

    },
    focusInput: function focusInput() {
      this.$refs.input.$el.querySelector('input').focus();
    }
  },
  mounted: function mounted() {
    if (this.autoFocus) this.focusInput();
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/src/layouts/components/AutoLogout.vue?vue&type=script&lang=js&":
/*!*********************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/src/layouts/components/AutoLogout.vue?vue&type=script&lang=js& ***!
  \*********************************************************************************************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var axios__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! axios */ "./node_modules/axios/index.js");
/* harmony import */ var axios__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(axios__WEBPACK_IMPORTED_MODULE_0__);
//
//
//
//
//
//

/* harmony default export */ __webpack_exports__["default"] = ({
  name: 'AutoLogout',
  data: function data() {
    return {
      events: ['click', 'mousemove', 'mousedown', 'scroll', 'keypress', 'load'],
      dialogActive: false,
      warningTimer: null,
      sessionTimeoutMin: 10,
      countdownTimer: 10,
      refreshIntervalId: null
    };
  },
  computed: {
    countdown: function countdown() {
      return this.countdownTimer;
    }
  },
  mounted: function mounted() {
    var _this = this;

    this.events.forEach(function (event) {
      window.addEventListener(event, _this.resetTimer);
    });
    this.setTimers();
  },
  destroyed: function destroyed() {
    var _this2 = this;

    this.events.forEach(function (event) {
      window.removeEventListener(event, _this2.resetTimer);
    });
    this.resetTimer();
  },
  methods: {
    setTimers: function setTimers() {
      this.warningTimer = setTimeout(this.warningMessage, 60 * 1000 * this.sessionTimeoutMin);
    },
    expireEvent: function expireEvent() {
      window.location.reload();
    },
    startCountdown: function startCountdown() {
      var _this3 = this;

      this.dialogActive = true;
      var intervalId = setInterval(function () {
        if (_this3.countdownTimer == 0) {
          _this3.expireEvent();

          _this3.resetTimer();
        } else {
          _this3.countdownTimer = _this3.countdownTimer - 1;
        }
      }, 1000);
      this.refreshIntervalId = intervalId;
    },
    warningMessage: function warningMessage() {
      this.startCountdown();
    },
    resetTimer: function resetTimer() {
      clearTimeout(this.warningTimer);
      clearInterval(this.refreshIntervalId);

      if (this.dialogActive) {
        this.sessionRefresh();
      }

      this.dialogActive = false;
      this.countdownTimer = 10;
      this.setTimers();
    },
    sessionRefresh: function sessionRefresh() {
      axios__WEBPACK_IMPORTED_MODULE_0___default.a.get('/sanctum/csrf-cookie').then(function () {});
    }
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/src/layouts/components/MultiDocumentNav.vue?vue&type=script&lang=js&":
/*!***************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/src/layouts/components/MultiDocumentNav.vue?vue&type=script&lang=js& ***!
  \***************************************************************************************************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _babel_runtime_core_js_array_from__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @babel/runtime/core-js/array/from */ "./node_modules/@babel/runtime/core-js/array/from.js");
/* harmony import */ var _babel_runtime_core_js_array_from__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_core_js_array_from__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _babel_runtime_core_js_is_iterable__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @babel/runtime/core-js/is-iterable */ "./node_modules/@babel/runtime/core-js/is-iterable.js");
/* harmony import */ var _babel_runtime_core_js_is_iterable__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_core_js_is_iterable__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var _babel_runtime_core_js_object_get_own_property_descriptor__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! @babel/runtime/core-js/object/get-own-property-descriptor */ "./node_modules/@babel/runtime/core-js/object/get-own-property-descriptor.js");
/* harmony import */ var _babel_runtime_core_js_object_get_own_property_descriptor__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_core_js_object_get_own_property_descriptor__WEBPACK_IMPORTED_MODULE_2__);
/* harmony import */ var _babel_runtime_core_js_object_get_own_property_symbols__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! @babel/runtime/core-js/object/get-own-property-symbols */ "./node_modules/@babel/runtime/core-js/object/get-own-property-symbols.js");
/* harmony import */ var _babel_runtime_core_js_object_get_own_property_symbols__WEBPACK_IMPORTED_MODULE_3___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_core_js_object_get_own_property_symbols__WEBPACK_IMPORTED_MODULE_3__);
/* harmony import */ var _babel_runtime_core_js_object_keys__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! @babel/runtime/core-js/object/keys */ "./node_modules/@babel/runtime/core-js/object/keys.js");
/* harmony import */ var _babel_runtime_core_js_object_keys__WEBPACK_IMPORTED_MODULE_4___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_core_js_object_keys__WEBPACK_IMPORTED_MODULE_4__);
/* harmony import */ var _babel_runtime_core_js_object_define_property__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! @babel/runtime/core-js/object/define-property */ "./node_modules/@babel/runtime/core-js/object/define-property.js");
/* harmony import */ var _babel_runtime_core_js_object_define_property__WEBPACK_IMPORTED_MODULE_5___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_core_js_object_define_property__WEBPACK_IMPORTED_MODULE_5__);
/* harmony import */ var _babel_runtime_core_js_promise__WEBPACK_IMPORTED_MODULE_6__ = __webpack_require__(/*! @babel/runtime/core-js/promise */ "./node_modules/@babel/runtime/core-js/promise.js");
/* harmony import */ var _babel_runtime_core_js_promise__WEBPACK_IMPORTED_MODULE_6___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_core_js_promise__WEBPACK_IMPORTED_MODULE_6__);
/* harmony import */ var vue_context__WEBPACK_IMPORTED_MODULE_7__ = __webpack_require__(/*! vue-context */ "./node_modules/vue-context/dist/js/vue-context.js");
/* harmony import */ var vue_context__WEBPACK_IMPORTED_MODULE_7___default = /*#__PURE__*/__webpack_require__.n(vue_context__WEBPACK_IMPORTED_MODULE_7__);
/* harmony import */ var vuex__WEBPACK_IMPORTED_MODULE_8__ = __webpack_require__(/*! vuex */ "./node_modules/vuex/dist/vuex.esm.js");








function _toConsumableArray(arr) { return _arrayWithoutHoles(arr) || _iterableToArray(arr) || _nonIterableSpread(); }

function _nonIterableSpread() { throw new TypeError("Invalid attempt to spread non-iterable instance"); }

function _iterableToArray(iter) { if (_babel_runtime_core_js_is_iterable__WEBPACK_IMPORTED_MODULE_1___default()(Object(iter)) || Object.prototype.toString.call(iter) === "[object Arguments]") return _babel_runtime_core_js_array_from__WEBPACK_IMPORTED_MODULE_0___default()(iter); }

function _arrayWithoutHoles(arr) { if (Array.isArray(arr)) { for (var i = 0, arr2 = new Array(arr.length); i < arr.length; i++) { arr2[i] = arr[i]; } return arr2; } }

function _objectSpread(target) { for (var i = 1; i < arguments.length; i++) { var source = arguments[i] != null ? arguments[i] : {}; var ownKeys = _babel_runtime_core_js_object_keys__WEBPACK_IMPORTED_MODULE_4___default()(source); if (typeof _babel_runtime_core_js_object_get_own_property_symbols__WEBPACK_IMPORTED_MODULE_3___default.a === 'function') { ownKeys = ownKeys.concat(_babel_runtime_core_js_object_get_own_property_symbols__WEBPACK_IMPORTED_MODULE_3___default()(source).filter(function (sym) { return _babel_runtime_core_js_object_get_own_property_descriptor__WEBPACK_IMPORTED_MODULE_2___default()(source, sym).enumerable; })); } ownKeys.forEach(function (key) { _defineProperty(target, key, source[key]); }); } return target; }

function _defineProperty(obj, key, value) { if (key in obj) { _babel_runtime_core_js_object_define_property__WEBPACK_IMPORTED_MODULE_5___default()(obj, key, { value: value, enumerable: true, configurable: true, writable: true }); } else { obj[key] = value; } return obj; }

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
function lazyLoadView(AsyncView) {
  var AsyncHandler = function AsyncHandler() {
    return {
      component: AsyncView,
      // A component to use while the component is loading.
      loading: __webpack_require__(/*! @/views/_loading.vue */ "./resources/js/src/views/_loading.vue").default,
      // Delay before showing the loading component.
      // Default: 200 (milliseconds).
      delay: 0,
      // A fallback component in case the timeout is exceeded
      // when loading the component.
      error: __webpack_require__(/*! @/views/_timeout.vue */ "./resources/js/src/views/_timeout.vue").default,
      // Time before giving up trying to load the component.
      // Default: Infinity (milliseconds).
      timeout: 10000
    };
  };

  return _babel_runtime_core_js_promise__WEBPACK_IMPORTED_MODULE_6___default.a.resolve({
    functional: true,
    render: function render(h, _ref) {
      var data = _ref.data,
          children = _ref.children;
      // Transparently pass any props or children
      // to the view component.
      return h(AsyncHandler, data, children);
    }
  });
}



/* harmony default export */ __webpack_exports__["default"] = ({
  components: {
    VueContext: vue_context__WEBPACK_IMPORTED_MODULE_7__["VueContext"],
    "tab-home": function tabHome() {
      return lazyLoadView(Promise.all(/*! import() | home */[__webpack_require__.e("vendors~home"), __webpack_require__.e("home")]).then(__webpack_require__.bind(null, /*! @/views/Home.vue */ "./resources/js/src/views/Home.vue")));
    },
    "tab-empty": function tabEmpty() {
      return lazyLoadView(__webpack_require__.e(/*! import() | empty */ "empty").then(__webpack_require__.bind(null, /*! @/views/Empty.vue */ "./resources/js/src/views/Empty.vue")));
    },
    "tab-example": function tabExample() {
      return lazyLoadView(__webpack_require__.e(/*! import() | example */ "example").then(__webpack_require__.bind(null, /*! @/views/Example.vue */ "./resources/js/src/views/Example.vue")));
    },
    "tab-page-1-1": function tabPage11() {
      return lazyLoadView(__webpack_require__.e(/*! import() | page-1-1 */ "page-1-1").then(__webpack_require__.bind(null, /*! @/views/Page-1-1.vue */ "./resources/js/src/views/Page-1-1.vue")));
    },
    "tab-page-1-2": function tabPage12() {
      return lazyLoadView(__webpack_require__.e(/*! import() | page-1-2 */ "page-1-2").then(__webpack_require__.bind(null, /*! @/views/Page-1-2.vue */ "./resources/js/src/views/Page-1-2.vue")));
    },
    "tab-page-1-3": function tabPage13() {
      return lazyLoadView(Promise.all(/*! import() | page-1-3 */[__webpack_require__.e(0), __webpack_require__.e("page-1-3")]).then(__webpack_require__.bind(null, /*! @/views/Page-1-3.vue */ "./resources/js/src/views/Page-1-3.vue")));
    },
    "tab-page-1-4-1": function tabPage141() {
      return lazyLoadView(Promise.all(/*! import() | page-1-4-1 */[__webpack_require__.e(0), __webpack_require__.e("page-1-4-1")]).then(__webpack_require__.bind(null, /*! @/views/Page-1-4-1.vue */ "./resources/js/src/views/Page-1-4-1.vue")));
    },
    "tab-page-1-4-2": function tabPage142() {
      return lazyLoadView(__webpack_require__.e(/*! import() | page-1-4-2 */ "page-1-4-2").then(__webpack_require__.bind(null, /*! @/views/Page-1-4-2.vue */ "./resources/js/src/views/Page-1-4-2.vue")));
    },
    "tab-page-1-4-3": function tabPage143() {
      return lazyLoadView(__webpack_require__.e(/*! import() | page-1-4-3 */ "page-1-4-3").then(__webpack_require__.bind(null, /*! @/views/Page-1-4-3.vue */ "./resources/js/src/views/Page-1-4-3.vue")));
    },
    "tab-page-1-5-1": function tabPage151() {
      return lazyLoadView(__webpack_require__.e(/*! import() | page-1-5-1 */ "page-1-5-1").then(__webpack_require__.bind(null, /*! @/views/Page-1-5-1.vue */ "./resources/js/src/views/Page-1-5-1.vue")));
    },
    "tab-page-1-5-2": function tabPage152() {
      return lazyLoadView(__webpack_require__.e(/*! import() | page-1-5-2 */ "page-1-5-2").then(__webpack_require__.bind(null, /*! @/views/Page-1-5-2.vue */ "./resources/js/src/views/Page-1-5-2.vue")));
    },
    "tab-page-1-5-3": function tabPage153() {
      return lazyLoadView(__webpack_require__.e(/*! import() | page-1-5-3 */ "page-1-5-3").then(__webpack_require__.bind(null, /*! @/views/Page-1-5-3.vue */ "./resources/js/src/views/Page-1-5-3.vue")));
    },
    "tab-page-1-6": function tabPage16() {
      return lazyLoadView(Promise.all(/*! import() | page-1-6 */[__webpack_require__.e("vendors~page-1-6~page-1-7"), __webpack_require__.e("page-1-6~page-1-7"), __webpack_require__.e("page-1-6")]).then(__webpack_require__.bind(null, /*! @/views/Page-1-6.vue */ "./resources/js/src/views/Page-1-6.vue")));
    },
    "tab-page-1-7": function tabPage17() {
      return lazyLoadView(Promise.all(/*! import() | page-1-7 */[__webpack_require__.e("vendors~page-1-6~page-1-7"), __webpack_require__.e("page-1-6~page-1-7"), __webpack_require__.e("page-1-7")]).then(__webpack_require__.bind(null, /*! @/views/Page-1-7.vue */ "./resources/js/src/views/Page-1-7.vue")));
    },
    "tab-page-1-8-1": function tabPage181() {
      return lazyLoadView(__webpack_require__.e(/*! import() | page-1-8-1 */ "page-1-8-1").then(__webpack_require__.bind(null, /*! @/views/Page-1-8-1.vue */ "./resources/js/src/views/Page-1-8-1.vue")));
    },
    "tab-page-1-8-2": function tabPage182() {
      return lazyLoadView(__webpack_require__.e(/*! import() | page-1-8-2 */ "page-1-8-2").then(__webpack_require__.bind(null, /*! @/views/Page-1-8-2.vue */ "./resources/js/src/views/Page-1-8-2.vue")));
    },
    "tab-page-1-9": function tabPage19() {
      return lazyLoadView(__webpack_require__.e(/*! import() | page-1-9 */ "page-1-9").then(__webpack_require__.bind(null, /*! @/views/Page-1-9.vue */ "./resources/js/src/views/Page-1-9.vue")));
    },
    "tab-page-1-10": function tabPage110() {
      return lazyLoadView(__webpack_require__.e(/*! import() | page-1-10 */ "page-1-10").then(__webpack_require__.bind(null, /*! @/views/Page-1-10.vue */ "./resources/js/src/views/Page-1-10.vue")));
    },
    "tab-page-1-11": function tabPage111() {
      return lazyLoadView(Promise.all(/*! import() | page-1-11 */[__webpack_require__.e(0), __webpack_require__.e(2), __webpack_require__.e("page-1-11")]).then(__webpack_require__.bind(null, /*! @/views/Page-1-11.vue */ "./resources/js/src/views/Page-1-11.vue")));
    },
    "tab-page-7-1": function tabPage71() {
      return lazyLoadView(__webpack_require__.e(/*! import() | page-7-1 */ "page-7-1").then(__webpack_require__.bind(null, /*! @/views/Page-7-1.vue */ "./resources/js/src/views/Page-7-1.vue")));
    },
    "tab-profile-general": function tabProfileGeneral() {
      return lazyLoadView(__webpack_require__.e(/*! import() | profile-general */ "profile-general").then(__webpack_require__.bind(null, /*! @/views/ProfileGeneral.vue */ "./resources/js/src/views/ProfileGeneral.vue")));
    },
    "tab-profile-password": function tabProfilePassword() {
      return lazyLoadView(__webpack_require__.e(/*! import() | profile-password */ "profile-password").then(__webpack_require__.bind(null, /*! @/views/ProfilePassword.vue */ "./resources/js/src/views/ProfilePassword.vue")));
    }
  },
  data: function data() {
    return {
      contextTab: null
    };
  },
  computed: _objectSpread({}, Object(vuex__WEBPACK_IMPORTED_MODULE_8__["mapGetters"])({
    activeTab: "mdn/getActive",
    tabs: "mdn/getTabs",
    activeTabComponent: "mdn/getActiveTabComponent"
  })),
  methods: _objectSpread({}, Object(vuex__WEBPACK_IMPORTED_MODULE_8__["mapActions"])({
    gotoTab: "mdn/gotoTab",
    addTab: "mdn/addTab",
    removeTab: "mdn/removeTab",
    removeTabs: "mdn/removeTabs",
    routeTo: "mdn/tabRouteTo"
  }), {
    closeTab: function closeTab(tab) {
      var _this = this;

      this.$vs.dialog({
        type: "confirm",
        color: "dark",
        title: this.$t("Confirmation"),
        text: this.$t("CloseDocument"),
        acceptText: this.$t("Accept"),
        cancelText: this.$t("Cancel"),
        accept: function accept() {
          return _this.removeTab(tab);
        }
      });
    },
    contextClose: function contextClose() {
      this.removeTab(this.contextTab);
    },
    contextCloseOther: function contextCloseOther() {
      var _this2 = this;

      var tabsToRemove = [];

      var tabsClone = _toConsumableArray(this.tabs);

      tabsClone.forEach(function (tab) {
        if (tab.value != _this2.contextTab) {
          tabsToRemove.push(tab);
        }
      });
      this.removeTabs(tabsToRemove);
    },
    contextCloseRight: function contextCloseRight() {
      var _this3 = this;

      var tabsToRemove = [];

      var tabsClone = _toConsumableArray(this.tabs);

      var found = false;
      tabsClone.forEach(function (tab) {
        if (found) {
          tabsToRemove.push(tab);
        }

        if (tab.value == _this3.contextTab) {
          found = true;
        }
      });
      this.removeTabs(tabsToRemove);
    },
    contextCloseAll: function contextCloseAll() {
      var tabsClone = _toConsumableArray(this.tabs);

      this.removeTabs(tabsClone);
    }
  })
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/src/layouts/components/TheFooter.vue?vue&type=script&lang=js&":
/*!********************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/src/layouts/components/TheFooter.vue?vue&type=script&lang=js& ***!
  \********************************************************************************************************************************************************************************/
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
/* harmony default export */ __webpack_exports__["default"] = ({
  name: 'the-footer',
  props: {
    classes: {
      type: String
    }
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/src/layouts/components/horizontal-nav-menu/HorizontalNavMenu.vue?vue&type=script&lang=js&":
/*!************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/src/layouts/components/horizontal-nav-menu/HorizontalNavMenu.vue?vue&type=script&lang=js& ***!
  \************************************************************************************************************************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _HorizontalNavMenuGroup_vue__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./HorizontalNavMenuGroup.vue */ "./resources/js/src/layouts/components/horizontal-nav-menu/HorizontalNavMenuGroup.vue");
/* harmony import */ var _HorizontalNavMenuHeader_vue__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./HorizontalNavMenuHeader.vue */ "./resources/js/src/layouts/components/horizontal-nav-menu/HorizontalNavMenuHeader.vue");
/* harmony import */ var _HorizontalNavMenuItem_vue__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./HorizontalNavMenuItem.vue */ "./resources/js/src/layouts/components/horizontal-nav-menu/HorizontalNavMenuItem.vue");
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
  props: {
    // navbarColor  : { type: String, default: "#fff", },
    navMenuItems: {
      type: Array,
      required: true
    }
  },
  components: {
    HNavMenuGroup: _HorizontalNavMenuGroup_vue__WEBPACK_IMPORTED_MODULE_0__["default"],
    HNavMenuHeader: _HorizontalNavMenuHeader_vue__WEBPACK_IMPORTED_MODULE_1__["default"],
    HNavMenuItem: _HorizontalNavMenuItem_vue__WEBPACK_IMPORTED_MODULE_2__["default"]
  },
  computed: {
    navbarColor: function navbarColor() {
      return this.$store.state.theme === 'dark' ? '#10163a' : '#fff';
    }
  },
  methods: {
    checkGrpChildrenActive: function checkGrpChildrenActive(group) {
      var _this = this;

      var path = this.$route.fullPath;
      var active = false;
      var routeParent = this.$route.meta ? this.$route.meta.parent : undefined;

      if (group.submenu) {
        group.submenu.forEach(function (item) {
          if (active) return true;

          if ((path === item.url || routeParent === item.slug) && item.url) {
            active = true;
          } else if (item.submenu) {
            _this.checkGrpChildrenActive(item);
          }
        });
      }

      return active;
    }
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/src/layouts/components/horizontal-nav-menu/HorizontalNavMenuGroup.vue?vue&type=script&lang=js&":
/*!*****************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/src/layouts/components/horizontal-nav-menu/HorizontalNavMenuGroup.vue?vue&type=script&lang=js& ***!
  \*****************************************************************************************************************************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _HorizontalNavMenuItem_vue__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./HorizontalNavMenuItem.vue */ "./resources/js/src/layouts/components/horizontal-nav-menu/HorizontalNavMenuItem.vue");
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
// import VNavMenuItem from './VerticalNavMenuItem.vue'

/* harmony default export */ __webpack_exports__["default"] = ({
  name: 'h-nav-menu-group',
  props: {
    openHover: {
      type: Boolean,
      default: true
    },
    open: {
      type: Boolean,
      default: false
    },
    group: {
      type: Object
    },
    groupIndex: {
      type: Number
    },
    bottom: {
      type: Boolean,
      default: false
    }
  },
  components: {
    HNavMenuItem: _HorizontalNavMenuItem_vue__WEBPACK_IMPORTED_MODULE_0__["default"]
  },
  data: function data() {
    return {
      openItems: false,
      hovered: false,
      dropLeft: false
    };
  },
  computed: {
    iconClasses: function iconClasses() {
      var classes = 'mr-3 ';
      classes += this.groupIndex % 1 !== 0 ? 'w-3 h-3' : 'w-5 h-5';
      return classes;
    },
    styleItems: function styleItems() {
      var style = {};

      if (this.bottom) {
        style.top = '100%';
        style.left = '0';
      } else {
        style.top = '12px';
        style.left = '100%';
      }

      if (this.dropLeft) {
        style.left = null;
        style.right = '100%';
      }

      if (this.$vs.rtl) {
        var temp = style.left;
        style.left = style.right;
        style.right = temp;
      }

      return style;
    },
    itemIcon: function itemIcon() {
      // return (index) => {
      //   // if (!((index.match(/\./g) || []).length > 1)) return "CircleIcon"
      // }
      return 'CircleIcon';
    },
    isGroupActive: function isGroupActive() {
      var _this = this;

      return function (item) {
        var path = _this.$route.fullPath;
        var open = false;
        var routeParent = _this.$route.meta ? _this.$route.meta.parent : undefined;

        var func = function func(item) {
          if (item.submenu) {
            item.submenu.forEach(function (item) {
              if ((path === item.url || routeParent === item.slug) && item.url) {
                open = true;
              } else if (item.submenu) {
                func(item);
              }
            });
          }
        };

        func(item);
        return open;
      };
    }
  },
  watch: {
    hovered: function hovered(val) {
      var _this2 = this;

      this.$nextTick(function () {
        if (val) {
          var dd = _this2.$refs.childDropdown;

          if (window.innerHeight - dd.getBoundingClientRect().top - dd.getBoundingClientRect().height - 28 < 1) {
            var maxHeight = window.innerHeight - dd.getBoundingClientRect().top - 70;
            dd.style.maxHeight = "".concat(maxHeight, "px");
            dd.style.overflowY = 'auto';
            dd.style.overflowX = 'hidden';
          }

          if (dd.getBoundingClientRect().left + dd.offsetWidth - (window.innerWidth - 16) >= 0 || _this2.$parent.dropLeft) {
            _this2.dropLeft = true;
          }

          if (_this2.$vs.rtl) {
            if (dd.getBoundingClientRect().right - dd.offsetWidth - 16 < 0) {
              _this2.dropLeft = true;
            }
          }
        } else {
          _this2.dropLeft = false;
        }
      });
    }
  },
  methods: {
    mouseover: function mouseover() {
      this.hovered = true;

      if (this.openHover) {
        this.showChildren();
      }
    },
    mouseout: function mouseout() {
      this.hovered = false;

      if (this.openHover) {
        this.showChildren(false);
      }
    },
    showChildren: function showChildren() {
      var val = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : true;
      this.openItems = val;
    }
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/src/layouts/components/horizontal-nav-menu/HorizontalNavMenuHeader.vue?vue&type=script&lang=js&":
/*!******************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/src/layouts/components/horizontal-nav-menu/HorizontalNavMenuHeader.vue?vue&type=script&lang=js& ***!
  \******************************************************************************************************************************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _HorizontalNavMenuGroup_vue__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./HorizontalNavMenuGroup.vue */ "./resources/js/src/layouts/components/horizontal-nav-menu/HorizontalNavMenuGroup.vue");
/* harmony import */ var _HorizontalNavMenuItem_vue__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./HorizontalNavMenuItem.vue */ "./resources/js/src/layouts/components/horizontal-nav-menu/HorizontalNavMenuItem.vue");
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
  props: {
    header: {
      type: Object,
      requried: true
    },
    openOnHover: {
      type: Boolean,
      default: true
    }
  },
  components: {
    HNavMenuGroup: _HorizontalNavMenuGroup_vue__WEBPACK_IMPORTED_MODULE_0__["default"],
    HNavMenuItem: _HorizontalNavMenuItem_vue__WEBPACK_IMPORTED_MODULE_1__["default"]
  },
  data: function data() {
    return {
      showChildren: false,
      isHovered: false,
      dropRight: false
    };
  },
  computed: {
    isHeaderActive: function isHeaderActive() {
      var _this = this;

      var path = this.$route.fullPath;
      var active = false;
      var routeParent = this.$route.meta ? this.$route.meta.parent : undefined;
      this.header.items.forEach(function (item) {
        // If item is group
        if (item.submenu) {
          if (_this.checkGrpChildrenActive(item)) {
            active = true;
          }
        } else if (item.url) {
          if (path === item.url || routeParent === item.slug) {
            active = true;
          }
        }
      });
      return active;
    }
  },
  watch: {
    showChildren: function showChildren() {
      var _this2 = this;

      this.$nextTick(function () {
        if (_this2.showChildren) {
          var dd = _this2.$refs.headerDropdown;

          if (dd.getBoundingClientRect().left + dd.offsetWidth - (window.innerWidth - 16) >= 0) {
            _this2.dropRight = true;
          }
        }
      });
    }
  },
  methods: {
    checkGrpChildrenActive: function checkGrpChildrenActive(group) {
      var _this3 = this;

      var path = this.$route.fullPath;
      var active = false;
      var routeParent = this.$route.meta ? this.$route.meta.parent : undefined;

      if (group.submenu) {
        group.submenu.forEach(function (item) {
          if ((path === item.url || routeParent === item.slug) && item.slug) active = true;else if (item.submenu) {
            if (_this3.checkGrpChildrenActive(item)) active = true;
          }
        });
      }

      return active;
    },
    hovered: function hovered() {
      var val = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : true;
      this.isHovered = val;

      if (this.openOnHover) {
        val ? this.showChildren = true : this.showChildren = false;
      }
    }
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/src/layouts/components/horizontal-nav-menu/HorizontalNavMenuItem.vue?vue&type=script&lang=js&":
/*!****************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/src/layouts/components/horizontal-nav-menu/HorizontalNavMenuItem.vue?vue&type=script&lang=js& ***!
  \****************************************************************************************************************************************************************************************************************/
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
/* harmony default export */ __webpack_exports__["default"] = ({
  name: 'v-nav-menu-item',
  props: {
    icon: {
      type: String,
      default: ''
    },
    iconSmall: {
      type: Boolean,
      default: false
    },
    iconPack: {
      type: String,
      default: 'material-icons'
    },
    href: {
      type: [String, null],
      default: '#'
    },
    to: {
      type: [String, Object, null],
      default: null
    },
    slug: {
      type: String,
      default: null
    },
    index: {
      type: [String, Number],
      default: null
    },
    featherIcon: {
      type: Boolean,
      default: true
    },
    target: {
      type: String,
      default: '_self'
    },
    isDisabled: {
      type: Boolean,
      default: false
    }
  },
  computed: {
    iconClasses: function iconClasses() {
      return this.iconSmall ? 'w-3 h-3 mr-3' : 'w-5 h-5 mr-3';
    },
    activeLink: function activeLink() {
      return !!((this.to === this.$route.path || this.$route.meta.parent === this.slug) && this.to);
    }
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/src/layouts/components/navbar/TheNavbarHorizontal.vue?vue&type=script&lang=js&":
/*!*************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/src/layouts/components/navbar/TheNavbarHorizontal.vue?vue&type=script&lang=js& ***!
  \*************************************************************************************************************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _components_Bookmarks_vue__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./components/Bookmarks.vue */ "./resources/js/src/layouts/components/navbar/components/Bookmarks.vue");
/* harmony import */ var _components_SearchBar_vue__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./components/SearchBar.vue */ "./resources/js/src/layouts/components/navbar/components/SearchBar.vue");
/* harmony import */ var _components_NotificationDropDown_vue__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./components/NotificationDropDown.vue */ "./resources/js/src/layouts/components/navbar/components/NotificationDropDown.vue");
/* harmony import */ var _components_ProfileDropDown_vue__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./components/ProfileDropDown.vue */ "./resources/js/src/layouts/components/navbar/components/ProfileDropDown.vue");
/* harmony import */ var _Logo_vue__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! ../Logo.vue */ "./resources/js/src/layouts/components/Logo.vue");
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
  name: 'the-navbar-horizontal',
  props: {
    logo: {
      type: String
    },
    navbarType: {
      type: String,
      required: true
    }
  },
  components: {
    Logo: _Logo_vue__WEBPACK_IMPORTED_MODULE_4__["default"],
    Bookmarks: _components_Bookmarks_vue__WEBPACK_IMPORTED_MODULE_0__["default"],
    SearchBar: _components_SearchBar_vue__WEBPACK_IMPORTED_MODULE_1__["default"],
    NotificationDropDown: _components_NotificationDropDown_vue__WEBPACK_IMPORTED_MODULE_2__["default"],
    ProfileDropDown: _components_ProfileDropDown_vue__WEBPACK_IMPORTED_MODULE_3__["default"]
  },
  computed: {
    navbarColor: function navbarColor() {
      var color = '#fff';
      if (this.navbarType === 'sticky') color = '#f7f7f7';else if (this.navbarType === 'static') {
        if (this.scrollY < 50) {
          color = '#f7f7f7';
        }
      }

      if (this.isThemedark === 'dark') {
        if (color === '#fff') {
          color = '#10163a';
        } else {
          color = '#262c49';
        }
      }

      return color;
    },
    isThemedark: function isThemedark() {
      return this.$store.state.theme;
    },
    navbarStyle: function navbarStyle() {
      return this.navbarType === 'static' ? {
        transition: 'all .25s ease-in-out'
      } : {};
    },
    navbarClasses: function navbarClasses() {
      return this.scrollY > 5 && this.navbarType === 'static' ? null : 'd-theme-dark-light-bg shadow-none';
    },
    scrollY: function scrollY() {
      return this.$store.state.scrollY;
    },
    verticalNavMenuWidth: function verticalNavMenuWidth() {
      return this.$store.state.verticalNavMenuWidth;
    },
    windowWidth: function windowWidth() {
      return this.$store.state.windowWidth;
    }
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/src/layouts/components/navbar/TheNavbarVertical.vue?vue&type=script&lang=js&":
/*!***********************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/src/layouts/components/navbar/TheNavbarVertical.vue?vue&type=script&lang=js& ***!
  \***********************************************************************************************************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _babel_runtime_core_js_get_iterator__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @babel/runtime/core-js/get-iterator */ "./node_modules/@babel/runtime/core-js/get-iterator.js");
/* harmony import */ var _babel_runtime_core_js_get_iterator__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_core_js_get_iterator__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var axios__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! axios */ "./node_modules/axios/index.js");
/* harmony import */ var axios__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(axios__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var _components_Bookmarks_vue__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./components/Bookmarks.vue */ "./resources/js/src/layouts/components/navbar/components/Bookmarks.vue");
/* harmony import */ var _components_SearchBar_vue__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./components/SearchBar.vue */ "./resources/js/src/layouts/components/navbar/components/SearchBar.vue");
/* harmony import */ var _components_I18n_vue__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! ./components/I18n.vue */ "./resources/js/src/layouts/components/navbar/components/I18n.vue");
/* harmony import */ var _components_NotificationDropDown_vue__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! ./components/NotificationDropDown.vue */ "./resources/js/src/layouts/components/navbar/components/NotificationDropDown.vue");
/* harmony import */ var _components_ProfileDropDown_vue__WEBPACK_IMPORTED_MODULE_6__ = __webpack_require__(/*! ./components/ProfileDropDown.vue */ "./resources/js/src/layouts/components/navbar/components/ProfileDropDown.vue");
/* harmony import */ var _vertical_nav_menu_navMenuItems__WEBPACK_IMPORTED_MODULE_7__ = __webpack_require__(/*! ./../vertical-nav-menu/navMenuItems */ "./resources/js/src/layouts/components/vertical-nav-menu/navMenuItems.js");


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







/* harmony default export */ __webpack_exports__["default"] = ({
  name: 'the-navbar-vertical',
  props: {
    navbarColor: {
      type: String,
      default: '#fff'
    }
  },
  components: {
    I18n: _components_I18n_vue__WEBPACK_IMPORTED_MODULE_4__["default"],
    Bookmarks: _components_Bookmarks_vue__WEBPACK_IMPORTED_MODULE_2__["default"],
    SearchBar: _components_SearchBar_vue__WEBPACK_IMPORTED_MODULE_3__["default"],
    NotificationDropDown: _components_NotificationDropDown_vue__WEBPACK_IMPORTED_MODULE_5__["default"],
    ProfileDropDown: _components_ProfileDropDown_vue__WEBPACK_IMPORTED_MODULE_6__["default"]
  },
  computed: {
    navbarColorLocal: function navbarColorLocal() {
      return this.$store.state.theme === 'dark' && this.navbarColor === '#fff' ? '#10163a' : this.navbarColor;
    },
    verticalNavMenuWidth: function verticalNavMenuWidth() {
      return this.$store.state.verticalNavMenuWidth;
    },
    textColor: function textColor() {
      return {
        'text-white': this.navbarColor !== '#10163a' && this.$store.state.theme === 'dark' || this.navbarColor !== '#fff' && this.$store.state.theme !== 'dark'
      };
    },
    windowWidth: function windowWidth() {
      return this.$store.state.windowWidth;
    },
    // NAVBAR STYLE
    classObj: function classObj() {
      if (this.verticalNavMenuWidth === 'default') return 'navbar-default';else if (this.verticalNavMenuWidth === 'reduced') return 'navbar-reduced';else if (this.verticalNavMenuWidth) return 'navbar-full';
    },
    menuItemsUpdated: function menuItemsUpdated() {
      var clone = _vertical_nav_menu_navMenuItems__WEBPACK_IMPORTED_MODULE_7__["default"].slice().filter(function (item) {
        return !item.hideMenu;
      });
      var _iteratorNormalCompletion = true;
      var _didIteratorError = false;
      var _iteratorError = undefined;

      try {
        var _loop = function _loop() {
          var _step$value = _slicedToArray(_step.value, 2),
              index = _step$value[0],
              item = _step$value[1];

          if (item.header && item.items.length && (index || 1)) {
            var i = clone.findIndex(function (ix) {
              return ix.header === item.header;
            });
            var _iteratorNormalCompletion2 = true;
            var _didIteratorError2 = false;
            var _iteratorError2 = undefined;

            try {
              for (var _iterator2 = _babel_runtime_core_js_get_iterator__WEBPACK_IMPORTED_MODULE_0___default()(item.items.entries()), _step2; !(_iteratorNormalCompletion2 = (_step2 = _iterator2.next()).done); _iteratorNormalCompletion2 = true) {
                var _step2$value = _slicedToArray(_step2.value, 2),
                    subIndex = _step2$value[0],
                    subItem = _step2$value[1];

                clone.splice(i + 1 + subIndex, 0, subItem);
              }
            } catch (err) {
              _didIteratorError2 = true;
              _iteratorError2 = err;
            } finally {
              try {
                if (!_iteratorNormalCompletion2 && _iterator2.return != null) {
                  _iterator2.return();
                }
              } finally {
                if (_didIteratorError2) {
                  throw _iteratorError2;
                }
              }
            }
          }
        };

        for (var _iterator = _babel_runtime_core_js_get_iterator__WEBPACK_IMPORTED_MODULE_0___default()(_vertical_nav_menu_navMenuItems__WEBPACK_IMPORTED_MODULE_7__["default"].entries()), _step; !(_iteratorNormalCompletion = (_step = _iterator.next()).done); _iteratorNormalCompletion = true) {
          _loop();
        }
      } catch (err) {
        _didIteratorError = true;
        _iteratorError = err;
      } finally {
        try {
          if (!_iteratorNormalCompletion && _iterator.return != null) {
            _iterator.return();
          }
        } finally {
          if (_didIteratorError) {
            throw _iteratorError;
          }
        }
      }

      return clone;
    }
  },
  methods: {
    showSidebar: function showSidebar() {
      this.$store.commit('TOGGLE_IS_VERTICAL_NAV_MENU_ACTIVE', true);
    },
    logout: function logout() {
      var _this = this;

      axios__WEBPACK_IMPORTED_MODULE_1___default.a.post('/logout').then(function (res) {
        localStorage.removeItem('userInfo'); // This is just for demo Purpose. If user clicks on logout -> redirect

        _this.$router.push('/login').catch(function () {});
      });
    }
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/src/layouts/components/navbar/components/Bookmarks.vue?vue&type=script&lang=js&":
/*!**************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/src/layouts/components/navbar/components/Bookmarks.vue?vue&type=script&lang=js& ***!
  \**************************************************************************************************************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var vuedraggable__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! vuedraggable */ "./node_modules/vuedraggable/dist/vuedraggable.umd.js");
/* harmony import */ var vuedraggable__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(vuedraggable__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _components_vx_auto_suggest_VxAutoSuggest_vue__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @/components/vx-auto-suggest/VxAutoSuggest.vue */ "./resources/js/src/components/vx-auto-suggest/VxAutoSuggest.vue");
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
  props: {
    navbarColor: {
      type: String,
      default: '#fff'
    }
  },
  components: {
    draggable: vuedraggable__WEBPACK_IMPORTED_MODULE_0___default.a,
    VxAutoSuggest: _components_vx_auto_suggest_VxAutoSuggest_vue__WEBPACK_IMPORTED_MODULE_1__["default"]
  },
  data: function data() {
    return {
      showBookmarkPagesDropdown: false
    };
  },
  watch: {
    '$route': function $route() {
      if (this.showBookmarkPagesDropdown) this.showBookmarkPagesDropdown = false;
    }
  },
  computed: {
    navbarSearchAndPinList: function navbarSearchAndPinList() {
      return {
        pages: this.$store.state.navbarSearchAndPinList['pages']
      };
    },
    starredPages: function starredPages() {
      return this.$store.state.starredPages;
    },
    starredPagesLimited: {
      get: function get() {
        return this.starredPages.slice(0, 10);
      },
      set: function set(list) {
        this.$store.dispatch('arrangeStarredPagesLimited', list);
      }
    },
    starredPagesMore: {
      get: function get() {
        return this.starredPages.slice(10);
      },
      set: function set(list) {
        this.$store.dispatch('arrangeStarredPagesMore', list);
      }
    },
    textColor: function textColor() {
      return {
        'text-white': this.$store.state.mainLayoutType === 'vertical' && this.navbarColor !== (this.$store.state.theme === 'dark' ? '#10163a' : '#fff')
      };
    }
  },
  methods: {
    selected: function selected(obj) {
      this.$store.commit('TOGGLE_CONTENT_OVERLAY', false);
      this.showBookmarkPagesDropdown = false;
      this.$router.push(obj.pages.url).catch(function () {});
    },
    actionClicked: function actionClicked(item) {
      this.$store.dispatch('updateStarredPage', {
        url: item.url,
        val: !item.is_bookmarked
      }); // this.$refs.bookmarkAutoSuggest.filterData()
    },
    outside: function outside() {
      this.showBookmarkPagesDropdown = false;
    },
    hnd_search_query_update: function hnd_search_query_update(query) {
      // Show overlay if any character is entered
      this.$store.commit('TOGGLE_CONTENT_OVERLAY', !!query);
    }
  },
  directives: {
    'click-outside': {
      bind: function bind(el, binding) {
        var bubble = binding.modifiers.bubble;

        var handler = function handler(e) {
          /* eslint-disable no-mixed-operators */
          if (bubble || !el.contains(e.target) && el !== e.target) {
            /* eslint-enable no-mixed-operators */
            binding.value(e);
          }
        };

        el.__vueClickOutside__ = handler;
        document.addEventListener('click', handler);
      },
      unbind: function unbind(el) {
        document.removeEventListener('click', el.__vueClickOutside__);
        el.__vueClickOutside__ = null;
      }
    }
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/src/layouts/components/navbar/components/I18n.vue?vue&type=script&lang=js&":
/*!*********************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/src/layouts/components/navbar/components/I18n.vue?vue&type=script&lang=js& ***!
  \*********************************************************************************************************************************************************************************************/
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
/* harmony default export */ __webpack_exports__["default"] = ({
  computed: {
    i18n_locale_img: function i18n_locale_img() {
      // Use below code to dynamically fetch image instead of if-else
      // NOTE: We used if-else because laravel throws error in 'yarn prod'.
      // If you are not using laravel + Vue, you can use below code to dynamically get image
      // return require(`@assets/images/flags/${this.$i18n.locale}.png`)
      var locale = this.$i18n.locale;
      if (locale === 'en') return __webpack_require__(/*! @assets/images/flags/en.png */ "./resources/assets/images/flags/en.png");else if (locale === 'kr') return __webpack_require__(/*! @assets/images/flags/kr.png */ "./resources/assets/images/flags/kr.png");else return __webpack_require__(/*! @assets/images/flags/en.png */ "./resources/assets/images/flags/en.png");
    },
    getCurrentLocaleData: function getCurrentLocaleData() {
      var locale = this.$i18n.locale;
      if (locale === 'en') return {
        flag: 'us',
        lang: 'English'
      };else if (locale === 'kr') return {
        flag: 'kr',
        lang: 'Korean'
      };
    }
  },
  methods: {
    updateLocale: function updateLocale(locale) {
      this.$i18n.locale = locale;
    }
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/src/layouts/components/navbar/components/NotificationDropDown.vue?vue&type=script&lang=js&":
/*!*************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/src/layouts/components/navbar/components/NotificationDropDown.vue?vue&type=script&lang=js& ***!
  \*************************************************************************************************************************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var vue_perfect_scrollbar__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! vue-perfect-scrollbar */ "./node_modules/vue-perfect-scrollbar/dist/index.js");
/* harmony import */ var vue_perfect_scrollbar__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(vue_perfect_scrollbar__WEBPACK_IMPORTED_MODULE_0__);
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
  components: {
    VuePerfectScrollbar: vue_perfect_scrollbar__WEBPACK_IMPORTED_MODULE_0___default.a
  },
  data: function data() {
    return {
      unreadNotifications: [{
        index: 0,
        title: 'New Message',
        msg: 'Are your going to meet me tonight?',
        icon: 'MessageSquareIcon',
        time: this.randomDate({
          sec: 10
        }),
        category: 'primary'
      }, {
        index: 1,
        title: 'New Order Recieved',
        msg: 'You got new order of goods.',
        icon: 'PackageIcon',
        time: this.randomDate({
          sec: 40
        }),
        category: 'success'
      }, {
        index: 2,
        title: 'Server Limit Reached!',
        msg: 'Server have 99% CPU usage.',
        icon: 'AlertOctagonIcon',
        time: this.randomDate({
          min: 1
        }),
        category: 'danger'
      }, {
        index: 3,
        title: 'New Mail From Peter',
        msg: 'Cake sesame snaps cupcake',
        icon: 'MailIcon',
        time: this.randomDate({
          min: 6
        }),
        category: 'primary'
      }, {
        index: 4,
        title: 'Bruce\'s Party',
        msg: 'Chocolate cake oat cake tiramisu',
        icon: 'CalendarIcon',
        time: this.randomDate({
          hr: 2
        }),
        category: 'warning'
      }],
      settings: {
        maxScrollbarLength: 60,
        wheelSpeed: .60
      }
    };
  },
  computed: {
    scrollbarTag: function scrollbarTag() {
      return this.$store.getters.scrollbarTag;
    }
  },
  methods: {
    elapsedTime: function elapsedTime(startTime) {
      var x = new Date(startTime);
      var now = new Date();
      var timeDiff = now - x;
      timeDiff /= 1000;
      var seconds = Math.round(timeDiff);
      timeDiff = Math.floor(timeDiff / 60);
      var minutes = Math.round(timeDiff % 60);
      timeDiff = Math.floor(timeDiff / 60);
      var hours = Math.round(timeDiff % 24);
      timeDiff = Math.floor(timeDiff / 24);
      var days = Math.round(timeDiff % 365);
      timeDiff = Math.floor(timeDiff / 365);
      var years = timeDiff;

      if (years > 0) {
        return "".concat(years + (years > 1 ? ' Years ' : ' Year '), "ago");
      } else if (days > 0) {
        return "".concat(days + (days > 1 ? ' Days ' : ' Day '), "ago");
      } else if (hours > 0) {
        return "".concat(hours + (hours > 1 ? ' Hrs ' : ' Hour '), "ago");
      } else if (minutes > 0) {
        return "".concat(minutes + (minutes > 1 ? ' Mins ' : ' Min '), "ago");
      } else if (seconds > 0) {
        return seconds + (seconds > 1 ? ' sec ago' : 'just now');
      }

      return 'Just Now';
    },
    // Method for creating dummy notification time
    randomDate: function randomDate(_ref) {
      var hr = _ref.hr,
          min = _ref.min,
          sec = _ref.sec;
      var date = new Date();
      if (hr) date.setHours(date.getHours() - hr);
      if (min) date.setMinutes(date.getMinutes() - min);
      if (sec) date.setSeconds(date.getSeconds() - sec);
      return date;
    }
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/src/layouts/components/navbar/components/ProfileDropDown.vue?vue&type=script&lang=js&":
/*!********************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/src/layouts/components/navbar/components/ProfileDropDown.vue?vue&type=script&lang=js& ***!
  \********************************************************************************************************************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var axios__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! axios */ "./node_modules/axios/index.js");
/* harmony import */ var axios__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(axios__WEBPACK_IMPORTED_MODULE_0__);
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
  computed: {
    activeUserInfo: function activeUserInfo() {
      return this.$store.state.AppActiveUser;
    }
  },
  methods: {
    logout: function logout() {
      var _this = this;

      axios__WEBPACK_IMPORTED_MODULE_0___default.a.post('/logout').then(function (res) {
        localStorage.removeItem('userInfo'); // This is just for demo Purpose. If user clicks on logout -> redirect

        _this.$router.push('/login').catch(function () {});
      });
    }
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/src/layouts/components/navbar/components/SearchBar.vue?vue&type=script&lang=js&":
/*!**************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/src/layouts/components/navbar/components/SearchBar.vue?vue&type=script&lang=js& ***!
  \**************************************************************************************************************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _components_vx_auto_suggest_VxAutoSuggest_vue__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @/components/vx-auto-suggest/VxAutoSuggest.vue */ "./resources/js/src/components/vx-auto-suggest/VxAutoSuggest.vue");
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
  components: {
    VxAutoSuggest: _components_vx_auto_suggest_VxAutoSuggest_vue__WEBPACK_IMPORTED_MODULE_0__["default"]
  },
  data: function data() {
    return {
      navbarSearchAndPinList: this.$store.state.navbarSearchAndPinList,
      showFullSearch: false
    };
  },
  methods: {
    selected: function selected(item) {
      if (item.pages) this.$router.push(item.pages.url).catch(function () {});
      this.showFullSearch = false;
    },
    hnd_search_query_update: function hnd_search_query_update(query) {
      // Show overlay if any character is entered
      this.$store.commit('TOGGLE_CONTENT_OVERLAY', !!query);
    }
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/src/layouts/components/vertical-nav-menu/VerticalNavMenu.vue?vue&type=script&lang=js&":
/*!********************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/src/layouts/components/vertical-nav-menu/VerticalNavMenu.vue?vue&type=script&lang=js& ***!
  \********************************************************************************************************************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _babel_runtime_core_js_get_iterator__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @babel/runtime/core-js/get-iterator */ "./node_modules/@babel/runtime/core-js/get-iterator.js");
/* harmony import */ var _babel_runtime_core_js_get_iterator__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_core_js_get_iterator__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var vue_perfect_scrollbar__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! vue-perfect-scrollbar */ "./node_modules/vue-perfect-scrollbar/dist/index.js");
/* harmony import */ var vue_perfect_scrollbar__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(vue_perfect_scrollbar__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var _VerticalNavMenuGroup_vue__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./VerticalNavMenuGroup.vue */ "./resources/js/src/layouts/components/vertical-nav-menu/VerticalNavMenuGroup.vue");
/* harmony import */ var _VerticalNavMenuItem_vue__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./VerticalNavMenuItem.vue */ "./resources/js/src/layouts/components/vertical-nav-menu/VerticalNavMenuItem.vue");
/* harmony import */ var _Logo_vue__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! ../Logo.vue */ "./resources/js/src/layouts/components/Logo.vue");


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
  name: 'v-nav-menu',
  components: {
    VNavMenuGroup: _VerticalNavMenuGroup_vue__WEBPACK_IMPORTED_MODULE_2__["default"],
    VNavMenuItem: _VerticalNavMenuItem_vue__WEBPACK_IMPORTED_MODULE_3__["default"],
    VuePerfectScrollbar: vue_perfect_scrollbar__WEBPACK_IMPORTED_MODULE_1___default.a,
    Logo: _Logo_vue__WEBPACK_IMPORTED_MODULE_4__["default"]
  },
  props: {
    logo: {
      type: String
    },
    openGroupHover: {
      type: Boolean,
      default: false
    },
    parent: {
      type: String
    },
    reduceNotRebound: {
      type: Boolean,
      default: true
    },
    navMenuItems: {
      type: Array,
      required: true
    },
    title: {
      type: String
    }
  },
  data: function data() {
    return {
      clickNotClose: false,
      // disable close navMenu on outside click
      isMouseEnter: false,
      reduce: false,
      // determines if navMenu is reduce - component property
      showCloseButton: false,
      // show close button in smaller devices
      settings: {
        // perfectScrollbar settings
        maxScrollbarLength: 60,
        wheelSpeed: 1,
        swipeEasing: true
      },
      showShadowBottom: false
    };
  },
  computed: {
    isGroupActive: function isGroupActive() {
      var _this = this;

      return function (item) {
        var path = _this.$route.fullPath;
        var routeParent = _this.$route.meta ? _this.$route.meta.parent : undefined;
        var open = false;

        var func = function func(item) {
          if (item.submenu) {
            item.submenu.forEach(function (item) {
              if (item.url && (path === item.url || routeParent === item.slug)) {
                open = true;
              } else if (item.submenu) {
                func(item);
              }
            });
          }
        };

        func(item);
        return open;
      };
    },
    menuItemsUpdated: function menuItemsUpdated() {
      var clone = this.navMenuItems.slice();
      var _iteratorNormalCompletion = true;
      var _didIteratorError = false;
      var _iteratorError = undefined;

      try {
        var _loop = function _loop() {
          var _step$value = _slicedToArray(_step.value, 2),
              index = _step$value[0],
              item = _step$value[1];

          if (item.header && item.items.length && (index || 1)) {
            var i = clone.findIndex(function (ix) {
              return ix.header === item.header;
            });
            var _iteratorNormalCompletion3 = true;
            var _didIteratorError3 = false;
            var _iteratorError3 = undefined;

            try {
              for (var _iterator3 = _babel_runtime_core_js_get_iterator__WEBPACK_IMPORTED_MODULE_0___default()(item.items.entries()), _step3; !(_iteratorNormalCompletion3 = (_step3 = _iterator3.next()).done); _iteratorNormalCompletion3 = true) {
                var _step3$value = _slicedToArray(_step3.value, 2),
                    subIndex = _step3$value[0],
                    subItem = _step3$value[1];

                clone.splice(i + 1 + subIndex, 0, subItem);
              }
            } catch (err) {
              _didIteratorError3 = true;
              _iteratorError3 = err;
            } finally {
              try {
                if (!_iteratorNormalCompletion3 && _iterator3.return != null) {
                  _iterator3.return();
                }
              } finally {
                if (_didIteratorError3) {
                  throw _iteratorError3;
                }
              }
            }
          }
        };

        for (var _iterator = _babel_runtime_core_js_get_iterator__WEBPACK_IMPORTED_MODULE_0___default()(this.navMenuItems.entries()), _step; !(_iteratorNormalCompletion = (_step = _iterator.next()).done); _iteratorNormalCompletion = true) {
          _loop();
        }
      } catch (err) {
        _didIteratorError = true;
        _iteratorError = err;
      } finally {
        try {
          if (!_iteratorNormalCompletion && _iterator.return != null) {
            _iterator.return();
          }
        } finally {
          if (_didIteratorError) {
            throw _iteratorError;
          }
        }
      }

      var currPath = this.$route.path;
      var _iteratorNormalCompletion2 = true;
      var _didIteratorError2 = false;
      var _iteratorError2 = undefined;

      try {
        for (var _iterator2 = _babel_runtime_core_js_get_iterator__WEBPACK_IMPORTED_MODULE_0___default()(this.navMenuItems), _step2; !(_iteratorNormalCompletion2 = (_step2 = _iterator2.next()).done); _iteratorNormalCompletion2 = true) {
          var item = _step2.value;

          if (currPath.startsWith(item.showSubmenuOn)) {
            return item.submenu;
          }
        }
      } catch (err) {
        _didIteratorError2 = true;
        _iteratorError2 = err;
      } finally {
        try {
          if (!_iteratorNormalCompletion2 && _iterator2.return != null) {
            _iterator2.return();
          }
        } finally {
          if (_didIteratorError2) {
            throw _iteratorError2;
          }
        }
      }

      return [];
    },
    isVerticalNavMenuActive: {
      get: function get() {
        return this.$store.state.isVerticalNavMenuActive;
      },
      set: function set(val) {
        this.$store.commit('TOGGLE_IS_VERTICAL_NAV_MENU_ACTIVE', val);
      }
    },
    layoutType: function layoutType() {
      return this.$store.state.mainLayoutType;
    },
    reduceButton: {
      get: function get() {
        return this.$store.state.reduceButton;
      },
      set: function set(val) {
        this.$store.commit('TOGGLE_REDUCE_BUTTON', val);
      }
    },
    isVerticalNavMenuReduced: function isVerticalNavMenuReduced() {
      return Boolean(this.reduce && this.reduceButton);
    },
    verticalNavMenuItemsMin: function verticalNavMenuItemsMin() {
      return this.$store.state.verticalNavMenuItemsMin;
    },
    scrollbarTag: function scrollbarTag() {
      return this.$store.getters.scrollbarTag;
    },
    windowWidth: function windowWidth() {
      return this.$store.state.windowWidth;
    }
  },
  watch: {
    '$route': function $route() {
      if (this.isVerticalNavMenuActive && this.showCloseButton) this.$store.commit('TOGGLE_IS_VERTICAL_NAV_MENU_ACTIVE', false);
    },
    reduce: function reduce(val) {
      var verticalNavMenuWidth = val ? 'reduced' : this.$store.state.windowWidth < 1200 ? 'no-nav-menu' : 'default';
      this.$store.dispatch('updateVerticalNavMenuWidth', verticalNavMenuWidth);
      setTimeout(function () {
        window.dispatchEvent(new Event('resize'));
      }, 100);
    },
    layoutType: function layoutType() {
      this.setVerticalNavMenuWidth();
    },
    reduceButton: function reduceButton() {
      this.setVerticalNavMenuWidth();
    },
    windowWidth: function windowWidth() {
      this.setVerticalNavMenuWidth();
    }
  },
  methods: {
    onMenuSwipe: function onMenuSwipe(event) {
      if (event.direction === 4 && this.$vs.rtl) {
        // Swipe Right
        if (this.isVerticalNavMenuActive && this.showCloseButton) this.isVerticalNavMenuActive = false;
      } else if (event.direction === 2 && !this.$vs.rtl) {
        // Swipe Left
        if (this.isVerticalNavMenuActive && this.showCloseButton) this.isVerticalNavMenuActive = false;
      }
    },
    onSwipeAreaSwipe: function onSwipeAreaSwipe(event) {
      if (event.direction === 4 && !this.$vs.rtl) {
        // Swipe Right
        if (!this.isVerticalNavMenuActive && this.showCloseButton) this.isVerticalNavMenuActive = true;
      } else if (event.direction === 2 && this.$vs.rtl) {
        // Swipe Left
        if (!this.isVerticalNavMenuActive && this.showCloseButton) this.isVerticalNavMenuActive = true;
      }
    },
    psSectionScroll: function psSectionScroll() {
      var scroll_el = this.$refs.verticalNavMenuPs.$el || this.$refs.verticalNavMenuPs;
      this.showShadowBottom = scroll_el.scrollTop > 0;
    },
    mouseEnter: function mouseEnter() {
      if (this.reduce) this.$store.commit('UPDATE_VERTICAL_NAV_MENU_ITEMS_MIN', false);
      this.isMouseEnter = true;
    },
    mouseLeave: function mouseLeave() {
      if (this.reduce) this.$store.commit('UPDATE_VERTICAL_NAV_MENU_ITEMS_MIN', true);
      this.isMouseEnter = false;
    },
    setVerticalNavMenuWidth: function setVerticalNavMenuWidth() {
      if (this.windowWidth > 1200) {
        if (this.layoutType === 'vertical') {
          // Set reduce
          this.reduce = !!this.reduceButton; // Open NavMenu

          this.$store.commit('TOGGLE_IS_VERTICAL_NAV_MENU_ACTIVE', true); // Set Menu Items Only Icon Mode

          var verticalNavMenuItemsMin = !!(this.reduceButton && !this.isMouseEnter);
          this.$store.commit('UPDATE_VERTICAL_NAV_MENU_ITEMS_MIN', verticalNavMenuItemsMin); // Menu Action buttons

          this.clickNotClose = true;
          this.showCloseButton = false;
          var verticalNavMenuWidth = this.isVerticalNavMenuReduced ? 'reduced' : 'default';
          this.$store.dispatch('updateVerticalNavMenuWidth', verticalNavMenuWidth);
          return;
        }
      } // Close NavMenu


      this.$store.commit('TOGGLE_IS_VERTICAL_NAV_MENU_ACTIVE', false); // Reduce button

      if (this.reduceButton) this.reduce = false; // Menu Action buttons

      this.showCloseButton = true;
      this.clickNotClose = false; // Update NavMenu Width

      this.$store.dispatch('updateVerticalNavMenuWidth', 'no-nav-menu'); // Remove Only Icon in Menu

      this.$store.commit('UPDATE_VERTICAL_NAV_MENU_ITEMS_MIN', false); // if(this.layoutType === 'vertical' || (this.layoutType === 'horizontal' && this.windowWidth < 1200))
      // if (this.windowWidth < 1200) {
      //   // Close NavMenu
      //   this.$store.commit('TOGGLE_IS_VERTICAL_NAV_MENU_ACTIVE', false)
      //   // Reduce button
      //   if (this.reduceButton) this.reduce = false
      //   // Menu Action buttons
      //   this.showCloseButton = true
      //   this.clickNotClose   = false
      //   // Update NavMenu Width
      //   this.$store.dispatch('updateVerticalNavMenuWidth', 'no-nav-menu')
      //   // Remove Only Icon in Menu
      //   this.$store.commit('UPDATE_VERTICAL_NAV_MENU_ITEMS_MIN', false)
      // } else {
      //   // Set reduce
      //   this.reduce = this.reduceButton ? true : false
      //   // Open NavMenu
      //   this.$store.commit('TOGGLE_IS_VERTICAL_NAV_MENU_ACTIVE', true)
      //   // Set Menu Items Only Icon Mode
      //   const verticalNavMenuItemsMin = (this.reduceButton && !this.isMouseEnter) ? true : false
      //   this.$store.commit('UPDATE_VERTICAL_NAV_MENU_ITEMS_MIN', verticalNavMenuItemsMin)
      //   // Menu Action buttons
      //   this.clickNotClose   = true
      //   this.showCloseButton = false
      //   const verticalNavMenuWidth   = this.isVerticalNavMenuReduced ? "reduced" : "default"
      //   this.$store.dispatch('updateVerticalNavMenuWidth', verticalNavMenuWidth)
      // }
    },
    toggleReduce: function toggleReduce(val) {
      this.reduceButton = val;
      this.setVerticalNavMenuWidth();
    }
  },
  mounted: function mounted() {
    this.setVerticalNavMenuWidth();
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/src/layouts/components/vertical-nav-menu/VerticalNavMenuGroup.vue?vue&type=script&lang=js&":
/*!*************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/src/layouts/components/vertical-nav-menu/VerticalNavMenuGroup.vue?vue&type=script&lang=js& ***!
  \*************************************************************************************************************************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _VerticalNavMenuItem_vue__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./VerticalNavMenuItem.vue */ "./resources/js/src/layouts/components/vertical-nav-menu/VerticalNavMenuItem.vue");
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
  name: 'v-nav-menu-group',
  props: {
    openHover: {
      type: Boolean,
      default: false
    },
    open: {
      type: Boolean,
      default: false
    },
    group: {
      type: Object
    },
    groupIndex: {
      type: Number
    }
  },
  components: {
    VNavMenuItem: _VerticalNavMenuItem_vue__WEBPACK_IMPORTED_MODULE_0__["default"]
  },
  data: function data() {
    return {
      maxHeight: '0px',
      openItems: false
    };
  },
  computed: {
    verticalNavMenuItemsMin: function verticalNavMenuItemsMin() {
      return this.$store.state.verticalNavMenuItemsMin;
    },
    styleItems: function styleItems() {
      return {
        maxHeight: this.maxHeight
      };
    },
    itemIcon: function itemIcon() {
      return function (index) {
        if (!((index.match(/\./g) || []).length > 1)) return 'CircleIcon';
      };
    },
    isGroupActive: function isGroupActive() {
      var _this = this;

      return function (item) {
        var path = _this.$route.fullPath;
        var open = false;
        var routeParent = _this.$route.meta ? _this.$route.meta.parent : undefined;

        var func = function func(item) {
          if (item.submenu) {
            item.submenu.forEach(function (item) {
              if ((path === item.url || routeParent === item.slug) && item.url) {
                open = true;
              } else if (item.submenu) {
                func(item);
              }
            });
          }
        };

        func(item);
        return open;
      };
    }
  },
  watch: {
    // OPEN & CLOSES DROPDOWN ON ROUTE CHANGE
    '$route': function $route() {
      var _this2 = this;

      if (this.verticalNavMenuItemsMin) return;
      var scrollHeight = this.scrollHeight; // Collapse Group

      if (this.openItems && !this.open) {
        this.maxHeight = "".concat(scrollHeight, "px");
        setTimeout(function () {
          _this2.maxHeight = "".concat(0, "px");
        }, 50); // Expand Group
      } else if (this.open) {
        this.maxHeight = "".concat(scrollHeight, "px");
        setTimeout(function () {
          _this2.maxHeight = 'none';
        }, 300);
      }
    },
    maxHeight: function maxHeight() {
      this.openItems = this.maxHeight !== '0px';
    },
    // OPEN AND CLOSES DROPDOWN MENU ON NavMenu COLLAPSE AND DEFAULT VIEW
    '$store.state.verticalNavMenuItemsMin': function $storeStateVerticalNavMenuItemsMin(val) {
      var _this3 = this;

      var scrollHeight = this.$refs.items.scrollHeight;

      if (!val && this.open) {
        this.maxHeight = "".concat(scrollHeight, "px");
        setTimeout(function () {
          _this3.maxHeight = 'none';
        }, 300);
      } else {
        this.maxHeight = "".concat(scrollHeight, "px");
        setTimeout(function () {
          _this3.maxHeight = '0px';
        }, 50);
      }

      if (val && this.open) {
        this.maxHeight = "".concat(scrollHeight, "px");
        setTimeout(function () {
          _this3.maxHeight = '0px';
        }, 250);
      }
    }
  },
  methods: {
    clickGroup: function clickGroup() {
      var _this4 = this;

      if (!this.openHover) {
        var thisScrollHeight = this.$refs.items.scrollHeight;

        if (this.maxHeight === '0px') {
          this.maxHeight = "".concat(thisScrollHeight, "px");
          setTimeout(function () {
            _this4.maxHeight = 'none';
          }, 300);
        } else {
          this.maxHeight = "".concat(thisScrollHeight, "px");
          setTimeout(function () {
            _this4.maxHeight = "".concat(0, "px");
          }, 50);
        }

        this.$parent.$children.map(function (child) {
          if (child.isGroupActive) {
            if (child !== _this4 && !child.open && child.maxHeight !== '0px') {
              setTimeout(function () {
                child.maxHeight = "".concat(0, "px");
              }, 50);
            }
          }
        });
      }
    },
    mouseover: function mouseover() {
      if (this.openHover) {
        var scrollHeight = this.$refs.items.scrollHeight;
        this.maxHeight = "".concat(scrollHeight, "px");
      }
    },
    mouseout: function mouseout() {
      if (this.openHover) {
        var scrollHeight = 0;
        this.maxHeight = "".concat(scrollHeight, "px");
      }
    }
  },
  mounted: function mounted() {
    this.openItems = this.open;

    if (this.open) {
      this.maxHeight = 'none';
    }
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/src/layouts/components/vertical-nav-menu/VerticalNavMenuItem.vue?vue&type=script&lang=js&":
/*!************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/src/layouts/components/vertical-nav-menu/VerticalNavMenuItem.vue?vue&type=script&lang=js& ***!
  \************************************************************************************************************************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _babel_runtime_core_js_object_get_own_property_descriptor__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @babel/runtime/core-js/object/get-own-property-descriptor */ "./node_modules/@babel/runtime/core-js/object/get-own-property-descriptor.js");
/* harmony import */ var _babel_runtime_core_js_object_get_own_property_descriptor__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_core_js_object_get_own_property_descriptor__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _babel_runtime_core_js_object_get_own_property_symbols__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @babel/runtime/core-js/object/get-own-property-symbols */ "./node_modules/@babel/runtime/core-js/object/get-own-property-symbols.js");
/* harmony import */ var _babel_runtime_core_js_object_get_own_property_symbols__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_core_js_object_get_own_property_symbols__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var _babel_runtime_core_js_object_keys__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! @babel/runtime/core-js/object/keys */ "./node_modules/@babel/runtime/core-js/object/keys.js");
/* harmony import */ var _babel_runtime_core_js_object_keys__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_core_js_object_keys__WEBPACK_IMPORTED_MODULE_2__);
/* harmony import */ var _babel_runtime_core_js_object_define_property__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! @babel/runtime/core-js/object/define-property */ "./node_modules/@babel/runtime/core-js/object/define-property.js");
/* harmony import */ var _babel_runtime_core_js_object_define_property__WEBPACK_IMPORTED_MODULE_3___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_core_js_object_define_property__WEBPACK_IMPORTED_MODULE_3__);
/* harmony import */ var vuex__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! vuex */ "./node_modules/vuex/dist/vuex.esm.js");





function _objectSpread(target) { for (var i = 1; i < arguments.length; i++) { var source = arguments[i] != null ? arguments[i] : {}; var ownKeys = _babel_runtime_core_js_object_keys__WEBPACK_IMPORTED_MODULE_2___default()(source); if (typeof _babel_runtime_core_js_object_get_own_property_symbols__WEBPACK_IMPORTED_MODULE_1___default.a === 'function') { ownKeys = ownKeys.concat(_babel_runtime_core_js_object_get_own_property_symbols__WEBPACK_IMPORTED_MODULE_1___default()(source).filter(function (sym) { return _babel_runtime_core_js_object_get_own_property_descriptor__WEBPACK_IMPORTED_MODULE_0___default()(source, sym).enumerable; })); } ownKeys.forEach(function (key) { _defineProperty(target, key, source[key]); }); } return target; }

function _defineProperty(obj, key, value) { if (key in obj) { _babel_runtime_core_js_object_define_property__WEBPACK_IMPORTED_MODULE_3___default()(obj, key, { value: value, enumerable: true, configurable: true, writable: true }); } else { obj[key] = value; } return obj; }

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
  name: 'v-nav-menu-item',
  props: {
    icon: {
      type: String,
      default: ''
    },
    iconSmall: {
      type: Boolean,
      default: false
    },
    iconPack: {
      type: String,
      default: 'material-icons'
    },
    href: {
      type: [String, null],
      default: '#'
    },
    to: {
      type: [String, Object, null],
      default: null
    },
    slug: {
      type: String,
      default: null
    },
    index: {
      type: [String, Number],
      default: null
    },
    featherIcon: {
      type: Boolean,
      default: true
    },
    target: {
      type: String,
      default: '_self'
    },
    isDisabled: {
      type: Boolean,
      default: false
    }
  },
  computed: _objectSpread({
    activeLink: function activeLink() {
      return !!((this.to === this.$route.path || this.$route.meta.parent === this.slug) && this.to);
    }
  }, Object(vuex__WEBPACK_IMPORTED_MODULE_4__["mapGetters"])({
    tabExceeded: 'mdn/tabExceeded'
  })),
  methods: {
    showExceededDialog: function showExceededDialog() {
      this.$vs.dialog({
        color: 'warning',
        title: this.$t('Warning'),
        text: this.$t('TabLimitReached'),
        acceptText: this.$t('Accept')
      });
    }
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/src/layouts/main/Main.vue?vue&type=script&lang=js&":
/*!*********************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/src/layouts/main/Main.vue?vue&type=script&lang=js& ***!
  \*********************************************************************************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var vue_backtotop__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! vue-backtotop */ "./node_modules/vue-backtotop/src/main.js");
/* harmony import */ var _layouts_components_horizontal_nav_menu_HorizontalNavMenu_vue__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @/layouts/components/horizontal-nav-menu/HorizontalNavMenu.vue */ "./resources/js/src/layouts/components/horizontal-nav-menu/HorizontalNavMenu.vue");
/* harmony import */ var _layouts_components_vertical_nav_menu_navMenuItems_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! @/layouts/components/vertical-nav-menu/navMenuItems.js */ "./resources/js/src/layouts/components/vertical-nav-menu/navMenuItems.js");
/* harmony import */ var _layouts_components_navbar_TheNavbarHorizontal_vue__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! @/layouts/components/navbar/TheNavbarHorizontal.vue */ "./resources/js/src/layouts/components/navbar/TheNavbarHorizontal.vue");
/* harmony import */ var _layouts_components_navbar_TheNavbarVertical_vue__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! @/layouts/components/navbar/TheNavbarVertical.vue */ "./resources/js/src/layouts/components/navbar/TheNavbarVertical.vue");
/* harmony import */ var _layouts_components_TheFooter_vue__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! @/layouts/components/TheFooter.vue */ "./resources/js/src/layouts/components/TheFooter.vue");
/* harmony import */ var _themeConfig_js__WEBPACK_IMPORTED_MODULE_6__ = __webpack_require__(/*! @/../themeConfig.js */ "./resources/js/themeConfig.js");
/* harmony import */ var _layouts_components_vertical_nav_menu_VerticalNavMenu_vue__WEBPACK_IMPORTED_MODULE_7__ = __webpack_require__(/*! @/layouts/components/vertical-nav-menu/VerticalNavMenu.vue */ "./resources/js/src/layouts/components/vertical-nav-menu/VerticalNavMenu.vue");
/* harmony import */ var _components_MultiDocumentNav_vue__WEBPACK_IMPORTED_MODULE_8__ = __webpack_require__(/*! ../components/MultiDocumentNav.vue */ "./resources/js/src/layouts/components/MultiDocumentNav.vue");
/* harmony import */ var _components_AutoLogout_vue__WEBPACK_IMPORTED_MODULE_9__ = __webpack_require__(/*! ../components/AutoLogout.vue */ "./resources/js/src/layouts/components/AutoLogout.vue");
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
//
//
//
//
//
//
//
//










/* harmony default export */ __webpack_exports__["default"] = ({
  components: {
    BackToTop: vue_backtotop__WEBPACK_IMPORTED_MODULE_0__["default"],
    HNavMenu: _layouts_components_horizontal_nav_menu_HorizontalNavMenu_vue__WEBPACK_IMPORTED_MODULE_1__["default"],
    TheFooter: _layouts_components_TheFooter_vue__WEBPACK_IMPORTED_MODULE_5__["default"],
    TheNavbarHorizontal: _layouts_components_navbar_TheNavbarHorizontal_vue__WEBPACK_IMPORTED_MODULE_3__["default"],
    TheNavbarVertical: _layouts_components_navbar_TheNavbarVertical_vue__WEBPACK_IMPORTED_MODULE_4__["default"],
    VNavMenu: _layouts_components_vertical_nav_menu_VerticalNavMenu_vue__WEBPACK_IMPORTED_MODULE_7__["default"],
    MultiDocumentNav: _components_MultiDocumentNav_vue__WEBPACK_IMPORTED_MODULE_8__["default"],
    AutoLogout: _components_AutoLogout_vue__WEBPACK_IMPORTED_MODULE_9__["default"]
  },
  data: function data() {
    return {
      footerType: _themeConfig_js__WEBPACK_IMPORTED_MODULE_6__["default"].footerType || 'static',
      hideScrollToTop: _themeConfig_js__WEBPACK_IMPORTED_MODULE_6__["default"].hideScrollToTop,
      isNavbarDark: false,
      navMenuItems: _layouts_components_vertical_nav_menu_navMenuItems_js__WEBPACK_IMPORTED_MODULE_2__["default"],
      navbarColor: _themeConfig_js__WEBPACK_IMPORTED_MODULE_6__["default"].navbarColor || '#fff',
      navbarType: _themeConfig_js__WEBPACK_IMPORTED_MODULE_6__["default"].navbarType || 'floating',
      routerTransition: _themeConfig_js__WEBPACK_IMPORTED_MODULE_6__["default"].routerTransition || 'none',
      routeTitle: this.$route.meta.pageTitle,
      setAppClassEvent: 'setAppClasses'
    };
  },
  watch: {
    '$route': function $route() {
      this.routeTitle = this.$route.meta.pageTitle;
    },
    isThemeDark: function isThemeDark(val) {
      var color = this.navbarColor === '#fff' && val ? '#10163a' : '#fff';
      this.updateNavbarColor(color);
    },
    '$store.state.mainLayoutType': function $storeStateMainLayoutType(val) {
      this.setNavMenuVisibility(val);
    }
  },
  computed: {
    bodyOverlay: function bodyOverlay() {
      return this.$store.state.bodyOverlay;
    },
    contentAreaClass: function contentAreaClass() {
      if (this.mainLayoutType === 'vertical') {
        if (this.verticalNavMenuWidth === 'default') return 'content-area-reduced';else if (this.verticalNavMenuWidth === 'reduced') return 'content-area-lg';else return 'content-area-full';
      } else return 'content-area-full';
    },
    footerClasses: function footerClasses() {
      return {
        'footer-hidden': this.footerType === 'hidden',
        'footer-sticky': this.footerType === 'sticky',
        'footer-static': this.footerType === 'static'
      };
    },
    isAppPage: function isAppPage() {
      return this.$route.meta.no_scroll;
    },
    isThemeDark: function isThemeDark() {
      return this.$store.state.theme === 'dark';
    },
    layoutTypeClass: function layoutTypeClass() {
      return "main-".concat(this.mainLayoutType);
    },
    mainLayoutType: function mainLayoutType() {
      return this.$store.state.mainLayoutType;
    },
    navbarClasses: function navbarClasses() {
      return {
        'navbar-hidden': this.navbarType === 'hidden',
        'navbar-sticky': this.navbarType === 'sticky',
        'navbar-static': this.navbarType === 'static',
        'navbar-floating': this.navbarType === 'floating'
      };
    },
    verticalNavMenuWidth: function verticalNavMenuWidth() {
      return this.$store.state.verticalNavMenuWidth;
    },
    windowWidth: function windowWidth() {
      return this.$store.state.windowWidth;
    }
  },
  methods: {
    changeRouteTitle: function changeRouteTitle(title) {
      this.routeTitle = title;
    },
    updateNavbarColor: function updateNavbarColor(val) {
      this.navbarColor = val;
      if (val === '#fff') this.isNavbarDark = false;else this.isNavbarDark = true;
    },
    setNavMenuVisibility: function setNavMenuVisibility(layoutType) {
      if (layoutType === 'horizontal' && this.windowWidth >= 1200 || layoutType === 'vertical' && this.windowWidth < 1200) {
        this.$store.commit('TOGGLE_IS_VERTICAL_NAV_MENU_ACTIVE', false);
        this.$store.dispatch('updateVerticalNavMenuWidth', 'no-nav-menu');
      } else {
        this.$store.commit('TOGGLE_IS_VERTICAL_NAV_MENU_ACTIVE', true);
      }
    }
  },
  created: function created() {
    var color = this.navbarColor === '#fff' && this.isThemeDark ? '#10163a' : this.navbarColor;
    this.updateNavbarColor(color);
    this.setNavMenuVisibility(this.$store.state.mainLayoutType);
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/src/views/_loading.vue?vue&type=script&lang=js&":
/*!******************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/src/views/_loading.vue?vue&type=script&lang=js& ***!
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
/* harmony default export */ __webpack_exports__["default"] = ({
  data: function data() {
    return {
      types: ['border']
    };
  },
  mounted: function mounted() {
    var _this = this;

    this.types.forEach(function (type) {
      _this.$vs.loading({
        container: "#loading-border",
        type: 'border'
      });
    });
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/src/views/_timeout.vue?vue&type=script&lang=js&":
/*!******************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/src/views/_timeout.vue?vue&type=script&lang=js& ***!
  \******************************************************************************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
//
//
//
//
/* harmony default export */ __webpack_exports__["default"] = ({});

/***/ }),

/***/ "./node_modules/css-loader/index.js!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/lib/index.js?!./node_modules/sass-loader/dist/cjs.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/src/components/vx-auto-suggest/VxAutoSuggest.vue?vue&type=style&index=0&lang=scss&":
/*!*******************************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/css-loader!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/lib??ref--8-2!./node_modules/sass-loader/dist/cjs.js??ref--8-3!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/src/components/vx-auto-suggest/VxAutoSuggest.vue?vue&type=style&index=0&lang=scss& ***!
  \*******************************************************************************************************************************************************************************************************************************************************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

exports = module.exports = __webpack_require__(/*! ../../../../../node_modules/css-loader/lib/css-base.js */ "./node_modules/css-loader/lib/css-base.js")(false);
// imports


// module
exports.push([module.i, "/*=========================================================================================\n  File Name: vxAutoSuggest.scss\n  Description: Styles for vx-auto-suggest component. Imported in VxAutoSuggest.vue file\n  ----------------------------------------------------------------------------------------\n  Item Name: Vuexy - Vuejs, HTML & Laravel Admin Dashboard Template\n  Author: Pixinvent\n  Author URL: http://www.themeforest.net/user/pixinvent\n==========================================================================================*/\n.vx-auto-suggest {\n  position: relative;\n}\n.vx-auto-suggest .vs-input .vs-con-input .vs-inputx {\n  z-index: 10;\n}\n.vx-auto-suggest .vs-input .vs-con-input .vs-input--placeholder {\n  top: 0;\n  z-index: 50;\n}\n.vx-auto-suggest .auto-suggest-suggestions-list {\n  position: absolute;\n  width: 100%;\n  max-height: 82vh;\n  overflow-y: auto;\n}\n[dir] .vx-auto-suggest .auto-suggest-suggestions-list {\n  background: #fff;\n}\n[dir] .vx-auto-suggest .auto-suggest-suggestions-list .auto-suggest__suggestion-group__suggestion.vx-auto-suggest__current-selected {\n  background: #F1F1F1;\n}", ""]);

// exports


/***/ }),

/***/ "./node_modules/css-loader/index.js!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/lib/index.js?!./node_modules/sass-loader/dist/cjs.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/src/layouts/components/horizontal-nav-menu/HorizontalNavMenu.vue?vue&type=style&index=0&lang=scss&":
/*!***********************************************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/css-loader!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/lib??ref--8-2!./node_modules/sass-loader/dist/cjs.js??ref--8-3!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/src/layouts/components/horizontal-nav-menu/HorizontalNavMenu.vue?vue&type=style&index=0&lang=scss& ***!
  \***********************************************************************************************************************************************************************************************************************************************************************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

exports = module.exports = __webpack_require__(/*! ../../../../../../node_modules/css-loader/lib/css-base.js */ "./node_modules/css-loader/lib/css-base.js")(false);
// imports


// module
exports.push([module.i, "/*=========================================================================================\n    File Name: _variables.scss\n    Description: partial- SCSS varibales\n    ----------------------------------------------------------------------------------------\n    Item Name: Vuexy - Vuejs, HTML & Laravel Admin Dashboard Template\n      Author: Pixinvent\n    Author URL: http://www.themeforest.net/user/pixinvent\n==========================================================================================*/\n\n/*========================================================\n        SPACING\n=========================================================*/\n\n/*========================================================\n        COLORS\n=========================================================*/\n\n/*========================================================\n        TYPOGRAPHY\n=========================================================*/\n\n/*========================================================\n        TYPOGRAPHY\n=========================================================*/\n\n/*========================================================\n        DARK THEME\n=========================================================*/\n.menu-item .nav-link {\n  color: inherit;\n}\n.menu-item .disabled-item span {\n  color: #e2e2e2;\n}\n[dir] .h-nav-menu-dd {\n  background-color: #fff;\n}\n\n/* DARK THEME */\n[dir] .theme-dark .h-nav-menu-dd {\n  background-color: #262c49;\n  box-shadow: 0px 0px 30px #0f163a !important;\n}", ""]);

// exports


/***/ }),

/***/ "./node_modules/css-loader/index.js!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/lib/index.js?!./node_modules/sass-loader/dist/cjs.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/src/layouts/components/horizontal-nav-menu/HorizontalNavMenuGroup.vue?vue&type=style&index=0&lang=scss&":
/*!****************************************************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/css-loader!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/lib??ref--8-2!./node_modules/sass-loader/dist/cjs.js??ref--8-3!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/src/layouts/components/horizontal-nav-menu/HorizontalNavMenuGroup.vue?vue&type=style&index=0&lang=scss& ***!
  \****************************************************************************************************************************************************************************************************************************************************************************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

exports = module.exports = __webpack_require__(/*! ../../../../../../node_modules/css-loader/lib/css-base.js */ "./node_modules/css-loader/lib/css-base.js")(false);
// imports


// module
exports.push([module.i, "/*=========================================================================================\n    File Name: _variables.scss\n    Description: partial- SCSS varibales\n    ----------------------------------------------------------------------------------------\n    Item Name: Vuexy - Vuejs, HTML & Laravel Admin Dashboard Template\n      Author: Pixinvent\n    Author URL: http://www.themeforest.net/user/pixinvent\n==========================================================================================*/\n\n/*========================================================\n        SPACING\n=========================================================*/\n\n/*========================================================\n        COLORS\n=========================================================*/\n\n/*========================================================\n        TYPOGRAPHY\n=========================================================*/\n\n/*========================================================\n        TYPOGRAPHY\n=========================================================*/\n\n/*========================================================\n        DARK THEME\n=========================================================*/\n[dir] .menu-item > .h-nav-group-open .group-header {\n  background-color: #f6f6f6;\n}\n[dir] .theme-dark .menu-item > .h-nav-group-open .group-header {\n  background-color: #262c49;\n}\n[dir] .header-children .h-nav-group-active {\n  background-color: #f6f6f6;\n}\n[dir] .theme-dark .header-children .h-nav-group-active {\n  background-color: #10163a;\n}\n.h-nav-group-items {\n  min-width: 215px;\n  z-index: 1;\n}\n[dir] .h-nav-group-items {\n  border-radius: 4px;\n}\n[dir=ltr] .h-nav-group-items.dd-left {\n  right: 0rem;\n}\n[dir=rtl] .h-nav-group-items.dd-left {\n  left: 0rem;\n}\n.h-nav-group-items::-webkit-scrollbar {\n  width: 5px;\n  height: 5px;\n}\n[dir] .h-nav-group-items::-webkit-scrollbar-thumb {\n  background: #dae1e7;\n  border-radius: 20px;\n}\n[dir] .theme-dark .h-nav-group-items::-webkit-scrollbar-thumb {\n  background: #10163a;\n}\n[dir] .h-nav-group-items::-webkit-scrollbar-track {\n  background: #f8f8f8;\n  border-radius: 30px;\n}\n[dir] .theme-dark .h-nav-group-items::-webkit-scrollbar-track {\n  background: #262c49;\n}\n.nav-header .group-header {\n  transition: all 0.2s ease;\n}\n[dir] .nav-header .group-header {\n  padding: 0.75rem 1.5rem;\n}\n[dir=ltr] .nav-header .group-header:hover {\n  transform: translateX(5px);\n}\n[dir=rtl] .nav-header .group-header:hover {\n  transform: translateX(-5px);\n}\n[dir] .menu-item > .h-nav-group .group-header {\n  border-radius: 4px;\n  padding: 0.5rem 1.5rem;\n}\n.menu-item > .h-nav-group-active .group-header {\n  color: #fff;\n}\n[dir] .menu-item > .h-nav-group-active .group-header {\n  box-shadow: 0px 0px 6px 1px rgba(var(--vs-primary), 0.6);\n}\n[dir=ltr] .menu-item > .h-nav-group-active .group-header {\n  background: linear-gradient(118deg, rgba(var(--vs-primary), 1), rgba(var(--vs-primary), 0.7)) !important;\n}\n[dir=rtl] .menu-item > .h-nav-group-active .group-header {\n  background: linear-gradient(-118deg, rgba(var(--vs-primary), 1), rgba(var(--vs-primary), 0.7)) !important;\n}", ""]);

// exports


/***/ }),

/***/ "./node_modules/css-loader/index.js!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/lib/index.js?!./node_modules/sass-loader/dist/cjs.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/src/layouts/components/horizontal-nav-menu/HorizontalNavMenuHeader.vue?vue&type=style&index=0&lang=scss&":
/*!*****************************************************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/css-loader!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/lib??ref--8-2!./node_modules/sass-loader/dist/cjs.js??ref--8-3!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/src/layouts/components/horizontal-nav-menu/HorizontalNavMenuHeader.vue?vue&type=style&index=0&lang=scss& ***!
  \*****************************************************************************************************************************************************************************************************************************************************************************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

exports = module.exports = __webpack_require__(/*! ../../../../../../node_modules/css-loader/lib/css-base.js */ "./node_modules/css-loader/lib/css-base.js")(false);
// imports


// module
exports.push([module.i, "/*=========================================================================================\n    File Name: _variables.scss\n    Description: partial- SCSS varibales\n    ----------------------------------------------------------------------------------------\n    Item Name: Vuexy - Vuejs, HTML & Laravel Admin Dashboard Template\n      Author: Pixinvent\n    Author URL: http://www.themeforest.net/user/pixinvent\n==========================================================================================*/\n\n/*========================================================\n        SPACING\n=========================================================*/\n\n/*========================================================\n        COLORS\n=========================================================*/\n\n/*========================================================\n        TYPOGRAPHY\n=========================================================*/\n\n/*========================================================\n        TYPOGRAPHY\n=========================================================*/\n\n/*========================================================\n        DARK THEME\n=========================================================*/\n[dir] .header-active {\n  box-shadow: 0px 0px 6px 1px rgba(var(--vs-primary), 0.6);\n}\n[dir] .header-label {\n  border-radius: 4px;\n}\n[dir] .header-open {\n  background-color: #f6f6f6;\n}\n.header-children {\n  min-width: 215px;\n  top: 100%;\n  z-index: 1;\n}\n[dir] .header-children {\n  border-radius: 4px;\n}\n[dir=ltr] .header-children.dd-right {\n  right: 1rem;\n}\n[dir=rtl] .header-children.dd-right {\n  left: 1rem;\n}\n[dir] .theme-dark .header-open {\n  background-color: #262c49;\n}", ""]);

// exports


/***/ }),

/***/ "./node_modules/css-loader/index.js!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/lib/index.js?!./node_modules/sass-loader/dist/cjs.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/src/layouts/components/horizontal-nav-menu/HorizontalNavMenuItem.vue?vue&type=style&index=0&lang=scss&":
/*!***************************************************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/css-loader!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/lib??ref--8-2!./node_modules/sass-loader/dist/cjs.js??ref--8-3!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/src/layouts/components/horizontal-nav-menu/HorizontalNavMenuItem.vue?vue&type=style&index=0&lang=scss& ***!
  \***************************************************************************************************************************************************************************************************************************************************************************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

exports = module.exports = __webpack_require__(/*! ../../../../../../node_modules/css-loader/lib/css-base.js */ "./node_modules/css-loader/lib/css-base.js")(false);
// imports


// module
exports.push([module.i, "/*=========================================================================================\n    File Name: _variables.scss\n    Description: partial- SCSS varibales\n    ----------------------------------------------------------------------------------------\n    Item Name: Vuexy - Vuejs, HTML & Laravel Admin Dashboard Template\n      Author: Pixinvent\n    Author URL: http://www.themeforest.net/user/pixinvent\n==========================================================================================*/\n\n/*========================================================\n        SPACING\n=========================================================*/\n\n/*========================================================\n        COLORS\n=========================================================*/\n\n/*========================================================\n        TYPOGRAPHY\n=========================================================*/\n\n/*========================================================\n        TYPOGRAPHY\n=========================================================*/\n\n/*========================================================\n        DARK THEME\n=========================================================*/\n[dir] .menu-item li .h-nav-menu-item a {\n  padding: 0.75rem 1.5rem;\n}\n.menu-item li .h-nav-menu-item > * {\n  transition: 0.25s ease-in-out;\n}\n[dir=ltr] .menu-item li .h-nav-menu-item > *:hover {\n  transform: translateX(5px);\n}\n[dir=rtl] .menu-item li .h-nav-menu-item > *:hover {\n  transform: translateX(-5px);\n}\n[dir] .menu-item li .h-nav-menu-item.h-nav-active-item {\n  background-color: #f6f6f6;\n}\n[dir] .theme-dark .menu-item li .h-nav-menu-item.h-nav-active-item {\n  background-color: #10163a;\n}\n[dir] .menu-link .h-nav-menu-item:hover .nav-link {\n  background: #f6f6f6;\n}\n[dir] .theme-dark .menu-link .h-nav-menu-item:hover .nav-link {\n  background: #262c49;\n}\n.menu-link .h-nav-menu-item.h-nav-active-item a {\n  color: #fff;\n}\n[dir] .menu-link .h-nav-menu-item.h-nav-active-item a {\n  box-shadow: 0px 0px 6px 1px rgba(var(--vs-primary), 0.6);\n}\n[dir=ltr] .menu-link .h-nav-menu-item.h-nav-active-item a {\n  background: linear-gradient(118deg, rgba(var(--vs-primary), 1), rgba(var(--vs-primary), 0.7)) !important;\n}\n[dir=rtl] .menu-link .h-nav-menu-item.h-nav-active-item a {\n  background: linear-gradient(-118deg, rgba(var(--vs-primary), 1), rgba(var(--vs-primary), 0.7)) !important;\n}\n[dir] .menu-link .h-nav-menu-item a {\n  border-radius: 4px;\n  padding: 0.5rem 1.5rem;\n}", ""]);

// exports


/***/ }),

/***/ "./node_modules/css-loader/index.js!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/lib/index.js?!./node_modules/sass-loader/dist/cjs.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/src/layouts/components/vertical-nav-menu/VerticalNavMenu.vue?vue&type=style&index=0&lang=scss&":
/*!*******************************************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/css-loader!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/lib??ref--8-2!./node_modules/sass-loader/dist/cjs.js??ref--8-3!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/src/layouts/components/vertical-nav-menu/VerticalNavMenu.vue?vue&type=style&index=0&lang=scss& ***!
  \*******************************************************************************************************************************************************************************************************************************************************************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

exports = module.exports = __webpack_require__(/*! ../../../../../../node_modules/css-loader/lib/css-base.js */ "./node_modules/css-loader/lib/css-base.js")(false);
// imports


// module
exports.push([module.i, "/*=========================================================================================\n  File Name: verticalNavMenu.scss\n  Description: Styles for v-nav-menu component. Imported in VerticalNavMenu.vue file\n  ----------------------------------------------------------------------------------------\n  Item Name: Vuexy - Vuejs, HTML & Laravel Admin Dashboard Template\n  Author: Pixinvent\n  Author URL: http://www.themeforest.net/user/pixinvent\n==========================================================================================*/\n\n/*=========================================================================================\n    File Name: _variables.scss\n    Description: partial- SCSS varibales\n    ----------------------------------------------------------------------------------------\n    Item Name: Vuexy - Vuejs, HTML & Laravel Admin Dashboard Template\n      Author: Pixinvent\n    Author URL: http://www.themeforest.net/user/pixinvent\n==========================================================================================*/\n\n/*========================================================\n        SPACING\n=========================================================*/\n\n/*========================================================\n        COLORS\n=========================================================*/\n\n/*========================================================\n        TYPOGRAPHY\n=========================================================*/\n\n/*========================================================\n        TYPOGRAPHY\n=========================================================*/\n\n/*========================================================\n        DARK THEME\n=========================================================*/\n.v-nav-menu-swipe-area {\n  position: fixed;\n  height: calc(var(--vh, 1vh) * 100);\n  width: 30px;\n  z-index: 1;\n  top: 0;\n}\n[dir] .v-nav-menu-swipe-area {\n  background: transparent;\n}\n[dir=ltr] .v-nav-menu-swipe-area {\n  left: 0;\n}\n[dir=rtl] .v-nav-menu-swipe-area {\n  right: 0;\n}\n.v-nav-menu {\n  white-space: nowrap;\n}\n.v-nav-menu .vs-sidebar--background {\n  z-index: 51000;\n}\n.v-nav-menu .vs-sidebar {\n  z-index: 51000;\n  position: fixed;\n}\n[dir] .v-nav-menu .vs-sidebar .vs-sidebar--items {\n  padding: 0;\n}\n.v-nav-menu .vs-sidebar.vs-sidebar-reduce {\n  max-width: 80px;\n}\n[dir] .v-nav-menu .vs-sidebar.vs-sidebar-reduce:hover {\n  box-shadow: 0 15px 30px 0 rgba(0, 0, 0, 0.11), 0 5px 15px 0 rgba(0, 0, 0, 0.08) !important;\n}\n.v-nav-menu .vs-sidebar.vs-sidebar-reduce:hover:not(.vs-sidebar-reduceNotRebound):not(.vs-sidebar-reduceNotHoverExpand) .vs-sidebar-group .group-header i {\n  display: block;\n}\n.v-nav-menu .vs-sidebar.vs-sidebar-reduce .vs-sidebar-group .group-header i {\n  display: none;\n}\n.v-nav-menu .header-sidebar {\n  width: 100%;\n}\n[dir=ltr] .v-nav-menu .header-sidebar {\n  padding: 20px 19px 16px 23px;\n}\n[dir=rtl] .v-nav-menu .header-sidebar {\n  padding: 20px 23px 16px 19px;\n}\n[dir] .v-nav-menu .header-sidebar .logo img {\n  padding: 4px 0;\n}\n.v-nav-menu .header-sidebar .feather-icon svg {\n  color: #7367F0;\n}\n.v-nav-menu .shadow-bottom {\n  position: absolute;\n  z-index: 2;\n  height: 60px;\n  width: 100%;\n  pointer-events: none;\n  filter: blur(5px);\n}\n[dir] .v-nav-menu .shadow-bottom {\n  margin-top: -1.3rem;\n  background: linear-gradient(white 41%, rgba(255, 255, 255, 0.11) 95%, rgba(255, 255, 255, 0) 100%);\n}\n.v-nav-menu .scroll-area-v-nav-menu {\n  position: relative;\n  width: 100%;\n  height: calc(var(--vh, 1vh) * 100 - 69px);\n}\n[dir] .v-nav-menu .scroll-area-v-nav-menu {\n  margin: auto;\n}\n.v-nav-menu .scroll-area-v-nav-menu:not(.ps) {\n  overflow-y: auto;\n}\n[dir] .v-nav-menu .scroll-area-v-nav-menu > .vs-sidebar-group {\n  padding: 0 15px;\n}\n[dir] .v-nav-menu .scroll-area-v-nav-menu > .vs-sidebar--item {\n  padding: 0 15px;\n}\n.v-nav-menu .navigation-header {\n  font-size: 0.9rem;\n  display: block;\n  font-weight: 500;\n  text-transform: uppercase;\n  color: #999;\n}\n[dir] .v-nav-menu .navigation-header {\n  margin-bottom: 0.8rem;\n}\n[dir=ltr] .v-nav-menu .navigation-header {\n  margin-left: 2.2rem;\n}\n[dir=rtl] .v-nav-menu .navigation-header {\n  margin-right: 2.2rem;\n}\n[dir] .v-nav-menu .navigation-header:not(:first-child) {\n  margin-top: 2rem;\n}\n.v-nav-menu .feather-icon {\n  color: #565656;\n}\n[dir=ltr] .v-nav-menu .feather-icon {\n  margin-right: 14px;\n}\n[dir=rtl] .v-nav-menu .feather-icon {\n  margin-left: 14px;\n}\n.v-nav-menu .feather-icon .feather {\n  width: 20px;\n  height: 20px;\n}\n[dir] .v-nav-menu .feather-icon .feather {\n  margin: 1px 0;\n}\n.v-nav-menu .con-vs-chip {\n  min-height: 20px;\n  min-width: 20px;\n}\n[dir] .v-nav-menu .con-vs-chip {\n  box-shadow: 0px 0px 7px 3px rgba(0, 0, 0, 0.1);\n}\n.v-nav-menu .con-vs-chip .vs-chip--text {\n  color: #fff;\n  font-size: 0.8rem;\n}\n.v-nav-menu .vs-sidebar--item {\n  transition: none;\n  overflow: visible !important;\n}\n.v-nav-menu .vs-sidebar--item:hover a {\n  color: inherit;\n}\n[dir=ltr] .v-nav-menu .vs-sidebar--item:hover a > * {\n  transform: translateX(5px);\n}\n[dir=rtl] .v-nav-menu .vs-sidebar--item:hover a > * {\n  transform: translateX(-5px);\n}\n.v-nav-menu .vs-sidebar--item.vs-sidebar-item-active {\n  font-weight: 400;\n  z-index: 1;\n  position: relative;\n}\n[dir] .v-nav-menu .vs-sidebar--item.vs-sidebar-item-active {\n  border: none !important;\n}\n.v-nav-menu .vs-sidebar--item a {\n  font-size: 1rem;\n  transition: none;\n  opacity: unset;\n  color: #626262;\n}\n[dir] .v-nav-menu .vs-sidebar--item a {\n  border-radius: 4px;\n  padding: 10px 15px;\n}\n.v-nav-menu .vs-sidebar--item a > * {\n  transition: transform 0.25s ease;\n}\n.v-nav-menu .vs-sidebar--item a span {\n  font-size: 15px;\n}\n.v-nav-menu .vs-sidebar--item.disabled-item a span {\n  color: #e2e2e2;\n}\n.theme-dark .v-nav-menu .vs-sidebar--item.disabled-item a {\n  opacity: 0.3;\n}\n[dir] .v-nav-menu .vs-sidebar--item .router-link-active {\n  box-shadow: 0px 0px 10px 1px rgba(var(--vs-primary), 0.7);\n}\n[dir=ltr] .v-nav-menu .vs-sidebar--item .router-link-active {\n  background: linear-gradient(118deg, rgba(var(--vs-primary), 1), rgba(var(--vs-primary), 0.7));\n}\n[dir=rtl] .v-nav-menu .vs-sidebar--item .router-link-active {\n  background: linear-gradient(-118deg, rgba(var(--vs-primary), 1), rgba(var(--vs-primary), 0.7));\n}\n.v-nav-menu .vs-sidebar--item .router-link-active .feather-icon {\n  color: #fff;\n}\n.v-nav-menu .vs-sidebar--item .router-link-active span {\n  color: #fff;\n}\n#sidebar-demo .vs-sidebar {\n  z-index: 52000;\n}\n#sidebar-demo .vs-sidebar-staticPosition {\n  z-index: 10000;\n}\n#sidebar-demo #parentx-demo-7 .parentx:not(.show-custom-sidebar) .vs-sidebar {\n  display: none;\n  z-index: 1 !important;\n}", ""]);

// exports


/***/ }),

/***/ "./node_modules/css-loader/index.js!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/lib/index.js?!./node_modules/sass-loader/dist/cjs.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/src/layouts/components/vertical-nav-menu/VerticalNavMenuGroup.vue?vue&type=style&index=0&lang=scss&":
/*!************************************************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/css-loader!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/lib??ref--8-2!./node_modules/sass-loader/dist/cjs.js??ref--8-3!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/src/layouts/components/vertical-nav-menu/VerticalNavMenuGroup.vue?vue&type=style&index=0&lang=scss& ***!
  \************************************************************************************************************************************************************************************************************************************************************************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

exports = module.exports = __webpack_require__(/*! ../../../../../../node_modules/css-loader/lib/css-base.js */ "./node_modules/css-loader/lib/css-base.js")(false);
// imports


// module
exports.push([module.i, "/*=========================================================================================\n  File Name: verticalNavMenuGroup.scss\n  Description: Styles for v-nav-menu component. Imported in VerticalNavMenuGroup.vue file\n  ----------------------------------------------------------------------------------------\n  Item Name: Vuexy - Vuejs, HTML & Laravel Admin Dashboard Template\n  Author: Pixinvent\n  Author URL: http://www.themeforest.net/user/pixinvent\n==========================================================================================*/\n.vs-sidebar-group {\n  overflow: hidden;\n}\n.vs-sidebar-group .group-header {\n  transition: all 0.5s ease;\n  font-size: 15px;\n}\n[dir] .vs-sidebar-group .group-header {\n  padding: 10px 15px;\n  cursor: pointer;\n}\n.vs-sidebar-group .group-header .feather-grp-header-arrow {\n  position: absolute !important;\n  top: 12px;\n  transition: all 0.2s ease-out;\n  display: inline-block;\n}\n[dir] .vs-sidebar-group .group-header .feather-grp-header-arrow {\n  transform: rotate(0deg);\n}\n[dir=ltr] .vs-sidebar-group .group-header .feather-grp-header-arrow {\n  right: 8px;\n}\n[dir=rtl] .vs-sidebar-group .group-header .feather-grp-header-arrow {\n  left: 8px;\n}\n[dir=ltr] .vs-sidebar-group .group-header .feather-grp-header-arrow.rotate90 {\n  transform: rotate(90deg);\n}\n[dir=rtl] .vs-sidebar-group .group-header .feather-grp-header-arrow.rotate90 {\n  transform: rotate(-90deg);\n}\n.vs-sidebar-group .group-header > * {\n  transition: all 0.25s ease;\n}\n[dir=ltr] .vs-sidebar-group .group-header:hover > * {\n  transform: translateX(5px);\n}\n[dir=rtl] .vs-sidebar-group .group-header:hover > * {\n  transform: translateX(-5px);\n}\n[dir] .vs-sidebar-group .group-header .con-vs-chip {\n  margin-bottom: 0;\n}\n.vs-sidebar-group .vs-icon {\n  font-size: 1.5rem;\n}\n[dir] .vs-sidebar-group:hover > .group-header {\n  transform: unset;\n}\n[dir=ltr] .vs-sidebar-group .vs-sidebar-group .group-header {\n  padding-left: 20px;\n}\n[dir=rtl] .vs-sidebar-group .vs-sidebar-group .group-header {\n  padding-right: 20px;\n}\n[dir] .vs-sidebar-group.vs-sidebar-group-open > .group-header, [dir] .vs-sidebar-group.vs-sidebar-group-active > .group-header {\n  background: #f6f6f6;\n  border-radius: 6px;\n}\n[dir=ltr] .vs-sidebar-group.vs-sidebar-group-open > ul, [dir=ltr] .vs-sidebar-group.vs-sidebar-group-active > ul {\n  padding-left: 0 !important;\n}\n[dir=rtl] .vs-sidebar-group.vs-sidebar-group-open > ul, [dir=rtl] .vs-sidebar-group.vs-sidebar-group-active > ul {\n  padding-right: 0 !important;\n}\n[dir] .vs-sidebar-group.vs-sidebar-group-open > .group-header {\n  cursor: pointer;\n  margin-bottom: 7px;\n}\n[dir=ltr] .vs-sidebar-group.vs-sidebar-group-open > .vs-sidebar-group-items {\n  padding-left: 0;\n}\n[dir=rtl] .vs-sidebar-group.vs-sidebar-group-open > .vs-sidebar-group-items {\n  padding-right: 0;\n}\n[dir=ltr] .vs-sidebar-group.vs-sidebar-group-open > .vs-sidebar-group-items .vs-sidebar--item span {\n  padding-left: 0 0 0 2rem;\n}\n[dir=rtl] .vs-sidebar-group.vs-sidebar-group-open > .vs-sidebar-group-items .vs-sidebar--item span {\n  padding-right: 0 0 0 2rem;\n}\n[dir] .vs-sidebar-group.vs-sidebar-group-open > .vs-sidebar-group-items .vs-sidebar--item:last-child {\n  border-bottom: 0px;\n}\n.vs-sidebar-group.vs-sidebar-group-open .vs-sidebar-group {\n  overflow: visible;\n}\n.vs-sidebar-group .vs-sidebar-group-items {\n  opacity: 0;\n}\n[dir=ltr] .vs-sidebar-group .vs-sidebar-group-items .vs-sidebar--item a {\n  padding: 10px 15px 10px 20px;\n}\n[dir=rtl] .vs-sidebar-group .vs-sidebar-group-items .vs-sidebar--item a {\n  padding: 10px 20px 10px 15px;\n}\n[dir=ltr] .vs-sidebar-group .vs-sidebar-group-items .vs-sidebar--item a .feather-icon {\n  margin-right: 20px;\n}\n[dir=rtl] .vs-sidebar-group .vs-sidebar-group-items .vs-sidebar--item a .feather-icon {\n  margin-left: 20px;\n}\n[dir] .vs-sidebar-group .vs-sidebar-group-items .vs-sidebar--item:last-child a {\n  margin-bottom: 0;\n}\n[dir] .vs-sidebar-group .vs-sidebar-group-items li:last-child {\n  padding-bottom: 7px;\n}\n[dir=ltr] .vs-sidebar-group .vs-sidebar-group-items .vs-sidebar-group span .feather-icon {\n  margin-right: 20px;\n}\n[dir=rtl] .vs-sidebar-group .vs-sidebar-group-items .vs-sidebar-group span .feather-icon {\n  margin-left: 20px;\n}\n[dir=ltr] .vs-sidebar-group .vs-sidebar-group-items .vs-sidebar-group .feather-icon {\n  margin-right: 0px;\n}\n[dir=rtl] .vs-sidebar-group .vs-sidebar-group-items .vs-sidebar-group .feather-icon {\n  margin-left: 0px;\n}\n.vs-sidebar-group.disabled-item span {\n  color: #e2e2e2;\n}", ""]);

// exports


/***/ }),

/***/ "./node_modules/css-loader/index.js!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/lib/index.js?!./node_modules/sass-loader/dist/cjs.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/src/views/_loading.vue?vue&type=style&index=0&lang=scss&":
/*!*****************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/css-loader!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/lib??ref--8-2!./node_modules/sass-loader/dist/cjs.js??ref--8-3!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/src/views/_loading.vue?vue&type=style&index=0&lang=scss& ***!
  \*****************************************************************************************************************************************************************************************************************************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

exports = module.exports = __webpack_require__(/*! ../../../../node_modules/css-loader/lib/css-base.js */ "./node_modules/css-loader/lib/css-base.js")(false);
// imports


// module
exports.push([module.i, ".fill-row-loading {\n  display: flex;\n  align-items: center;\n  justify-content: center;\n  flex-wrap: wrap;\n}\n.fill-row-loading .loading-example {\n  width: 60px;\n  height: 60px;\n  transition: all 0.3s ease;\n}\n[dir] .fill-row-loading .loading-example {\n  margin: 8px;\n}\n[dir=ltr] .fill-row-loading .loading-example {\n  float: left;\n}\n[dir=rtl] .fill-row-loading .loading-example {\n  float: right;\n}\n[dir] .fill-row-loading .con-vs-loading {\n  background: #f8f8f8;\n}", ""]);

// exports


/***/ }),

/***/ "./node_modules/css-loader/index.js?!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/src/layouts/components/MultiDocumentNav.vue?vue&type=style&index=0&lang=css&":
/*!**********************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/css-loader??ref--7-1!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/lib??ref--7-2!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/src/layouts/components/MultiDocumentNav.vue?vue&type=style&index=0&lang=css& ***!
  \**********************************************************************************************************************************************************************************************************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

exports = module.exports = __webpack_require__(/*! ../../../../../node_modules/css-loader/lib/css-base.js */ "./node_modules/css-loader/lib/css-base.js")(false);
// imports


// module
exports.push([module.i, ".scrollbar-hidden::-webkit-scrollbar {\n  display: none;\n}\n[dir=ltr] .vs-tabs--li {\n  padding-right: 30px;\n}\n[dir=rtl] .vs-tabs--li {\n  padding-left: 30px;\n}\n.vs-tabs--btn-tag {\n  position: absolute;\n  width: 20px;\n  height: 20px;\n  display: flex;\n  align-items: center;\n  justify-content: center;\n  top: 9px;\n  z-index: 200;\n  z-index: 200;\n}\n[dir] .vs-tabs--btn-tag {\n  border-radius: 3px;\n  border: 0px;\n  background: rgb(255, 255, 255);\n  box-shadow: 0px 0px 10px 0px rgba(0, 0, 0, 0.05);\n  cursor: pointer;\n}\n[dir=ltr] .vs-tabs--btn-tag {\n  right: 9px;\n}\n[dir=rtl] .vs-tabs--btn-tag {\n  left: 9px;\n}\n.vs-tabs--btn-tag i {\n  font-size: 0.9rem;\n}\n[dir=ltr] .vs-tabs--btn-tag i {\n  padding-right: 0px !important;\n}\n[dir=rtl] .vs-tabs--btn-tag i {\n  padding-left: 0px !important;\n}\r\n", ""]);

// exports


/***/ }),

/***/ "./node_modules/style-loader/index.js!./node_modules/css-loader/index.js!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/lib/index.js?!./node_modules/sass-loader/dist/cjs.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/src/components/vx-auto-suggest/VxAutoSuggest.vue?vue&type=style&index=0&lang=scss&":
/*!***********************************************************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/style-loader!./node_modules/css-loader!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/lib??ref--8-2!./node_modules/sass-loader/dist/cjs.js??ref--8-3!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/src/components/vx-auto-suggest/VxAutoSuggest.vue?vue&type=style&index=0&lang=scss& ***!
  \***********************************************************************************************************************************************************************************************************************************************************************************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {


var content = __webpack_require__(/*! !../../../../../node_modules/css-loader!../../../../../node_modules/vue-loader/lib/loaders/stylePostLoader.js!../../../../../node_modules/postcss-loader/lib??ref--8-2!../../../../../node_modules/sass-loader/dist/cjs.js??ref--8-3!../../../../../node_modules/vue-loader/lib??vue-loader-options!./VxAutoSuggest.vue?vue&type=style&index=0&lang=scss& */ "./node_modules/css-loader/index.js!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/lib/index.js?!./node_modules/sass-loader/dist/cjs.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/src/components/vx-auto-suggest/VxAutoSuggest.vue?vue&type=style&index=0&lang=scss&");

if(typeof content === 'string') content = [[module.i, content, '']];

var transform;
var insertInto;



var options = {"hmr":true}

options.transform = transform
options.insertInto = undefined;

var update = __webpack_require__(/*! ../../../../../node_modules/style-loader/lib/addStyles.js */ "./node_modules/style-loader/lib/addStyles.js")(content, options);

if(content.locals) module.exports = content.locals;

if(false) {}

/***/ }),

/***/ "./node_modules/style-loader/index.js!./node_modules/css-loader/index.js!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/lib/index.js?!./node_modules/sass-loader/dist/cjs.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/src/layouts/components/horizontal-nav-menu/HorizontalNavMenu.vue?vue&type=style&index=0&lang=scss&":
/*!***************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/style-loader!./node_modules/css-loader!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/lib??ref--8-2!./node_modules/sass-loader/dist/cjs.js??ref--8-3!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/src/layouts/components/horizontal-nav-menu/HorizontalNavMenu.vue?vue&type=style&index=0&lang=scss& ***!
  \***************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {


var content = __webpack_require__(/*! !../../../../../../node_modules/css-loader!../../../../../../node_modules/vue-loader/lib/loaders/stylePostLoader.js!../../../../../../node_modules/postcss-loader/lib??ref--8-2!../../../../../../node_modules/sass-loader/dist/cjs.js??ref--8-3!../../../../../../node_modules/vue-loader/lib??vue-loader-options!./HorizontalNavMenu.vue?vue&type=style&index=0&lang=scss& */ "./node_modules/css-loader/index.js!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/lib/index.js?!./node_modules/sass-loader/dist/cjs.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/src/layouts/components/horizontal-nav-menu/HorizontalNavMenu.vue?vue&type=style&index=0&lang=scss&");

if(typeof content === 'string') content = [[module.i, content, '']];

var transform;
var insertInto;



var options = {"hmr":true}

options.transform = transform
options.insertInto = undefined;

var update = __webpack_require__(/*! ../../../../../../node_modules/style-loader/lib/addStyles.js */ "./node_modules/style-loader/lib/addStyles.js")(content, options);

if(content.locals) module.exports = content.locals;

if(false) {}

/***/ }),

/***/ "./node_modules/style-loader/index.js!./node_modules/css-loader/index.js!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/lib/index.js?!./node_modules/sass-loader/dist/cjs.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/src/layouts/components/horizontal-nav-menu/HorizontalNavMenuGroup.vue?vue&type=style&index=0&lang=scss&":
/*!********************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/style-loader!./node_modules/css-loader!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/lib??ref--8-2!./node_modules/sass-loader/dist/cjs.js??ref--8-3!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/src/layouts/components/horizontal-nav-menu/HorizontalNavMenuGroup.vue?vue&type=style&index=0&lang=scss& ***!
  \********************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {


var content = __webpack_require__(/*! !../../../../../../node_modules/css-loader!../../../../../../node_modules/vue-loader/lib/loaders/stylePostLoader.js!../../../../../../node_modules/postcss-loader/lib??ref--8-2!../../../../../../node_modules/sass-loader/dist/cjs.js??ref--8-3!../../../../../../node_modules/vue-loader/lib??vue-loader-options!./HorizontalNavMenuGroup.vue?vue&type=style&index=0&lang=scss& */ "./node_modules/css-loader/index.js!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/lib/index.js?!./node_modules/sass-loader/dist/cjs.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/src/layouts/components/horizontal-nav-menu/HorizontalNavMenuGroup.vue?vue&type=style&index=0&lang=scss&");

if(typeof content === 'string') content = [[module.i, content, '']];

var transform;
var insertInto;



var options = {"hmr":true}

options.transform = transform
options.insertInto = undefined;

var update = __webpack_require__(/*! ../../../../../../node_modules/style-loader/lib/addStyles.js */ "./node_modules/style-loader/lib/addStyles.js")(content, options);

if(content.locals) module.exports = content.locals;

if(false) {}

/***/ }),

/***/ "./node_modules/style-loader/index.js!./node_modules/css-loader/index.js!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/lib/index.js?!./node_modules/sass-loader/dist/cjs.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/src/layouts/components/horizontal-nav-menu/HorizontalNavMenuHeader.vue?vue&type=style&index=0&lang=scss&":
/*!*********************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/style-loader!./node_modules/css-loader!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/lib??ref--8-2!./node_modules/sass-loader/dist/cjs.js??ref--8-3!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/src/layouts/components/horizontal-nav-menu/HorizontalNavMenuHeader.vue?vue&type=style&index=0&lang=scss& ***!
  \*********************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {


var content = __webpack_require__(/*! !../../../../../../node_modules/css-loader!../../../../../../node_modules/vue-loader/lib/loaders/stylePostLoader.js!../../../../../../node_modules/postcss-loader/lib??ref--8-2!../../../../../../node_modules/sass-loader/dist/cjs.js??ref--8-3!../../../../../../node_modules/vue-loader/lib??vue-loader-options!./HorizontalNavMenuHeader.vue?vue&type=style&index=0&lang=scss& */ "./node_modules/css-loader/index.js!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/lib/index.js?!./node_modules/sass-loader/dist/cjs.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/src/layouts/components/horizontal-nav-menu/HorizontalNavMenuHeader.vue?vue&type=style&index=0&lang=scss&");

if(typeof content === 'string') content = [[module.i, content, '']];

var transform;
var insertInto;



var options = {"hmr":true}

options.transform = transform
options.insertInto = undefined;

var update = __webpack_require__(/*! ../../../../../../node_modules/style-loader/lib/addStyles.js */ "./node_modules/style-loader/lib/addStyles.js")(content, options);

if(content.locals) module.exports = content.locals;

if(false) {}

/***/ }),

/***/ "./node_modules/style-loader/index.js!./node_modules/css-loader/index.js!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/lib/index.js?!./node_modules/sass-loader/dist/cjs.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/src/layouts/components/horizontal-nav-menu/HorizontalNavMenuItem.vue?vue&type=style&index=0&lang=scss&":
/*!*******************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/style-loader!./node_modules/css-loader!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/lib??ref--8-2!./node_modules/sass-loader/dist/cjs.js??ref--8-3!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/src/layouts/components/horizontal-nav-menu/HorizontalNavMenuItem.vue?vue&type=style&index=0&lang=scss& ***!
  \*******************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {


var content = __webpack_require__(/*! !../../../../../../node_modules/css-loader!../../../../../../node_modules/vue-loader/lib/loaders/stylePostLoader.js!../../../../../../node_modules/postcss-loader/lib??ref--8-2!../../../../../../node_modules/sass-loader/dist/cjs.js??ref--8-3!../../../../../../node_modules/vue-loader/lib??vue-loader-options!./HorizontalNavMenuItem.vue?vue&type=style&index=0&lang=scss& */ "./node_modules/css-loader/index.js!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/lib/index.js?!./node_modules/sass-loader/dist/cjs.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/src/layouts/components/horizontal-nav-menu/HorizontalNavMenuItem.vue?vue&type=style&index=0&lang=scss&");

if(typeof content === 'string') content = [[module.i, content, '']];

var transform;
var insertInto;



var options = {"hmr":true}

options.transform = transform
options.insertInto = undefined;

var update = __webpack_require__(/*! ../../../../../../node_modules/style-loader/lib/addStyles.js */ "./node_modules/style-loader/lib/addStyles.js")(content, options);

if(content.locals) module.exports = content.locals;

if(false) {}

/***/ }),

/***/ "./node_modules/style-loader/index.js!./node_modules/css-loader/index.js!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/lib/index.js?!./node_modules/sass-loader/dist/cjs.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/src/layouts/components/vertical-nav-menu/VerticalNavMenu.vue?vue&type=style&index=0&lang=scss&":
/*!***********************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/style-loader!./node_modules/css-loader!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/lib??ref--8-2!./node_modules/sass-loader/dist/cjs.js??ref--8-3!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/src/layouts/components/vertical-nav-menu/VerticalNavMenu.vue?vue&type=style&index=0&lang=scss& ***!
  \***********************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {


var content = __webpack_require__(/*! !../../../../../../node_modules/css-loader!../../../../../../node_modules/vue-loader/lib/loaders/stylePostLoader.js!../../../../../../node_modules/postcss-loader/lib??ref--8-2!../../../../../../node_modules/sass-loader/dist/cjs.js??ref--8-3!../../../../../../node_modules/vue-loader/lib??vue-loader-options!./VerticalNavMenu.vue?vue&type=style&index=0&lang=scss& */ "./node_modules/css-loader/index.js!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/lib/index.js?!./node_modules/sass-loader/dist/cjs.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/src/layouts/components/vertical-nav-menu/VerticalNavMenu.vue?vue&type=style&index=0&lang=scss&");

if(typeof content === 'string') content = [[module.i, content, '']];

var transform;
var insertInto;



var options = {"hmr":true}

options.transform = transform
options.insertInto = undefined;

var update = __webpack_require__(/*! ../../../../../../node_modules/style-loader/lib/addStyles.js */ "./node_modules/style-loader/lib/addStyles.js")(content, options);

if(content.locals) module.exports = content.locals;

if(false) {}

/***/ }),

/***/ "./node_modules/style-loader/index.js!./node_modules/css-loader/index.js!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/lib/index.js?!./node_modules/sass-loader/dist/cjs.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/src/layouts/components/vertical-nav-menu/VerticalNavMenuGroup.vue?vue&type=style&index=0&lang=scss&":
/*!****************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/style-loader!./node_modules/css-loader!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/lib??ref--8-2!./node_modules/sass-loader/dist/cjs.js??ref--8-3!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/src/layouts/components/vertical-nav-menu/VerticalNavMenuGroup.vue?vue&type=style&index=0&lang=scss& ***!
  \****************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {


var content = __webpack_require__(/*! !../../../../../../node_modules/css-loader!../../../../../../node_modules/vue-loader/lib/loaders/stylePostLoader.js!../../../../../../node_modules/postcss-loader/lib??ref--8-2!../../../../../../node_modules/sass-loader/dist/cjs.js??ref--8-3!../../../../../../node_modules/vue-loader/lib??vue-loader-options!./VerticalNavMenuGroup.vue?vue&type=style&index=0&lang=scss& */ "./node_modules/css-loader/index.js!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/lib/index.js?!./node_modules/sass-loader/dist/cjs.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/src/layouts/components/vertical-nav-menu/VerticalNavMenuGroup.vue?vue&type=style&index=0&lang=scss&");

if(typeof content === 'string') content = [[module.i, content, '']];

var transform;
var insertInto;



var options = {"hmr":true}

options.transform = transform
options.insertInto = undefined;

var update = __webpack_require__(/*! ../../../../../../node_modules/style-loader/lib/addStyles.js */ "./node_modules/style-loader/lib/addStyles.js")(content, options);

if(content.locals) module.exports = content.locals;

if(false) {}

/***/ }),

/***/ "./node_modules/style-loader/index.js!./node_modules/css-loader/index.js!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/lib/index.js?!./node_modules/sass-loader/dist/cjs.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/src/views/_loading.vue?vue&type=style&index=0&lang=scss&":
/*!*********************************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/style-loader!./node_modules/css-loader!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/lib??ref--8-2!./node_modules/sass-loader/dist/cjs.js??ref--8-3!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/src/views/_loading.vue?vue&type=style&index=0&lang=scss& ***!
  \*********************************************************************************************************************************************************************************************************************************************************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {


var content = __webpack_require__(/*! !../../../../node_modules/css-loader!../../../../node_modules/vue-loader/lib/loaders/stylePostLoader.js!../../../../node_modules/postcss-loader/lib??ref--8-2!../../../../node_modules/sass-loader/dist/cjs.js??ref--8-3!../../../../node_modules/vue-loader/lib??vue-loader-options!./_loading.vue?vue&type=style&index=0&lang=scss& */ "./node_modules/css-loader/index.js!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/lib/index.js?!./node_modules/sass-loader/dist/cjs.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/src/views/_loading.vue?vue&type=style&index=0&lang=scss&");

if(typeof content === 'string') content = [[module.i, content, '']];

var transform;
var insertInto;



var options = {"hmr":true}

options.transform = transform
options.insertInto = undefined;

var update = __webpack_require__(/*! ../../../../node_modules/style-loader/lib/addStyles.js */ "./node_modules/style-loader/lib/addStyles.js")(content, options);

if(content.locals) module.exports = content.locals;

if(false) {}

/***/ }),

/***/ "./node_modules/style-loader/index.js!./node_modules/css-loader/index.js?!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/src/layouts/components/MultiDocumentNav.vue?vue&type=style&index=0&lang=css&":
/*!**************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/style-loader!./node_modules/css-loader??ref--7-1!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/lib??ref--7-2!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/src/layouts/components/MultiDocumentNav.vue?vue&type=style&index=0&lang=css& ***!
  \**************************************************************************************************************************************************************************************************************************************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {


var content = __webpack_require__(/*! !../../../../../node_modules/css-loader??ref--7-1!../../../../../node_modules/vue-loader/lib/loaders/stylePostLoader.js!../../../../../node_modules/postcss-loader/lib??ref--7-2!../../../../../node_modules/vue-loader/lib??vue-loader-options!./MultiDocumentNav.vue?vue&type=style&index=0&lang=css& */ "./node_modules/css-loader/index.js?!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/src/layouts/components/MultiDocumentNav.vue?vue&type=style&index=0&lang=css&");

if(typeof content === 'string') content = [[module.i, content, '']];

var transform;
var insertInto;



var options = {"hmr":true}

options.transform = transform
options.insertInto = undefined;

var update = __webpack_require__(/*! ../../../../../node_modules/style-loader/lib/addStyles.js */ "./node_modules/style-loader/lib/addStyles.js")(content, options);

if(content.locals) module.exports = content.locals;

if(false) {}

/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/src/components/vx-auto-suggest/VxAutoSuggest.vue?vue&type=template&id=3b23de25&":
/*!************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/src/components/vx-auto-suggest/VxAutoSuggest.vue?vue&type=template&id=3b23de25& ***!
  \************************************************************************************************************************************************************************************************************************************/
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
  return _c("div", { staticClass: "vx-auto-suggest" }, [
    _c(
      "div",
      { staticClass: "flex items-center relative" },
      [
        _c("vs-input", {
          ref: "input",
          staticClass: "z-50",
          class: _vm.inputClassses,
          attrs: {
            placeholder: _vm.placeholder,
            "icon-pack": "feather",
            icon: "icon-search",
            "icon-no-border": ""
          },
          on: {
            keyup: [
              function($event) {
                if (
                  !$event.type.indexOf("key") &&
                  _vm._k($event.keyCode, "esc", 27, $event.key, [
                    "Esc",
                    "Escape"
                  ])
                ) {
                  return null
                }
                return _vm.escPressed($event)
              },
              function($event) {
                if (
                  !$event.type.indexOf("key") &&
                  _vm._k($event.keyCode, "up", 38, $event.key, [
                    "Up",
                    "ArrowUp"
                  ])
                ) {
                  return null
                }
                return _vm.increaseIndex(false)
              },
              function($event) {
                if (
                  !$event.type.indexOf("key") &&
                  _vm._k($event.keyCode, "down", 40, $event.key, [
                    "Down",
                    "ArrowDown"
                  ])
                ) {
                  return null
                }
                return _vm.increaseIndex($event)
              },
              function($event) {
                if (
                  !$event.type.indexOf("key") &&
                  _vm._k($event.keyCode, "enter", 13, $event.key, "Enter")
                ) {
                  return null
                }
                return _vm.suggestionSelected($event)
              }
            ],
            focus: _vm.updateInputFocus,
            blur: function($event) {
              return _vm.updateInputFocus(false)
            }
          },
          model: {
            value: _vm.searchQuery,
            callback: function($$v) {
              _vm.searchQuery = $$v
            },
            expression: "searchQuery"
          }
        })
      ],
      1
    ),
    _vm._v(" "),
    _c(
      "ul",
      {
        ref: "scrollContainer",
        staticClass:
          "auto-suggest-suggestions-list z-50 rounded-lg mt-2 shadow-lg overflow-x-hidden",
        class: { hidden: !_vm.inputFocused },
        attrs: { tabindex: "-1" },
        on: {
          mouseenter: function($event) {
            _vm.insideSuggestions = true
          },
          mouseleave: function($event) {
            _vm.insideSuggestions = false
          },
          focus: _vm.updateInputFocus,
          blur: function($event) {
            return _vm.updateInputFocus(false)
          }
        }
      },
      _vm._l(_vm.filteredData, function(suggestion_list, grp_name, grp_index) {
        return _c(
          "li",
          {
            key: grp_index,
            ref: "grp_list",
            refInFor: true,
            staticClass: "auto-suggest__suggestion-group-container"
          },
          [
            !_vm.hideGroupTitle
              ? _c(
                  "p",
                  {
                    staticClass:
                      "auto-suggest__suggestion-group-title pt-3 pb-1 px-4"
                  },
                  [_vm._t("group", null, { group_name: grp_name })],
                  2
                )
              : _vm._e(),
            _vm._v(" "),
            _c(
              "ul",
              [
                _vm._l(suggestion_list, function(suggestion, index) {
                  return _c(
                    "li",
                    {
                      key: index,
                      staticClass:
                        "auto-suggest__suggestion-group__suggestion py-3 px-4 cursor-pointer",
                      class: {
                        "vx-auto-suggest__current-selected":
                          _vm.currentSelected == grp_index + "." + index
                      },
                      on: {
                        mouseenter: function($event) {
                          _vm.currentSelected = grp_index + "." + index
                        },
                        click: _vm.suggestionSelected
                      }
                    },
                    [_vm._t(grp_name, null, { suggestion: suggestion })],
                    2
                  )
                }),
                _vm._v(" "),
                !suggestion_list.length && _vm.searchQuery
                  ? _c(
                      "li",
                      {
                        staticClass:
                          "auto-suggest__suggestion-group__suggestion py-3 px-4 no-results"
                      },
                      [
                        _vm._t(
                          "noResult",
                          [_c("p", [_vm._v("No Results Found.")])],
                          { group_name: grp_name }
                        )
                      ],
                      2
                    )
                  : _vm._e()
              ],
              2
            )
          ]
        )
      }),
      0
    )
  ])
}
var staticRenderFns = []
render._withStripped = true



/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/src/layouts/components/AutoLogout.vue?vue&type=template&id=0d07e85a&":
/*!*************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/src/layouts/components/AutoLogout.vue?vue&type=template&id=0d07e85a& ***!
  \*************************************************************************************************************************************************************************************************************************/
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
    "vs-popup",
    {
      attrs: { title: "Session is about to expire", active: _vm.dialogActive },
      on: {
        "update:active": function($event) {
          _vm.dialogActive = $event
        }
      }
    },
    [
      _vm._v("\n    Your session is about to expire in "),
      _c("span", {
        staticClass: "text-danger",
        domProps: { textContent: _vm._s(_vm.countdown) }
      }),
      _vm._v(" seconds\n")
    ]
  )
}
var staticRenderFns = []
render._withStripped = true



/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/src/layouts/components/Logo.vue?vue&type=template&id=212d79e5&":
/*!*******************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/src/layouts/components/Logo.vue?vue&type=template&id=212d79e5& ***!
  \*******************************************************************************************************************************************************************************************************************/
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
    "svg",
    {
      attrs: {
        viewBox: "0 0 139 95",
        version: "1.1",
        xmlns: "http://www.w3.org/2000/svg",
        "xmlns:xlink": "http://www.w3.org/1999/xlink",
        height: "35"
      }
    },
    [
      _c(
        "defs",
        [
          _c(
            "linearGradient",
            {
              attrs: {
                x1: "100%",
                y1: "10.5120544%",
                x2: "50%",
                y2: "89.4879456%",
                id: "linearGradient-1"
              }
            },
            [
              _c("stop", { attrs: { "stop-color": "#000000", offset: "0%" } }),
              _vm._v(" "),
              _c("stop", { attrs: { "stop-color": "#FFFFFF", offset: "100%" } })
            ],
            1
          ),
          _vm._v(" "),
          _c(
            "linearGradient",
            {
              attrs: {
                x1: "64.0437835%",
                y1: "46.3276743%",
                x2: "37.373316%",
                y2: "100%",
                id: "linearGradient-2"
              }
            },
            [
              _c("stop", {
                attrs: {
                  "stop-color": "#EEEEEE",
                  "stop-opacity": "0",
                  offset: "0%"
                }
              }),
              _vm._v(" "),
              _c("stop", { attrs: { "stop-color": "#FFFFFF", offset: "100%" } })
            ],
            1
          )
        ],
        1
      ),
      _vm._v(" "),
      _c(
        "g",
        {
          attrs: {
            id: "Page-1",
            stroke: "none",
            "stroke-width": "1",
            fill: "none",
            "fill-rule": "evenodd"
          }
        },
        [
          _c(
            "g",
            {
              attrs: {
                id: "Artboard",
                transform: "translate(-400.000000, -178.000000)"
              }
            },
            [
              _c(
                "g",
                {
                  attrs: {
                    id: "Group",
                    transform: "translate(400.000000, 178.000000)"
                  }
                },
                [
                  _c("path", {
                    staticClass: "text-primary fill-current",
                    attrs: {
                      d:
                        "M-5.68434189e-14,2.84217094e-14 L39.1816085,2.84217094e-14 L69.3453773,32.2519224 L101.428699,2.84217094e-14 L138.784583,2.84217094e-14 L138.784199,29.8015838 C137.958931,37.3510206 135.784352,42.5567762 132.260463,45.4188507 C128.736573,48.2809251 112.33867,64.5239941 83.0667527,94.1480575 L56.2750821,94.1480575 L6.71554594,44.4188507 C2.46876683,39.9813776 0.345377275,35.1089553 0.345377275,29.8015838 C0.345377275,24.4942122 0.230251516,14.560351 -5.68434189e-14,2.84217094e-14 Z",
                      id: "Path"
                    }
                  }),
                  _vm._v(" "),
                  _c("path", {
                    attrs: {
                      d:
                        "M69.3453773,32.2519224 L101.428699,1.42108547e-14 L138.784583,1.42108547e-14 L138.784199,29.8015838 C137.958931,37.3510206 135.784352,42.5567762 132.260463,45.4188507 C128.736573,48.2809251 112.33867,64.5239941 83.0667527,94.1480575 L56.2750821,94.1480575 L32.8435758,70.5039241 L69.3453773,32.2519224 Z",
                      id: "Path",
                      fill: "url(#linearGradient-1)",
                      opacity: "0.2"
                    }
                  }),
                  _vm._v(" "),
                  _c("polygon", {
                    attrs: {
                      id: "Path-2",
                      fill: "#000000",
                      opacity: "0.049999997",
                      points:
                        "69.3922914 32.4202615 32.8435758 70.5039241 54.0490008 16.1851325"
                    }
                  }),
                  _vm._v(" "),
                  _c("polygon", {
                    attrs: {
                      id: "Path-2",
                      fill: "#000000",
                      opacity: "0.099999994",
                      points:
                        "69.3922914 32.4202615 32.8435758 70.5039241 58.3683556 20.7402338"
                    }
                  }),
                  _vm._v(" "),
                  _c("polygon", {
                    attrs: {
                      id: "Path-3",
                      fill: "url(#linearGradient-2)",
                      opacity: "0.099999994",
                      points:
                        "101.428699 0 83.0667527 94.1480575 130.378721 47.0740288"
                    }
                  })
                ]
              )
            ]
          )
        ]
      )
    ]
  )
}
var staticRenderFns = []
render._withStripped = true



/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/src/layouts/components/MultiDocumentNav.vue?vue&type=template&id=56864a49&":
/*!*******************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/src/layouts/components/MultiDocumentNav.vue?vue&type=template&id=56864a49& ***!
  \*******************************************************************************************************************************************************************************************************************************/
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
  return _c("div", [
    _vm.tabs.length > 0
      ? _c(
          "div",
          { staticClass: "flex flex-row overflow-x-auto mt-12" },
          [
            _vm._l(_vm.tabs, function(tab, key) {
              return _c(
                "vs-button",
                {
                  key: key,
                  staticClass: "py-1 pr-2 pl-5 flex-shrink-0",
                  style:
                    _vm.activeTab == tab.value ? "border-color: inherit" : "",
                  attrs: {
                    size: "large",
                    type: _vm.activeTab == tab.value ? "line" : "line",
                    color: _vm.activeTab == tab.value ? "primary" : "dark"
                  },
                  on: {
                    click: function($event) {
                      return _vm.routeTo({ path: tab.path })
                    },
                    contextmenu: function($event) {
                      $event.preventDefault()
                      _vm.$refs.menu.open($event)
                      _vm.contextTab = tab.value
                    }
                  }
                },
                [
                  _c(
                    "div",
                    { staticClass: "flex flex-row" },
                    [
                      _c("span", {
                        staticClass: "h6",
                        class:
                          _vm.activeTab == tab.value
                            ? "text-primary font-semibold"
                            : "",
                        domProps: { textContent: _vm._s(tab.label) }
                      }),
                      _vm._v(" "),
                      _c("vs-button", {
                        staticClass: "ml-2",
                        staticStyle: { "margin-top": "-9px" },
                        attrs: {
                          type: _vm.activeTab == tab.value ? "flat" : "flat",
                          color:
                            _vm.activeTab == tab.value ? "primary" : "dark",
                          size: "small",
                          icon: "close"
                        },
                        on: {
                          click: function($event) {
                            return _vm.closeTab(tab)
                          }
                        }
                      })
                    ],
                    1
                  )
                ]
              )
            }),
            _vm._v(" "),
            _c("vue-context", { ref: "menu" }, [
              _c("li", [
                _c(
                  "a",
                  {
                    staticClass: "flex items-center text-sm",
                    attrs: { href: "#" },
                    on: {
                      click: function($event) {
                        return _vm.contextClose()
                      }
                    }
                  },
                  [_c("span", { staticClass: "ml-2" }, [_vm._v("Close")])]
                )
              ]),
              _vm._v(" "),
              _c("li", [
                _c(
                  "a",
                  {
                    staticClass: "flex items-center text-sm",
                    attrs: { href: "#" },
                    on: {
                      click: function($event) {
                        return _vm.contextCloseOther()
                      }
                    }
                  },
                  [_c("span", { staticClass: "ml-2" }, [_vm._v("Close other")])]
                )
              ]),
              _vm._v(" "),
              _c("li", [
                _c(
                  "a",
                  {
                    staticClass: "flex items-center text-sm",
                    attrs: { href: "#" },
                    on: {
                      click: function($event) {
                        return _vm.contextCloseRight()
                      }
                    }
                  },
                  [
                    _c("span", { staticClass: "ml-2" }, [
                      _vm._v("Close to the right")
                    ])
                  ]
                )
              ]),
              _vm._v(" "),
              _c("li", [
                _c(
                  "a",
                  {
                    staticClass: "flex items-center text-sm",
                    attrs: { href: "#" },
                    on: {
                      click: function($event) {
                        return _vm.contextCloseAll()
                      }
                    }
                  },
                  [_c("span", { staticClass: "ml-2" }, [_vm._v("Close all")])]
                )
              ])
            ])
          ],
          2
        )
      : _vm._e(),
    _vm._v(" "),
    _vm.activeTabComponent
      ? _c(
          "div",
          { staticClass: "p-5" },
          [
            _c(
              "keep-alive",
              [_c(_vm.activeTabComponent, { tag: "component" })],
              1
            )
          ],
          1
        )
      : _vm._e()
  ])
}
var staticRenderFns = []
render._withStripped = true



/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/src/layouts/components/TheFooter.vue?vue&type=template&id=287afc22&functional=true&":
/*!****************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/src/layouts/components/TheFooter.vue?vue&type=template&id=287afc22&functional=true& ***!
  \****************************************************************************************************************************************************************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "render", function() { return render; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return staticRenderFns; });
var render = function(_h, _vm) {
  var _c = _vm._c
  return _c(
    "footer",
    { staticClass: "the-footer flex-wrap justify-between", class: _vm.classes },
    [
      _c("p", [
        _c("span", [_vm._v("COPYRIGHT ©")]),
        _vm._v(" "),
        _c("span", [_vm._v(_vm._s(new Date().getFullYear()) + " ")]),
        _vm._v(" "),
        _c(
          "a",
          {
            attrs: {
              href: "https://1.envato.market/vuexy_admin",
              target: "_blank",
              rel: "nofollow"
            }
          },
          [_vm._v("Pixinvent")]
        ),
        _vm._v(" "),
        _c("span", { staticClass: "hidden sm:inline-block" }, [
          _vm._v(", All rights Reserved")
        ])
      ]),
      _vm._v(" "),
      _c(
        "span",
        { staticClass: "md:flex hidden items-center" },
        [
          _c("span", [_vm._v("Hand-crafted & Made with")]),
          _vm._v(" "),
          _c("feather-icon", {
            staticClass: "ml-2",
            attrs: {
              icon: "HeartIcon",
              svgClasses: "stroke-current text-danger w-6 h-6"
            }
          })
        ],
        1
      )
    ]
  )
}
var staticRenderFns = []
render._withStripped = true



/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/src/layouts/components/horizontal-nav-menu/HorizontalNavMenu.vue?vue&type=template&id=24182a17&":
/*!****************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/src/layouts/components/horizontal-nav-menu/HorizontalNavMenu.vue?vue&type=template&id=24182a17& ***!
  \****************************************************************************************************************************************************************************************************************************************************/
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
  return _c("div", { staticClass: "relative" }, [
    _c(
      "div",
      { staticClass: "vx-navbar-wrapper nav-menu-wrapper" },
      [
        _c(
          "vs-navbar",
          {
            staticClass: "vx-navbar navbar-custom navbar-skelton",
            attrs: { color: _vm.navbarColor }
          },
          [
            _c(
              "ul",
              { staticClass: "menu-items flex flex-wrap w-full items-center" },
              _vm._l(_vm.navMenuItems, function(item, index) {
                return _c(
                  "li",
                  {
                    key: index,
                    staticClass: "menu-item",
                    class: { "mr-2": !(_vm.navMenuItems.length === index + 1) }
                  },
                  [
                    item.header
                      ? [
                          _c("h-nav-menu-header", {
                            staticClass: "menu-header relative",
                            attrs: { header: item }
                          })
                        ]
                      : item.submenu
                      ? [
                          _c("h-nav-menu-group", {
                            key: "group-" + index,
                            staticClass: "menu-group relative py-4",
                            attrs: {
                              bottom: "",
                              group: item,
                              groupIndex: index,
                              open: _vm.checkGrpChildrenActive(item)
                            }
                          })
                        ]
                      : item.url
                      ? _c(
                          "div",
                          { staticClass: "menu-link" },
                          [
                            _c(
                              "h-nav-menu-item",
                              {
                                staticClass: "relative py-4 cursor-pointer",
                                attrs: {
                                  to:
                                    item.slug !== "external" ? item.url : null,
                                  href:
                                    item.slug === "external" ? item.url : null,
                                  icon: item.icon,
                                  target: item.target,
                                  isDisabled: item.isDisabled,
                                  slug: item.slug
                                }
                              },
                              [
                                _c("span", { staticClass: "truncate" }, [
                                  _vm._v(_vm._s(item.name))
                                ]),
                                _vm._v(" "),
                                item.tag
                                  ? _c(
                                      "vs-chip",
                                      { attrs: { color: item.tagColor } },
                                      [_vm._v(_vm._s(item.tag))]
                                    )
                                  : _vm._e()
                              ],
                              1
                            )
                          ],
                          1
                        )
                      : _vm._e()
                  ],
                  2
                )
              }),
              0
            )
          ]
        )
      ],
      1
    )
  ])
}
var staticRenderFns = []
render._withStripped = true



/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/src/layouts/components/horizontal-nav-menu/HorizontalNavMenuGroup.vue?vue&type=template&id=3d04d158&":
/*!*********************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/src/layouts/components/horizontal-nav-menu/HorizontalNavMenuGroup.vue?vue&type=template&id=3d04d158& ***!
  \*********************************************************************************************************************************************************************************************************************************************************/
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
    {
      staticClass: "h-nav-group relative",
      class: [
        { "h-nav-group-open": _vm.openItems },
        { "h-nav-group-active": _vm.open },
        { "disabled-item pointer-events-none": _vm.group.isDisabled }
      ],
      on: { mouseover: _vm.mouseover, mouseleave: _vm.mouseout }
    },
    [
      _c(
        "div",
        { staticClass: "group-header w-full flex items-center" },
        [
          _c(
            "span",
            { staticClass: "flex items-center w-full" },
            [
              _vm.group.icon || this.groupIndex > Math.floor(this.groupIndex)
                ? _c("feather-icon", {
                    attrs: {
                      icon: _vm.group.icon || "CircleIcon",
                      svgClasses: _vm.iconClasses
                    }
                  })
                : _vm._e(),
              _vm._v(" "),
              _c("span", { staticClass: "truncate mr-3 select-none" }, [
                _vm._v(_vm._s(_vm.group.name))
              ])
            ],
            1
          ),
          _vm._v(" "),
          _c("feather-icon", {
            class: [{ rotate90: _vm.openItems }, "feather-grp-header-arrow"],
            attrs: {
              icon: _vm.bottom
                ? "ChevronDownIcon"
                : _vm.$vs.rtl
                ? "ChevronLeftIcon"
                : "ChevronRightIcon",
              "svg-classes": "w-4 h-4"
            }
          })
        ],
        1
      ),
      _vm._v(" "),
      _c("transition", { attrs: { name: "fade-bottom-2x" } }, [
        _c(
          "ul",
          {
            directives: [
              {
                name: "show",
                rawName: "v-show",
                value: _vm.openItems,
                expression: "openItems"
              }
            ],
            ref: "childDropdown",
            staticClass:
              "h-nav-group-items h-nav-menu-dd absolute shadow-drop py-2",
            style: _vm.styleItems
          },
          _vm._l(_vm.group.submenu, function(groupItem, index) {
            return _c(
              "li",
              { key: index },
              [
                groupItem.submenu
                  ? _c("h-nav-menu-group", {
                      attrs: {
                        group: groupItem,
                        groupIndex: Number(_vm.groupIndex + "." + (index + 1)),
                        open: _vm.isGroupActive(groupItem),
                        openHover: _vm.openHover
                      }
                    })
                  : _c(
                      "h-nav-menu-item",
                      {
                        attrs: {
                          "icon-small": "",
                          index: _vm.groupIndex + "." + index,
                          to:
                            groupItem.slug !== "external"
                              ? groupItem.url
                              : null,
                          href:
                            groupItem.slug === "external"
                              ? groupItem.url
                              : null,
                          icon: _vm.itemIcon,
                          slug: groupItem.slug,
                          target: groupItem.target
                        }
                      },
                      [
                        _c("span", { staticClass: "truncate" }, [
                          _vm._v(_vm._s(groupItem.name))
                        ]),
                        _vm._v(" "),
                        groupItem.tag
                          ? _c(
                              "vs-chip",
                              {
                                staticClass: "ml-auto",
                                attrs: { color: groupItem.tagColor }
                              },
                              [_vm._v(_vm._s(groupItem.tag))]
                            )
                          : _vm._e()
                      ],
                      1
                    )
              ],
              1
            )
          }),
          0
        )
      ])
    ],
    1
  )
}
var staticRenderFns = []
render._withStripped = true



/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/src/layouts/components/horizontal-nav-menu/HorizontalNavMenuHeader.vue?vue&type=template&id=e0ba01f8&":
/*!**********************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/src/layouts/components/horizontal-nav-menu/HorizontalNavMenuHeader.vue?vue&type=template&id=e0ba01f8& ***!
  \**********************************************************************************************************************************************************************************************************************************************************/
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
    {
      staticClass: "nav-header py-4",
      on: {
        mouseover: _vm.hovered,
        mouseleave: function($event) {
          return _vm.hovered(false)
        },
        click: function($event) {
          _vm.showChildren = !_vm.showChildren
        }
      }
    },
    [
      _c(
        "div",
        {
          staticClass:
            "header-label flex items-center cursor-pointer relative px-5 py-2",
          class: [
            {
              "text-white bg-primary-gradient header-active": _vm.isHeaderActive
            },
            { "header-open": _vm.isHovered || _vm.showChildren }
          ]
        },
        [
          _c("feather-icon", {
            staticClass: "mr-3",
            attrs: { icon: _vm.header.icon, svgClasses: "h-5 w-5" }
          }),
          _vm._v(" "),
          _c("span", { staticClass: "whitespace-no-wrap" }, [
            _vm._v(_vm._s(_vm.header.header))
          ]),
          _vm._v(" "),
          _c("feather-icon", {
            staticClass: "ml-1",
            attrs: { icon: "ChevronDownIcon", svgClasses: "h-4 w-4" }
          })
        ],
        1
      ),
      _vm._v(" "),
      _c("transition", { attrs: { name: "fade-top-2x" } }, [
        _c(
          "ul",
          {
            directives: [
              {
                name: "show",
                rawName: "v-show",
                value: _vm.showChildren,
                expression: "showChildren"
              }
            ],
            ref: "headerDropdown",
            staticClass:
              "header-children h-nav-menu-dd shadow-drop text-intial absolute shadow-lg py-2",
            class: { "dd-right": _vm.dropRight }
          },
          _vm._l(_vm.header.items, function(item, index) {
            return _c(
              "li",
              { key: item.name },
              [
                !item.submenu
                  ? [
                      _c(
                        "h-nav-menu-item",
                        {
                          attrs: {
                            to: item.slug != "external" ? item.url : "",
                            href: item.slug == "external" ? item.url : "",
                            icon: item.icon,
                            target: item.target,
                            isDisabled: item.isDisabled,
                            slug: item.slug
                          }
                        },
                        [
                          _c("span", { staticClass: "truncate" }, [
                            _vm._v(_vm._s(item.name))
                          ]),
                          _vm._v(" "),
                          item.tag
                            ? _c(
                                "vs-chip",
                                { attrs: { color: item.tagColor } },
                                [_vm._v(_vm._s(item.tag))]
                              )
                            : _vm._e()
                        ],
                        1
                      )
                    ]
                  : [
                      _c("h-nav-menu-group", {
                        key: "group-" + index,
                        attrs: {
                          openHover: "",
                          group: item,
                          groupIndex: index,
                          open: _vm.checkGrpChildrenActive(item)
                        }
                      })
                    ]
              ],
              2
            )
          }),
          0
        )
      ])
    ],
    1
  )
}
var staticRenderFns = []
render._withStripped = true



/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/src/layouts/components/horizontal-nav-menu/HorizontalNavMenuItem.vue?vue&type=template&id=1964704a&":
/*!********************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/src/layouts/components/horizontal-nav-menu/HorizontalNavMenuItem.vue?vue&type=template&id=1964704a& ***!
  \********************************************************************************************************************************************************************************************************************************************************/
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
    {
      staticClass: "h-nav-menu-item",
      class: [
        { "h-nav-active-item text-primary font-medium": _vm.activeLink },
        { "disabled-item pointer-events-none": _vm.isDisabled }
      ]
    },
    [
      _vm.to
        ? _c(
            "router-link",
            {
              class: [
                { "router-link-active": _vm.activeLink },
                "nav-link flex items-center"
              ],
              attrs: { exact: "", to: _vm.to, target: _vm.target }
            },
            [
              !_vm.featherIcon
                ? _c("vs-icon", {
                    attrs: { "icon-pack": _vm.iconPack, icon: _vm.icon }
                  })
                : _c("feather-icon", {
                    class: _vm.iconClasses,
                    attrs: { icon: _vm.icon }
                  }),
              _vm._v(" "),
              _vm._t("default")
            ],
            2
          )
        : _c(
            "a",
            {
              staticClass: "nav-link flex items-center",
              attrs: { target: _vm.target, href: _vm.href }
            },
            [
              !_vm.featherIcon
                ? _c("vs-icon", {
                    attrs: { "icon-pack": _vm.iconPack, icon: _vm.icon }
                  })
                : _c("feather-icon", {
                    class: _vm.iconClasses,
                    attrs: { icon: _vm.icon }
                  }),
              _vm._v(" "),
              _vm._t("default")
            ],
            2
          )
    ],
    1
  )
}
var staticRenderFns = []
render._withStripped = true



/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/src/layouts/components/navbar/TheNavbarHorizontal.vue?vue&type=template&id=23f1c760&":
/*!*****************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/src/layouts/components/navbar/TheNavbarHorizontal.vue?vue&type=template&id=23f1c760& ***!
  \*****************************************************************************************************************************************************************************************************************************************/
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
  return _c("div", { staticClass: "relative" }, [
    _c(
      "div",
      { staticClass: "vx-navbar-wrapper navbar-full p-0" },
      [
        _c(
          "vs-navbar",
          {
            staticClass: "navbar-custom navbar-skelton",
            class: _vm.navbarClasses,
            style: _vm.navbarStyle,
            attrs: { color: _vm.navbarColor }
          },
          [
            _vm.windowWidth >= 992
              ? _c("bookmarks", { attrs: { navbarColor: _vm.navbarColor } })
              : _vm._e(),
            _vm._v(" "),
            _c(
              "router-link",
              {
                staticClass: "vx-logo cursor-pointer mx-auto flex items-center",
                attrs: { tag: "div", to: "/" }
              },
              [
                _c("logo", {
                  staticClass: "w-10 mr-4 fill-current text-primary"
                }),
                _vm._v(" "),
                _c("span", { staticClass: "vx-logo-text text-primary" }, [
                  _vm._v("Vuexy")
                ])
              ],
              1
            ),
            _vm._v(" "),
            _c("search-bar", { staticClass: "mr-4" }),
            _vm._v(" "),
            _c("notification-drop-down"),
            _vm._v(" "),
            _c("profile-drop-down")
          ],
          1
        )
      ],
      1
    )
  ])
}
var staticRenderFns = []
render._withStripped = true



/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/src/layouts/components/navbar/TheNavbarVertical.vue?vue&type=template&id=2c25fa9c&":
/*!***************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/src/layouts/components/navbar/TheNavbarVertical.vue?vue&type=template&id=2c25fa9c& ***!
  \***************************************************************************************************************************************************************************************************************************************/
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
  return _c("div", { staticClass: "relative" }, [
    _c(
      "div",
      { staticClass: "vx-navbar-wrapper", class: _vm.classObj },
      [
        _c(
          "vs-navbar",
          {
            staticClass: "vx-navbar navbar-custom navbar-skelton",
            class: _vm.textColor,
            attrs: { color: _vm.navbarColorLocal }
          },
          [
            _c("feather-icon", {
              staticClass: "sm:inline-flex xl:hidden cursor-pointer p-2",
              attrs: { icon: "MenuIcon" },
              on: {
                click: function($event) {
                  $event.stopPropagation()
                  return _vm.showSidebar($event)
                }
              }
            }),
            _vm._v(" "),
            _vm._l(_vm.menuItemsUpdated, function(item, index) {
              return _c(
                "vs-navbar-item",
                { key: index, attrs: { index: index } },
                [
                  _c("router-link", {
                    attrs: { to: item.url },
                    domProps: { textContent: _vm._s(item.name) }
                  })
                ],
                1
              )
            }),
            _vm._v(" "),
            _c("vs-spacer"),
            _vm._v(" "),
            _c("i18n", { staticClass: "mr-5" }),
            _vm._v(" "),
            _c(
              "vs-navbar-item",
              [
                _c("router-link", { attrs: { to: "/profile" } }, [
                  _vm._v("Hi Administrator")
                ])
              ],
              1
            ),
            _vm._v(" "),
            _c("profile-drop-down"),
            _vm._v(" "),
            _c(
              "vs-navbar-item",
              {
                staticClass: "ml-5 text-danger cursor-pointer",
                attrs: { index: "0" }
              },
              [_c("span", { on: { click: _vm.logout } }, [_vm._v("로그아웃")])]
            )
          ],
          2
        )
      ],
      1
    )
  ])
}
var staticRenderFns = []
render._withStripped = true



/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/src/layouts/components/navbar/components/Bookmarks.vue?vue&type=template&id=f0f3dace&":
/*!******************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/src/layouts/components/navbar/components/Bookmarks.vue?vue&type=template&id=f0f3dace& ***!
  \******************************************************************************************************************************************************************************************************************************************/
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
  return _c("div", { staticClass: "navbar-bookmarks flex items-center" }, [
    _c(
      "ul",
      { staticClass: "vx-navbar__starred-pages" },
      [
        _c(
          "draggable",
          {
            staticClass: "flex cursor-move",
            attrs: { group: { name: "pinList" } },
            model: {
              value: _vm.starredPagesLimited,
              callback: function($$v) {
                _vm.starredPagesLimited = $$v
              },
              expression: "starredPagesLimited"
            }
          },
          _vm._l(_vm.starredPagesLimited, function(page) {
            return _c(
              "li",
              { key: page.url, staticClass: "starred-page" },
              [
                _c(
                  "vx-tooltip",
                  {
                    attrs: {
                      text: page.title,
                      position: "bottom",
                      delay: ".3s"
                    }
                  },
                  [
                    _c("feather-icon", {
                      staticClass: "p-2 cursor-pointer",
                      attrs: {
                        svgClasses: ["h-6 w-6 stroke-current", _vm.textColor],
                        icon: page.icon
                      },
                      on: {
                        click: function($event) {
                          _vm.$router.push(page.url).catch(function() {})
                        }
                      }
                    })
                  ],
                  1
                )
              ],
              1
            )
          }),
          0
        )
      ],
      1
    ),
    _vm._v(" "),
    _vm.starredPagesMore.length
      ? _c(
          "div",
          { staticClass: "vx-navbar__starred-pages--more-dropdown" },
          [
            _c(
              "vs-dropdown",
              {
                staticClass: "cursor-pointer",
                attrs: { "vs-custom-content": "", "vs-trigger-click": "" }
              },
              [
                _c("feather-icon", {
                  staticClass: "cursor-pointer p-2",
                  attrs: { icon: "ChevronDownIcon", svgClasses: "h-4 w-4" }
                }),
                _vm._v(" "),
                _c("vs-dropdown-menu", [
                  _c(
                    "ul",
                    { staticClass: "vx-navbar__starred-pages-more--list" },
                    [
                      _c(
                        "draggable",
                        {
                          staticClass: "cursor-move",
                          attrs: { group: { name: "pinList" } },
                          model: {
                            value: _vm.starredPagesMore,
                            callback: function($$v) {
                              _vm.starredPagesMore = $$v
                            },
                            expression: "starredPagesMore"
                          }
                        },
                        _vm._l(_vm.starredPagesMore, function(page) {
                          return _c(
                            "li",
                            {
                              key: page.url,
                              staticClass:
                                "starred-page--more flex items-center cursor-pointer",
                              on: {
                                click: function($event) {
                                  _vm.$router
                                    .push(page.url)
                                    .catch(function() {})
                                }
                              }
                            },
                            [
                              _c("feather-icon", {
                                staticClass: "ml-2 mr-1",
                                attrs: {
                                  icon: page.icon,
                                  svgClasses: [
                                    "h-5 w-5 stroke-current",
                                    _vm.textColor
                                  ]
                                }
                              }),
                              _vm._v(" "),
                              _c("span", { staticClass: "px-2 pt-2 pb-1" }, [
                                _vm._v(_vm._s(page.title))
                              ])
                            ],
                            1
                          )
                        }),
                        0
                      )
                    ],
                    1
                  )
                ])
              ],
              1
            )
          ],
          1
        )
      : _vm._e(),
    _vm._v(" "),
    _c(
      "div",
      { staticClass: "bookmark-container" },
      [
        _c("feather-icon", {
          staticClass: "cursor-pointer p-2",
          attrs: {
            icon: "StarIcon",
            svgClasses: ["stoke-current text-warning", _vm.textColor]
          },
          on: {
            click: function($event) {
              $event.stopPropagation()
              _vm.showBookmarkPagesDropdown = !_vm.showBookmarkPagesDropdown
            }
          }
        }),
        _vm._v(" "),
        _vm.showBookmarkPagesDropdown
          ? _c(
              "div",
              {
                directives: [
                  {
                    name: "click-outside",
                    rawName: "v-click-outside",
                    value: _vm.outside,
                    expression: "outside"
                  }
                ],
                staticClass: "absolute bookmark-list w-1/3 xl:w-1/4 mt-4"
              },
              [
                _c("vx-auto-suggest", {
                  ref: "bookmarkAutoSuggest",
                  attrs: {
                    autoFocus: true,
                    data: _vm.navbarSearchAndPinList,
                    initalData: {
                      pages: _vm.starredPagesLimited.concat(
                        _vm.starredPagesMore
                      )
                    },
                    searchLimit: 5,
                    placeholder: "Explore Vuexy...",
                    inputClassses: "w-full",
                    "show-action": "",
                    "show-pinned": "",
                    hideGroupTitle: "",
                    "background-overlay": ""
                  },
                  on: {
                    input: _vm.hnd_search_query_update,
                    selected: _vm.selected
                  },
                  scopedSlots: _vm._u(
                    [
                      {
                        key: "pages",
                        fn: function(ref) {
                          var suggestion = ref.suggestion
                          return [
                            _c(
                              "div",
                              {
                                staticClass: "flex items-center justify-between"
                              },
                              [
                                _c(
                                  "div",
                                  {
                                    staticClass:
                                      "flex items-end leading-none py-1"
                                  },
                                  [
                                    _c("feather-icon", {
                                      staticClass: "mr-4",
                                      attrs: {
                                        icon: suggestion.icon,
                                        svgClasses: "h-5 w-5"
                                      }
                                    }),
                                    _vm._v(" "),
                                    _c("span", { staticClass: "mt-1" }, [
                                      _vm._v(_vm._s(suggestion.title))
                                    ])
                                  ],
                                  1
                                ),
                                _vm._v(" "),
                                _c("feather-icon", {
                                  attrs: {
                                    icon: "StarIcon",
                                    svgClasses: [
                                      {
                                        "text-warning": suggestion.is_bookmarked
                                      },
                                      "h-5 w-5 stroke-current mt-1"
                                    ]
                                  },
                                  on: {
                                    click: function($event) {
                                      $event.stopPropagation()
                                      return _vm.actionClicked(suggestion)
                                    }
                                  }
                                })
                              ],
                              1
                            )
                          ]
                        }
                      }
                    ],
                    null,
                    false,
                    648118384
                  )
                })
              ],
              1
            )
          : _vm._e()
      ],
      1
    )
  ])
}
var staticRenderFns = []
render._withStripped = true



/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/src/layouts/components/navbar/components/I18n.vue?vue&type=template&id=7f0786b2&":
/*!*************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/src/layouts/components/navbar/components/I18n.vue?vue&type=template&id=7f0786b2& ***!
  \*************************************************************************************************************************************************************************************************************************************/
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
    "vs-dropdown",
    {
      staticClass: "cursor-pointer",
      attrs: { "vs-custom-content": "", "vs-trigger-click": "" }
    },
    [
      _c(
        "span",
        { staticClass: "cursor-pointer flex items-center i18n-locale" },
        [
          _c("img", {
            staticClass: "h-4 w-5",
            attrs: { src: _vm.i18n_locale_img, alt: _vm.$i18n.locale }
          }),
          _vm._v(" "),
          _c("span", { staticClass: "hidden sm:block ml-2" }, [
            _vm._v(_vm._s(_vm.getCurrentLocaleData.lang))
          ])
        ]
      ),
      _vm._v(" "),
      _c(
        "vs-dropdown-menu",
        { staticClass: "w-48 i18n-dropdown vx-navbar-dropdown" },
        [
          _c(
            "vs-dropdown-item",
            {
              on: {
                click: function($event) {
                  return _vm.updateLocale("en")
                }
              }
            },
            [
              _c("img", {
                staticClass: "h-4 w-5 mr-1",
                attrs: {
                  src: __webpack_require__(/*! @assets/images/flags/en.png */ "./resources/assets/images/flags/en.png"),
                  alt: "en"
                }
              }),
              _vm._v("  English")
            ]
          ),
          _vm._v(" "),
          _c(
            "vs-dropdown-item",
            {
              on: {
                click: function($event) {
                  return _vm.updateLocale("kr")
                }
              }
            },
            [
              _c("img", {
                staticClass: "h-4 w-5 mr-1",
                attrs: {
                  src: __webpack_require__(/*! @assets/images/flags/kr.png */ "./resources/assets/images/flags/kr.png"),
                  alt: "kr"
                }
              }),
              _vm._v("  Korean")
            ]
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

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/src/layouts/components/navbar/components/NotificationDropDown.vue?vue&type=template&id=4a684060&":
/*!*****************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/src/layouts/components/navbar/components/NotificationDropDown.vue?vue&type=template&id=4a684060& ***!
  \*****************************************************************************************************************************************************************************************************************************************************/
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
    "vs-dropdown",
    {
      staticClass: "cursor-pointer",
      attrs: { "vs-custom-content": "", "vs-trigger-click": "" }
    },
    [
      _c("feather-icon", {
        staticClass: "cursor-pointer mt-1 sm:mr-6 mr-2",
        attrs: { icon: "BellIcon", badge: _vm.unreadNotifications.length }
      }),
      _vm._v(" "),
      _c(
        "vs-dropdown-menu",
        {
          staticClass:
            "notification-dropdown dropdown-custom vx-navbar-dropdown"
        },
        [
          _c(
            "div",
            {
              staticClass:
                "notification-top text-center p-5 bg-primary text-white"
            },
            [
              _c("h3", { staticClass: "text-white" }, [
                _vm._v(_vm._s(_vm.unreadNotifications.length) + " New")
              ]),
              _vm._v(" "),
              _c("p", { staticClass: "opacity-75" }, [
                _vm._v("App Notifications")
              ])
            ]
          ),
          _vm._v(" "),
          _c(
            _vm.scrollbarTag,
            {
              key: _vm.$vs.rtl,
              ref: "mainSidebarPs",
              tag: "component",
              staticClass: "scroll-area--nofications-dropdown p-0 mb-10",
              attrs: { settings: _vm.settings }
            },
            [
              _c(
                "ul",
                { staticClass: "bordered-items" },
                _vm._l(_vm.unreadNotifications, function(ntf) {
                  return _c(
                    "li",
                    {
                      key: ntf.index,
                      staticClass:
                        "flex justify-between px-4 py-4 notification cursor-pointer"
                    },
                    [
                      _c(
                        "div",
                        { staticClass: "flex items-start" },
                        [
                          _c("feather-icon", {
                            attrs: {
                              icon: ntf.icon,
                              svgClasses: [
                                "text-" + ntf.category,
                                "stroke-current mr-1 h-6 w-6"
                              ]
                            }
                          }),
                          _vm._v(" "),
                          _c("div", { staticClass: "mx-2" }, [
                            _c(
                              "span",
                              {
                                staticClass:
                                  "font-medium block notification-title",
                                class: ["text-" + ntf.category]
                              },
                              [_vm._v(_vm._s(ntf.title))]
                            ),
                            _vm._v(" "),
                            _c("small", [_vm._v(_vm._s(ntf.msg))])
                          ])
                        ],
                        1
                      ),
                      _vm._v(" "),
                      _c("small", { staticClass: "mt-1 whitespace-no-wrap" }, [
                        _vm._v(_vm._s(_vm.elapsedTime(ntf.time)))
                      ])
                    ]
                  )
                }),
                0
              )
            ]
          ),
          _vm._v(" "),
          _c(
            "div",
            {
              staticClass:
                "\n      checkout-footer\n      fixed\n      bottom-0\n      rounded-b-lg\n      text-primary\n      w-full\n      p-2\n      font-semibold\n      text-center\n      border\n      border-b-0\n      border-l-0\n      border-r-0\n      border-solid\n      d-theme-border-grey-light\n      cursor-pointer"
            },
            [_c("span", [_vm._v("View All Notifications")])]
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

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/src/layouts/components/navbar/components/ProfileDropDown.vue?vue&type=template&id=3a9ac416&":
/*!************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/src/layouts/components/navbar/components/ProfileDropDown.vue?vue&type=template&id=3a9ac416& ***!
  \************************************************************************************************************************************************************************************************************************************************/
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
  return _vm.activeUserInfo.displayName
    ? _c(
        "div",
        { staticClass: "the-navbar__user-meta flex items-center" },
        [
          _c(
            "vs-dropdown",
            {
              staticClass: "cursor-pointer",
              attrs: { "vs-custom-content": "", "vs-trigger-click": "" }
            },
            [
              _c("vs-dropdown-menu", { staticClass: "vx-navbar-dropdown" }, [
                _c(
                  "ul",
                  { staticStyle: { "min-width": "9rem" } },
                  [
                    _c(
                      "li",
                      {
                        staticClass:
                          "flex py-2 px-4 cursor-pointer hover:bg-primary hover:text-white"
                      },
                      [
                        _c("feather-icon", {
                          attrs: { icon: "UserIcon", svgClasses: "w-4 h-4" }
                        }),
                        _vm._v(" "),
                        _c("span", { staticClass: "ml-2" }, [_vm._v("Profile")])
                      ],
                      1
                    ),
                    _vm._v(" "),
                    _c("vs-divider", { staticClass: "m-1" }),
                    _vm._v(" "),
                    _c(
                      "li",
                      {
                        staticClass:
                          "flex py-2 px-4 cursor-pointer hover:bg-primary hover:text-white",
                        on: { click: _vm.logout }
                      },
                      [
                        _c("feather-icon", {
                          attrs: { icon: "LogOutIcon", svgClasses: "w-4 h-4" }
                        }),
                        _vm._v(" "),
                        _c("span", { staticClass: "ml-2" }, [
                          _vm._v("로그아웃")
                        ])
                      ],
                      1
                    )
                  ],
                  1
                )
              ])
            ],
            1
          )
        ],
        1
      )
    : _vm._e()
}
var staticRenderFns = []
render._withStripped = true



/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/src/layouts/components/navbar/components/SearchBar.vue?vue&type=template&id=aa08d232&":
/*!******************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/src/layouts/components/navbar/components/SearchBar.vue?vue&type=template&id=aa08d232& ***!
  \******************************************************************************************************************************************************************************************************************************************/
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
    { staticClass: "flex" },
    [
      _c(
        "div",
        {
          directives: [
            {
              name: "show",
              rawName: "v-show",
              value: _vm.showFullSearch,
              expression: "showFullSearch"
            }
          ],
          staticClass:
            "search-full-container w-full h-full absolute left-0 top-0",
          class: { flex: _vm.showFullSearch }
        },
        [
          _c("vx-auto-suggest", {
            ref: "navbarSearch",
            staticClass: "w-full",
            attrs: {
              autoFocus: _vm.showFullSearch,
              data: _vm.navbarSearchAndPinList,
              search_key: "title",
              "background-overlay": "",
              inputClassses:
                "w-full vs-input-no-border vs-input-no-shdow-focus",
              icon: "SearchIcon",
              placeholder: "Explore Vuexy..."
            },
            on: {
              input: _vm.hnd_search_query_update,
              selected: _vm.selected,
              closeSearchbar: function($event) {
                _vm.showFullSearch = false
              }
            },
            scopedSlots: _vm._u([
              {
                key: "group",
                fn: function(ref) {
                  var group_name = ref.group_name
                  return [
                    _c("p", { staticClass: "font-semibold text-primary" }, [
                      _vm._v(_vm._s(_vm._f("title")(group_name)))
                    ])
                  ]
                }
              },
              {
                key: "pages",
                fn: function(ref) {
                  var suggestion = ref.suggestion
                  return [
                    _c(
                      "div",
                      { staticClass: "flex items-end leading-none py-1" },
                      [
                        _c("feather-icon", {
                          staticClass: "mr-4",
                          attrs: {
                            icon: suggestion.icon,
                            svgClasses: "h-5 w-5"
                          }
                        }),
                        _vm._v(" "),
                        _c("span", { staticClass: "mt-1" }, [
                          _vm._v(_vm._s(suggestion.title))
                        ])
                      ],
                      1
                    )
                  ]
                }
              },
              {
                key: "noResult",
                fn: function(ref) {
                  var group_name = ref.group_name
                  return [
                    _c(
                      "div",
                      { staticClass: "flex items-center" },
                      [
                        _c("feather-icon", {
                          staticClass: "mr-4",
                          attrs: { icon: "InfoIcon", svgClasses: "h-5 w-5" }
                        }),
                        _vm._v(" "),
                        _c("span", [_vm._v("No results found.")])
                      ],
                      1
                    )
                  ]
                }
              }
            ])
          }),
          _vm._v(" "),
          _c(
            "div",
            { staticClass: "absolute right-0 h-full z-50" },
            [
              _c("feather-icon", {
                staticClass: "px-4 cursor-pointer h-full close-search-icon",
                attrs: { icon: "XIcon" },
                on: {
                  click: function($event) {
                    _vm.showFullSearch = false
                  }
                }
              })
            ],
            1
          )
        ],
        1
      ),
      _vm._v(" "),
      _c("feather-icon", {
        staticClass: "cursor-pointer navbar-fuzzy-search ml-4",
        attrs: { icon: "SearchIcon" },
        on: {
          click: function($event) {
            _vm.showFullSearch = true
          }
        }
      })
    ],
    1
  )
}
var staticRenderFns = []
render._withStripped = true



/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/src/layouts/components/vertical-nav-menu/VerticalNavMenu.vue?vue&type=template&id=667d9133&":
/*!************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/src/layouts/components/vertical-nav-menu/VerticalNavMenu.vue?vue&type=template&id=667d9133& ***!
  \************************************************************************************************************************************************************************************************************************************************/
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
    { staticClass: "parentx" },
    [
      _c(
        "vs-sidebar",
        {
          directives: [
            {
              name: "hammer",
              rawName: "v-hammer:swipe",
              value: _vm.onMenuSwipe,
              expression: "onMenuSwipe",
              arg: "swipe"
            }
          ],
          ref: "verticalNavMenu",
          staticClass: "v-nav-menu items-no-padding",
          attrs: {
            "default-index": "-1",
            "click-not-close": _vm.clickNotClose,
            "reduce-not-rebound": _vm.reduceNotRebound,
            parent: _vm.parent,
            hiddenBackground: _vm.clickNotClose,
            reduce: _vm.reduce
          },
          model: {
            value: _vm.isVerticalNavMenuActive,
            callback: function($$v) {
              _vm.isVerticalNavMenuActive = $$v
            },
            expression: "isVerticalNavMenuActive"
          }
        },
        [
          _c(
            "div",
            { on: { mouseenter: _vm.mouseEnter, mouseleave: _vm.mouseLeave } },
            [
              _c(
                "div",
                {
                  staticClass: "header-sidebar flex items-end justify-between",
                  attrs: { slot: "header" },
                  slot: "header"
                },
                [
                  _c(
                    "router-link",
                    {
                      staticClass: "vx-logo cursor-pointer flex items-center",
                      attrs: { tag: "div", to: "/" }
                    },
                    [
                      _vm.title
                        ? _c(
                            "span",
                            {
                              directives: [
                                {
                                  name: "show",
                                  rawName: "v-show",
                                  value: _vm.isMouseEnter || !_vm.reduce,
                                  expression: "isMouseEnter || !reduce"
                                }
                              ],
                              staticClass: "vx-logo-text text-primary"
                            },
                            [_vm._v(_vm._s(_vm.title))]
                          )
                        : _vm._e()
                    ]
                  ),
                  _vm._v(" "),
                  _c("div")
                ],
                1
              ),
              _vm._v(" "),
              _c("div", {
                directives: [
                  {
                    name: "show",
                    rawName: "v-show",
                    value: _vm.showShadowBottom,
                    expression: "showShadowBottom"
                  }
                ],
                staticClass: "shadow-bottom"
              }),
              _vm._v(" "),
              _c(
                _vm.scrollbarTag,
                {
                  key: _vm.$vs.rtl,
                  ref: "verticalNavMenuPs",
                  tag: "component",
                  staticClass: "scroll-area-v-nav-menu pt-2",
                  attrs: { settings: _vm.settings },
                  on: {
                    "ps-scroll-y": _vm.psSectionScroll,
                    scroll: _vm.psSectionScroll
                  }
                },
                [
                  _vm._l(_vm.menuItemsUpdated, function(item, index) {
                    return [
                      item.header && !_vm.verticalNavMenuItemsMin
                        ? _c(
                            "span",
                            {
                              key: "header-" + index,
                              staticClass: "navigation-header truncate"
                            },
                            [
                              _vm._v(
                                "\n            " +
                                  _vm._s(item.header) +
                                  "\n          "
                              )
                            ]
                          )
                        : !item.header
                        ? [
                            !item.submenu
                              ? _c(
                                  "v-nav-menu-item",
                                  {
                                    key: "item-" + index,
                                    attrs: {
                                      index: index,
                                      to:
                                        item.slug !== "external"
                                          ? item.url
                                          : null,
                                      href:
                                        item.slug === "external"
                                          ? item.url
                                          : null,
                                      icon: item.icon,
                                      target: item.target,
                                      isDisabled: item.isDisabled,
                                      slug: item.slug
                                    }
                                  },
                                  [
                                    _c(
                                      "span",
                                      {
                                        directives: [
                                          {
                                            name: "show",
                                            rawName: "v-show",
                                            value: !_vm.verticalNavMenuItemsMin,
                                            expression:
                                              "!verticalNavMenuItemsMin"
                                          }
                                        ],
                                        staticClass: "truncate"
                                      },
                                      [_vm._v(_vm._s(item.name))]
                                    ),
                                    _vm._v(" "),
                                    item.tag &&
                                    (_vm.isMouseEnter || !_vm.reduce)
                                      ? _c(
                                          "vs-chip",
                                          {
                                            staticClass: "ml-auto",
                                            attrs: { color: item.tagColor }
                                          },
                                          [_vm._v(_vm._s(item.tag))]
                                        )
                                      : _vm._e()
                                  ],
                                  1
                                )
                              : [
                                  _c("v-nav-menu-group", {
                                    key: "group-" + index,
                                    attrs: {
                                      openHover: _vm.openGroupHover,
                                      group: item,
                                      groupIndex: index,
                                      open: _vm.isGroupActive(item)
                                    }
                                  })
                                ]
                          ]
                        : _vm._e()
                    ]
                  })
                ],
                2
              )
            ],
            1
          )
        ]
      ),
      _vm._v(" "),
      !_vm.isVerticalNavMenuActive
        ? _c("div", {
            directives: [
              {
                name: "hammer",
                rawName: "v-hammer:swipe",
                value: _vm.onSwipeAreaSwipe,
                expression: "onSwipeAreaSwipe",
                arg: "swipe"
              }
            ],
            staticClass: "v-nav-menu-swipe-area"
          })
        : _vm._e()
    ],
    1
  )
}
var staticRenderFns = []
render._withStripped = true



/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/src/layouts/components/vertical-nav-menu/VerticalNavMenuGroup.vue?vue&type=template&id=b6a10888&":
/*!*****************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/src/layouts/components/vertical-nav-menu/VerticalNavMenuGroup.vue?vue&type=template&id=b6a10888& ***!
  \*****************************************************************************************************************************************************************************************************************************************************/
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
    {
      staticClass: "vs-sidebar-group",
      class: [
        { "vs-sidebar-group-open": _vm.openItems },
        { "vs-sidebar-group-active": _vm.open },
        { "disabled-item pointer-events-none": _vm.group.isDisabled }
      ],
      on: { mouseover: _vm.mouseover, mouseout: _vm.mouseout }
    },
    [
      _c(
        "div",
        { staticClass: "group-header w-full", on: { click: _vm.clickGroup } },
        [
          _c(
            "span",
            { staticClass: "flex items-center w-full" },
            [
              _vm.group.icon || this.groupIndex > Math.floor(this.groupIndex)
                ? _c("feather-icon", {
                    attrs: {
                      icon: _vm.group.icon || "CircleIcon",
                      svgClasses: { "w-3 h-3": this.groupIndex % 1 != 0 }
                    }
                  })
                : _vm._e(),
              _vm._v(" "),
              _c(
                "span",
                {
                  directives: [
                    {
                      name: "show",
                      rawName: "v-show",
                      value: !_vm.verticalNavMenuItemsMin,
                      expression: "!verticalNavMenuItemsMin"
                    }
                  ],
                  staticClass: "truncate mr-3 select-none"
                },
                [_vm._v(_vm._s(_vm.group.name))]
              ),
              _vm._v(" "),
              _vm.group.tag && !_vm.verticalNavMenuItemsMin
                ? _c(
                    "vs-chip",
                    {
                      staticClass: "ml-auto mr-4",
                      attrs: { color: _vm.group.tagColor }
                    },
                    [_vm._v(_vm._s(_vm.group.tag))]
                  )
                : _vm._e()
            ],
            1
          ),
          _vm._v(" "),
          _c("feather-icon", {
            directives: [
              {
                name: "show",
                rawName: "v-show",
                value: !_vm.verticalNavMenuItemsMin,
                expression: "!verticalNavMenuItemsMin"
              }
            ],
            class: [{ rotate90: _vm.openItems }, "feather-grp-header-arrow"],
            attrs: {
              icon: _vm.$vs.rtl ? "ChevronLeftIcon" : "ChevronRightIcon",
              "svg-classes": "w-4 h-4"
            }
          }),
          _vm._v(" "),
          _c("span", { staticClass: "vs-sidebar--tooltip" }, [
            _vm._v(_vm._s(_vm.group.name))
          ])
        ],
        1
      ),
      _vm._v(" "),
      _c(
        "ul",
        {
          ref: "items",
          staticClass: "vs-sidebar-group-items",
          style: _vm.styleItems
        },
        _vm._l(_vm.group.submenu, function(groupItem, index) {
          return _c(
            "li",
            { key: index },
            [
              groupItem.submenu
                ? _c("v-nav-menu-group", {
                    attrs: {
                      group: groupItem,
                      groupIndex: Number(_vm.groupIndex + "." + (index + 1)),
                      open: _vm.isGroupActive(groupItem),
                      openHover: _vm.openHover
                    }
                  })
                : _c(
                    "v-nav-menu-item",
                    {
                      attrs: {
                        "icon-small": "",
                        index: _vm.groupIndex + "." + index,
                        to:
                          groupItem.slug !== "external" ? groupItem.url : null,
                        href:
                          groupItem.slug === "external" ? groupItem.url : null,
                        icon: _vm.itemIcon(_vm.groupIndex + "." + index),
                        slug: groupItem.slug,
                        target: groupItem.target
                      }
                    },
                    [
                      _c("span", { staticClass: "truncate" }, [
                        _vm._v(_vm._s(groupItem.name))
                      ]),
                      _vm._v(" "),
                      groupItem.tag
                        ? _c(
                            "vs-chip",
                            {
                              staticClass: "ml-auto",
                              attrs: { color: groupItem.tagColor }
                            },
                            [_vm._v(_vm._s(groupItem.tag))]
                          )
                        : _vm._e()
                    ],
                    1
                  )
            ],
            1
          )
        }),
        0
      )
    ]
  )
}
var staticRenderFns = []
render._withStripped = true



/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/src/layouts/components/vertical-nav-menu/VerticalNavMenuItem.vue?vue&type=template&id=4e48e966&":
/*!****************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/src/layouts/components/vertical-nav-menu/VerticalNavMenuItem.vue?vue&type=template&id=4e48e966& ***!
  \****************************************************************************************************************************************************************************************************************************************************/
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
    {
      staticClass: "vs-sidebar--item",
      class: [
        { "vs-sidebar-item-active": _vm.activeLink },
        { "disabled-item pointer-events-none": _vm.isDisabled }
      ]
    },
    [
      _vm.tabExceeded
        ? [
            _c(
              "a",
              {
                staticClass: "cursor-pointer",
                class: [{ "router-link-active": _vm.activeLink }],
                attrs: { tabindex: "-1", exact: "", target: _vm.target },
                on: { click: _vm.showExceededDialog }
              },
              [
                !_vm.featherIcon
                  ? _c("vs-icon", {
                      attrs: { "icon-pack": _vm.iconPack, icon: _vm.icon }
                    })
                  : _vm.icon
                  ? _c("feather-icon", {
                      class: { "w-3 h-3": _vm.iconSmall },
                      attrs: { icon: _vm.icon }
                    })
                  : _vm._e(),
                _vm._v(" "),
                _vm._t("default")
              ],
              2
            )
          ]
        : [
            _vm.to
              ? _c(
                  "router-link",
                  {
                    class: [{ "router-link-active": _vm.activeLink }],
                    attrs: {
                      tabindex: "-1",
                      exact: "",
                      to: _vm.to,
                      target: _vm.target
                    }
                  },
                  [
                    !_vm.featherIcon
                      ? _c("vs-icon", {
                          attrs: { "icon-pack": _vm.iconPack, icon: _vm.icon }
                        })
                      : _vm.icon
                      ? _c("feather-icon", {
                          class: { "w-3 h-3": _vm.iconSmall },
                          attrs: { icon: _vm.icon }
                        })
                      : _vm._e(),
                    _vm._v(" "),
                    _vm._t("default")
                  ],
                  2
                )
              : _c(
                  "a",
                  {
                    attrs: {
                      target: _vm.target,
                      href: _vm.href,
                      tabindex: "-1"
                    }
                  },
                  [
                    !_vm.featherIcon
                      ? _c("vs-icon", {
                          attrs: { "icon-pack": _vm.iconPack, icon: _vm.icon }
                        })
                      : _vm._e(),
                    _vm._v(" "),
                    _vm._t("default")
                  ],
                  2
                )
          ]
    ],
    2
  )
}
var staticRenderFns = []
render._withStripped = true



/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/src/layouts/main/Main.vue?vue&type=template&id=22fa5a70&":
/*!*************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/src/layouts/main/Main.vue?vue&type=template&id=22fa5a70& ***!
  \*************************************************************************************************************************************************************************************************************/
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
    {
      staticClass: "layout--main",
      class: [
        _vm.layoutTypeClass,
        _vm.navbarClasses,
        _vm.footerClasses,
        { "no-scroll": _vm.isAppPage }
      ]
    },
    [
      _c("auto-logout"),
      _vm._v(" "),
      _c("v-nav-menu", {
        attrs: {
          navMenuItems: _vm.navMenuItems,
          title: "복을만드는사람들",
          parent: ".layout--main"
        }
      }),
      _vm._v(" "),
      _c(
        "div",
        {
          class: [_vm.contentAreaClass, { "show-overlay": _vm.bodyOverlay }],
          attrs: { id: "content-area" }
        },
        [
          _c("div", { attrs: { id: "content-overlay" } }),
          _vm._v(" "),
          _vm.mainLayoutType === "horizontal" && _vm.windowWidth >= 1200
            ? [
                _c("the-navbar-horizontal", {
                  class: [
                    { "text-white": _vm.isNavbarDark && !_vm.isThemeDark },
                    { "text-base": !_vm.isNavbarDark && _vm.isThemeDark }
                  ],
                  attrs: { navbarType: _vm.navbarType }
                }),
                _vm._v(" "),
                _vm.navbarType === "static"
                  ? _c("div", { staticStyle: { height: "62px" } })
                  : _vm._e(),
                _vm._v(" "),
                _c("h-nav-menu", {
                  class: [
                    { "text-white": _vm.isNavbarDark && !_vm.isThemeDark },
                    { "text-base": !_vm.isNavbarDark && _vm.isThemeDark }
                  ],
                  attrs: { navMenuItems: _vm.navMenuItems }
                })
              ]
            : [
                _c("the-navbar-vertical", {
                  class: [
                    { "text-white": _vm.isNavbarDark && !_vm.isThemeDark },
                    { "text-base": !_vm.isNavbarDark && _vm.isThemeDark }
                  ],
                  attrs: { navbarColor: _vm.navbarColor }
                })
              ],
          _vm._v(" "),
          _c("div", { staticClass: "content-wrapper" }, [
            _c("div", { staticClass: "router-view pl-0" }, [
              _c(
                "div",
                { staticClass: "router-content" },
                [
                  _c("transition", { attrs: { name: _vm.routerTransition } }, [
                    _vm.$route.meta.breadcrumb || _vm.$route.meta.pageTitle
                      ? _c(
                          "div",
                          {
                            staticClass:
                              "router-header flex flex-wrap items-center mb-6"
                          },
                          [
                            _c(
                              "div",
                              {
                                staticClass: "content-area__heading",
                                class: {
                                  "pr-4 border-0 md:border-r border-solid border-grey-light":
                                    _vm.$route.meta.breadcrumb
                                }
                              },
                              [
                                _c("h2", { staticClass: "mb-1" }, [
                                  _vm._v(_vm._s(_vm.routeTitle))
                                ])
                              ]
                            ),
                            _vm._v(" "),
                            _vm.$route.meta.breadcrumb
                              ? _c("vx-breadcrumb", {
                                  staticClass: "ml-4 md:block hidden",
                                  attrs: {
                                    route: _vm.$route,
                                    isRTL: _vm.$vs.rtl
                                  }
                                })
                              : _vm._e(),
                            _vm._v(" "),
                            _c(
                              "vs-dropdown",
                              {
                                staticClass:
                                  "ml-auto md:block hidden cursor-pointer",
                                attrs: { "vs-trigger-click": "" }
                              },
                              [
                                _c("vs-button", {
                                  attrs: {
                                    radius: "",
                                    icon: "icon-settings",
                                    "icon-pack": "feather"
                                  }
                                }),
                                _vm._v(" "),
                                _c(
                                  "vs-dropdown-menu",
                                  { staticClass: "w-32" },
                                  [
                                    _c("vs-dropdown-item", [
                                      _c(
                                        "div",
                                        {
                                          staticClass: "flex items-center",
                                          on: {
                                            click: function($event) {
                                              _vm.$router
                                                .push("/pages/profile")
                                                .catch(function() {})
                                            }
                                          }
                                        },
                                        [
                                          _c("feather-icon", {
                                            staticClass: "inline-block mr-2",
                                            attrs: {
                                              icon: "UserIcon",
                                              svgClasses: "w-4 h-4"
                                            }
                                          }),
                                          _vm._v(" "),
                                          _c("span", [_vm._v("Profile")])
                                        ],
                                        1
                                      )
                                    ]),
                                    _vm._v(" "),
                                    _c("vs-dropdown-item", [
                                      _c(
                                        "div",
                                        {
                                          staticClass: "flex items-center",
                                          on: {
                                            click: function($event) {
                                              _vm.$router
                                                .push("/apps/todo")
                                                .catch(function() {})
                                            }
                                          }
                                        },
                                        [
                                          _c("feather-icon", {
                                            staticClass: "inline-block mr-2",
                                            attrs: {
                                              icon: "CheckSquareIcon",
                                              svgClasses: "w-4 h-4"
                                            }
                                          }),
                                          _vm._v(" "),
                                          _c("span", [_vm._v("Tasks")])
                                        ],
                                        1
                                      )
                                    ]),
                                    _vm._v(" "),
                                    _c("vs-dropdown-item", [
                                      _c(
                                        "div",
                                        {
                                          staticClass: "flex items-center",
                                          on: {
                                            click: function($event) {
                                              _vm.$router
                                                .push("/apps/email")
                                                .catch(function() {})
                                            }
                                          }
                                        },
                                        [
                                          _c("feather-icon", {
                                            staticClass: "inline-block mr-2",
                                            attrs: {
                                              icon: "MailIcon",
                                              svgClasses: "w-4 h-4"
                                            }
                                          }),
                                          _vm._v(" "),
                                          _c("span", [_vm._v("Inbox")])
                                        ],
                                        1
                                      )
                                    ])
                                  ],
                                  1
                                )
                              ],
                              1
                            )
                          ],
                          1
                        )
                      : _vm._e()
                  ]),
                  _vm._v(" "),
                  _c(
                    "div",
                    { staticClass: "content-area__content" },
                    [
                      _c("multi-document-nav"),
                      _vm._v(" "),
                      !_vm.hideScrollToTop
                        ? _c(
                            "back-to-top",
                            {
                              attrs: {
                                bottom: "5%",
                                right: _vm.$vs.rtl
                                  ? "calc(100% - 2.2rem - 38px)"
                                  : "30px",
                                visibleoffset: "500"
                              }
                            },
                            [
                              _c("vs-button", {
                                staticClass: "shadow-lg btn-back-to-top",
                                attrs: {
                                  "icon-pack": "feather",
                                  icon: "icon-arrow-up"
                                }
                              })
                            ],
                            1
                          )
                        : _vm._e(),
                      _vm._v(" "),
                      _c(
                        "transition",
                        {
                          attrs: { name: _vm.routerTransition, mode: "out-in" }
                        },
                        [
                          _c("router-view", {
                            on: {
                              changeRouteTitle: _vm.changeRouteTitle,
                              setAppClasses: function(classesStr) {
                                return _vm.$emit(
                                  _vm.setAppClassEvent,
                                  classesStr
                                )
                              }
                            }
                          })
                        ],
                        1
                      )
                    ],
                    1
                  )
                ],
                1
              )
            ])
          ]),
          _vm._v(" "),
          _c("the-footer")
        ],
        2
      )
    ],
    1
  )
}
var staticRenderFns = []
render._withStripped = true



/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/src/views/_loading.vue?vue&type=template&id=4c4e5ef2&":
/*!**********************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/src/views/_loading.vue?vue&type=template&id=4c4e5ef2& ***!
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
  return _c("div", { staticClass: "demo-alignment" }, [
    _c("div", { staticClass: "fill-row-loading m-0" }, [
      _c("div", {
        staticClass: "vs-con-loading__container loading-example",
        attrs: { id: ["loading-border"] }
      })
    ])
  ])
}
var staticRenderFns = []
render._withStripped = true



/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/src/views/_timeout.vue?vue&type=template&id=6c6aa22c&":
/*!**********************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/src/views/_timeout.vue?vue&type=template&id=6c6aa22c& ***!
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
  return _c("div", [_vm._v("timeout")])
}
var staticRenderFns = []
render._withStripped = true



/***/ }),

/***/ "./resources/assets/images/flags/en.png":
/*!**********************************************!*\
  !*** ./resources/assets/images/flags/en.png ***!
  \**********************************************/
/*! no static exports found */
/***/ (function(module, exports) {

module.exports = "/images/en.png?83b065848d14d33c0d10a13e01862f34";

/***/ }),

/***/ "./resources/assets/images/flags/kr.png":
/*!**********************************************!*\
  !*** ./resources/assets/images/flags/kr.png ***!
  \**********************************************/
/*! no static exports found */
/***/ (function(module, exports) {

module.exports = "/images/kr.png?a644cd34ae14eec28baed0e3b4d3042e";

/***/ }),

/***/ "./resources/js/src/components/vx-auto-suggest/VxAutoSuggest.vue":
/*!***********************************************************************!*\
  !*** ./resources/js/src/components/vx-auto-suggest/VxAutoSuggest.vue ***!
  \***********************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _VxAutoSuggest_vue_vue_type_template_id_3b23de25___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./VxAutoSuggest.vue?vue&type=template&id=3b23de25& */ "./resources/js/src/components/vx-auto-suggest/VxAutoSuggest.vue?vue&type=template&id=3b23de25&");
/* harmony import */ var _VxAutoSuggest_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./VxAutoSuggest.vue?vue&type=script&lang=js& */ "./resources/js/src/components/vx-auto-suggest/VxAutoSuggest.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport *//* harmony import */ var _VxAutoSuggest_vue_vue_type_style_index_0_lang_scss___WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./VxAutoSuggest.vue?vue&type=style&index=0&lang=scss& */ "./resources/js/src/components/vx-auto-suggest/VxAutoSuggest.vue?vue&type=style&index=0&lang=scss&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");






/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_3__["default"])(
  _VxAutoSuggest_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _VxAutoSuggest_vue_vue_type_template_id_3b23de25___WEBPACK_IMPORTED_MODULE_0__["render"],
  _VxAutoSuggest_vue_vue_type_template_id_3b23de25___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/src/components/vx-auto-suggest/VxAutoSuggest.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/src/components/vx-auto-suggest/VxAutoSuggest.vue?vue&type=script&lang=js&":
/*!************************************************************************************************!*\
  !*** ./resources/js/src/components/vx-auto-suggest/VxAutoSuggest.vue?vue&type=script&lang=js& ***!
  \************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_VxAutoSuggest_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/babel-loader/lib??ref--4-0!../../../../../node_modules/vue-loader/lib??vue-loader-options!./VxAutoSuggest.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/src/components/vx-auto-suggest/VxAutoSuggest.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_VxAutoSuggest_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/src/components/vx-auto-suggest/VxAutoSuggest.vue?vue&type=style&index=0&lang=scss&":
/*!*********************************************************************************************************!*\
  !*** ./resources/js/src/components/vx-auto-suggest/VxAutoSuggest.vue?vue&type=style&index=0&lang=scss& ***!
  \*********************************************************************************************************/
/*! no static exports found */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_style_loader_index_js_node_modules_css_loader_index_js_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_lib_index_js_ref_8_2_node_modules_sass_loader_dist_cjs_js_ref_8_3_node_modules_vue_loader_lib_index_js_vue_loader_options_VxAutoSuggest_vue_vue_type_style_index_0_lang_scss___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/style-loader!../../../../../node_modules/css-loader!../../../../../node_modules/vue-loader/lib/loaders/stylePostLoader.js!../../../../../node_modules/postcss-loader/lib??ref--8-2!../../../../../node_modules/sass-loader/dist/cjs.js??ref--8-3!../../../../../node_modules/vue-loader/lib??vue-loader-options!./VxAutoSuggest.vue?vue&type=style&index=0&lang=scss& */ "./node_modules/style-loader/index.js!./node_modules/css-loader/index.js!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/lib/index.js?!./node_modules/sass-loader/dist/cjs.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/src/components/vx-auto-suggest/VxAutoSuggest.vue?vue&type=style&index=0&lang=scss&");
/* harmony import */ var _node_modules_style_loader_index_js_node_modules_css_loader_index_js_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_lib_index_js_ref_8_2_node_modules_sass_loader_dist_cjs_js_ref_8_3_node_modules_vue_loader_lib_index_js_vue_loader_options_VxAutoSuggest_vue_vue_type_style_index_0_lang_scss___WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_node_modules_style_loader_index_js_node_modules_css_loader_index_js_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_lib_index_js_ref_8_2_node_modules_sass_loader_dist_cjs_js_ref_8_3_node_modules_vue_loader_lib_index_js_vue_loader_options_VxAutoSuggest_vue_vue_type_style_index_0_lang_scss___WEBPACK_IMPORTED_MODULE_0__);
/* harmony reexport (unknown) */ for(var __WEBPACK_IMPORT_KEY__ in _node_modules_style_loader_index_js_node_modules_css_loader_index_js_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_lib_index_js_ref_8_2_node_modules_sass_loader_dist_cjs_js_ref_8_3_node_modules_vue_loader_lib_index_js_vue_loader_options_VxAutoSuggest_vue_vue_type_style_index_0_lang_scss___WEBPACK_IMPORTED_MODULE_0__) if(["default"].indexOf(__WEBPACK_IMPORT_KEY__) < 0) (function(key) { __webpack_require__.d(__webpack_exports__, key, function() { return _node_modules_style_loader_index_js_node_modules_css_loader_index_js_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_lib_index_js_ref_8_2_node_modules_sass_loader_dist_cjs_js_ref_8_3_node_modules_vue_loader_lib_index_js_vue_loader_options_VxAutoSuggest_vue_vue_type_style_index_0_lang_scss___WEBPACK_IMPORTED_MODULE_0__[key]; }) }(__WEBPACK_IMPORT_KEY__));


/***/ }),

/***/ "./resources/js/src/components/vx-auto-suggest/VxAutoSuggest.vue?vue&type=template&id=3b23de25&":
/*!******************************************************************************************************!*\
  !*** ./resources/js/src/components/vx-auto-suggest/VxAutoSuggest.vue?vue&type=template&id=3b23de25& ***!
  \******************************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_VxAutoSuggest_vue_vue_type_template_id_3b23de25___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../../node_modules/vue-loader/lib??vue-loader-options!./VxAutoSuggest.vue?vue&type=template&id=3b23de25& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/src/components/vx-auto-suggest/VxAutoSuggest.vue?vue&type=template&id=3b23de25&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_VxAutoSuggest_vue_vue_type_template_id_3b23de25___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_VxAutoSuggest_vue_vue_type_template_id_3b23de25___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ }),

/***/ "./resources/js/src/layouts/components/AutoLogout.vue":
/*!************************************************************!*\
  !*** ./resources/js/src/layouts/components/AutoLogout.vue ***!
  \************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _AutoLogout_vue_vue_type_template_id_0d07e85a___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./AutoLogout.vue?vue&type=template&id=0d07e85a& */ "./resources/js/src/layouts/components/AutoLogout.vue?vue&type=template&id=0d07e85a&");
/* harmony import */ var _AutoLogout_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./AutoLogout.vue?vue&type=script&lang=js& */ "./resources/js/src/layouts/components/AutoLogout.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport *//* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _AutoLogout_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _AutoLogout_vue_vue_type_template_id_0d07e85a___WEBPACK_IMPORTED_MODULE_0__["render"],
  _AutoLogout_vue_vue_type_template_id_0d07e85a___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/src/layouts/components/AutoLogout.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/src/layouts/components/AutoLogout.vue?vue&type=script&lang=js&":
/*!*************************************************************************************!*\
  !*** ./resources/js/src/layouts/components/AutoLogout.vue?vue&type=script&lang=js& ***!
  \*************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_AutoLogout_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/babel-loader/lib??ref--4-0!../../../../../node_modules/vue-loader/lib??vue-loader-options!./AutoLogout.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/src/layouts/components/AutoLogout.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_AutoLogout_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/src/layouts/components/AutoLogout.vue?vue&type=template&id=0d07e85a&":
/*!*******************************************************************************************!*\
  !*** ./resources/js/src/layouts/components/AutoLogout.vue?vue&type=template&id=0d07e85a& ***!
  \*******************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_AutoLogout_vue_vue_type_template_id_0d07e85a___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../../node_modules/vue-loader/lib??vue-loader-options!./AutoLogout.vue?vue&type=template&id=0d07e85a& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/src/layouts/components/AutoLogout.vue?vue&type=template&id=0d07e85a&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_AutoLogout_vue_vue_type_template_id_0d07e85a___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_AutoLogout_vue_vue_type_template_id_0d07e85a___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ }),

/***/ "./resources/js/src/layouts/components/Logo.vue":
/*!******************************************************!*\
  !*** ./resources/js/src/layouts/components/Logo.vue ***!
  \******************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _Logo_vue_vue_type_template_id_212d79e5___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./Logo.vue?vue&type=template&id=212d79e5& */ "./resources/js/src/layouts/components/Logo.vue?vue&type=template&id=212d79e5&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");

var script = {}


/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_1__["default"])(
  script,
  _Logo_vue_vue_type_template_id_212d79e5___WEBPACK_IMPORTED_MODULE_0__["render"],
  _Logo_vue_vue_type_template_id_212d79e5___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/src/layouts/components/Logo.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/src/layouts/components/Logo.vue?vue&type=template&id=212d79e5&":
/*!*************************************************************************************!*\
  !*** ./resources/js/src/layouts/components/Logo.vue?vue&type=template&id=212d79e5& ***!
  \*************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Logo_vue_vue_type_template_id_212d79e5___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../../node_modules/vue-loader/lib??vue-loader-options!./Logo.vue?vue&type=template&id=212d79e5& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/src/layouts/components/Logo.vue?vue&type=template&id=212d79e5&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Logo_vue_vue_type_template_id_212d79e5___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Logo_vue_vue_type_template_id_212d79e5___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ }),

/***/ "./resources/js/src/layouts/components/MultiDocumentNav.vue":
/*!******************************************************************!*\
  !*** ./resources/js/src/layouts/components/MultiDocumentNav.vue ***!
  \******************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _MultiDocumentNav_vue_vue_type_template_id_56864a49___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./MultiDocumentNav.vue?vue&type=template&id=56864a49& */ "./resources/js/src/layouts/components/MultiDocumentNav.vue?vue&type=template&id=56864a49&");
/* harmony import */ var _MultiDocumentNav_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./MultiDocumentNav.vue?vue&type=script&lang=js& */ "./resources/js/src/layouts/components/MultiDocumentNav.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport *//* harmony import */ var _MultiDocumentNav_vue_vue_type_style_index_0_lang_css___WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./MultiDocumentNav.vue?vue&type=style&index=0&lang=css& */ "./resources/js/src/layouts/components/MultiDocumentNav.vue?vue&type=style&index=0&lang=css&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");






/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_3__["default"])(
  _MultiDocumentNav_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _MultiDocumentNav_vue_vue_type_template_id_56864a49___WEBPACK_IMPORTED_MODULE_0__["render"],
  _MultiDocumentNav_vue_vue_type_template_id_56864a49___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/src/layouts/components/MultiDocumentNav.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/src/layouts/components/MultiDocumentNav.vue?vue&type=script&lang=js&":
/*!*******************************************************************************************!*\
  !*** ./resources/js/src/layouts/components/MultiDocumentNav.vue?vue&type=script&lang=js& ***!
  \*******************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_MultiDocumentNav_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/babel-loader/lib??ref--4-0!../../../../../node_modules/vue-loader/lib??vue-loader-options!./MultiDocumentNav.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/src/layouts/components/MultiDocumentNav.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_MultiDocumentNav_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/src/layouts/components/MultiDocumentNav.vue?vue&type=style&index=0&lang=css&":
/*!***************************************************************************************************!*\
  !*** ./resources/js/src/layouts/components/MultiDocumentNav.vue?vue&type=style&index=0&lang=css& ***!
  \***************************************************************************************************/
/*! no static exports found */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_style_loader_index_js_node_modules_css_loader_index_js_ref_7_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_lib_index_js_ref_7_2_node_modules_vue_loader_lib_index_js_vue_loader_options_MultiDocumentNav_vue_vue_type_style_index_0_lang_css___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/style-loader!../../../../../node_modules/css-loader??ref--7-1!../../../../../node_modules/vue-loader/lib/loaders/stylePostLoader.js!../../../../../node_modules/postcss-loader/lib??ref--7-2!../../../../../node_modules/vue-loader/lib??vue-loader-options!./MultiDocumentNav.vue?vue&type=style&index=0&lang=css& */ "./node_modules/style-loader/index.js!./node_modules/css-loader/index.js?!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/src/layouts/components/MultiDocumentNav.vue?vue&type=style&index=0&lang=css&");
/* harmony import */ var _node_modules_style_loader_index_js_node_modules_css_loader_index_js_ref_7_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_lib_index_js_ref_7_2_node_modules_vue_loader_lib_index_js_vue_loader_options_MultiDocumentNav_vue_vue_type_style_index_0_lang_css___WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_node_modules_style_loader_index_js_node_modules_css_loader_index_js_ref_7_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_lib_index_js_ref_7_2_node_modules_vue_loader_lib_index_js_vue_loader_options_MultiDocumentNav_vue_vue_type_style_index_0_lang_css___WEBPACK_IMPORTED_MODULE_0__);
/* harmony reexport (unknown) */ for(var __WEBPACK_IMPORT_KEY__ in _node_modules_style_loader_index_js_node_modules_css_loader_index_js_ref_7_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_lib_index_js_ref_7_2_node_modules_vue_loader_lib_index_js_vue_loader_options_MultiDocumentNav_vue_vue_type_style_index_0_lang_css___WEBPACK_IMPORTED_MODULE_0__) if(["default"].indexOf(__WEBPACK_IMPORT_KEY__) < 0) (function(key) { __webpack_require__.d(__webpack_exports__, key, function() { return _node_modules_style_loader_index_js_node_modules_css_loader_index_js_ref_7_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_lib_index_js_ref_7_2_node_modules_vue_loader_lib_index_js_vue_loader_options_MultiDocumentNav_vue_vue_type_style_index_0_lang_css___WEBPACK_IMPORTED_MODULE_0__[key]; }) }(__WEBPACK_IMPORT_KEY__));


/***/ }),

/***/ "./resources/js/src/layouts/components/MultiDocumentNav.vue?vue&type=template&id=56864a49&":
/*!*************************************************************************************************!*\
  !*** ./resources/js/src/layouts/components/MultiDocumentNav.vue?vue&type=template&id=56864a49& ***!
  \*************************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_MultiDocumentNav_vue_vue_type_template_id_56864a49___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../../node_modules/vue-loader/lib??vue-loader-options!./MultiDocumentNav.vue?vue&type=template&id=56864a49& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/src/layouts/components/MultiDocumentNav.vue?vue&type=template&id=56864a49&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_MultiDocumentNav_vue_vue_type_template_id_56864a49___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_MultiDocumentNav_vue_vue_type_template_id_56864a49___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ }),

/***/ "./resources/js/src/layouts/components/TheFooter.vue":
/*!***********************************************************!*\
  !*** ./resources/js/src/layouts/components/TheFooter.vue ***!
  \***********************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _TheFooter_vue_vue_type_template_id_287afc22_functional_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./TheFooter.vue?vue&type=template&id=287afc22&functional=true& */ "./resources/js/src/layouts/components/TheFooter.vue?vue&type=template&id=287afc22&functional=true&");
/* harmony import */ var _TheFooter_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./TheFooter.vue?vue&type=script&lang=js& */ "./resources/js/src/layouts/components/TheFooter.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport *//* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _TheFooter_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _TheFooter_vue_vue_type_template_id_287afc22_functional_true___WEBPACK_IMPORTED_MODULE_0__["render"],
  _TheFooter_vue_vue_type_template_id_287afc22_functional_true___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  true,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/src/layouts/components/TheFooter.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/src/layouts/components/TheFooter.vue?vue&type=script&lang=js&":
/*!************************************************************************************!*\
  !*** ./resources/js/src/layouts/components/TheFooter.vue?vue&type=script&lang=js& ***!
  \************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_TheFooter_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/babel-loader/lib??ref--4-0!../../../../../node_modules/vue-loader/lib??vue-loader-options!./TheFooter.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/src/layouts/components/TheFooter.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_TheFooter_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/src/layouts/components/TheFooter.vue?vue&type=template&id=287afc22&functional=true&":
/*!**********************************************************************************************************!*\
  !*** ./resources/js/src/layouts/components/TheFooter.vue?vue&type=template&id=287afc22&functional=true& ***!
  \**********************************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_TheFooter_vue_vue_type_template_id_287afc22_functional_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../../node_modules/vue-loader/lib??vue-loader-options!./TheFooter.vue?vue&type=template&id=287afc22&functional=true& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/src/layouts/components/TheFooter.vue?vue&type=template&id=287afc22&functional=true&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_TheFooter_vue_vue_type_template_id_287afc22_functional_true___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_TheFooter_vue_vue_type_template_id_287afc22_functional_true___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ }),

/***/ "./resources/js/src/layouts/components/horizontal-nav-menu/HorizontalNavMenu.vue":
/*!***************************************************************************************!*\
  !*** ./resources/js/src/layouts/components/horizontal-nav-menu/HorizontalNavMenu.vue ***!
  \***************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _HorizontalNavMenu_vue_vue_type_template_id_24182a17___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./HorizontalNavMenu.vue?vue&type=template&id=24182a17& */ "./resources/js/src/layouts/components/horizontal-nav-menu/HorizontalNavMenu.vue?vue&type=template&id=24182a17&");
/* harmony import */ var _HorizontalNavMenu_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./HorizontalNavMenu.vue?vue&type=script&lang=js& */ "./resources/js/src/layouts/components/horizontal-nav-menu/HorizontalNavMenu.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport *//* harmony import */ var _HorizontalNavMenu_vue_vue_type_style_index_0_lang_scss___WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./HorizontalNavMenu.vue?vue&type=style&index=0&lang=scss& */ "./resources/js/src/layouts/components/horizontal-nav-menu/HorizontalNavMenu.vue?vue&type=style&index=0&lang=scss&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ../../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");






/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_3__["default"])(
  _HorizontalNavMenu_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _HorizontalNavMenu_vue_vue_type_template_id_24182a17___WEBPACK_IMPORTED_MODULE_0__["render"],
  _HorizontalNavMenu_vue_vue_type_template_id_24182a17___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/src/layouts/components/horizontal-nav-menu/HorizontalNavMenu.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/src/layouts/components/horizontal-nav-menu/HorizontalNavMenu.vue?vue&type=script&lang=js&":
/*!****************************************************************************************************************!*\
  !*** ./resources/js/src/layouts/components/horizontal-nav-menu/HorizontalNavMenu.vue?vue&type=script&lang=js& ***!
  \****************************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_HorizontalNavMenu_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../../node_modules/babel-loader/lib??ref--4-0!../../../../../../node_modules/vue-loader/lib??vue-loader-options!./HorizontalNavMenu.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/src/layouts/components/horizontal-nav-menu/HorizontalNavMenu.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_HorizontalNavMenu_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/src/layouts/components/horizontal-nav-menu/HorizontalNavMenu.vue?vue&type=style&index=0&lang=scss&":
/*!*************************************************************************************************************************!*\
  !*** ./resources/js/src/layouts/components/horizontal-nav-menu/HorizontalNavMenu.vue?vue&type=style&index=0&lang=scss& ***!
  \*************************************************************************************************************************/
/*! no static exports found */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_style_loader_index_js_node_modules_css_loader_index_js_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_lib_index_js_ref_8_2_node_modules_sass_loader_dist_cjs_js_ref_8_3_node_modules_vue_loader_lib_index_js_vue_loader_options_HorizontalNavMenu_vue_vue_type_style_index_0_lang_scss___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../../node_modules/style-loader!../../../../../../node_modules/css-loader!../../../../../../node_modules/vue-loader/lib/loaders/stylePostLoader.js!../../../../../../node_modules/postcss-loader/lib??ref--8-2!../../../../../../node_modules/sass-loader/dist/cjs.js??ref--8-3!../../../../../../node_modules/vue-loader/lib??vue-loader-options!./HorizontalNavMenu.vue?vue&type=style&index=0&lang=scss& */ "./node_modules/style-loader/index.js!./node_modules/css-loader/index.js!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/lib/index.js?!./node_modules/sass-loader/dist/cjs.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/src/layouts/components/horizontal-nav-menu/HorizontalNavMenu.vue?vue&type=style&index=0&lang=scss&");
/* harmony import */ var _node_modules_style_loader_index_js_node_modules_css_loader_index_js_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_lib_index_js_ref_8_2_node_modules_sass_loader_dist_cjs_js_ref_8_3_node_modules_vue_loader_lib_index_js_vue_loader_options_HorizontalNavMenu_vue_vue_type_style_index_0_lang_scss___WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_node_modules_style_loader_index_js_node_modules_css_loader_index_js_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_lib_index_js_ref_8_2_node_modules_sass_loader_dist_cjs_js_ref_8_3_node_modules_vue_loader_lib_index_js_vue_loader_options_HorizontalNavMenu_vue_vue_type_style_index_0_lang_scss___WEBPACK_IMPORTED_MODULE_0__);
/* harmony reexport (unknown) */ for(var __WEBPACK_IMPORT_KEY__ in _node_modules_style_loader_index_js_node_modules_css_loader_index_js_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_lib_index_js_ref_8_2_node_modules_sass_loader_dist_cjs_js_ref_8_3_node_modules_vue_loader_lib_index_js_vue_loader_options_HorizontalNavMenu_vue_vue_type_style_index_0_lang_scss___WEBPACK_IMPORTED_MODULE_0__) if(["default"].indexOf(__WEBPACK_IMPORT_KEY__) < 0) (function(key) { __webpack_require__.d(__webpack_exports__, key, function() { return _node_modules_style_loader_index_js_node_modules_css_loader_index_js_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_lib_index_js_ref_8_2_node_modules_sass_loader_dist_cjs_js_ref_8_3_node_modules_vue_loader_lib_index_js_vue_loader_options_HorizontalNavMenu_vue_vue_type_style_index_0_lang_scss___WEBPACK_IMPORTED_MODULE_0__[key]; }) }(__WEBPACK_IMPORT_KEY__));


/***/ }),

/***/ "./resources/js/src/layouts/components/horizontal-nav-menu/HorizontalNavMenu.vue?vue&type=template&id=24182a17&":
/*!**********************************************************************************************************************!*\
  !*** ./resources/js/src/layouts/components/horizontal-nav-menu/HorizontalNavMenu.vue?vue&type=template&id=24182a17& ***!
  \**********************************************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_HorizontalNavMenu_vue_vue_type_template_id_24182a17___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../../../node_modules/vue-loader/lib??vue-loader-options!./HorizontalNavMenu.vue?vue&type=template&id=24182a17& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/src/layouts/components/horizontal-nav-menu/HorizontalNavMenu.vue?vue&type=template&id=24182a17&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_HorizontalNavMenu_vue_vue_type_template_id_24182a17___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_HorizontalNavMenu_vue_vue_type_template_id_24182a17___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ }),

/***/ "./resources/js/src/layouts/components/horizontal-nav-menu/HorizontalNavMenuGroup.vue":
/*!********************************************************************************************!*\
  !*** ./resources/js/src/layouts/components/horizontal-nav-menu/HorizontalNavMenuGroup.vue ***!
  \********************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _HorizontalNavMenuGroup_vue_vue_type_template_id_3d04d158___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./HorizontalNavMenuGroup.vue?vue&type=template&id=3d04d158& */ "./resources/js/src/layouts/components/horizontal-nav-menu/HorizontalNavMenuGroup.vue?vue&type=template&id=3d04d158&");
/* harmony import */ var _HorizontalNavMenuGroup_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./HorizontalNavMenuGroup.vue?vue&type=script&lang=js& */ "./resources/js/src/layouts/components/horizontal-nav-menu/HorizontalNavMenuGroup.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport *//* harmony import */ var _HorizontalNavMenuGroup_vue_vue_type_style_index_0_lang_scss___WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./HorizontalNavMenuGroup.vue?vue&type=style&index=0&lang=scss& */ "./resources/js/src/layouts/components/horizontal-nav-menu/HorizontalNavMenuGroup.vue?vue&type=style&index=0&lang=scss&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ../../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");






/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_3__["default"])(
  _HorizontalNavMenuGroup_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _HorizontalNavMenuGroup_vue_vue_type_template_id_3d04d158___WEBPACK_IMPORTED_MODULE_0__["render"],
  _HorizontalNavMenuGroup_vue_vue_type_template_id_3d04d158___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/src/layouts/components/horizontal-nav-menu/HorizontalNavMenuGroup.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/src/layouts/components/horizontal-nav-menu/HorizontalNavMenuGroup.vue?vue&type=script&lang=js&":
/*!*********************************************************************************************************************!*\
  !*** ./resources/js/src/layouts/components/horizontal-nav-menu/HorizontalNavMenuGroup.vue?vue&type=script&lang=js& ***!
  \*********************************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_HorizontalNavMenuGroup_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../../node_modules/babel-loader/lib??ref--4-0!../../../../../../node_modules/vue-loader/lib??vue-loader-options!./HorizontalNavMenuGroup.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/src/layouts/components/horizontal-nav-menu/HorizontalNavMenuGroup.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_HorizontalNavMenuGroup_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/src/layouts/components/horizontal-nav-menu/HorizontalNavMenuGroup.vue?vue&type=style&index=0&lang=scss&":
/*!******************************************************************************************************************************!*\
  !*** ./resources/js/src/layouts/components/horizontal-nav-menu/HorizontalNavMenuGroup.vue?vue&type=style&index=0&lang=scss& ***!
  \******************************************************************************************************************************/
/*! no static exports found */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_style_loader_index_js_node_modules_css_loader_index_js_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_lib_index_js_ref_8_2_node_modules_sass_loader_dist_cjs_js_ref_8_3_node_modules_vue_loader_lib_index_js_vue_loader_options_HorizontalNavMenuGroup_vue_vue_type_style_index_0_lang_scss___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../../node_modules/style-loader!../../../../../../node_modules/css-loader!../../../../../../node_modules/vue-loader/lib/loaders/stylePostLoader.js!../../../../../../node_modules/postcss-loader/lib??ref--8-2!../../../../../../node_modules/sass-loader/dist/cjs.js??ref--8-3!../../../../../../node_modules/vue-loader/lib??vue-loader-options!./HorizontalNavMenuGroup.vue?vue&type=style&index=0&lang=scss& */ "./node_modules/style-loader/index.js!./node_modules/css-loader/index.js!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/lib/index.js?!./node_modules/sass-loader/dist/cjs.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/src/layouts/components/horizontal-nav-menu/HorizontalNavMenuGroup.vue?vue&type=style&index=0&lang=scss&");
/* harmony import */ var _node_modules_style_loader_index_js_node_modules_css_loader_index_js_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_lib_index_js_ref_8_2_node_modules_sass_loader_dist_cjs_js_ref_8_3_node_modules_vue_loader_lib_index_js_vue_loader_options_HorizontalNavMenuGroup_vue_vue_type_style_index_0_lang_scss___WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_node_modules_style_loader_index_js_node_modules_css_loader_index_js_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_lib_index_js_ref_8_2_node_modules_sass_loader_dist_cjs_js_ref_8_3_node_modules_vue_loader_lib_index_js_vue_loader_options_HorizontalNavMenuGroup_vue_vue_type_style_index_0_lang_scss___WEBPACK_IMPORTED_MODULE_0__);
/* harmony reexport (unknown) */ for(var __WEBPACK_IMPORT_KEY__ in _node_modules_style_loader_index_js_node_modules_css_loader_index_js_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_lib_index_js_ref_8_2_node_modules_sass_loader_dist_cjs_js_ref_8_3_node_modules_vue_loader_lib_index_js_vue_loader_options_HorizontalNavMenuGroup_vue_vue_type_style_index_0_lang_scss___WEBPACK_IMPORTED_MODULE_0__) if(["default"].indexOf(__WEBPACK_IMPORT_KEY__) < 0) (function(key) { __webpack_require__.d(__webpack_exports__, key, function() { return _node_modules_style_loader_index_js_node_modules_css_loader_index_js_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_lib_index_js_ref_8_2_node_modules_sass_loader_dist_cjs_js_ref_8_3_node_modules_vue_loader_lib_index_js_vue_loader_options_HorizontalNavMenuGroup_vue_vue_type_style_index_0_lang_scss___WEBPACK_IMPORTED_MODULE_0__[key]; }) }(__WEBPACK_IMPORT_KEY__));


/***/ }),

/***/ "./resources/js/src/layouts/components/horizontal-nav-menu/HorizontalNavMenuGroup.vue?vue&type=template&id=3d04d158&":
/*!***************************************************************************************************************************!*\
  !*** ./resources/js/src/layouts/components/horizontal-nav-menu/HorizontalNavMenuGroup.vue?vue&type=template&id=3d04d158& ***!
  \***************************************************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_HorizontalNavMenuGroup_vue_vue_type_template_id_3d04d158___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../../../node_modules/vue-loader/lib??vue-loader-options!./HorizontalNavMenuGroup.vue?vue&type=template&id=3d04d158& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/src/layouts/components/horizontal-nav-menu/HorizontalNavMenuGroup.vue?vue&type=template&id=3d04d158&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_HorizontalNavMenuGroup_vue_vue_type_template_id_3d04d158___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_HorizontalNavMenuGroup_vue_vue_type_template_id_3d04d158___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ }),

/***/ "./resources/js/src/layouts/components/horizontal-nav-menu/HorizontalNavMenuHeader.vue":
/*!*********************************************************************************************!*\
  !*** ./resources/js/src/layouts/components/horizontal-nav-menu/HorizontalNavMenuHeader.vue ***!
  \*********************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _HorizontalNavMenuHeader_vue_vue_type_template_id_e0ba01f8___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./HorizontalNavMenuHeader.vue?vue&type=template&id=e0ba01f8& */ "./resources/js/src/layouts/components/horizontal-nav-menu/HorizontalNavMenuHeader.vue?vue&type=template&id=e0ba01f8&");
/* harmony import */ var _HorizontalNavMenuHeader_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./HorizontalNavMenuHeader.vue?vue&type=script&lang=js& */ "./resources/js/src/layouts/components/horizontal-nav-menu/HorizontalNavMenuHeader.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport *//* harmony import */ var _HorizontalNavMenuHeader_vue_vue_type_style_index_0_lang_scss___WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./HorizontalNavMenuHeader.vue?vue&type=style&index=0&lang=scss& */ "./resources/js/src/layouts/components/horizontal-nav-menu/HorizontalNavMenuHeader.vue?vue&type=style&index=0&lang=scss&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ../../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");






/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_3__["default"])(
  _HorizontalNavMenuHeader_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _HorizontalNavMenuHeader_vue_vue_type_template_id_e0ba01f8___WEBPACK_IMPORTED_MODULE_0__["render"],
  _HorizontalNavMenuHeader_vue_vue_type_template_id_e0ba01f8___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/src/layouts/components/horizontal-nav-menu/HorizontalNavMenuHeader.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/src/layouts/components/horizontal-nav-menu/HorizontalNavMenuHeader.vue?vue&type=script&lang=js&":
/*!**********************************************************************************************************************!*\
  !*** ./resources/js/src/layouts/components/horizontal-nav-menu/HorizontalNavMenuHeader.vue?vue&type=script&lang=js& ***!
  \**********************************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_HorizontalNavMenuHeader_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../../node_modules/babel-loader/lib??ref--4-0!../../../../../../node_modules/vue-loader/lib??vue-loader-options!./HorizontalNavMenuHeader.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/src/layouts/components/horizontal-nav-menu/HorizontalNavMenuHeader.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_HorizontalNavMenuHeader_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/src/layouts/components/horizontal-nav-menu/HorizontalNavMenuHeader.vue?vue&type=style&index=0&lang=scss&":
/*!*******************************************************************************************************************************!*\
  !*** ./resources/js/src/layouts/components/horizontal-nav-menu/HorizontalNavMenuHeader.vue?vue&type=style&index=0&lang=scss& ***!
  \*******************************************************************************************************************************/
/*! no static exports found */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_style_loader_index_js_node_modules_css_loader_index_js_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_lib_index_js_ref_8_2_node_modules_sass_loader_dist_cjs_js_ref_8_3_node_modules_vue_loader_lib_index_js_vue_loader_options_HorizontalNavMenuHeader_vue_vue_type_style_index_0_lang_scss___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../../node_modules/style-loader!../../../../../../node_modules/css-loader!../../../../../../node_modules/vue-loader/lib/loaders/stylePostLoader.js!../../../../../../node_modules/postcss-loader/lib??ref--8-2!../../../../../../node_modules/sass-loader/dist/cjs.js??ref--8-3!../../../../../../node_modules/vue-loader/lib??vue-loader-options!./HorizontalNavMenuHeader.vue?vue&type=style&index=0&lang=scss& */ "./node_modules/style-loader/index.js!./node_modules/css-loader/index.js!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/lib/index.js?!./node_modules/sass-loader/dist/cjs.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/src/layouts/components/horizontal-nav-menu/HorizontalNavMenuHeader.vue?vue&type=style&index=0&lang=scss&");
/* harmony import */ var _node_modules_style_loader_index_js_node_modules_css_loader_index_js_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_lib_index_js_ref_8_2_node_modules_sass_loader_dist_cjs_js_ref_8_3_node_modules_vue_loader_lib_index_js_vue_loader_options_HorizontalNavMenuHeader_vue_vue_type_style_index_0_lang_scss___WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_node_modules_style_loader_index_js_node_modules_css_loader_index_js_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_lib_index_js_ref_8_2_node_modules_sass_loader_dist_cjs_js_ref_8_3_node_modules_vue_loader_lib_index_js_vue_loader_options_HorizontalNavMenuHeader_vue_vue_type_style_index_0_lang_scss___WEBPACK_IMPORTED_MODULE_0__);
/* harmony reexport (unknown) */ for(var __WEBPACK_IMPORT_KEY__ in _node_modules_style_loader_index_js_node_modules_css_loader_index_js_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_lib_index_js_ref_8_2_node_modules_sass_loader_dist_cjs_js_ref_8_3_node_modules_vue_loader_lib_index_js_vue_loader_options_HorizontalNavMenuHeader_vue_vue_type_style_index_0_lang_scss___WEBPACK_IMPORTED_MODULE_0__) if(["default"].indexOf(__WEBPACK_IMPORT_KEY__) < 0) (function(key) { __webpack_require__.d(__webpack_exports__, key, function() { return _node_modules_style_loader_index_js_node_modules_css_loader_index_js_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_lib_index_js_ref_8_2_node_modules_sass_loader_dist_cjs_js_ref_8_3_node_modules_vue_loader_lib_index_js_vue_loader_options_HorizontalNavMenuHeader_vue_vue_type_style_index_0_lang_scss___WEBPACK_IMPORTED_MODULE_0__[key]; }) }(__WEBPACK_IMPORT_KEY__));


/***/ }),

/***/ "./resources/js/src/layouts/components/horizontal-nav-menu/HorizontalNavMenuHeader.vue?vue&type=template&id=e0ba01f8&":
/*!****************************************************************************************************************************!*\
  !*** ./resources/js/src/layouts/components/horizontal-nav-menu/HorizontalNavMenuHeader.vue?vue&type=template&id=e0ba01f8& ***!
  \****************************************************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_HorizontalNavMenuHeader_vue_vue_type_template_id_e0ba01f8___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../../../node_modules/vue-loader/lib??vue-loader-options!./HorizontalNavMenuHeader.vue?vue&type=template&id=e0ba01f8& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/src/layouts/components/horizontal-nav-menu/HorizontalNavMenuHeader.vue?vue&type=template&id=e0ba01f8&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_HorizontalNavMenuHeader_vue_vue_type_template_id_e0ba01f8___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_HorizontalNavMenuHeader_vue_vue_type_template_id_e0ba01f8___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ }),

/***/ "./resources/js/src/layouts/components/horizontal-nav-menu/HorizontalNavMenuItem.vue":
/*!*******************************************************************************************!*\
  !*** ./resources/js/src/layouts/components/horizontal-nav-menu/HorizontalNavMenuItem.vue ***!
  \*******************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _HorizontalNavMenuItem_vue_vue_type_template_id_1964704a___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./HorizontalNavMenuItem.vue?vue&type=template&id=1964704a& */ "./resources/js/src/layouts/components/horizontal-nav-menu/HorizontalNavMenuItem.vue?vue&type=template&id=1964704a&");
/* harmony import */ var _HorizontalNavMenuItem_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./HorizontalNavMenuItem.vue?vue&type=script&lang=js& */ "./resources/js/src/layouts/components/horizontal-nav-menu/HorizontalNavMenuItem.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport *//* harmony import */ var _HorizontalNavMenuItem_vue_vue_type_style_index_0_lang_scss___WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./HorizontalNavMenuItem.vue?vue&type=style&index=0&lang=scss& */ "./resources/js/src/layouts/components/horizontal-nav-menu/HorizontalNavMenuItem.vue?vue&type=style&index=0&lang=scss&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ../../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");






/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_3__["default"])(
  _HorizontalNavMenuItem_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _HorizontalNavMenuItem_vue_vue_type_template_id_1964704a___WEBPACK_IMPORTED_MODULE_0__["render"],
  _HorizontalNavMenuItem_vue_vue_type_template_id_1964704a___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/src/layouts/components/horizontal-nav-menu/HorizontalNavMenuItem.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/src/layouts/components/horizontal-nav-menu/HorizontalNavMenuItem.vue?vue&type=script&lang=js&":
/*!********************************************************************************************************************!*\
  !*** ./resources/js/src/layouts/components/horizontal-nav-menu/HorizontalNavMenuItem.vue?vue&type=script&lang=js& ***!
  \********************************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_HorizontalNavMenuItem_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../../node_modules/babel-loader/lib??ref--4-0!../../../../../../node_modules/vue-loader/lib??vue-loader-options!./HorizontalNavMenuItem.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/src/layouts/components/horizontal-nav-menu/HorizontalNavMenuItem.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_HorizontalNavMenuItem_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/src/layouts/components/horizontal-nav-menu/HorizontalNavMenuItem.vue?vue&type=style&index=0&lang=scss&":
/*!*****************************************************************************************************************************!*\
  !*** ./resources/js/src/layouts/components/horizontal-nav-menu/HorizontalNavMenuItem.vue?vue&type=style&index=0&lang=scss& ***!
  \*****************************************************************************************************************************/
/*! no static exports found */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_style_loader_index_js_node_modules_css_loader_index_js_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_lib_index_js_ref_8_2_node_modules_sass_loader_dist_cjs_js_ref_8_3_node_modules_vue_loader_lib_index_js_vue_loader_options_HorizontalNavMenuItem_vue_vue_type_style_index_0_lang_scss___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../../node_modules/style-loader!../../../../../../node_modules/css-loader!../../../../../../node_modules/vue-loader/lib/loaders/stylePostLoader.js!../../../../../../node_modules/postcss-loader/lib??ref--8-2!../../../../../../node_modules/sass-loader/dist/cjs.js??ref--8-3!../../../../../../node_modules/vue-loader/lib??vue-loader-options!./HorizontalNavMenuItem.vue?vue&type=style&index=0&lang=scss& */ "./node_modules/style-loader/index.js!./node_modules/css-loader/index.js!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/lib/index.js?!./node_modules/sass-loader/dist/cjs.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/src/layouts/components/horizontal-nav-menu/HorizontalNavMenuItem.vue?vue&type=style&index=0&lang=scss&");
/* harmony import */ var _node_modules_style_loader_index_js_node_modules_css_loader_index_js_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_lib_index_js_ref_8_2_node_modules_sass_loader_dist_cjs_js_ref_8_3_node_modules_vue_loader_lib_index_js_vue_loader_options_HorizontalNavMenuItem_vue_vue_type_style_index_0_lang_scss___WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_node_modules_style_loader_index_js_node_modules_css_loader_index_js_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_lib_index_js_ref_8_2_node_modules_sass_loader_dist_cjs_js_ref_8_3_node_modules_vue_loader_lib_index_js_vue_loader_options_HorizontalNavMenuItem_vue_vue_type_style_index_0_lang_scss___WEBPACK_IMPORTED_MODULE_0__);
/* harmony reexport (unknown) */ for(var __WEBPACK_IMPORT_KEY__ in _node_modules_style_loader_index_js_node_modules_css_loader_index_js_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_lib_index_js_ref_8_2_node_modules_sass_loader_dist_cjs_js_ref_8_3_node_modules_vue_loader_lib_index_js_vue_loader_options_HorizontalNavMenuItem_vue_vue_type_style_index_0_lang_scss___WEBPACK_IMPORTED_MODULE_0__) if(["default"].indexOf(__WEBPACK_IMPORT_KEY__) < 0) (function(key) { __webpack_require__.d(__webpack_exports__, key, function() { return _node_modules_style_loader_index_js_node_modules_css_loader_index_js_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_lib_index_js_ref_8_2_node_modules_sass_loader_dist_cjs_js_ref_8_3_node_modules_vue_loader_lib_index_js_vue_loader_options_HorizontalNavMenuItem_vue_vue_type_style_index_0_lang_scss___WEBPACK_IMPORTED_MODULE_0__[key]; }) }(__WEBPACK_IMPORT_KEY__));


/***/ }),

/***/ "./resources/js/src/layouts/components/horizontal-nav-menu/HorizontalNavMenuItem.vue?vue&type=template&id=1964704a&":
/*!**************************************************************************************************************************!*\
  !*** ./resources/js/src/layouts/components/horizontal-nav-menu/HorizontalNavMenuItem.vue?vue&type=template&id=1964704a& ***!
  \**************************************************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_HorizontalNavMenuItem_vue_vue_type_template_id_1964704a___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../../../node_modules/vue-loader/lib??vue-loader-options!./HorizontalNavMenuItem.vue?vue&type=template&id=1964704a& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/src/layouts/components/horizontal-nav-menu/HorizontalNavMenuItem.vue?vue&type=template&id=1964704a&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_HorizontalNavMenuItem_vue_vue_type_template_id_1964704a___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_HorizontalNavMenuItem_vue_vue_type_template_id_1964704a___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ }),

/***/ "./resources/js/src/layouts/components/navbar/TheNavbarHorizontal.vue":
/*!****************************************************************************!*\
  !*** ./resources/js/src/layouts/components/navbar/TheNavbarHorizontal.vue ***!
  \****************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _TheNavbarHorizontal_vue_vue_type_template_id_23f1c760___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./TheNavbarHorizontal.vue?vue&type=template&id=23f1c760& */ "./resources/js/src/layouts/components/navbar/TheNavbarHorizontal.vue?vue&type=template&id=23f1c760&");
/* harmony import */ var _TheNavbarHorizontal_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./TheNavbarHorizontal.vue?vue&type=script&lang=js& */ "./resources/js/src/layouts/components/navbar/TheNavbarHorizontal.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport *//* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _TheNavbarHorizontal_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _TheNavbarHorizontal_vue_vue_type_template_id_23f1c760___WEBPACK_IMPORTED_MODULE_0__["render"],
  _TheNavbarHorizontal_vue_vue_type_template_id_23f1c760___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/src/layouts/components/navbar/TheNavbarHorizontal.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/src/layouts/components/navbar/TheNavbarHorizontal.vue?vue&type=script&lang=js&":
/*!*****************************************************************************************************!*\
  !*** ./resources/js/src/layouts/components/navbar/TheNavbarHorizontal.vue?vue&type=script&lang=js& ***!
  \*****************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_TheNavbarHorizontal_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../../node_modules/babel-loader/lib??ref--4-0!../../../../../../node_modules/vue-loader/lib??vue-loader-options!./TheNavbarHorizontal.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/src/layouts/components/navbar/TheNavbarHorizontal.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_TheNavbarHorizontal_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/src/layouts/components/navbar/TheNavbarHorizontal.vue?vue&type=template&id=23f1c760&":
/*!***********************************************************************************************************!*\
  !*** ./resources/js/src/layouts/components/navbar/TheNavbarHorizontal.vue?vue&type=template&id=23f1c760& ***!
  \***********************************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_TheNavbarHorizontal_vue_vue_type_template_id_23f1c760___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../../../node_modules/vue-loader/lib??vue-loader-options!./TheNavbarHorizontal.vue?vue&type=template&id=23f1c760& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/src/layouts/components/navbar/TheNavbarHorizontal.vue?vue&type=template&id=23f1c760&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_TheNavbarHorizontal_vue_vue_type_template_id_23f1c760___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_TheNavbarHorizontal_vue_vue_type_template_id_23f1c760___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ }),

/***/ "./resources/js/src/layouts/components/navbar/TheNavbarVertical.vue":
/*!**************************************************************************!*\
  !*** ./resources/js/src/layouts/components/navbar/TheNavbarVertical.vue ***!
  \**************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _TheNavbarVertical_vue_vue_type_template_id_2c25fa9c___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./TheNavbarVertical.vue?vue&type=template&id=2c25fa9c& */ "./resources/js/src/layouts/components/navbar/TheNavbarVertical.vue?vue&type=template&id=2c25fa9c&");
/* harmony import */ var _TheNavbarVertical_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./TheNavbarVertical.vue?vue&type=script&lang=js& */ "./resources/js/src/layouts/components/navbar/TheNavbarVertical.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport *//* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _TheNavbarVertical_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _TheNavbarVertical_vue_vue_type_template_id_2c25fa9c___WEBPACK_IMPORTED_MODULE_0__["render"],
  _TheNavbarVertical_vue_vue_type_template_id_2c25fa9c___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/src/layouts/components/navbar/TheNavbarVertical.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/src/layouts/components/navbar/TheNavbarVertical.vue?vue&type=script&lang=js&":
/*!***************************************************************************************************!*\
  !*** ./resources/js/src/layouts/components/navbar/TheNavbarVertical.vue?vue&type=script&lang=js& ***!
  \***************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_TheNavbarVertical_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../../node_modules/babel-loader/lib??ref--4-0!../../../../../../node_modules/vue-loader/lib??vue-loader-options!./TheNavbarVertical.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/src/layouts/components/navbar/TheNavbarVertical.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_TheNavbarVertical_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/src/layouts/components/navbar/TheNavbarVertical.vue?vue&type=template&id=2c25fa9c&":
/*!*********************************************************************************************************!*\
  !*** ./resources/js/src/layouts/components/navbar/TheNavbarVertical.vue?vue&type=template&id=2c25fa9c& ***!
  \*********************************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_TheNavbarVertical_vue_vue_type_template_id_2c25fa9c___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../../../node_modules/vue-loader/lib??vue-loader-options!./TheNavbarVertical.vue?vue&type=template&id=2c25fa9c& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/src/layouts/components/navbar/TheNavbarVertical.vue?vue&type=template&id=2c25fa9c&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_TheNavbarVertical_vue_vue_type_template_id_2c25fa9c___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_TheNavbarVertical_vue_vue_type_template_id_2c25fa9c___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ }),

/***/ "./resources/js/src/layouts/components/navbar/components/Bookmarks.vue":
/*!*****************************************************************************!*\
  !*** ./resources/js/src/layouts/components/navbar/components/Bookmarks.vue ***!
  \*****************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _Bookmarks_vue_vue_type_template_id_f0f3dace___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./Bookmarks.vue?vue&type=template&id=f0f3dace& */ "./resources/js/src/layouts/components/navbar/components/Bookmarks.vue?vue&type=template&id=f0f3dace&");
/* harmony import */ var _Bookmarks_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./Bookmarks.vue?vue&type=script&lang=js& */ "./resources/js/src/layouts/components/navbar/components/Bookmarks.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport *//* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _Bookmarks_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _Bookmarks_vue_vue_type_template_id_f0f3dace___WEBPACK_IMPORTED_MODULE_0__["render"],
  _Bookmarks_vue_vue_type_template_id_f0f3dace___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/src/layouts/components/navbar/components/Bookmarks.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/src/layouts/components/navbar/components/Bookmarks.vue?vue&type=script&lang=js&":
/*!******************************************************************************************************!*\
  !*** ./resources/js/src/layouts/components/navbar/components/Bookmarks.vue?vue&type=script&lang=js& ***!
  \******************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Bookmarks_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../../../node_modules/babel-loader/lib??ref--4-0!../../../../../../../node_modules/vue-loader/lib??vue-loader-options!./Bookmarks.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/src/layouts/components/navbar/components/Bookmarks.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Bookmarks_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/src/layouts/components/navbar/components/Bookmarks.vue?vue&type=template&id=f0f3dace&":
/*!************************************************************************************************************!*\
  !*** ./resources/js/src/layouts/components/navbar/components/Bookmarks.vue?vue&type=template&id=f0f3dace& ***!
  \************************************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Bookmarks_vue_vue_type_template_id_f0f3dace___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../../../../node_modules/vue-loader/lib??vue-loader-options!./Bookmarks.vue?vue&type=template&id=f0f3dace& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/src/layouts/components/navbar/components/Bookmarks.vue?vue&type=template&id=f0f3dace&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Bookmarks_vue_vue_type_template_id_f0f3dace___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Bookmarks_vue_vue_type_template_id_f0f3dace___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ }),

/***/ "./resources/js/src/layouts/components/navbar/components/I18n.vue":
/*!************************************************************************!*\
  !*** ./resources/js/src/layouts/components/navbar/components/I18n.vue ***!
  \************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _I18n_vue_vue_type_template_id_7f0786b2___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./I18n.vue?vue&type=template&id=7f0786b2& */ "./resources/js/src/layouts/components/navbar/components/I18n.vue?vue&type=template&id=7f0786b2&");
/* harmony import */ var _I18n_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./I18n.vue?vue&type=script&lang=js& */ "./resources/js/src/layouts/components/navbar/components/I18n.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport *//* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _I18n_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _I18n_vue_vue_type_template_id_7f0786b2___WEBPACK_IMPORTED_MODULE_0__["render"],
  _I18n_vue_vue_type_template_id_7f0786b2___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/src/layouts/components/navbar/components/I18n.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/src/layouts/components/navbar/components/I18n.vue?vue&type=script&lang=js&":
/*!*************************************************************************************************!*\
  !*** ./resources/js/src/layouts/components/navbar/components/I18n.vue?vue&type=script&lang=js& ***!
  \*************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_I18n_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../../../node_modules/babel-loader/lib??ref--4-0!../../../../../../../node_modules/vue-loader/lib??vue-loader-options!./I18n.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/src/layouts/components/navbar/components/I18n.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_I18n_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/src/layouts/components/navbar/components/I18n.vue?vue&type=template&id=7f0786b2&":
/*!*******************************************************************************************************!*\
  !*** ./resources/js/src/layouts/components/navbar/components/I18n.vue?vue&type=template&id=7f0786b2& ***!
  \*******************************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_I18n_vue_vue_type_template_id_7f0786b2___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../../../../node_modules/vue-loader/lib??vue-loader-options!./I18n.vue?vue&type=template&id=7f0786b2& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/src/layouts/components/navbar/components/I18n.vue?vue&type=template&id=7f0786b2&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_I18n_vue_vue_type_template_id_7f0786b2___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_I18n_vue_vue_type_template_id_7f0786b2___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ }),

/***/ "./resources/js/src/layouts/components/navbar/components/NotificationDropDown.vue":
/*!****************************************************************************************!*\
  !*** ./resources/js/src/layouts/components/navbar/components/NotificationDropDown.vue ***!
  \****************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _NotificationDropDown_vue_vue_type_template_id_4a684060___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./NotificationDropDown.vue?vue&type=template&id=4a684060& */ "./resources/js/src/layouts/components/navbar/components/NotificationDropDown.vue?vue&type=template&id=4a684060&");
/* harmony import */ var _NotificationDropDown_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./NotificationDropDown.vue?vue&type=script&lang=js& */ "./resources/js/src/layouts/components/navbar/components/NotificationDropDown.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport *//* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _NotificationDropDown_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _NotificationDropDown_vue_vue_type_template_id_4a684060___WEBPACK_IMPORTED_MODULE_0__["render"],
  _NotificationDropDown_vue_vue_type_template_id_4a684060___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/src/layouts/components/navbar/components/NotificationDropDown.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/src/layouts/components/navbar/components/NotificationDropDown.vue?vue&type=script&lang=js&":
/*!*****************************************************************************************************************!*\
  !*** ./resources/js/src/layouts/components/navbar/components/NotificationDropDown.vue?vue&type=script&lang=js& ***!
  \*****************************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_NotificationDropDown_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../../../node_modules/babel-loader/lib??ref--4-0!../../../../../../../node_modules/vue-loader/lib??vue-loader-options!./NotificationDropDown.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/src/layouts/components/navbar/components/NotificationDropDown.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_NotificationDropDown_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/src/layouts/components/navbar/components/NotificationDropDown.vue?vue&type=template&id=4a684060&":
/*!***********************************************************************************************************************!*\
  !*** ./resources/js/src/layouts/components/navbar/components/NotificationDropDown.vue?vue&type=template&id=4a684060& ***!
  \***********************************************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_NotificationDropDown_vue_vue_type_template_id_4a684060___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../../../../node_modules/vue-loader/lib??vue-loader-options!./NotificationDropDown.vue?vue&type=template&id=4a684060& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/src/layouts/components/navbar/components/NotificationDropDown.vue?vue&type=template&id=4a684060&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_NotificationDropDown_vue_vue_type_template_id_4a684060___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_NotificationDropDown_vue_vue_type_template_id_4a684060___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ }),

/***/ "./resources/js/src/layouts/components/navbar/components/ProfileDropDown.vue":
/*!***********************************************************************************!*\
  !*** ./resources/js/src/layouts/components/navbar/components/ProfileDropDown.vue ***!
  \***********************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _ProfileDropDown_vue_vue_type_template_id_3a9ac416___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./ProfileDropDown.vue?vue&type=template&id=3a9ac416& */ "./resources/js/src/layouts/components/navbar/components/ProfileDropDown.vue?vue&type=template&id=3a9ac416&");
/* harmony import */ var _ProfileDropDown_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./ProfileDropDown.vue?vue&type=script&lang=js& */ "./resources/js/src/layouts/components/navbar/components/ProfileDropDown.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport *//* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _ProfileDropDown_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _ProfileDropDown_vue_vue_type_template_id_3a9ac416___WEBPACK_IMPORTED_MODULE_0__["render"],
  _ProfileDropDown_vue_vue_type_template_id_3a9ac416___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/src/layouts/components/navbar/components/ProfileDropDown.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/src/layouts/components/navbar/components/ProfileDropDown.vue?vue&type=script&lang=js&":
/*!************************************************************************************************************!*\
  !*** ./resources/js/src/layouts/components/navbar/components/ProfileDropDown.vue?vue&type=script&lang=js& ***!
  \************************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_ProfileDropDown_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../../../node_modules/babel-loader/lib??ref--4-0!../../../../../../../node_modules/vue-loader/lib??vue-loader-options!./ProfileDropDown.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/src/layouts/components/navbar/components/ProfileDropDown.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_ProfileDropDown_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/src/layouts/components/navbar/components/ProfileDropDown.vue?vue&type=template&id=3a9ac416&":
/*!******************************************************************************************************************!*\
  !*** ./resources/js/src/layouts/components/navbar/components/ProfileDropDown.vue?vue&type=template&id=3a9ac416& ***!
  \******************************************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_ProfileDropDown_vue_vue_type_template_id_3a9ac416___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../../../../node_modules/vue-loader/lib??vue-loader-options!./ProfileDropDown.vue?vue&type=template&id=3a9ac416& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/src/layouts/components/navbar/components/ProfileDropDown.vue?vue&type=template&id=3a9ac416&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_ProfileDropDown_vue_vue_type_template_id_3a9ac416___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_ProfileDropDown_vue_vue_type_template_id_3a9ac416___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ }),

/***/ "./resources/js/src/layouts/components/navbar/components/SearchBar.vue":
/*!*****************************************************************************!*\
  !*** ./resources/js/src/layouts/components/navbar/components/SearchBar.vue ***!
  \*****************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _SearchBar_vue_vue_type_template_id_aa08d232___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./SearchBar.vue?vue&type=template&id=aa08d232& */ "./resources/js/src/layouts/components/navbar/components/SearchBar.vue?vue&type=template&id=aa08d232&");
/* harmony import */ var _SearchBar_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./SearchBar.vue?vue&type=script&lang=js& */ "./resources/js/src/layouts/components/navbar/components/SearchBar.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport *//* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _SearchBar_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _SearchBar_vue_vue_type_template_id_aa08d232___WEBPACK_IMPORTED_MODULE_0__["render"],
  _SearchBar_vue_vue_type_template_id_aa08d232___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/src/layouts/components/navbar/components/SearchBar.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/src/layouts/components/navbar/components/SearchBar.vue?vue&type=script&lang=js&":
/*!******************************************************************************************************!*\
  !*** ./resources/js/src/layouts/components/navbar/components/SearchBar.vue?vue&type=script&lang=js& ***!
  \******************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_SearchBar_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../../../node_modules/babel-loader/lib??ref--4-0!../../../../../../../node_modules/vue-loader/lib??vue-loader-options!./SearchBar.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/src/layouts/components/navbar/components/SearchBar.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_SearchBar_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/src/layouts/components/navbar/components/SearchBar.vue?vue&type=template&id=aa08d232&":
/*!************************************************************************************************************!*\
  !*** ./resources/js/src/layouts/components/navbar/components/SearchBar.vue?vue&type=template&id=aa08d232& ***!
  \************************************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_SearchBar_vue_vue_type_template_id_aa08d232___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../../../../node_modules/vue-loader/lib??vue-loader-options!./SearchBar.vue?vue&type=template&id=aa08d232& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/src/layouts/components/navbar/components/SearchBar.vue?vue&type=template&id=aa08d232&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_SearchBar_vue_vue_type_template_id_aa08d232___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_SearchBar_vue_vue_type_template_id_aa08d232___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ }),

/***/ "./resources/js/src/layouts/components/vertical-nav-menu/VerticalNavMenu.vue":
/*!***********************************************************************************!*\
  !*** ./resources/js/src/layouts/components/vertical-nav-menu/VerticalNavMenu.vue ***!
  \***********************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _VerticalNavMenu_vue_vue_type_template_id_667d9133___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./VerticalNavMenu.vue?vue&type=template&id=667d9133& */ "./resources/js/src/layouts/components/vertical-nav-menu/VerticalNavMenu.vue?vue&type=template&id=667d9133&");
/* harmony import */ var _VerticalNavMenu_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./VerticalNavMenu.vue?vue&type=script&lang=js& */ "./resources/js/src/layouts/components/vertical-nav-menu/VerticalNavMenu.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport *//* harmony import */ var _VerticalNavMenu_vue_vue_type_style_index_0_lang_scss___WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./VerticalNavMenu.vue?vue&type=style&index=0&lang=scss& */ "./resources/js/src/layouts/components/vertical-nav-menu/VerticalNavMenu.vue?vue&type=style&index=0&lang=scss&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ../../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");






/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_3__["default"])(
  _VerticalNavMenu_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _VerticalNavMenu_vue_vue_type_template_id_667d9133___WEBPACK_IMPORTED_MODULE_0__["render"],
  _VerticalNavMenu_vue_vue_type_template_id_667d9133___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/src/layouts/components/vertical-nav-menu/VerticalNavMenu.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/src/layouts/components/vertical-nav-menu/VerticalNavMenu.vue?vue&type=script&lang=js&":
/*!************************************************************************************************************!*\
  !*** ./resources/js/src/layouts/components/vertical-nav-menu/VerticalNavMenu.vue?vue&type=script&lang=js& ***!
  \************************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_VerticalNavMenu_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../../node_modules/babel-loader/lib??ref--4-0!../../../../../../node_modules/vue-loader/lib??vue-loader-options!./VerticalNavMenu.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/src/layouts/components/vertical-nav-menu/VerticalNavMenu.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_VerticalNavMenu_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/src/layouts/components/vertical-nav-menu/VerticalNavMenu.vue?vue&type=style&index=0&lang=scss&":
/*!*********************************************************************************************************************!*\
  !*** ./resources/js/src/layouts/components/vertical-nav-menu/VerticalNavMenu.vue?vue&type=style&index=0&lang=scss& ***!
  \*********************************************************************************************************************/
/*! no static exports found */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_style_loader_index_js_node_modules_css_loader_index_js_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_lib_index_js_ref_8_2_node_modules_sass_loader_dist_cjs_js_ref_8_3_node_modules_vue_loader_lib_index_js_vue_loader_options_VerticalNavMenu_vue_vue_type_style_index_0_lang_scss___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../../node_modules/style-loader!../../../../../../node_modules/css-loader!../../../../../../node_modules/vue-loader/lib/loaders/stylePostLoader.js!../../../../../../node_modules/postcss-loader/lib??ref--8-2!../../../../../../node_modules/sass-loader/dist/cjs.js??ref--8-3!../../../../../../node_modules/vue-loader/lib??vue-loader-options!./VerticalNavMenu.vue?vue&type=style&index=0&lang=scss& */ "./node_modules/style-loader/index.js!./node_modules/css-loader/index.js!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/lib/index.js?!./node_modules/sass-loader/dist/cjs.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/src/layouts/components/vertical-nav-menu/VerticalNavMenu.vue?vue&type=style&index=0&lang=scss&");
/* harmony import */ var _node_modules_style_loader_index_js_node_modules_css_loader_index_js_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_lib_index_js_ref_8_2_node_modules_sass_loader_dist_cjs_js_ref_8_3_node_modules_vue_loader_lib_index_js_vue_loader_options_VerticalNavMenu_vue_vue_type_style_index_0_lang_scss___WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_node_modules_style_loader_index_js_node_modules_css_loader_index_js_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_lib_index_js_ref_8_2_node_modules_sass_loader_dist_cjs_js_ref_8_3_node_modules_vue_loader_lib_index_js_vue_loader_options_VerticalNavMenu_vue_vue_type_style_index_0_lang_scss___WEBPACK_IMPORTED_MODULE_0__);
/* harmony reexport (unknown) */ for(var __WEBPACK_IMPORT_KEY__ in _node_modules_style_loader_index_js_node_modules_css_loader_index_js_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_lib_index_js_ref_8_2_node_modules_sass_loader_dist_cjs_js_ref_8_3_node_modules_vue_loader_lib_index_js_vue_loader_options_VerticalNavMenu_vue_vue_type_style_index_0_lang_scss___WEBPACK_IMPORTED_MODULE_0__) if(["default"].indexOf(__WEBPACK_IMPORT_KEY__) < 0) (function(key) { __webpack_require__.d(__webpack_exports__, key, function() { return _node_modules_style_loader_index_js_node_modules_css_loader_index_js_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_lib_index_js_ref_8_2_node_modules_sass_loader_dist_cjs_js_ref_8_3_node_modules_vue_loader_lib_index_js_vue_loader_options_VerticalNavMenu_vue_vue_type_style_index_0_lang_scss___WEBPACK_IMPORTED_MODULE_0__[key]; }) }(__WEBPACK_IMPORT_KEY__));


/***/ }),

/***/ "./resources/js/src/layouts/components/vertical-nav-menu/VerticalNavMenu.vue?vue&type=template&id=667d9133&":
/*!******************************************************************************************************************!*\
  !*** ./resources/js/src/layouts/components/vertical-nav-menu/VerticalNavMenu.vue?vue&type=template&id=667d9133& ***!
  \******************************************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_VerticalNavMenu_vue_vue_type_template_id_667d9133___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../../../node_modules/vue-loader/lib??vue-loader-options!./VerticalNavMenu.vue?vue&type=template&id=667d9133& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/src/layouts/components/vertical-nav-menu/VerticalNavMenu.vue?vue&type=template&id=667d9133&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_VerticalNavMenu_vue_vue_type_template_id_667d9133___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_VerticalNavMenu_vue_vue_type_template_id_667d9133___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ }),

/***/ "./resources/js/src/layouts/components/vertical-nav-menu/VerticalNavMenuGroup.vue":
/*!****************************************************************************************!*\
  !*** ./resources/js/src/layouts/components/vertical-nav-menu/VerticalNavMenuGroup.vue ***!
  \****************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _VerticalNavMenuGroup_vue_vue_type_template_id_b6a10888___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./VerticalNavMenuGroup.vue?vue&type=template&id=b6a10888& */ "./resources/js/src/layouts/components/vertical-nav-menu/VerticalNavMenuGroup.vue?vue&type=template&id=b6a10888&");
/* harmony import */ var _VerticalNavMenuGroup_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./VerticalNavMenuGroup.vue?vue&type=script&lang=js& */ "./resources/js/src/layouts/components/vertical-nav-menu/VerticalNavMenuGroup.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport *//* harmony import */ var _VerticalNavMenuGroup_vue_vue_type_style_index_0_lang_scss___WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./VerticalNavMenuGroup.vue?vue&type=style&index=0&lang=scss& */ "./resources/js/src/layouts/components/vertical-nav-menu/VerticalNavMenuGroup.vue?vue&type=style&index=0&lang=scss&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ../../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");






/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_3__["default"])(
  _VerticalNavMenuGroup_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _VerticalNavMenuGroup_vue_vue_type_template_id_b6a10888___WEBPACK_IMPORTED_MODULE_0__["render"],
  _VerticalNavMenuGroup_vue_vue_type_template_id_b6a10888___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/src/layouts/components/vertical-nav-menu/VerticalNavMenuGroup.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/src/layouts/components/vertical-nav-menu/VerticalNavMenuGroup.vue?vue&type=script&lang=js&":
/*!*****************************************************************************************************************!*\
  !*** ./resources/js/src/layouts/components/vertical-nav-menu/VerticalNavMenuGroup.vue?vue&type=script&lang=js& ***!
  \*****************************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_VerticalNavMenuGroup_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../../node_modules/babel-loader/lib??ref--4-0!../../../../../../node_modules/vue-loader/lib??vue-loader-options!./VerticalNavMenuGroup.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/src/layouts/components/vertical-nav-menu/VerticalNavMenuGroup.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_VerticalNavMenuGroup_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/src/layouts/components/vertical-nav-menu/VerticalNavMenuGroup.vue?vue&type=style&index=0&lang=scss&":
/*!**************************************************************************************************************************!*\
  !*** ./resources/js/src/layouts/components/vertical-nav-menu/VerticalNavMenuGroup.vue?vue&type=style&index=0&lang=scss& ***!
  \**************************************************************************************************************************/
/*! no static exports found */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_style_loader_index_js_node_modules_css_loader_index_js_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_lib_index_js_ref_8_2_node_modules_sass_loader_dist_cjs_js_ref_8_3_node_modules_vue_loader_lib_index_js_vue_loader_options_VerticalNavMenuGroup_vue_vue_type_style_index_0_lang_scss___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../../node_modules/style-loader!../../../../../../node_modules/css-loader!../../../../../../node_modules/vue-loader/lib/loaders/stylePostLoader.js!../../../../../../node_modules/postcss-loader/lib??ref--8-2!../../../../../../node_modules/sass-loader/dist/cjs.js??ref--8-3!../../../../../../node_modules/vue-loader/lib??vue-loader-options!./VerticalNavMenuGroup.vue?vue&type=style&index=0&lang=scss& */ "./node_modules/style-loader/index.js!./node_modules/css-loader/index.js!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/lib/index.js?!./node_modules/sass-loader/dist/cjs.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/src/layouts/components/vertical-nav-menu/VerticalNavMenuGroup.vue?vue&type=style&index=0&lang=scss&");
/* harmony import */ var _node_modules_style_loader_index_js_node_modules_css_loader_index_js_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_lib_index_js_ref_8_2_node_modules_sass_loader_dist_cjs_js_ref_8_3_node_modules_vue_loader_lib_index_js_vue_loader_options_VerticalNavMenuGroup_vue_vue_type_style_index_0_lang_scss___WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_node_modules_style_loader_index_js_node_modules_css_loader_index_js_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_lib_index_js_ref_8_2_node_modules_sass_loader_dist_cjs_js_ref_8_3_node_modules_vue_loader_lib_index_js_vue_loader_options_VerticalNavMenuGroup_vue_vue_type_style_index_0_lang_scss___WEBPACK_IMPORTED_MODULE_0__);
/* harmony reexport (unknown) */ for(var __WEBPACK_IMPORT_KEY__ in _node_modules_style_loader_index_js_node_modules_css_loader_index_js_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_lib_index_js_ref_8_2_node_modules_sass_loader_dist_cjs_js_ref_8_3_node_modules_vue_loader_lib_index_js_vue_loader_options_VerticalNavMenuGroup_vue_vue_type_style_index_0_lang_scss___WEBPACK_IMPORTED_MODULE_0__) if(["default"].indexOf(__WEBPACK_IMPORT_KEY__) < 0) (function(key) { __webpack_require__.d(__webpack_exports__, key, function() { return _node_modules_style_loader_index_js_node_modules_css_loader_index_js_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_lib_index_js_ref_8_2_node_modules_sass_loader_dist_cjs_js_ref_8_3_node_modules_vue_loader_lib_index_js_vue_loader_options_VerticalNavMenuGroup_vue_vue_type_style_index_0_lang_scss___WEBPACK_IMPORTED_MODULE_0__[key]; }) }(__WEBPACK_IMPORT_KEY__));


/***/ }),

/***/ "./resources/js/src/layouts/components/vertical-nav-menu/VerticalNavMenuGroup.vue?vue&type=template&id=b6a10888&":
/*!***********************************************************************************************************************!*\
  !*** ./resources/js/src/layouts/components/vertical-nav-menu/VerticalNavMenuGroup.vue?vue&type=template&id=b6a10888& ***!
  \***********************************************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_VerticalNavMenuGroup_vue_vue_type_template_id_b6a10888___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../../../node_modules/vue-loader/lib??vue-loader-options!./VerticalNavMenuGroup.vue?vue&type=template&id=b6a10888& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/src/layouts/components/vertical-nav-menu/VerticalNavMenuGroup.vue?vue&type=template&id=b6a10888&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_VerticalNavMenuGroup_vue_vue_type_template_id_b6a10888___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_VerticalNavMenuGroup_vue_vue_type_template_id_b6a10888___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ }),

/***/ "./resources/js/src/layouts/components/vertical-nav-menu/VerticalNavMenuItem.vue":
/*!***************************************************************************************!*\
  !*** ./resources/js/src/layouts/components/vertical-nav-menu/VerticalNavMenuItem.vue ***!
  \***************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _VerticalNavMenuItem_vue_vue_type_template_id_4e48e966___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./VerticalNavMenuItem.vue?vue&type=template&id=4e48e966& */ "./resources/js/src/layouts/components/vertical-nav-menu/VerticalNavMenuItem.vue?vue&type=template&id=4e48e966&");
/* harmony import */ var _VerticalNavMenuItem_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./VerticalNavMenuItem.vue?vue&type=script&lang=js& */ "./resources/js/src/layouts/components/vertical-nav-menu/VerticalNavMenuItem.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport *//* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _VerticalNavMenuItem_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _VerticalNavMenuItem_vue_vue_type_template_id_4e48e966___WEBPACK_IMPORTED_MODULE_0__["render"],
  _VerticalNavMenuItem_vue_vue_type_template_id_4e48e966___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/src/layouts/components/vertical-nav-menu/VerticalNavMenuItem.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/src/layouts/components/vertical-nav-menu/VerticalNavMenuItem.vue?vue&type=script&lang=js&":
/*!****************************************************************************************************************!*\
  !*** ./resources/js/src/layouts/components/vertical-nav-menu/VerticalNavMenuItem.vue?vue&type=script&lang=js& ***!
  \****************************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_VerticalNavMenuItem_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../../node_modules/babel-loader/lib??ref--4-0!../../../../../../node_modules/vue-loader/lib??vue-loader-options!./VerticalNavMenuItem.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/src/layouts/components/vertical-nav-menu/VerticalNavMenuItem.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_VerticalNavMenuItem_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/src/layouts/components/vertical-nav-menu/VerticalNavMenuItem.vue?vue&type=template&id=4e48e966&":
/*!**********************************************************************************************************************!*\
  !*** ./resources/js/src/layouts/components/vertical-nav-menu/VerticalNavMenuItem.vue?vue&type=template&id=4e48e966& ***!
  \**********************************************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_VerticalNavMenuItem_vue_vue_type_template_id_4e48e966___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../../../node_modules/vue-loader/lib??vue-loader-options!./VerticalNavMenuItem.vue?vue&type=template&id=4e48e966& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/src/layouts/components/vertical-nav-menu/VerticalNavMenuItem.vue?vue&type=template&id=4e48e966&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_VerticalNavMenuItem_vue_vue_type_template_id_4e48e966___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_VerticalNavMenuItem_vue_vue_type_template_id_4e48e966___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ }),

/***/ "./resources/js/src/layouts/components/vertical-nav-menu/navMenuItems.js":
/*!*******************************************************************************!*\
  !*** ./resources/js/src/layouts/components/vertical-nav-menu/navMenuItems.js ***!
  \*******************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/*=========================================================================================
  File Name: sidebarItems.js
  Description: Sidebar Items list. Add / Remove menu items from here.
  Strucutre:
          url     => router path
          name    => name to display in sidebar
          slug    => router path name
          icon    => Feather Icon component/icon name
          tag     => text to display on badge
          tagColor  => class to apply on badge element
          i18n    => Internationalization
          submenu   => submenu of current item (current item will become dropdown )
                NOTE: Submenu don't have any icon(you can add icon if u want to display)
          isDisabled  => disable sidebar item/group
  ----------------------------------------------------------------------------------------
  Item Name: Vuexy - Vuejs, HTML & Laravel Admin Dashboard Template
  Author: Pixinvent
  Author URL: http://www.themeforest.net/user/pixinvent
==========================================================================================*/
/* harmony default export */ __webpack_exports__["default"] = ([{
  url: "/1",
  name: "정보관리",
  slug: "정보관리",
  showSubmenuOn: '/1',
  submenu: [{
    url: "/1/1",
    name: "회사정보등록",
    slug: "회사정보등록",
    showSubmenuOn: '/1'
  }, {
    url: "/1/2",
    name: "HACCP담당자 관리",
    slug: "HACCP담당자 관리",
    showSubmenuOn: '/1'
  }, {
    url: "/1/3",
    name: "생산담당자 관리",
    slug: "생산담당자 관리",
    showSubmenuOn: '/1'
  }, {
    url: "/1/4",
    name: "HACCP서류등록",
    slug: "HACCP서류등록",
    showSubmenuOn: '/1',
    submenu: [{
      url: "/1/4/1",
      name: "HACCP 기준서 등록",
      slug: "HACCP 기준서 등록",
      showSubmenuOn: '/1'
    }, {
      url: "/1/4/2",
      name: "식품위생서류 등록",
      slug: "식품위생서류 등록",
      showSubmenuOn: '/1'
    }, {
      url: "/1/4/3",
      name: "HACCP 이행점검표",
      slug: "HACCP 이행점검표",
      showSubmenuOn: '/1'
    }]
  }, {
    url: "/1/5",
    name: "원/부자재 기준",
    slug: "원/부자재 기준",
    showSubmenuOn: '/1',
    submenu: [{
      url: "/1/5/1",
      name: "가공원료 기준등록",
      slug: "가공원료 기준등록",
      showSubmenuOn: '/1'
    }, {
      url: "/1/5/2",
      name: "원료 기준등록",
      slug: "원료 기준등록",
      showSubmenuOn: '/1'
    }, {
      url: "/1/5/3",
      name: "부자재 기준등록",
      slug: "부자재 기준등록",
      showSubmenuOn: '/1'
    }]
  }, {
    url: "/1/6",
    name: "원/부자재 관리",
    slug: "원/부자재 관리",
    showSubmenuOn: '/1'
  }, {
    url: "/1/7",
    name: "BOM 관리",
    slug: "BOM 관리",
    showSubmenuOn: '/1'
  }, {
    url: "/1/8",
    name: "공정순서관리",
    slug: "공정순서관리",
    showSubmenuOn: '/1',
    submenu: [{
      url: "/1/8/1",
      name: "전처리공정등록",
      slug: "전처리공정등록",
      showSubmenuOn: '/1'
    }, {
      url: "/1/8/2",
      name: "제조공정등록",
      slug: "제조공정등록",
      showSubmenuOn: '/1'
    }]
  }, {
    url: "/1/9",
    name: "구매기업정보등록",
    slug: "구매기업정보등록",
    showSubmenuOn: '/1'
  }, {
    url: "/1/10",
    name: "납품기업정보등록",
    slug: "납품기업정보등록",
    showSubmenuOn: '/1'
  }, {
    url: "/1/11",
    name: "정보보호관리",
    slug: "정보보호관리",
    showSubmenuOn: '/1'
  }]
}, {
  url: "/2",
  name: "구매관리",
  slug: "구매관리",
  showSubmenuOn: '/2',
  submenu: [{
    url: "/2/1",
    name: "원료재고관리",
    slug: "원료재고관리",
    showSubmenuOn: '/2'
  }, {
    url: "/2/2",
    name: "부자재재고관리",
    slug: "부자재재고관리",
    showSubmenuOn: '/2'
  }, {
    url: "/2/3",
    name: "구매관리",
    slug: "구매관리",
    showSubmenuOn: '/2'
  }, {
    url: "/2/4",
    name: "입고관리",
    slug: "입고관리",
    showSubmenuOn: '/2'
  }, {
    url: "/2/5",
    name: "재고이력관리",
    slug: "재고이력관리",
    showSubmenuOn: '/2',
    submenu: [{
      url: "/2/5/1",
      name: "(가공)원료재고이력",
      slug: "(가공)원료재고이력",
      showSubmenuOn: '/2'
    }, {
      url: "/2/5/2",
      name: "부자재 재고이력",
      slug: "부자재 재고이력",
      showSubmenuOn: '/2'
    }]
  }]
}, {
  url: "/3",
  name: "주문처리",
  slug: "주문처리",
  showSubmenuOn: '/3',
  submenu: [{
    url: "/3/1",
    name: "B2B 주문처리",
    slug: "B2B 주문처리",
    showSubmenuOn: '/3'
  }, {
    url: "/3/2",
    name: "B2C 주문처리",
    slug: "B2C 주문처리",
    showSubmenuOn: '/3'
  }]
}, {
  url: "/4",
  name: "생산관리",
  slug: "생산관리",
  showSubmenuOn: '/4',
  submenu: [{
    url: "/4/1",
    name: "당일생산리스트",
    slug: "당일생산리스트",
    showSubmenuOn: '/4'
  }, {
    url: "/4/2",
    name: "원부자재출고",
    slug: "원부자재출고",
    showSubmenuOn: '/4'
  }, {
    url: "/4/3",
    name: "제조사원업무등록",
    slug: "제조사원업무등록",
    showSubmenuOn: '/4'
  }, {
    url: "/4/4",
    name: "사원별업무투입현황",
    slug: "사원별업무투입현황",
    showSubmenuOn: '/4'
  }]
}, {
  url: "/5",
  name: "출하관리",
  slug: "출하관리",
  showSubmenuOn: '/5',
  submenu: [{
    url: "/5/1",
    name: "제품재고현황",
    slug: "제품재고현황",
    showSubmenuOn: '/5'
  }, {
    url: "/5/2",
    name: "출하관리",
    slug: "출하관리",
    showSubmenuOn: '/5'
  }]
}, {
  url: "/6",
  name: "HACCP모니터링",
  slug: "HACCP모니터링",
  showSubmenuOn: '/6',
  submenu: [{
    url: "/6/1",
    name: "HACCP이행점검표",
    slug: "HACCP이행점검표",
    showSubmenuOn: '/6'
  }, {
    url: "/6/2",
    name: "CCP 모니터링",
    slug: "CCP 모니터링",
    showSubmenuOn: '/6'
  }, {
    url: "/6/3",
    name: "CCP이탈관리",
    slug: "CCP이탈관리",
    showSubmenuOn: '/6'
  }, {
    url: "/6/4",
    name: "CCP모니터링정보",
    slug: "CCP모니터링정보",
    showSubmenuOn: '/6'
  }, {
    url: "/6/5",
    name: "선행기준이탈관리",
    slug: "선행기준이탈관리",
    showSubmenuOn: '/6'
  }, {
    url: "/6/6",
    name: "제품이력관리",
    slug: "제품이력관리",
    showSubmenuOn: '/6'
  }, {
    url: "/6/7",
    name: "시험검사관리",
    slug: "시험검사관리",
    showSubmenuOn: '/6'
  }, {
    url: "/6/8",
    name: "KPI관리",
    slug: "KPI관리",
    showSubmenuOn: '/6'
  }]
}, {
  url: "/7",
  name: "자료관리",
  slug: "자료관리",
  showSubmenuOn: '/7',
  submenu: [{
    url: "/7/1",
    name: "공통코드 관리",
    slug: "공통코드 관리",
    showSubmenuOn: '/7'
  }, {
    url: "/7/2",
    name: "프로그램권한 권리",
    slug: "프로그램권한 권리",
    showSubmenuOn: '/7'
  }, {
    url: "/7/3",
    name: "A Management",
    slug: "A Management",
    showSubmenuOn: '/7'
  }, {
    url: "/7/4",
    name: "B Management",
    slug: "B Management",
    showSubmenuOn: '/7'
  }]
}, {
  url: "/profile",
  name: "Profile",
  slug: "Profile",
  showSubmenuOn: '/profile',
  hideMenu: true,
  submenu: [{
    url: "/profile/general",
    name: "Profile General",
    slug: "Profile General",
    showSubmenuOn: '/profile'
  }, {
    url: "/profile/password",
    name: "Change Password",
    slug: "Change Password",
    showSubmenuOn: '/profile'
  }]
}]);

/***/ }),

/***/ "./resources/js/src/layouts/main/Main.vue":
/*!************************************************!*\
  !*** ./resources/js/src/layouts/main/Main.vue ***!
  \************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _Main_vue_vue_type_template_id_22fa5a70___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./Main.vue?vue&type=template&id=22fa5a70& */ "./resources/js/src/layouts/main/Main.vue?vue&type=template&id=22fa5a70&");
/* harmony import */ var _Main_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./Main.vue?vue&type=script&lang=js& */ "./resources/js/src/layouts/main/Main.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport *//* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _Main_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _Main_vue_vue_type_template_id_22fa5a70___WEBPACK_IMPORTED_MODULE_0__["render"],
  _Main_vue_vue_type_template_id_22fa5a70___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/src/layouts/main/Main.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/src/layouts/main/Main.vue?vue&type=script&lang=js&":
/*!*************************************************************************!*\
  !*** ./resources/js/src/layouts/main/Main.vue?vue&type=script&lang=js& ***!
  \*************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Main_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/babel-loader/lib??ref--4-0!../../../../../node_modules/vue-loader/lib??vue-loader-options!./Main.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/src/layouts/main/Main.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Main_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/src/layouts/main/Main.vue?vue&type=template&id=22fa5a70&":
/*!*******************************************************************************!*\
  !*** ./resources/js/src/layouts/main/Main.vue?vue&type=template&id=22fa5a70& ***!
  \*******************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Main_vue_vue_type_template_id_22fa5a70___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../../node_modules/vue-loader/lib??vue-loader-options!./Main.vue?vue&type=template&id=22fa5a70& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/src/layouts/main/Main.vue?vue&type=template&id=22fa5a70&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Main_vue_vue_type_template_id_22fa5a70___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Main_vue_vue_type_template_id_22fa5a70___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ }),

/***/ "./resources/js/src/views/_loading.vue":
/*!*********************************************!*\
  !*** ./resources/js/src/views/_loading.vue ***!
  \*********************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _loading_vue_vue_type_template_id_4c4e5ef2___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./_loading.vue?vue&type=template&id=4c4e5ef2& */ "./resources/js/src/views/_loading.vue?vue&type=template&id=4c4e5ef2&");
/* harmony import */ var _loading_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./_loading.vue?vue&type=script&lang=js& */ "./resources/js/src/views/_loading.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport *//* harmony import */ var _loading_vue_vue_type_style_index_0_lang_scss___WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./_loading.vue?vue&type=style&index=0&lang=scss& */ "./resources/js/src/views/_loading.vue?vue&type=style&index=0&lang=scss&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");






/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_3__["default"])(
  _loading_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _loading_vue_vue_type_template_id_4c4e5ef2___WEBPACK_IMPORTED_MODULE_0__["render"],
  _loading_vue_vue_type_template_id_4c4e5ef2___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/src/views/_loading.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/src/views/_loading.vue?vue&type=script&lang=js&":
/*!**********************************************************************!*\
  !*** ./resources/js/src/views/_loading.vue?vue&type=script&lang=js& ***!
  \**********************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_loading_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib??ref--4-0!../../../../node_modules/vue-loader/lib??vue-loader-options!./_loading.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/src/views/_loading.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_loading_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/src/views/_loading.vue?vue&type=style&index=0&lang=scss&":
/*!*******************************************************************************!*\
  !*** ./resources/js/src/views/_loading.vue?vue&type=style&index=0&lang=scss& ***!
  \*******************************************************************************/
/*! no static exports found */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_style_loader_index_js_node_modules_css_loader_index_js_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_lib_index_js_ref_8_2_node_modules_sass_loader_dist_cjs_js_ref_8_3_node_modules_vue_loader_lib_index_js_vue_loader_options_loading_vue_vue_type_style_index_0_lang_scss___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/style-loader!../../../../node_modules/css-loader!../../../../node_modules/vue-loader/lib/loaders/stylePostLoader.js!../../../../node_modules/postcss-loader/lib??ref--8-2!../../../../node_modules/sass-loader/dist/cjs.js??ref--8-3!../../../../node_modules/vue-loader/lib??vue-loader-options!./_loading.vue?vue&type=style&index=0&lang=scss& */ "./node_modules/style-loader/index.js!./node_modules/css-loader/index.js!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/lib/index.js?!./node_modules/sass-loader/dist/cjs.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/src/views/_loading.vue?vue&type=style&index=0&lang=scss&");
/* harmony import */ var _node_modules_style_loader_index_js_node_modules_css_loader_index_js_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_lib_index_js_ref_8_2_node_modules_sass_loader_dist_cjs_js_ref_8_3_node_modules_vue_loader_lib_index_js_vue_loader_options_loading_vue_vue_type_style_index_0_lang_scss___WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_node_modules_style_loader_index_js_node_modules_css_loader_index_js_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_lib_index_js_ref_8_2_node_modules_sass_loader_dist_cjs_js_ref_8_3_node_modules_vue_loader_lib_index_js_vue_loader_options_loading_vue_vue_type_style_index_0_lang_scss___WEBPACK_IMPORTED_MODULE_0__);
/* harmony reexport (unknown) */ for(var __WEBPACK_IMPORT_KEY__ in _node_modules_style_loader_index_js_node_modules_css_loader_index_js_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_lib_index_js_ref_8_2_node_modules_sass_loader_dist_cjs_js_ref_8_3_node_modules_vue_loader_lib_index_js_vue_loader_options_loading_vue_vue_type_style_index_0_lang_scss___WEBPACK_IMPORTED_MODULE_0__) if(["default"].indexOf(__WEBPACK_IMPORT_KEY__) < 0) (function(key) { __webpack_require__.d(__webpack_exports__, key, function() { return _node_modules_style_loader_index_js_node_modules_css_loader_index_js_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_lib_index_js_ref_8_2_node_modules_sass_loader_dist_cjs_js_ref_8_3_node_modules_vue_loader_lib_index_js_vue_loader_options_loading_vue_vue_type_style_index_0_lang_scss___WEBPACK_IMPORTED_MODULE_0__[key]; }) }(__WEBPACK_IMPORT_KEY__));


/***/ }),

/***/ "./resources/js/src/views/_loading.vue?vue&type=template&id=4c4e5ef2&":
/*!****************************************************************************!*\
  !*** ./resources/js/src/views/_loading.vue?vue&type=template&id=4c4e5ef2& ***!
  \****************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_loading_vue_vue_type_template_id_4c4e5ef2___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../node_modules/vue-loader/lib??vue-loader-options!./_loading.vue?vue&type=template&id=4c4e5ef2& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/src/views/_loading.vue?vue&type=template&id=4c4e5ef2&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_loading_vue_vue_type_template_id_4c4e5ef2___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_loading_vue_vue_type_template_id_4c4e5ef2___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ }),

/***/ "./resources/js/src/views/_timeout.vue":
/*!*********************************************!*\
  !*** ./resources/js/src/views/_timeout.vue ***!
  \*********************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _timeout_vue_vue_type_template_id_6c6aa22c___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./_timeout.vue?vue&type=template&id=6c6aa22c& */ "./resources/js/src/views/_timeout.vue?vue&type=template&id=6c6aa22c&");
/* harmony import */ var _timeout_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./_timeout.vue?vue&type=script&lang=js& */ "./resources/js/src/views/_timeout.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport *//* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _timeout_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _timeout_vue_vue_type_template_id_6c6aa22c___WEBPACK_IMPORTED_MODULE_0__["render"],
  _timeout_vue_vue_type_template_id_6c6aa22c___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/src/views/_timeout.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/src/views/_timeout.vue?vue&type=script&lang=js&":
/*!**********************************************************************!*\
  !*** ./resources/js/src/views/_timeout.vue?vue&type=script&lang=js& ***!
  \**********************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_timeout_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib??ref--4-0!../../../../node_modules/vue-loader/lib??vue-loader-options!./_timeout.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/src/views/_timeout.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_timeout_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/src/views/_timeout.vue?vue&type=template&id=6c6aa22c&":
/*!****************************************************************************!*\
  !*** ./resources/js/src/views/_timeout.vue?vue&type=template&id=6c6aa22c& ***!
  \****************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_timeout_vue_vue_type_template_id_6c6aa22c___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../node_modules/vue-loader/lib??vue-loader-options!./_timeout.vue?vue&type=template&id=6c6aa22c& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/src/views/_timeout.vue?vue&type=template&id=6c6aa22c&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_timeout_vue_vue_type_template_id_6c6aa22c___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_timeout_vue_vue_type_template_id_6c6aa22c___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ })

}]);