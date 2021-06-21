'use strict';

Object.defineProperty(exports, '__esModule', { value: true });

var vue2Leaflet = require('vue2-leaflet');
var LDrawToolbar = require('vue2-leaflet-draw-toolbar');
var L = require('leaflet');
require('leaflet-boundary-canvas');
require('leaflet-extra-markers');
require('leaflet-extra-markers/dist/css/leaflet.extra-markers.min.css');
var __vue_normalize__ = require('vue-runtime-helpers/dist/normalize-component.mjs');
require('leaflet.browser.print/dist/leaflet.browser.print');
require('leaflet.fullscreen');
require('leaflet.fullscreen/Control.FullScreen.css');
var screenfull = require('screenfull');
var lodashEs = require('lodash-es');
var vueLeafletHelper = require('@ttungbmt/vue-leaflet-helper');
var invariant = require('@turf/invariant');
require('leaflet.polylinemeasure');
require('leaflet.polylinemeasure/Leaflet.PolylineMeasure.css');
require('leaflet.locatecontrol');
require('leaflet.locatecontrol/dist/L.Control.Locate.css');
require('@geoman-io/leaflet-geoman-free');
require('@geoman-io/leaflet-geoman-free/dist/leaflet-geoman.css');

function _interopDefaultLegacy (e) { return e && typeof e === 'object' && 'default' in e ? e : { 'default': e }; }

var LDrawToolbar__default = /*#__PURE__*/_interopDefaultLegacy(LDrawToolbar);
var L__default = /*#__PURE__*/_interopDefaultLegacy(L);
var __vue_normalize____default = /*#__PURE__*/_interopDefaultLegacy(__vue_normalize__);
var screenfull__default = /*#__PURE__*/_interopDefaultLegacy(screenfull);

//
/*
* Legend: https://bando.net.vn/wp-content/uploads/2020/02/Khi-Hau-VN.jpg
* https://github.com/ptma/Leaflet.Legend
* https://github.com/consbio/Leaflet.HtmlLegend
* */

var script$a = {
  name: 'LControlLegend',
  mixins: [vue2Leaflet.ControlMixin, vue2Leaflet.OptionsMixin],
  props: {
    items: Array,
    title: String
  },
  computed: {},
  mounted: function mounted() {
    var _this = this;

    var $legend = this.$refs.legend.innerHTML;
    var options = vue2Leaflet.optionsMerger(Object.assign({}, this.controlOptions, {
      title: this.title
    }), this);
    this.mapObject = L.control(options);
    vue2Leaflet.propsBinder(this, this.mapObject, this.$options.props);

    this.mapObject.onAdd = function (map) {
      var div = L.DomUtil.create('div', 'info legend');
      div.innerHTML = $legend;
      return div;
    };

    this.parentContainer = vue2Leaflet.findRealParent(this.$parent);
    this.mapObject.addTo(this.parentContainer.mapObject);
    this.$nextTick(function () {
      /**
       * Triggers when the component is ready
       * @type {object}
       * @property {object} mapObject - reference to leaflet map object
       */
      _this.$emit('ready', _this.mapObject);
    });
  },
  methods: {
    getStyle: function getStyle(i) {
      var style = "background-color: ".concat(i.fillColor, ";");
      if (i.stroke) style += "border: 1px solid ".concat(i.stroke, ";");
      return style;
    }
  }
};

/* script */
var __vue_script__$a = script$a;
/* template */

var __vue_render__$2 = function __vue_render__() {
  var _vm = this;

  var _h = _vm.$createElement;

  var _c = _vm._self._c || _h;

  return _c('div', {
    ref: "legend",
    staticStyle: {
      "display": "none"
    }
  }, [_vm._t("default"), _vm._v(" "), _c('div', {
    staticClass: "leaflet-bar leaflet-legend leaflet-legend-expanded"
  }, [_vm.title ? _c('div', {
    staticClass: "leaflet-legend-title"
  }, [_vm._v(_vm._s(_vm.title))]) : _vm._e(), _vm._v(" "), _c('div', {
    staticClass: "legend-items"
  }, _vm._l(_vm.items, function (i) {
    return _c('div', {
      staticClass: "legend-row"
    }, [_c('div', {
      staticClass: "leaflet-legend-html"
    }, [_c('div', {
      "class": "lengend-" + i.type,
      style: _vm.getStyle(i)
    })]), _vm._v(" "), _c('div', {
      staticClass: "lengend-label"
    }, [_vm._v(_vm._s(i.label))])]);
  }), 0)])], 2);
};

