/*! For license information please see theme.js.LICENSE.txt */
(()=>{"use strict";var t,e={54:()=>{function t(t){return getComputedStyle(t)}function e(t,e){for(var i in e){var n=e[i];"number"==typeof n&&(n+="px"),t.style[i]=n}return t}function i(t){var e=document.createElement("div");return e.className=t,e}var n="undefined"!=typeof Element&&(Element.prototype.matches||Element.prototype.webkitMatchesSelector||Element.prototype.mozMatchesSelector||Element.prototype.msMatchesSelector);function r(t,e){if(!n)throw new Error("No element matching method supported");return n.call(t,e)}function l(t){t.remove?t.remove():t.parentNode&&t.parentNode.removeChild(t)}function o(t,e){return Array.prototype.filter.call(t.children,(function(t){return r(t,e)}))}var s="ps",a="ps__rtl",c={thumb:function(t){return"ps__thumb-"+t},rail:function(t){return"ps__rail-"+t},consuming:"ps__child--consume"},h={focus:"ps--focus",clicking:"ps--clicking",active:function(t){return"ps--active-"+t},scrolling:function(t){return"ps--scrolling-"+t}},d={x:null,y:null};function u(t,e){var i=t.element.classList,n=h.scrolling(e);i.contains(n)?clearTimeout(d[e]):i.add(n)}function f(t,e){d[e]=setTimeout((function(){return t.isAlive&&t.element.classList.remove(h.scrolling(e))}),t.settings.scrollingThreshold)}var p=function(t){this.element=t,this.handlers={}},b={isEmpty:{configurable:!0}};p.prototype.bind=function(t,e){void 0===this.handlers[t]&&(this.handlers[t]=[]),this.handlers[t].push(e),this.element.addEventListener(t,e,!1)},p.prototype.unbind=function(t,e){var i=this;this.handlers[t]=this.handlers[t].filter((function(n){return!(!e||n===e)||(i.element.removeEventListener(t,n,!1),!1)}))},p.prototype.unbindAll=function(){for(var t in this.handlers)this.unbind(t)},b.isEmpty.get=function(){var t=this;return Object.keys(this.handlers).every((function(e){return 0===t.handlers[e].length}))},Object.defineProperties(p.prototype,b);var g=function(){this.eventElements=[]};function v(t){if("function"==typeof window.CustomEvent)return new CustomEvent(t);var e=document.createEvent("CustomEvent");return e.initCustomEvent(t,!1,!1,void 0),e}function m(t,e,i,n,r){var l;if(void 0===n&&(n=!0),void 0===r&&(r=!1),"top"===e)l=["contentHeight","containerHeight","scrollTop","y","up","down"];else{if("left"!==e)throw new Error("A proper axis should be provided");l=["contentWidth","containerWidth","scrollLeft","x","left","right"]}!function(t,e,i,n,r){var l=i[0],o=i[1],s=i[2],a=i[3],c=i[4],h=i[5];void 0===n&&(n=!0);void 0===r&&(r=!1);var d=t.element;t.reach[a]=null,d[s]<1&&(t.reach[a]="start");d[s]>t[l]-t[o]-1&&(t.reach[a]="end");e&&(d.dispatchEvent(v("ps-scroll-"+a)),e<0?d.dispatchEvent(v("ps-scroll-"+c)):e>0&&d.dispatchEvent(v("ps-scroll-"+h)),n&&function(t,e){u(t,e),f(t,e)}(t,a));t.reach[a]&&(e||r)&&d.dispatchEvent(v("ps-"+a+"-reach-"+t.reach[a]))}(t,i,l,n,r)}function y(t){return parseInt(t,10)||0}g.prototype.eventElement=function(t){var e=this.eventElements.filter((function(e){return e.element===t}))[0];return e||(e=new p(t),this.eventElements.push(e)),e},g.prototype.bind=function(t,e,i){this.eventElement(t).bind(e,i)},g.prototype.unbind=function(t,e,i){var n=this.eventElement(t);n.unbind(e,i),n.isEmpty&&this.eventElements.splice(this.eventElements.indexOf(n),1)},g.prototype.unbindAll=function(){this.eventElements.forEach((function(t){return t.unbindAll()})),this.eventElements=[]},g.prototype.once=function(t,e,i){var n=this.eventElement(t),r=function(t){n.unbind(e,r),i(t)};n.bind(e,r)};var w={isWebKit:"undefined"!=typeof document&&"WebkitAppearance"in document.documentElement.style,supportsTouch:"undefined"!=typeof window&&("ontouchstart"in window||"maxTouchPoints"in window.navigator&&window.navigator.maxTouchPoints>0||window.DocumentTouch&&document instanceof window.DocumentTouch),supportsIePointer:"undefined"!=typeof navigator&&navigator.msMaxTouchPoints,isChrome:"undefined"!=typeof navigator&&/Chrome/i.test(navigator&&navigator.userAgent)};function Y(t){var i=t.element,n=Math.floor(i.scrollTop),r=i.getBoundingClientRect();t.containerWidth=Math.ceil(r.width),t.containerHeight=Math.ceil(r.height),t.contentWidth=i.scrollWidth,t.contentHeight=i.scrollHeight,i.contains(t.scrollbarXRail)||(o(i,c.rail("x")).forEach((function(t){return l(t)})),i.appendChild(t.scrollbarXRail)),i.contains(t.scrollbarYRail)||(o(i,c.rail("y")).forEach((function(t){return l(t)})),i.appendChild(t.scrollbarYRail)),!t.settings.suppressScrollX&&t.containerWidth+t.settings.scrollXMarginOffset<t.contentWidth?(t.scrollbarXActive=!0,t.railXWidth=t.containerWidth-t.railXMarginWidth,t.railXRatio=t.containerWidth/t.railXWidth,t.scrollbarXWidth=X(t,y(t.railXWidth*t.containerWidth/t.contentWidth)),t.scrollbarXLeft=y((t.negativeScrollAdjustment+i.scrollLeft)*(t.railXWidth-t.scrollbarXWidth)/(t.contentWidth-t.containerWidth))):t.scrollbarXActive=!1,!t.settings.suppressScrollY&&t.containerHeight+t.settings.scrollYMarginOffset<t.contentHeight?(t.scrollbarYActive=!0,t.railYHeight=t.containerHeight-t.railYMarginHeight,t.railYRatio=t.containerHeight/t.railYHeight,t.scrollbarYHeight=X(t,y(t.railYHeight*t.containerHeight/t.contentHeight)),t.scrollbarYTop=y(n*(t.railYHeight-t.scrollbarYHeight)/(t.contentHeight-t.containerHeight))):t.scrollbarYActive=!1,t.scrollbarXLeft>=t.railXWidth-t.scrollbarXWidth&&(t.scrollbarXLeft=t.railXWidth-t.scrollbarXWidth),t.scrollbarYTop>=t.railYHeight-t.scrollbarYHeight&&(t.scrollbarYTop=t.railYHeight-t.scrollbarYHeight),function(t,i){var n={width:i.railXWidth},r=Math.floor(t.scrollTop);i.isRtl?n.left=i.negativeScrollAdjustment+t.scrollLeft+i.containerWidth-i.contentWidth:n.left=t.scrollLeft;i.isScrollbarXUsingBottom?n.bottom=i.scrollbarXBottom-r:n.top=i.scrollbarXTop+r;e(i.scrollbarXRail,n);var l={top:r,height:i.railYHeight};i.isScrollbarYUsingRight?i.isRtl?l.right=i.contentWidth-(i.negativeScrollAdjustment+t.scrollLeft)-i.scrollbarYRight-i.scrollbarYOuterWidth-9:l.right=i.scrollbarYRight-t.scrollLeft:i.isRtl?l.left=i.negativeScrollAdjustment+t.scrollLeft+2*i.containerWidth-i.contentWidth-i.scrollbarYLeft-i.scrollbarYOuterWidth:l.left=i.scrollbarYLeft+t.scrollLeft;e(i.scrollbarYRail,l),e(i.scrollbarX,{left:i.scrollbarXLeft,width:i.scrollbarXWidth-i.railBorderXWidth}),e(i.scrollbarY,{top:i.scrollbarYTop,height:i.scrollbarYHeight-i.railBorderYWidth})}(i,t),t.scrollbarXActive?i.classList.add(h.active("x")):(i.classList.remove(h.active("x")),t.scrollbarXWidth=0,t.scrollbarXLeft=0,i.scrollLeft=!0===t.isRtl?t.contentWidth:0),t.scrollbarYActive?i.classList.add(h.active("y")):(i.classList.remove(h.active("y")),t.scrollbarYHeight=0,t.scrollbarYTop=0,i.scrollTop=0)}function X(t,e){return t.settings.minScrollbarLength&&(e=Math.max(e,t.settings.minScrollbarLength)),t.settings.maxScrollbarLength&&(e=Math.min(e,t.settings.maxScrollbarLength)),e}function L(t,e){var i=e[0],n=e[1],r=e[2],l=e[3],o=e[4],s=e[5],a=e[6],c=e[7],d=e[8],p=t.element,b=null,g=null,v=null;function m(e){e.touches&&e.touches[0]&&(e[r]=e.touches[0].pageY),p[a]=b+v*(e[r]-g),u(t,c),Y(t),e.stopPropagation(),e.preventDefault()}function y(){f(t,c),t[d].classList.remove(h.clicking),t.event.unbind(t.ownerDocument,"mousemove",m)}function w(e,o){b=p[a],o&&e.touches&&(e[r]=e.touches[0].pageY),g=e[r],v=(t[n]-t[i])/(t[l]-t[s]),o?t.event.bind(t.ownerDocument,"touchmove",m):(t.event.bind(t.ownerDocument,"mousemove",m),t.event.once(t.ownerDocument,"mouseup",y),e.preventDefault()),t[d].classList.add(h.clicking),e.stopPropagation()}t.event.bind(t[o],"mousedown",(function(t){w(t)})),t.event.bind(t[o],"touchstart",(function(t){w(t,!0)}))}var W={"click-rail":function(t){t.element,t.event.bind(t.scrollbarY,"mousedown",(function(t){return t.stopPropagation()})),t.event.bind(t.scrollbarYRail,"mousedown",(function(e){var i=e.pageY-window.pageYOffset-t.scrollbarYRail.getBoundingClientRect().top>t.scrollbarYTop?1:-1;t.element.scrollTop+=i*t.containerHeight,Y(t),e.stopPropagation()})),t.event.bind(t.scrollbarX,"mousedown",(function(t){return t.stopPropagation()})),t.event.bind(t.scrollbarXRail,"mousedown",(function(e){var i=e.pageX-window.pageXOffset-t.scrollbarXRail.getBoundingClientRect().left>t.scrollbarXLeft?1:-1;t.element.scrollLeft+=i*t.containerWidth,Y(t),e.stopPropagation()}))},"drag-thumb":function(t){L(t,["containerWidth","contentWidth","pageX","railXWidth","scrollbarX","scrollbarXWidth","scrollLeft","x","scrollbarXRail"]),L(t,["containerHeight","contentHeight","pageY","railYHeight","scrollbarY","scrollbarYHeight","scrollTop","y","scrollbarYRail"])},keyboard:function(t){var e=t.element;t.event.bind(t.ownerDocument,"keydown",(function(i){if(!(i.isDefaultPrevented&&i.isDefaultPrevented()||i.defaultPrevented)&&(r(e,":hover")||r(t.scrollbarX,":focus")||r(t.scrollbarY,":focus"))){var n,l=document.activeElement?document.activeElement:t.ownerDocument.activeElement;if(l){if("IFRAME"===l.tagName)l=l.contentDocument.activeElement;else for(;l.shadowRoot;)l=l.shadowRoot.activeElement;if(r(n=l,"input,[contenteditable]")||r(n,"select,[contenteditable]")||r(n,"textarea,[contenteditable]")||r(n,"button,[contenteditable]"))return}var o=0,s=0;switch(i.which){case 37:o=i.metaKey?-t.contentWidth:i.altKey?-t.containerWidth:-30;break;case 38:s=i.metaKey?t.contentHeight:i.altKey?t.containerHeight:30;break;case 39:o=i.metaKey?t.contentWidth:i.altKey?t.containerWidth:30;break;case 40:s=i.metaKey?-t.contentHeight:i.altKey?-t.containerHeight:-30;break;case 32:s=i.shiftKey?t.containerHeight:-t.containerHeight;break;case 33:s=t.containerHeight;break;case 34:s=-t.containerHeight;break;case 36:s=t.contentHeight;break;case 35:s=-t.contentHeight;break;default:return}t.settings.suppressScrollX&&0!==o||t.settings.suppressScrollY&&0!==s||(e.scrollTop-=s,e.scrollLeft+=o,Y(t),function(i,n){var r=Math.floor(e.scrollTop);if(0===i){if(!t.scrollbarYActive)return!1;if(0===r&&n>0||r>=t.contentHeight-t.containerHeight&&n<0)return!t.settings.wheelPropagation}var l=e.scrollLeft;if(0===n){if(!t.scrollbarXActive)return!1;if(0===l&&i<0||l>=t.contentWidth-t.containerWidth&&i>0)return!t.settings.wheelPropagation}return!0}(o,s)&&i.preventDefault())}}))},wheel:function(e){var i=e.element;function n(n){var r=function(t){var e=t.deltaX,i=-1*t.deltaY;return void 0!==e&&void 0!==i||(e=-1*t.wheelDeltaX/6,i=t.wheelDeltaY/6),t.deltaMode&&1===t.deltaMode&&(e*=10,i*=10),e!=e&&i!=i&&(e=0,i=t.wheelDelta),t.shiftKey?[-i,-e]:[e,i]}(n),l=r[0],o=r[1];if(!function(e,n,r){if(!w.isWebKit&&i.querySelector("select:focus"))return!0;if(!i.contains(e))return!1;for(var l=e;l&&l!==i;){if(l.classList.contains(c.consuming))return!0;var o=t(l);if(r&&o.overflowY.match(/(scroll|auto)/)){var s=l.scrollHeight-l.clientHeight;if(s>0&&(l.scrollTop>0&&r<0||l.scrollTop<s&&r>0))return!0}if(n&&o.overflowX.match(/(scroll|auto)/)){var a=l.scrollWidth-l.clientWidth;if(a>0&&(l.scrollLeft>0&&n<0||l.scrollLeft<a&&n>0))return!0}l=l.parentNode}return!1}(n.target,l,o)){var s=!1;e.settings.useBothWheelAxes?e.scrollbarYActive&&!e.scrollbarXActive?(o?i.scrollTop-=o*e.settings.wheelSpeed:i.scrollTop+=l*e.settings.wheelSpeed,s=!0):e.scrollbarXActive&&!e.scrollbarYActive&&(l?i.scrollLeft+=l*e.settings.wheelSpeed:i.scrollLeft-=o*e.settings.wheelSpeed,s=!0):(i.scrollTop-=o*e.settings.wheelSpeed,i.scrollLeft+=l*e.settings.wheelSpeed),Y(e),(s=s||function(t,n){var r=Math.floor(i.scrollTop),l=0===i.scrollTop,o=r+i.offsetHeight===i.scrollHeight,s=0===i.scrollLeft,a=i.scrollLeft+i.offsetWidth===i.scrollWidth;return!(Math.abs(n)>Math.abs(t)?l||o:s||a)||!e.settings.wheelPropagation}(l,o))&&!n.ctrlKey&&(n.stopPropagation(),n.preventDefault())}}void 0!==window.onwheel?e.event.bind(i,"wheel",n):void 0!==window.onmousewheel&&e.event.bind(i,"mousewheel",n)},touch:function(e){if(w.supportsTouch||w.supportsIePointer){var i=e.element,n={},r=0,l={},o=null;w.supportsTouch?(e.event.bind(i,"touchstart",d),e.event.bind(i,"touchmove",u),e.event.bind(i,"touchend",f)):w.supportsIePointer&&(window.PointerEvent?(e.event.bind(i,"pointerdown",d),e.event.bind(i,"pointermove",u),e.event.bind(i,"pointerup",f)):window.MSPointerEvent&&(e.event.bind(i,"MSPointerDown",d),e.event.bind(i,"MSPointerMove",u),e.event.bind(i,"MSPointerUp",f)))}function s(t,n){i.scrollTop-=n,i.scrollLeft-=t,Y(e)}function a(t){return t.targetTouches?t.targetTouches[0]:t}function h(t){return(!t.pointerType||"pen"!==t.pointerType||0!==t.buttons)&&(!(!t.targetTouches||1!==t.targetTouches.length)||!(!t.pointerType||"mouse"===t.pointerType||t.pointerType===t.MSPOINTER_TYPE_MOUSE))}function d(t){if(h(t)){var e=a(t);n.pageX=e.pageX,n.pageY=e.pageY,r=(new Date).getTime(),null!==o&&clearInterval(o)}}function u(o){if(h(o)){var d=a(o),u={pageX:d.pageX,pageY:d.pageY},f=u.pageX-n.pageX,p=u.pageY-n.pageY;if(function(e,n,r){if(!i.contains(e))return!1;for(var l=e;l&&l!==i;){if(l.classList.contains(c.consuming))return!0;var o=t(l);if(r&&o.overflowY.match(/(scroll|auto)/)){var s=l.scrollHeight-l.clientHeight;if(s>0&&(l.scrollTop>0&&r<0||l.scrollTop<s&&r>0))return!0}if(n&&o.overflowX.match(/(scroll|auto)/)){var a=l.scrollWidth-l.clientWidth;if(a>0&&(l.scrollLeft>0&&n<0||l.scrollLeft<a&&n>0))return!0}l=l.parentNode}return!1}(o.target,f,p))return;s(f,p),n=u;var b=(new Date).getTime(),g=b-r;g>0&&(l.x=f/g,l.y=p/g,r=b),function(t,n){var r=Math.floor(i.scrollTop),l=i.scrollLeft,o=Math.abs(t),s=Math.abs(n);if(s>o){if(n<0&&r===e.contentHeight-e.containerHeight||n>0&&0===r)return 0===window.scrollY&&n>0&&w.isChrome}else if(o>s&&(t<0&&l===e.contentWidth-e.containerWidth||t>0&&0===l))return!0;return!0}(f,p)&&o.preventDefault()}}function f(){e.settings.swipeEasing&&(clearInterval(o),o=setInterval((function(){e.isInitialized?clearInterval(o):l.x||l.y?Math.abs(l.x)<.01&&Math.abs(l.y)<.01?clearInterval(o):(s(30*l.x,30*l.y),l.x*=.8,l.y*=.8):clearInterval(o)}),10))}}},S=function(n,r){var l=this;if(void 0===r&&(r={}),"string"==typeof n&&(n=document.querySelector(n)),!n||!n.nodeName)throw new Error("no element is specified to initialize PerfectScrollbar");for(var o in this.element=n,n.classList.add(s),this.settings={handlers:["click-rail","drag-thumb","keyboard","wheel","touch"],maxScrollbarLength:null,minScrollbarLength:null,scrollingThreshold:1e3,scrollXMarginOffset:0,scrollYMarginOffset:0,suppressScrollX:!1,suppressScrollY:!1,swipeEasing:!0,useBothWheelAxes:!1,wheelPropagation:!0,wheelSpeed:1},r)this.settings[o]=r[o];this.containerWidth=null,this.containerHeight=null,this.contentWidth=null,this.contentHeight=null;var d,u,f=function(){return n.classList.add(h.focus)},p=function(){return n.classList.remove(h.focus)};this.isRtl="rtl"===t(n).direction,!0===this.isRtl&&n.classList.add(a),this.isNegativeScroll=(u=n.scrollLeft,n.scrollLeft=-1,d=n.scrollLeft<0,n.scrollLeft=u,d),this.negativeScrollAdjustment=this.isNegativeScroll?n.scrollWidth-n.clientWidth:0,this.event=new g,this.ownerDocument=n.ownerDocument||document,this.scrollbarXRail=i(c.rail("x")),n.appendChild(this.scrollbarXRail),this.scrollbarX=i(c.thumb("x")),this.scrollbarXRail.appendChild(this.scrollbarX),this.scrollbarX.setAttribute("tabindex",0),this.event.bind(this.scrollbarX,"focus",f),this.event.bind(this.scrollbarX,"blur",p),this.scrollbarXActive=null,this.scrollbarXWidth=null,this.scrollbarXLeft=null;var b=t(this.scrollbarXRail);this.scrollbarXBottom=parseInt(b.bottom,10),isNaN(this.scrollbarXBottom)?(this.isScrollbarXUsingBottom=!1,this.scrollbarXTop=y(b.top)):this.isScrollbarXUsingBottom=!0,this.railBorderXWidth=y(b.borderLeftWidth)+y(b.borderRightWidth),e(this.scrollbarXRail,{display:"block"}),this.railXMarginWidth=y(b.marginLeft)+y(b.marginRight),e(this.scrollbarXRail,{display:""}),this.railXWidth=null,this.railXRatio=null,this.scrollbarYRail=i(c.rail("y")),n.appendChild(this.scrollbarYRail),this.scrollbarY=i(c.thumb("y")),this.scrollbarYRail.appendChild(this.scrollbarY),this.scrollbarY.setAttribute("tabindex",0),this.event.bind(this.scrollbarY,"focus",f),this.event.bind(this.scrollbarY,"blur",p),this.scrollbarYActive=null,this.scrollbarYHeight=null,this.scrollbarYTop=null;var v=t(this.scrollbarYRail);this.scrollbarYRight=parseInt(v.right,10),isNaN(this.scrollbarYRight)?(this.isScrollbarYUsingRight=!1,this.scrollbarYLeft=y(v.left)):this.isScrollbarYUsingRight=!0,this.scrollbarYOuterWidth=this.isRtl?function(e){var i=t(e);return y(i.width)+y(i.paddingLeft)+y(i.paddingRight)+y(i.borderLeftWidth)+y(i.borderRightWidth)}(this.scrollbarY):null,this.railBorderYWidth=y(v.borderTopWidth)+y(v.borderBottomWidth),e(this.scrollbarYRail,{display:"block"}),this.railYMarginHeight=y(v.marginTop)+y(v.marginBottom),e(this.scrollbarYRail,{display:""}),this.railYHeight=null,this.railYRatio=null,this.reach={x:n.scrollLeft<=0?"start":n.scrollLeft>=this.contentWidth-this.containerWidth?"end":null,y:n.scrollTop<=0?"start":n.scrollTop>=this.contentHeight-this.containerHeight?"end":null},this.isAlive=!0,this.settings.handlers.forEach((function(t){return W[t](l)})),this.lastScrollTop=Math.floor(n.scrollTop),this.lastScrollLeft=n.scrollLeft,this.event.bind(this.element,"scroll",(function(t){return l.onScroll(t)})),Y(this)};S.prototype.update=function(){this.isAlive&&(this.negativeScrollAdjustment=this.isNegativeScroll?this.element.scrollWidth-this.element.clientWidth:0,e(this.scrollbarXRail,{display:"block"}),e(this.scrollbarYRail,{display:"block"}),this.railXMarginWidth=y(t(this.scrollbarXRail).marginLeft)+y(t(this.scrollbarXRail).marginRight),this.railYMarginHeight=y(t(this.scrollbarYRail).marginTop)+y(t(this.scrollbarYRail).marginBottom),e(this.scrollbarXRail,{display:"none"}),e(this.scrollbarYRail,{display:"none"}),Y(this),m(this,"top",0,!1,!0),m(this,"left",0,!1,!0),e(this.scrollbarXRail,{display:""}),e(this.scrollbarYRail,{display:""}))},S.prototype.onScroll=function(t){this.isAlive&&(Y(this),m(this,"top",this.element.scrollTop-this.lastScrollTop),m(this,"left",this.element.scrollLeft-this.lastScrollLeft),this.lastScrollTop=Math.floor(this.element.scrollTop),this.lastScrollLeft=this.element.scrollLeft)},S.prototype.destroy=function(){this.isAlive&&(this.event.unbindAll(),l(this.scrollbarX),l(this.scrollbarY),l(this.scrollbarXRail),l(this.scrollbarYRail),this.removePsClasses(),this.element=null,this.scrollbarX=null,this.scrollbarY=null,this.scrollbarXRail=null,this.scrollbarYRail=null,this.isAlive=!1)},S.prototype.removePsClasses=function(){this.element.className=this.element.className.split(" ").filter((function(t){return!t.match(/^ps([-_].+|)$/)})).join(" ")};const R=S;document.addEventListener("DOMContentLoaded",(function(){document.querySelector("meta[name=viewport]").setAttribute("content","width=device-width, initial-scale=1, shrink-to-fit=no"),document.querySelector(".w-sidebar").classList.add("sidebar-hidden");var t=document.createElement("span");if(t.className="hamburger-menu",document.querySelector(".content .h-header").prepend(t),t.addEventListener("click",(function(t){t.stopPropagation(),document.querySelector(".w-sidebar").classList.toggle("sidebar-hidden")}),!0),document.querySelectorAll(".w-sidebar a, .w-sidebar .cursor-pointer").forEach((function(t){t.addEventListener("click",(function(){document.querySelector(".w-sidebar").classList.add("sidebar-hidden")}),!1)})),document.querySelectorAll("body,html").forEach((function(t){t.addEventListener("click",(function(t){var e=document.querySelector(".w-sidebar");t.target===e||e.contains(t.target)||e.classList.add("sidebar-hidden")}))})),Nova.config.nt){if(document.querySelectorAll(".w-sidebar h4").forEach((function(t){(Nova.config.nt.hide_all_sidebar_headlines||-1!==Nova.config.nt.hidden_sidebar_headlines.indexOf(t.textContent))&&t.classList.add("hidden")})),Nova.config.nt.resource_tables_sticky_actions)document.querySelectorAll(".content").forEach((function(t){t.classList.add("sticky-actions")}));if(Nova.config.nt.resource_tables_sticky_actions_on_mobile)document.querySelectorAll(".content").forEach((function(t){t.classList.add("sticky-actions-on-mobile")}));if(Nova.config.nt.hide_update_and_continue_editing_button)document.querySelectorAll(".content").forEach((function(t){t.classList.add("hide-update-and-continue-editing-button")}));if(Nova.config.nt.hide_update_and_continue_editing_button_on_mobile)document.querySelectorAll(".content").forEach((function(t){t.classList.add("hide-update-and-continue-editing-button-on-mobile")}));if(Nova.config.nt.fixed_sidebar&&(document.querySelector("body").classList.add("fixed-sidebar"),document.querySelector(".sidebar-scroll")))new R(".sidebar-scroll");Nova.config.nt.fixed_navbar&&document.querySelector(".content .h-header").classList.add("sticky-navbar"),document.querySelector("#app-loader")&&(document.getElementById("app-loader").style.display="none")}}),!1)},936:()=>{}},i={};function n(t){var r=i[t];if(void 0!==r)return r.exports;var l=i[t]={exports:{}};return e[t](l,l.exports,n),l.exports}n.m=e,t=[],n.O=(e,i,r,l)=>{if(!i){var o=1/0;for(c=0;c<t.length;c++){for(var[i,r,l]=t[c],s=!0,a=0;a<i.length;a++)(!1&l||o>=l)&&Object.keys(n.O).every((t=>n.O[t](i[a])))?i.splice(a--,1):(s=!1,l<o&&(o=l));s&&(t.splice(c--,1),e=r())}return e}l=l||0;for(var c=t.length;c>0&&t[c-1][2]>l;c--)t[c]=t[c-1];t[c]=[i,r,l]},n.o=(t,e)=>Object.prototype.hasOwnProperty.call(t,e),(()=>{var t={8:0,676:0};n.O.j=e=>0===t[e];var e=(e,i)=>{var r,l,[o,s,a]=i,c=0;for(r in s)n.o(s,r)&&(n.m[r]=s[r]);for(a&&a(n),e&&e(i);c<o.length;c++)l=o[c],n.o(t,l)&&t[l]&&t[l][0](),t[o[c]]=0;n.O()},i=self.webpackChunk=self.webpackChunk||[];i.forEach(e.bind(null,0)),i.push=e.bind(null,i.push.bind(i))})(),n.O(void 0,[676],(()=>n(54)));var r=n.O(void 0,[676],(()=>n(936)));r=n.O(r)})();