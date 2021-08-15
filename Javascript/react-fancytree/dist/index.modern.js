import React, { useState, useCallback, memo, useRef, useEffect } from 'react';
import clsx from 'clsx';
import _, { mapValues, mapKeys, keys, map } from 'lodash';
import $ from 'jquery';
import 'jquery-ui';
import 'jquery.fancytree';
import 'jquery.fancytree/dist/modules/jquery.fancytree.filter';
import 'jquery.fancytree/dist/modules/jquery.fancytree.glyph';
import constate from 'constate';
import { useImmerReducer } from 'use-immer';
import 'immer';
import { toTree } from '@ttungbmt/tree-js';
import { useContextMenu, Menu, Item, contextMenu } from 'react-contexify';
import 'react-contexify/dist/ReactContexify.css';

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

const initialState = {
  loading: false,
  ids: [],
  entities: {}
};

const updateIds = state => void (state.ids = keys(state.entities));

const caseReducers = {
  setLoading: (state, {
    payload
  }) => state.loading = payload,
  setAll: (state, {
    payload
  }) => {
    state.entities = mapKeys(payload.map(v => {
      if (!v.folder && !v.icon) v.icon = false;
      return v;
    }), 'id');
    updateIds(state);
  },
  select: (state, {
    payload
  }) => {
    payload.ids.map(id => state.entities[id].selected = payload.selected);
  },
  selectOne: (state, {
    payload: {
      ids,
      selected,
      siblingIds
    }
  }) => {
    siblingIds.map(id => state.entities[id].selected = !selected);
    ids.map(id => state.entities[id].selected = selected);
  },
  setExpand: (state, {
    payload: id
  }) => {
    if (state.entities[id]) state.entities[id].expanded = true;
  },
  setCollapse: (state, {
    payload: id
  }) => {
    if (state.entities[id]) state.entities[id].expanded = false;
  },
  updateItem: (state, {
    payload
  }) => {
    let entity = state.entities[payload.id];
    map(payload.changes, (v, k) => entity[k] = v);
  }
};

const reducer = (draft, action) => void caseReducers[action.type](draft, action);

function useTree() {
  const [state, dispatch] = useImmerReducer(reducer, initialState);
  const [tree, setTree] = useState(undefined);
  const actions = useCallback(() => _extends({}, mapValues(caseReducers, (action, type) => payload => dispatch({
    type,
    payload
  })), {
    expandAll: () => tree.expandAll(),
    collapseAll: () => tree.expandAll(false),
    toggleExpandAll: () => tree.visit(node => node.toggleExpanded())
  }), [tree]);
  return _extends({}, actions(), {
    tree,
    setTree,
    dispatch,
    source: toTree(state.ids.map(id => state.entities[id]))
  });
}

const [TreeProvider, useTreeContext] = constate(useTree);

const _excluded2 = ["id", "style", "className", "children", "source", "onItemClick"];
const events = ['blurTree', 'create', 'init', 'focusTree', 'restore', 'activate', 'beforeActivate', 'beforeExpand', 'beforeSelect', 'blur', 'click', 'collapse', 'createNode', 'dblclick', 'deactivate', 'expand', 'focus', 'keydown', 'keypress', 'lazyLoad', 'loadChildren', 'loadError', 'postProcess', 'modifyChild', 'renderNode', 'renderTitle', 'select'];

const toEventFuncs = props => _.chain(events).mapKeys(n => n).mapValues(n => (...args) => {
  let eventName = `on${_.upperFirst(n)}`;
  props[eventName] && props[eventName](...args);
}).value();

function useTreeElement(treeRef, props) {
  const {
    tree,
    setTree
  } = useTreeContext();
  const options = _.omit(props.options, events) || {};
  useEffect(() => {

    if (treeRef.current) {
      let eventFns = toEventFuncs(props);
      $(treeRef.current).fancytree(_extends({}, eventFns, options, {
        source: props.source,
        renderNode: function (event, {
          node
        }) {
          let $el = $(node.span).find('.label-feature-count'),
              count = node.data.count;

          if (count && !$el.length) {
            $(node.span).append($(`<div class="label-feature-count">${count}</div>`));
          }

          $(node.span).find('.fancytree-title').contextmenu(e => {
            contextMenu.show({
              id: MENU_ID,
              event: e,
              props: _extends({}, node.data, _.pick(node, ['title', 'type']))
            });
          });
        }
      }));
      setTree($.ui.fancytree.getTree(treeRef.current));
    }

    return () => {
      if (!treeRef.current) {
        tree && tree.destroy();
        setTree(null);
      }
    };
  }, []);
}

const MENU_ID = "layers";

function FancyTree(_ref) {
  let {
    id,
    style,
    className,
    children,
    source,
    onItemClick
  } = _ref,
      props = _objectWithoutPropertiesLoose(_ref, _excluded2);

  const treeRef = useRef(null);
  const {
    show,
    hideAll
  } = useContextMenu({
    id: MENU_ID
  });
  useTreeElement(treeRef, _extends({}, props, {
    source,
    show
  }));
  return /*#__PURE__*/React.createElement("div", {
    id: id,
    className: clsx(className),
    style: style,
    ref: treeRef
  }, children ? children : /*#__PURE__*/React.createElement("ul", {
    style: {
      display: 'none'
    }
  }), /*#__PURE__*/React.createElement(Menu, {
    id: MENU_ID
  }, /*#__PURE__*/React.createElement(Item, {
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
  onItemClick: () => {}
};
var FancyTree$1 = memo(FancyTree);

const getToggleFiles = node => {
  if (node.isFolder()) {
    let children = [];
    node.visit(child => {
      !child.isFolder() && children.push(child);
    });
    return children;
  }

  return [node];
};

export { FancyTree$1 as FancyTree, TreeProvider, getToggleFiles, useTreeContext };
//# sourceMappingURL=index.modern.js.map