var __vue_staticRenderFns__$2 = [];
/* style */

var __vue_inject_styles__$a = undefined;
/* scoped */

var __vue_scope_id__$a = undefined;
/* module identifier */

var __vue_module_identifier__$a = undefined;
/* functional template */

var __vue_is_functional_template__$a = false;
/* style inject */

/* style inject SSR */

/* style inject shadow dom */

var __vue_component__$a = /*#__PURE__*/__vue_normalize____default['default']({
  render: __vue_render__$2,
  staticRenderFns: __vue_staticRenderFns__$2
}, __vue_inject_styles__$a, __vue_script__$a, __vue_scope_id__$a, __vue_is_functional_template__$a, __vue_module_identifier__$a, false, undefined, undefined, undefined);

/**
 * Add any custom component as a leaflet control-scale
 */

var script$9 = {
  name: 'LControlPrint',
  mixins: [vue2Leaflet.ControlMixin, vue2Leaflet.OptionsMixin],
  props: {},
  mounted: function mounted() {
    var _this = this;

    var options = vue2Leaflet.optionsMerger(Object.assign({}, this.controlOptions), this);
    this.mapObject = L.control.browserPrint(options);
    vue2Leaflet.propsBinder(this, this.mapObject, this.$options.props);
    this.mapObject.addTo(this.$parent.mapObject);
    L.DomEvent.on(this.$parent.mapObject, this.$listeners);
    this.$nextTick(function () {
      /**
       * Triggers when the component is ready
       * @type {object}
       * @property {object} mapObject - reference to leaflet map object
       */
      _this.$emit('ready', _this.mapObject);
    });
  },
  render: function render() {
    return null;
  }
};

/* script */
var __vue_script__$9 = script$9;
/* template */

/* style */

var __vue_inject_styles__$9 = undefined;
/* scoped */

var __vue_scope_id__$9 = undefined;
/* module identifier */

var __vue_module_identifier__$9 = undefined;
/* functional template */

var __vue_is_functional_template__$9 = undefined;
/* style inject */

/* style inject SSR */

/* style inject shadow dom */

var __vue_component__$9 = /*#__PURE__*/__vue_normalize____default['default']({}, __vue_inject_styles__$9, __vue_script__$9, __vue_scope_id__$9, __vue_is_functional_template__$9, __vue_module_identifier__$9, false, undefined, undefined, undefined);

if (!window['screenfull']) window['screenfull'] = screenfull__default['default'];
/**
 * Add any custom component as a leaflet control-fullscrren
 */

var script$8 = {
  name: 'LControlFullscreen',
  mixins: [vue2Leaflet.ControlMixin, vue2Leaflet.OptionsMixin],
  props: {
    title: {
      type: String,
      "default": 'Full Screen'
    },
    titleCancel: {
      type: String,
      "default": 'Exit Full Screen'
    },
    forceSeparateButton: {
      type: Boolean,
      "default": true
    },
    forcePseudoFullscreen: {
      type: Boolean,
      "default": false
    },
    fullscreenElement: {
      type: Boolean,
      "default": false
    }
  },
  mounted: function mounted() {
    var _this = this;

    var options = vue2Leaflet.optionsMerger(Object.assign({}, this.controlOptions), this);
    this.mapObject = L.control.fullscreen(options);
    vue2Leaflet.propsBinder(this, this.mapObject, this.$options.props);
    this.parentContainer = vue2Leaflet.findRealParent(this.$parent);
    this.mapObject.addTo(this.parentContainer.mapObject);
    this.$nextTick(function () {
      /**
       * Triggers when the component is ready
       * @type {object}
       * @property {object} mapObject - reference to leaflet map object
       */
      _this.$emit('ready', _this.mapObject);
    });
  },
  render: function render() {
    return null;
  }
};

