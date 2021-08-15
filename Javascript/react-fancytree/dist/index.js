var React = require('react');
var clsx = require('clsx');
var _ = require('lodash');
var $ = require('jquery');
require('jquery-ui');
require('jquery.fancytree');
require('jquery.fancytree/dist/modules/jquery.fancytree.filter');
require('jquery.fancytree/dist/modules/jquery.fancytree.glyph');
var constate = require('constate');
var useImmer = require('use-immer');
require('immer');
var treeJs = require('@ttungbmt/tree-js');
var reactContexify = require('react-contexify');
require('react-contexify/dist/ReactContexify.css');

function _interopDefaultLegacy (e) { return e && typeof e === 'object' && 'default' in e ? e : { 'default': e }; }

var React__default = /*#__PURE__*/_interopDefaultLegacy(React);
var clsx__default = /*#__PURE__*/_interopDefaultLegacy(clsx);
var ___default = /*#__PURE__*/_interopDefaultLegacy(_);
var $__default = /*#__PURE__*/_interopDefaultLegacy($);
var constate__default = /*#__PURE__*/_interopDefaultLegacy(constate);

function _extends() {
  _extends = Object.assign || function (target) {
    for (var i = 1; i < arguments.length; i++) {
      var source = arguments[i];

      for (var key in source) {
        if (Object.prototype.hasOwnProperty.call(source, key)) {
          target[key] = source[key];
        }
      }
    }

    return target;
  };

  return _extends.apply(this, arguments);
}

function _objectWithoutPropertiesLoose(source, excluded) {
  if (source == null) return {};
  var target = {};
  var sourceKeys = Object.keys(source);
  var key, i;

  for (i = 0; i < sourceKeys.length; i++) {
    key = sourceKeys[i];
    if (excluded.indexOf(key) >= 0) continue;
    target[key] = source[key];
  }

  return target;
}

var initialState = {
  loading: false,
  ids: [],
  entities: {}
};

var updateIds = function updateIds(state) {
  return void (state.ids = _.keys(state.entities));
};

var caseReducers = {
  setLoading: function setLoading(state, _ref) {
    var payload = _ref.payload;
    return state.loading = payload;
  },
  setAll: function setAll(state, _ref2) {
    var payload = _ref2.payload;
    state.entities = _.mapKeys(payload.map(function (v) {
      if (!v.folder && !v.icon) v.icon = false;
      return v;
    }), 'id');
    updateIds(state);
  },
  select: function select(state, _ref3) {
    var payload = _ref3.payload;
    payload.ids.map(function (id) {
      return state.entities[id].selected = payload.selected;
    });
  },
  selectOne: function selectOne(state, _ref4) {
    var _ref4$payload = _ref4.payload,
        ids = _ref4$payload.ids,
        selected = _ref4$payload.selected,
        siblingIds = _ref4$payload.siblingIds;
    siblingIds.map(function (id) {
      return state.entities[id].selected = !selected;
    });
    ids.map(function (id) {
      return state.entities[id].selected = selected;
    });
  },
  setExpand: function setExpand(state, _ref5) {
    var id = _ref5.payload;
    if (state.entities[id]) state.entities[id].expanded = true;
  },
  setCollapse: function setCollapse(state, _ref6) {
    var id = _ref6.payload;
    if (state.entities[id]) state.entities[id].expanded = false;
  },
  updateItem: function updateItem(state, _ref7) {
    var payload = _ref7.payload;
    var entity = state.entities[payload.id];
    _.map(payload.changes, function (v, k) {
      return entity[k] = v;
    });
  }
};

var reducer = function reducer(draft, action) {
  return void caseReducers[action.type](draft, action);
};

function useTree() {
  var _useImmerReducer = useImmer.useImmerReducer(reducer, initialState),
      state = _useImmerReducer[0],
      dispatch = _useImmerReducer[1];

  var _useState = React.useState(undefined),
      tree = _useState[0],
      setTree = _useState[1];

  var actions = React.useCallback(function () {
    return _extends({}, _.mapValues(caseReducers, function (action, type) {
      return function (payload) {
        return dispatch({
          type: type,
          payload: payload
        });
      };
    }), {
      expandAll: function expandAll() {
        return tree.expandAll();
      },
      collapseAll: function collapseAll() {
        return tree.expandAll(false);
      },
      toggleExpandAll: function toggleExpandAll() {
        return tree.visit(function (node) {
          return node.toggleExpanded();
        });
      }
    });
  }, [tree]);
  return _extends({}, actions(), {
    tree: tree,
    setTree: setTree,
    dispatch: dispatch,
    source: treeJs.toTree(state.ids.map(function (id) {
      return state.entities[id];
    }))
  });
}

var _constate = constate__default['default'](useTree),
    TreeProvider = _constate[0],
    useTreeContext = _constate[1];

var _excluded2 = ["id", "style", "className", "children", "source", "onItemClick"];
var events = ['blurTree', 'create', 'init', 'focusTree', 'restore', 'activate', 'beforeActivate', 'beforeExpand', 'beforeSelect', 'blur', 'click', 'collapse', 'createNode', 'dblclick', 'deactivate', 'expand', 'focus', 'keydown', 'keypress', 'lazyLoad', 'loadChildren', 'loadError', 'postProcess', 'modifyChild', 'renderNode', 'renderTitle', 'select'];

