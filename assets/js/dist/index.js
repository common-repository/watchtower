!function(t){var e={};function n(r){if(e[r])return e[r].exports;var o=e[r]={i:r,l:!1,exports:{}};return t[r].call(o.exports,o,o.exports,n),o.l=!0,o.exports}n.m=t,n.c=e,n.d=function(t,e,r){n.o(t,e)||Object.defineProperty(t,e,{enumerable:!0,get:r})},n.r=function(t){"undefined"!=typeof Symbol&&Symbol.toStringTag&&Object.defineProperty(t,Symbol.toStringTag,{value:"Module"}),Object.defineProperty(t,"__esModule",{value:!0})},n.t=function(t,e){if(1&e&&(t=n(t)),8&e)return t;if(4&e&&"object"==typeof t&&t&&t.__esModule)return t;var r=Object.create(null);if(n.r(r),Object.defineProperty(r,"default",{enumerable:!0,value:t}),2&e&&"string"!=typeof t)for(var o in t)n.d(r,o,function(e){return t[e]}.bind(null,o));return r},n.n=function(t){var e=t&&t.__esModule?function(){return t.default}:function(){return t};return n.d(e,"a",e),e},n.o=function(t,e){return Object.prototype.hasOwnProperty.call(t,e)},n.p="",n(n.s=17)}([function(t,e){!function(){t.exports=this.wp.element}()},function(t,e){t.exports=function(t){if(void 0===t)throw new ReferenceError("this hasn't been initialised - super() hasn't been called");return t}},function(t,e){t.exports=function(t,e,n){return e in t?Object.defineProperty(t,e,{value:n,enumerable:!0,configurable:!0,writable:!0}):t[e]=n,t}},function(t,e,n){var r=n(11),o=n(12),c=n(13),a=n(14);t.exports=function(t){return r(t)||o(t)||c(t)||a()}},function(t,e){t.exports=watchtowerContacts},function(t,e){function n(e){return t.exports=n=Object.setPrototypeOf?Object.getPrototypeOf:function(t){return t.__proto__||Object.getPrototypeOf(t)},n(e)}t.exports=n},function(t,e){t.exports=function(t,e){(null==e||e>t.length)&&(e=t.length);for(var n=0,r=new Array(e);n<e;n++)r[n]=t[n];return r}},function(t,e){t.exports=function(t,e){if(!(t instanceof e))throw new TypeError("Cannot call a class as a function")}},function(t,e){function n(t,e){for(var n=0;n<e.length;n++){var r=e[n];r.enumerable=r.enumerable||!1,r.configurable=!0,"value"in r&&(r.writable=!0),Object.defineProperty(t,r.key,r)}}t.exports=function(t,e,r){return e&&n(t.prototype,e),r&&n(t,r),t}},function(t,e,n){var r=n(15);t.exports=function(t,e){if("function"!=typeof e&&null!==e)throw new TypeError("Super expression must either be null or a function");t.prototype=Object.create(e&&e.prototype,{constructor:{value:t,writable:!0,configurable:!0}}),e&&r(t,e)}},function(t,e,n){var r=n(16),o=n(1);t.exports=function(t,e){return!e||"object"!==r(e)&&"function"!=typeof e?o(t):e}},function(t,e,n){var r=n(6);t.exports=function(t){if(Array.isArray(t))return r(t)}},function(t,e){t.exports=function(t){if("undefined"!=typeof Symbol&&Symbol.iterator in Object(t))return Array.from(t)}},function(t,e,n){var r=n(6);t.exports=function(t,e){if(t){if("string"==typeof t)return r(t,e);var n=Object.prototype.toString.call(t).slice(8,-1);return"Object"===n&&t.constructor&&(n=t.constructor.name),"Map"===n||"Set"===n?Array.from(t):"Arguments"===n||/^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(n)?r(t,e):void 0}}},function(t,e){t.exports=function(){throw new TypeError("Invalid attempt to spread non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method.")}},function(t,e){function n(e,r){return t.exports=n=Object.setPrototypeOf||function(t,e){return t.__proto__=e,t},n(e,r)}t.exports=n},function(t,e){function n(e){return"function"==typeof Symbol&&"symbol"==typeof Symbol.iterator?t.exports=n=function(t){return typeof t}:t.exports=n=function(t){return t&&"function"==typeof Symbol&&t.constructor===Symbol&&t!==Symbol.prototype?"symbol":typeof t},n(e)}t.exports=n},function(t,e,n){"use strict";n.r(e);var r=n(0),o=n(3),c=n.n(o),a=n(7),i=n.n(a),u=n(8),l=n.n(u),f=n(1),s=n.n(f),p=n(9),d=n.n(p),b=n(10),y=n.n(b),m=n(5),v=n.n(m),O=n(2),h=n.n(O);function j(t,e){var n=Object.keys(t);if(Object.getOwnPropertySymbols){var r=Object.getOwnPropertySymbols(t);e&&(r=r.filter((function(e){return Object.getOwnPropertyDescriptor(t,e).enumerable}))),n.push.apply(n,r)}return n}function g(t){var e=function(){if("undefined"==typeof Reflect||!Reflect.construct)return!1;if(Reflect.construct.sham)return!1;if("function"==typeof Proxy)return!0;try{return Date.prototype.toString.call(Reflect.construct(Date,[],(function(){}))),!0}catch(t){return!1}}();return function(){var n,r=v()(t);if(e){var o=v()(this).constructor;n=Reflect.construct(r,arguments,o)}else n=r.apply(this,arguments);return y()(this,n)}}var E=function(t){d()(n,t);var e=g(n);function n(t){var o;i()(this,n),o=e.call(this,t),h()(s()(o),"addContactHandler",(function(t){t.preventDefault();var e={id:Math.floor(Math.random()*Date.now()),contact_type_id:1,endpoint:"",key:"",active:1},n=c()(o.state.contacts);n.push(e),o.setState({contacts:n})})),h()(s()(o),"changeTypeHandler",(function(t,e){var n=c()(o.state.contacts);n=n.map((function(n){return n.id==e&&(n.contact_type_id=t.target.options[t.target.selectedIndex].value),n})),o.setState({contacts:n})})),h()(s()(o),"changeEndpointHandler",(function(t,e){var n=c()(o.state.contacts);n=n.map((function(n){return n.id==e&&(n.endpoint=t.target.value),n})),o.setState({contacts:n})})),h()(s()(o),"changeActiveHandler",(function(t,e){var n=c()(o.state.contacts);n=n.map((function(n){return n.id==e&&(n.active=t.target.checked?1:0),n})),o.setState({contacts:n})})),h()(s()(o),"deleteContactHandler",(function(t,e){t.preventDefault();var n=c()(o.state.contacts);n=n.filter((function(t){return t.id!=e})),o.setState({contacts:n})})),h()(s()(o),"getSaveData",(function(){var t=c()(o.state.contacts);return t=t.map((function(t){var e=function(t){for(var e=1;e<arguments.length;e++){var n=null!=arguments[e]?arguments[e]:{};e%2?j(Object(n),!0).forEach((function(e){h()(t,e,n[e])})):Object.getOwnPropertyDescriptors?Object.defineProperties(t,Object.getOwnPropertyDescriptors(n)):j(Object(n)).forEach((function(e){Object.defineProperty(t,e,Object.getOwnPropertyDescriptor(n,e))}))}return t}({},t);return delete e.id,e}))})),h()(s()(o),"renderContactFields",(function(){return o.state.contacts.map((function(t,e){var n=2==t.contact_type_id?Object(r.createElement)("p",{class:"description"},"Phone numbers should be in the format of +15556667777"):null,c="basic"==o.state.accountPlan,a="basic"==o.state.accountPlan?"SMS (Pro only)":"SMS",i=!!t.active;return Object(r.createElement)("tr",null,Object(r.createElement)("th",null,"Contact ",e+1),Object(r.createElement)("td",null,Object(r.createElement)("select",{name:"contact_type_id[]",onChange:function(e){o.changeTypeHandler(e,t.id)}},Object(r.createElement)("option",{value:"1",selected:1==t.contact_type_id},"Email"),Object(r.createElement)("option",{value:"2",selected:2==t.contact_type_id,disabled:c},a)),Object(r.createElement)("input",{type:"text",name:"endpoint[]",onChange:function(e){o.changeEndpointHandler(e,t.id)},value:t.endpoint,className:"regular-text"}),Object(r.createElement)("br",null),Object(r.createElement)("fieldset",{style:{marginTop:"5px"}},Object(r.createElement)("label",{for:"enabled"},Object(r.createElement)("input",{name:"active[]",type:"checkbox",id:"enabled",value:"1",onChange:function(e){o.changeActiveHandler(e,t.id)},defaultChecked:i}),"Enabled (or ",Object(r.createElement)("a",{href:"#delete",onClick:function(e){o.deleteContactHandler(e,t.id)},style:{color:"red"}},"Delete"),")")),n,Object(r.createElement)("input",{type:"hidden",name:"key[]",value:t.key})))}))}));var a=t.contacts.map((function(t){return t.id=Math.floor(Math.random()*Date.now()),t}));return o.state={contacts:a,accountPlan:t.accountPlan},o}return l()(n,[{key:"render",value:function(){var t=this;return Object(r.createElement)("div",null,Object(r.createElement)("table",{className:"form-table",id:"contacts"},Object(r.createElement)("tbody",null,this.renderContactFields())),Object(r.createElement)("button",{onClick:function(e){t.addContactHandler(e)},className:"button"},"+ Add New Contact"),Object(r.createElement)("form",{method:"post"},Object(r.createElement)("input",{type:"hidden",name:"watchtower_nonce",value:this.props.nonce}),Object(r.createElement)("input",{type:"hidden",name:"watchtower_contacts",value:JSON.stringify(this.getSaveData())}),Object(r.createElement)("p",{className:"submit"},Object(r.createElement)("input",{type:"submit",className:"button button-primary",value:"Save Changes"}))))}}]),n}(r.Component),x=n(4);Object(r.render)(Object(r.createElement)(E,{contacts:x.contacts,accountPlan:x.accountPlan,nonce:x.nonce}),document.querySelector("div#watchtower-contacts"))}]);