/* script */
var __vue_script__$8 = script$8;
/* template */

/* style */

var __vue_inject_styles__$8 = undefined;
/* scoped */

var __vue_scope_id__$8 = undefined;
/* module identifier */

var __vue_module_identifier__$8 = undefined;
/* functional template */

var __vue_is_functional_template__$8 = undefined;
/* style inject */

/* style inject SSR */

/* style inject shadow dom */

var __vue_component__$8 = /*#__PURE__*/__vue_normalize____default['default']({}, __vue_inject_styles__$8, __vue_script__$8, __vue_scope_id__$8, __vue_is_functional_template__$8, __vue_module_identifier__$8, false, undefined, undefined, undefined);

//
/**
 * Load tiles from a map server and display them accordingly to map zoom, center and size
 */

var script$7 = {
  name: 'LTileLayer',
  mixins: [vue2Leaflet.TileLayerMixin, vue2Leaflet.OptionsMixin],
  props: {
    url: {
      type: String,
      "default": null
    },
    tileLayerClass: {
      type: Function,
      "default": L.tileLayer
    }
  },
  mounted: function mounted() {
    var _this = this;

    var options = vue2Leaflet.optionsMerger(this.tileLayerOptions, this);
    var boundary = this.$attrs.boundary || options.boundary;
    this.mapObject = boundary ? L.TileLayer.BoundaryCanvas.createFromLayer(this.tileLayerClass(this.url, options), {
      boundary: boundary,
      trackAttribution: true
    }) : this.tileLayerClass(this.url, options);
    L.DomEvent.on(this.mapObject, this.$listeners);
    vue2Leaflet.propsBinder(this, this.mapObject, this.$options.props);
    this.parentContainer = vue2Leaflet.findRealParent(this.$parent);
    this.parentContainer.addLayer(this, !this.visible);
    this.$nextTick(function () {
      /**
       * Triggers when the component is ready
       * @type {object}
       * @property {object} mapObject - reference to leaflet map object
       */
      _this.$emit('ready', _this.mapObject);
    });
  }
};

/* script */
var __vue_script__$7 = script$7;
/* template */

var __vue_render__$1 = function __vue_render__() {
  var _vm = this;

  var _h = _vm.$createElement;

  var _c = _vm._self._c || _h;

  return _c('div');
};

var __vue_staticRenderFns__$1 = [];
/* style */

var __vue_inject_styles__$7 = undefined;
/* scoped */

var __vue_scope_id__$7 = undefined;
/* module identifier */

var __vue_module_identifier__$7 = undefined;
/* functional template */

var __vue_is_functional_template__$7 = false;
/* style inject */

/* style inject SSR */

/* style inject shadow dom */

var __vue_component__$7 = /*#__PURE__*/__vue_normalize____default['default']({
  render: __vue_render__$1,
  staticRenderFns: __vue_staticRenderFns__$1
}, __vue_inject_styles__$7, __vue_script__$7, __vue_scope_id__$7, __vue_is_functional_template__$7, __vue_module_identifier__$7, false, undefined, undefined, undefined);

var findLeafletParent = function findLeafletParent(firstVueParent) {
  var found = false;

  while (firstVueParent && !found) {
    if (firstVueParent.mapObject === undefined || !(firstVueParent.mapObject instanceof L.Map)) {
      firstVueParent = firstVueParent.$parent;
    } else {
      found = true;
    }
  }

  return firstVueParent;
};

/**
 * Display a popup on the map
 */