var toEventFuncs = function toEventFuncs(props) {
  return ___default['default'].chain(events).mapKeys(function (n) {
    return n;
  }).mapValues(function (n) {
    return function () {
      var eventName = "on" + ___default['default'].upperFirst(n);

      props[eventName] && props[eventName].apply(props, [].slice.call(arguments));
    };
  }).value();
};

function useTreeElement(treeRef, props) {
  var _useTreeContext = useTreeContext(),
      tree = _useTreeContext.tree,
      setTree = _useTreeContext.setTree;

  var options = ___default['default'].omit(props.options, events) || {};
  React.useEffect(function () {

    if (treeRef.current) {
      var eventFns = toEventFuncs(props);
      $__default['default'](treeRef.current).fancytree(_extends({}, eventFns, options, {
        source: props.source,
        renderNode: function renderNode(event, _ref) {
          var node = _ref.node;
          var $el = $__default['default'](node.span).find('.label-feature-count'),
              count = node.data.count;

          if (count && !$el.length) {
            $__default['default'](node.span).append($__default['default']("<div class=\"label-feature-count\">" + count + "</div>"));
          }

          $__default['default'](node.span).find('.fancytree-title').contextmenu(function (e) {
            reactContexify.contextMenu.show({
              id: MENU_ID,
              event: e,
              props: _extends({}, node.data, ___default['default'].pick(node, ['title', 'type']))
            });
          });
        }
      }));
      setTree($__default['default'].ui.fancytree.getTree(treeRef.current));
    }

    return function () {
      if (!treeRef.current) {
        tree && tree.destroy();
        setTree(null);
      }
    };
  }, []);
}

var MENU_ID = "layers";

function FancyTree(_ref2) {
  var id = _ref2.id,
      style = _ref2.style,
      className = _ref2.className,
      children = _ref2.children,
      source = _ref2.source,
      onItemClick = _ref2.onItemClick,
      props = _objectWithoutPropertiesLoose(_ref2, _excluded2);

  var treeRef = React.useRef(null);

  var _useContextMenu = reactContexify.useContextMenu({
    id: MENU_ID
  }),
      show = _useContextMenu.show;

  useTreeElement(treeRef, _extends({}, props, {
    source: source,
    show: show
  }));
  return /*#__PURE__*/React__default['default'].createElement("div", {
    id: id,
    className: clsx__default['default'](className),
    style: style,
    ref: treeRef
  }, children ? children : /*#__PURE__*/React__default['default'].createElement("ul", {
    style: {
      display: 'none'
    }
  }), /*#__PURE__*/React__default['default'].createElement(reactContexify.Menu, {
    id: MENU_ID
  }, /*#__PURE__*/React__default['default'].createElement(reactContexify.Item, {
    id: "act-edit",
    onClick: onItemClick
  }, "T\xF9y ch\u1EC9nh")));
}

FancyTree.defaultProps = {
  options: {
    checkbox: true,
    // Show check boxes
    selectMode: 3,
    // 1:single, 2:multi, 3:multi-hier
    quicksearch: true,
    // Navigate to next node by typing the first letters
    icon: true,
    // Display node icons
    clickFolderMode: 3,
    // 1:activate, 2:expand, 3:activate and expand, 4:activate (dblclick expands)
    checkboxAutoHide: false,
    // Display check boxes on hover only
    disabled: false,
    // Disable control
    wide: {
      iconWidth: '3em',
      // Adjust this if @fancy-icon-width != "16px"
      iconSpacing: '0.5em',
      // Adjust this if @fancy-icon-spacing != "3px"
      labelSpacing: '0.1em',
      // Adjust this if padding between icon and label != "3px"
      levelOfs: '1.5em' // Adjust this if ul padding != "16px"

    },
    filter: {
      autoApply: true,
      // Re-apply last filter if lazy data is loaded
      autoExpand: false,
      // Expand all branches that contain matches while filtered
      counter: true,
      // Show a badge with number of matching child nodes near parent icons
      fuzzy: false,
      // Match single characters in order, e.g. 'fb' will match 'FooBar'
      hideExpandedCounter: true,
      // Hide counter badge if parent is expanded
      hideExpanders: false,
      // Hide expanders if all child nodes are hidden by filter
      highlight: true,
      // Highlight matches by wrapping inside <mark> tags
      leavesOnly: false,
      // Match end nodes only
      nodata: true,
      // Display a 'no data' status node if result is empty
      mode: 'dimm' // Grayout unmatched nodes (pass "hide" to remove unmatched node instead)

    },
    childcounter: {
      deep: true,
      hideZeros: true,
      hideExpanded: true
    },
    extensions: ['filter' // 'childcounter'
    ]
  },
  onItemClick: function onItemClick() {}
};
var FancyTree$1 = React.memo(FancyTree);

var getToggleFiles = function getToggleFiles(node) {
  if (node.isFolder()) {
    var children = [];
    node.visit(function (child) {
      !child.isFolder() && children.push(child);
    });
    return children;
  }

  return [node];
};

exports.FancyTree = FancyTree$1;
exports.TreeProvider = TreeProvider;
exports.getToggleFiles = getToggleFiles;
exports.useTreeContext = useTreeContext;
//# sourceMappingURL=index.js.map