var script$6 = {
  name: 'LPopup',
  mixins: [vue2Leaflet.PopperMixin, vue2Leaflet.OptionsMixin],
  props: {
    latLng: {
      type: [Object, Array],
      custom: true,
      "default": function _default() {
        return [];
      }
    }
  },
  watch: {
    options: function options(newVal, oldVal) {
      var _this = this;

      this.$nextTick(function () {
        _this.mapObject.update();
      });
    }
  },
  mounted: function mounted() {
    var _this2 = this;

    var options = vue2Leaflet.optionsMerger(this.popperOptions, this);
    this.mapObject = L.popup(options);
    this.leafletObject = findLeafletParent(this.$parent).mapObject;
    this.parentContainer = vue2Leaflet.findRealParent(this.$parent);
    L.DomEvent.on(this.mapObject, this.$listeners);
    vue2Leaflet.propsBinder(this, this.mapObject, this.$options.props);
    this.mapObject.setContent(this.content || this.$el);

    if (!lodashEs.isEmpty(this.latLng)) {
      this.mapObject.setLatLng(this.latLng);
      this.openPopup();
    }

    this.parentContainer.mapObject.bindPopup && this.parentContainer.mapObject.bindPopup(this.mapObject);
    this.$nextTick(function () {
      /**
       * Triggers when the component is ready
       * @type {object}
       * @property {object} mapObject - reference to leaflet map object
       */
      _this2.$emit('ready', _this2.mapObject);
    });
  },
  methods: {
    openPopup: function openPopup() {
      if (!lodashEs.isEmpty(this.latLng)) this.mapObject.openOn(this.leafletObject);
    },
    closePopup: function closePopup() {
      this.leafletObject.closePopup();
    },
    setLatLng: function setLatLng(newVal, oldVal) {
      if (!lodashEs.isEmpty(newVal)) {
        this.mapObject.setLatLng(newVal).update();
        this.openPopup();
      } else {
        this.closePopup();
      }
    }
  },
  beforeDestroy: function beforeDestroy() {
    if (this.parentContainer) {
      this.closePopup();

      if (this.parentContainer.unbindPopup) {
        this.parentContainer.unbindPopup();
      } else if (this.parentContainer.mapObject && this.parentContainer.mapObject.unbindPopup) {
        this.parentContainer.mapObject.unbindPopup();
      }
    }
  }
};

/* script */
var __vue_script__$6 = script$6;
/* template */

/* style */

var __vue_inject_styles__$6 = undefined;
/* scoped */

var __vue_scope_id__$6 = undefined;
/* module identifier */

var __vue_module_identifier__$6 = undefined;
/* functional template */

var __vue_is_functional_template__$6 = undefined;
/* style inject */

/* style inject SSR */

/* style inject shadow dom */

var __vue_component__$6 = /*#__PURE__*/__vue_normalize____default['default']({}, __vue_inject_styles__$6, __vue_script__$6, __vue_scope_id__$6, __vue_is_functional_template__$6, __vue_module_identifier__$6, false, undefined, undefined, undefined);

function _defineProperty(obj, key, value) {
  if (key in obj) {
    Object.defineProperty(obj, key, {
      value: value,
      enumerable: true,
      configurable: true,
      writable: true
    });
  } else {
    obj[key] = value;
  }

  return obj;
}

var script$5 = {
  name: 'LManager',
  props: ['layers', 'controls'],
  computed: {
    computedControls: function computedControls() {
      return vueLeafletHelper.toMapControls(this.controls);
    },
    computedLayers: function computedLayers() {
      return vueLeafletHelper.toMapLayers(this.layers);
    }
  },
  mounted: function mounted() {
    var _this = this;

    this.$nextTick(function () {
      _this.map = vue2Leaflet.findRealParent(_this.$parent).mapObject;
    });
  },
  methods: {
    onLayerReady: function onLayerReady(layerObject, cLayer, k) {
      var _this2 = this;

      layerObject._id = cLayer.id;
      var layer = this.layers[k];

      if (layer.geom_field) {
        if (layerObject instanceof L__default['default'].Marker) {
          layerObject.on('pm:edit', function (e) {
            var latlng = e.layer.getLatLng();
            return _this2.$emit('shapeUpdated', {
              layer: e.layer,
              id: e.layer._id,
              type: 'marker',
              data: [latlng.lat, latlng.lng]
            });
          });
        }

        if (layerObject instanceof L__default['default'].Path || layerObject instanceof L__default['default'].GeoJSON) {
          layerObject.on('pm:edit', function (e) {
            return _this2.$emit('shapeUpdated', {
              layer: layerObject,
              id: layerObject._id,
              type: 'geojson',
              data: invariant.getGeom(e.layer.toGeoJSON())
            });
          });
        }
      }
    },
    getLayerListeners: function getLayerListeners(cLayer, index) {
      this.layers[index];
          var events = {};
      return events;
    },
    getControlListeners: function getControlListeners(cControl, index) {
      var _this3 = this;

      var control = this.controls[cControl.name];

      if (cControl.name === 'geoman') {
        var _ref3;

        return _ref3 = {}, _defineProperty(_ref3, 'pm:create', function pmCreate(_ref) {
          var layer = _ref.layer,
              shape = _ref.shape;
              _ref.target;
          if (!control.drawMultiple) _this3.map.pm.disableGlobalEditMode();

          _this3.map.removeLayer(layer);

          _this3.$emit('shapeCreated', {
            shape: shape,
            layer: layer
          });
        }), _defineProperty(_ref3, 'pm:remove', function pmRemove(_ref2) {
          var layer = _ref2.layer,
              shape = _ref2.shape,
              target = _ref2.target;
          if (!control.drawMultiple) _this3.map.pm.disableGlobalRemovalMode();

          if (!layer._id) {
            target.eachLayer(function (l) {
              l._id && l.hasLayer && l.hasLayer(layer) && _this3.$emit('shapeRemoved', {
                shape: shape,
                layer: l
              });
            });
          }
        }), _ref3;
      }

      return {};
    }
  }
};

/* script */
var __vue_script__$5 = script$5;
/* template */

var __vue_render__ = function __vue_render__() {
  var _vm = this;

  var _h = _vm.$createElement;

  var _c = _vm._self._c || _h;

  return _c('div', [_vm._l(_vm.computedControls, function (i, k) {
    return _c(i.component, _vm._g(_vm._b({
      key: "control-" + k,
      tag: "component"
    }, 'component', i, false), _vm.getControlListeners(i, k)));
  }), _vm._v(" "), _vm._l(_vm.computedLayers, function (i, k) {
    return _c(i.component, _vm._g(_vm._b({
      key: "layer-" + k,
      tag: "component",
      on: {
        "ready": function ready(layer) {
          return _vm.onLayerReady(layer, i, k);
        }
      }
    }, 'component', i, false), _vm.getLayerListeners(i, k)));
  }), _vm._v(" "), _vm._t("default")], 2);
};

var __vue_staticRenderFns__ = [];
/* style */

var __vue_inject_styles__$5 = undefined;
/* scoped */

var __vue_scope_id__$5 = undefined;
/* module identifier */

var __vue_module_identifier__$5 = undefined;
/* functional template */

var __vue_is_functional_template__$5 = false;
/* style inject */

/* style inject SSR */

/* style inject shadow dom */

var __vue_component__$5 = /*#__PURE__*/__vue_normalize____default['default']({
  render: __vue_render__,
  staticRenderFns: __vue_staticRenderFns__
}, __vue_inject_styles__$5, __vue_script__$5, __vue_scope_id__$5, __vue_is_functional_template__$5, __vue_module_identifier__$5, false, undefined, undefined, undefined);

/**
 * Add any custom component as a leaflet control-layers
 */

var script$4 = {
  name: 'LControlLayers',
  mixins: [vue2Leaflet.ControlMixin, vue2Leaflet.OptionsMixin],
  props: {
    collapsed: {
      type: Boolean,
      "default": true
    },
    autoZIndex: {
      type: Boolean,
      "default": false
    },
    hideSingleBase: {
      type: Boolean,
      "default": false
    },
    sortLayers: {
      type: Boolean,
      "default": false
    },
    sortFunction: {
      type: Function,
      "default": undefined
    }
  },
  mounted: function mounted() {
    var _this = this;

    var options = vue2Leaflet.optionsMerger(Object.assign({}, this.controlOptions, {
      collapsed: this.collapsed,
      autoZIndex: this.autoZIndex,
      hideSingleBase: this.hideSingleBase,
      sortLayers: this.sortLayers,
      sortFunction: this.sortFunction
    }), this);
    this.mapObject = L.control.layers(null, null, options);
    this.parentContainer = findLeafletParent(this.$parent);
    vue2Leaflet.propsBinder(this, this.mapObject, this.$options.props);
    this.parentContainer.registerLayerControl(this);
    this.$nextTick(function () {
      /**
       * Triggers when the component is ready
       * @type {object}
       * @property {object} mapObject - reference to leaflet map object
       */
      _this.$emit('ready', _this.mapObject);
    });
  },
  methods: {
    addLayer: function addLayer(layer) {
      if (layer.layerType === 'base') {
        this.mapObject.addBaseLayer(layer.mapObject, layer.name);
      } else if (layer.layerType === 'overlay') {
        this.mapObject.addOverlay(layer.mapObject, layer.name);
      }
    },
    removeLayer: function removeLayer(layer) {
      this.mapObject.removeLayer(layer.mapObject);
    }
  },
  render: function render() {
    return null;
  }
};

/* script */
var __vue_script__$4 = script$4;
/* template */

/* style */

var __vue_inject_styles__$4 = undefined;
/* scoped */

var __vue_scope_id__$4 = undefined;
/* module identifier */

var __vue_module_identifier__$4 = undefined;
/* functional template */

var __vue_is_functional_template__$4 = undefined;
/* style inject */

/* style inject SSR */

/* style inject shadow dom */

var __vue_component__$4 = /*#__PURE__*/__vue_normalize____default['default']({}, __vue_inject_styles__$4, __vue_script__$4, __vue_scope_id__$4, __vue_is_functional_template__$4, __vue_module_identifier__$4, false, undefined, undefined, undefined);

/**
 * Add any custom component as a leaflet control-fullscrren
 */

var script$3 = {
  name: 'LControlMeasure',
  mixins: [vue2Leaflet.ControlMixin, vue2Leaflet.OptionsMixin],
  props: {
    clearMeasurementsOnStop: {
      type: Boolean,
      "default": true
    },
    showBearings: Boolean,
    measureControlLabel: String,
    measureControlClasses: Array,
    showClearControl: Boolean,
    showUnitControl: Boolean
  },
  mounted: function mounted() {
    var _this = this;

    var options = vue2Leaflet.optionsMerger(Object.assign({}, this.controlOptions, {
      clearMeasurementsOnStop: this.clearMeasurementsOnStop,
      showBearings: this.showBearings,
      measureControlLabel: this.measureControlLabel,
      measureControlClasses: this.measureControlClasses,
      showClearControl: this.showClearControl,
      showUnitControl: this.showUnitControl
    }), this);
    this.mapObject = L.control.polylineMeasure(options);
    vue2Leaflet.propsBinder(this, this.mapObject, this.$options.props);
    this.parentContainer = vue2Leaflet.findRealParent(this.$parent);
    this.mapObject.addTo(this.parentContainer.mapObject);
    this.$nextTick(function () {
      /**
       * Triggers when the component is ready
       * @type {object}
       * @property {object} mapObject - reference to leaflet map object
       */
      _this.$emit('ready', _this.mapObject);
    });
  },
  render: function render() {
    return null;
  }
};

/* script */
var __vue_script__$3 = script$3;
/* template */

/* style */

var __vue_inject_styles__$3 = undefined;
/* scoped */

var __vue_scope_id__$3 = undefined;
/* module identifier */

var __vue_module_identifier__$3 = undefined;
/* functional template */

var __vue_is_functional_template__$3 = undefined;
/* style inject */

/* style inject SSR */

/* style inject shadow dom */

var __vue_component__$3 = /*#__PURE__*/__vue_normalize____default['default']({}, __vue_inject_styles__$3, __vue_script__$3, __vue_scope_id__$3, __vue_is_functional_template__$3, __vue_module_identifier__$3, false, undefined, undefined, undefined);

/**
 * Add any custom component as a leaflet control-fullscrren
 */

var script$2 = {
  name: 'LControlLocate',
  mixins: [vue2Leaflet.ControlMixin, vue2Leaflet.OptionsMixin],
  props: {
    position: {
      type: String,
      "default": 'bottomright'
    },
    icon: String
  },
  mounted: function mounted() {
    var _this = this;

    var options = vue2Leaflet.optionsMerger(Object.assign({}, this.controlOptions, {
      icon: this.icon
    }), this);
    this.mapObject = L.control.locate(options);
    vue2Leaflet.propsBinder(this, this.mapObject, this.$options.props);
    this.parentContainer = vue2Leaflet.findRealParent(this.$parent);
    this.mapObject.addTo(this.parentContainer.mapObject);
    this.$nextTick(function () {
      /**
       * Triggers when the component is ready
       * @type {object}
       * @property {object} mapObject - reference to leaflet map object
       */
      _this.$emit('ready', _this.mapObject);
    });
  },
  render: function render() {
    return null;
  }
};

/* script */
var __vue_script__$2 = script$2;
/* template */

/* style */

var __vue_inject_styles__$2 = undefined;
/* scoped */

var __vue_scope_id__$2 = undefined;
/* module identifier */

var __vue_module_identifier__$2 = undefined;
/* functional template */

var __vue_is_functional_template__$2 = undefined;
/* style inject */

/* style inject SSR */

/* style inject shadow dom */

var __vue_component__$2 = /*#__PURE__*/__vue_normalize____default['default']({}, __vue_inject_styles__$2, __vue_script__$2, __vue_scope_id__$2, __vue_is_functional_template__$2, __vue_module_identifier__$2, false, undefined, undefined, undefined);

var options = new L.PM.Toolbar().options;
var props = lodashEs.transform({
  drawMarker: Boolean,
  drawCircleMarker: Boolean,
  drawPolyline: Boolean,
  drawRectangle: Boolean,
  drawPolygon: Boolean,
  drawCircle: Boolean,
  editMode: Boolean,
  dragMode: Boolean,
  cutPolygon: Boolean,
  removalMode: Boolean,
  oneBlock: Boolean,
  drawControls: Boolean,
  editControls: Boolean,
  customControls: Boolean,
  optionsControls: Boolean,
  pinningOption: Boolean,
  snappingOption: Boolean
}, function (result, value, key) {
  result[key] = {
    type: value,
    "default": lodashEs.get(options, key, false)
  };
  return result;
}, {});
/**
 * Add any custom component as a leaflet control-fullscrren
 */

var script$1 = {
  name: 'LControlGeoman',
  mixins: [vue2Leaflet.ControlMixin, vue2Leaflet.OptionsMixin],
  props: props,
  mounted: function mounted() {
    var _this = this;

    var options = vue2Leaflet.optionsMerger(Object.assign({}, this.controlOptions, lodashEs.transform(props, function (result, value, key) {
      result[key] = _this[key];
    }, {})), this);
    this.parentContainer = vue2Leaflet.findRealParent(this.$parent);
    this.mapObject = this.parentContainer.mapObject.pm;
    this.mapObject.remove = this.mapObject.removeControls;
    L.DomEvent.on(this.parentContainer.mapObject, this.$listeners);
    vue2Leaflet.propsBinder(this, this.mapObject, this.$options.props);
    this.mapObject.addControls(options);
    this.$nextTick(function () {
      /**
       * Triggers when the component is ready
       * @type {object}
       * @property {object} mapObject - reference to leaflet map object
       */
      _this.$emit('ready', _this.mapObject);
    });
  },
  render: function render() {
    return null;
  }
};

/* script */
var __vue_script__$1 = script$1;
/* template */

/* style */

var __vue_inject_styles__$1 = undefined;
/* scoped */

var __vue_scope_id__$1 = undefined;
/* module identifier */

var __vue_module_identifier__$1 = undefined;
/* functional template */

var __vue_is_functional_template__$1 = undefined;
/* style inject */

/* style inject SSR */

/* style inject shadow dom */

var __vue_component__$1 = /*#__PURE__*/__vue_normalize____default['default']({}, __vue_inject_styles__$1, __vue_script__$1, __vue_scope_id__$1, __vue_is_functional_template__$1, __vue_module_identifier__$1, false, undefined, undefined, undefined);

/**
 * Add any custom component as a leaflet control-scale
 */

var script = {
  name: 'LControlScale',
  mixins: [vue2Leaflet.ControlMixin, vue2Leaflet.OptionsMixin],
  props: {
    maxWidth: {
      type: Number,
      "default": 100
    },
    metric: {
      type: Boolean,
      "default": true
    },
    imperial: {
      type: Boolean,
      "default": true
    },
    updateWhenIdle: {
      type: Boolean,
      "default": false
    }
  },
  mounted: function mounted() {
    var _this = this;

    var options = vue2Leaflet.optionsMerger(Object.assign({}, this.controlOptions, {
      maxWidth: this.maxWidth,
      metric: this.metric,
      imperial: this.imperial,
      updateWhenIdle: this.updateWhenIdle
    }), this);
    this.mapObject = L.control.scale(options);
    vue2Leaflet.propsBinder(this, this.mapObject, this.$options.props);
    this.parentContainer = vue2Leaflet.findRealParent(this.$parent);
    this.mapObject.addTo(this.parentContainer.mapObject);
    this.$nextTick(function () {
      /**
       * Triggers when the component is ready
       * @type {object}
       * @property {object} mapObject - reference to leaflet map object
       */
      _this.$emit('ready', _this.mapObject);
    });
  },
  render: function render() {
    return null;
  }
};

/* script */
var __vue_script__ = script;
/* template */

/* style */

var __vue_inject_styles__ = undefined;
/* scoped */

var __vue_scope_id__ = undefined;
/* module identifier */

var __vue_module_identifier__ = undefined;
/* functional template */

var __vue_is_functional_template__ = undefined;
/* style inject */

/* style inject SSR */

/* style inject shadow dom */

var __vue_component__ = /*#__PURE__*/__vue_normalize____default['default']({}, __vue_inject_styles__, __vue_script__, __vue_scope_id__, __vue_is_functional_template__, __vue_module_identifier__, false, undefined, undefined, undefined);

L__default['default'].Icon.Default = L__default['default'].ExtraMarkers.Icon;
L__default['default'].Icon.Default.mergeOptions({
  icon: 'far fa-circle extra-marker-icon',
  markerColor: 'orange'
});
var index = {
  install: function install(Vue) {
    Vue.component('l-map', vue2Leaflet.LMap);
    Vue.component('l-tile-layer', __vue_component__$7);
    Vue.component('l-marker', vue2Leaflet.LMarker);
    Vue.component('l-cirlce', vue2Leaflet.LCircle);
    Vue.component('l-geojson', vue2Leaflet.LGeoJson);
    Vue.component('l-feature-group', vue2Leaflet.LFeatureGroup);
    Vue.component('l-popup', __vue_component__$6);
    Vue.component('l-tooltip', vue2Leaflet.LTooltip);
    Vue.component('l-wms-tile-layer', vue2Leaflet.LWMSTileLayer);
    Vue.component('l-draw-toolbar', LDrawToolbar__default['default']);
    Vue.component('l-control-layers', __vue_component__$4);
    Vue.component('l-control-legend', __vue_component__$a);
    Vue.component('l-control-print', __vue_component__$9);
    Vue.component('l-control-fullscreen', __vue_component__$8);
    Vue.component('l-control-zoom', vue2Leaflet.LControlZoom);
    Vue.component('l-control-zoom', vue2Leaflet.LControlZoom);
    Vue.component('l-control-measure', __vue_component__$3);
    Vue.component('l-control-locate', __vue_component__$2);
    Vue.component('l-control-geoman', __vue_component__$1);
    Vue.component('l-control-scale', __vue_component__);
    Vue.component('l-manager', __vue_component__$5);
  }
};

Object.defineProperty(exports, 'LCircle', {
    enumerable: true,
    get: function () {
        return vue2Leaflet.LCircle;
    }
});
Object.defineProperty(exports, 'LGeoJson', {
    enumerable: true,
    get: function () {
        return vue2Leaflet.LGeoJson;
    }
});
Object.defineProperty(exports, 'LMap', {
    enumerable: true,
    get: function () {
        return vue2Leaflet.LMap;
    }
});
Object.defineProperty(exports, 'LMarker', {
    enumerable: true,
    get: function () {
        return vue2Leaflet.LMarker;
    }
});
Object.defineProperty(exports, 'LWMSTileLayer', {
    enumerable: true,
    get: function () {
        return vue2Leaflet.LWMSTileLayer;
    }
});
exports.LControlLayers = __vue_component__$4;
exports.LPopup = __vue_component__$6;
exports.default = index;
