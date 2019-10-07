var frontend_blocks=function(t){var e={};function n(o){if(e[o])return e[o].exports;var r=e[o]={i:o,l:!1,exports:{}};return t[o].call(r.exports,r,r.exports,n),r.l=!0,r.exports}return n.m=t,n.c=e,n.d=function(t,e,o){n.o(t,e)||Object.defineProperty(t,e,{enumerable:!0,get:o})},n.r=function(t){"undefined"!=typeof Symbol&&Symbol.toStringTag&&Object.defineProperty(t,Symbol.toStringTag,{value:"Module"}),Object.defineProperty(t,"__esModule",{value:!0})},n.t=function(t,e){if(1&e&&(t=n(t)),8&e)return t;if(4&e&&"object"==typeof t&&t&&t.__esModule)return t;var o=Object.create(null);if(n.r(o),Object.defineProperty(o,"default",{enumerable:!0,value:t}),2&e&&"string"!=typeof t)for(var r in t)n.d(o,r,function(e){return t[e]}.bind(null,r));return o},n.n=function(t){var e=t&&t.__esModule?function(){return t.default}:function(){return t};return n.d(e,"a",e),e},n.o=function(t,e){return Object.prototype.hasOwnProperty.call(t,e)},n.p="",n(n.s=13)}([,,,function(t,e,n){"use strict";e.a=function(t){if("complete"===document.readyState||"interactive"===document.readyState)return t();document.addEventListener("DOMContentLoaded",t)}},,,,,,function(t,e){!function(){var e,n,o,r,i,a,s,c,l,u,p,f,d,h,g,y,b,v,m,w,x,S,_,A,T,k,E,L,O,M,C,q,H,j=window,z=[],P={},I=document,B="appendChild",D="createElement",W="removeChild",R="innerHTML",F="pointer-events:auto",N="clientHeight",U="clientWidth",Q="addEventListener",V=j.setTimeout,G=j.clearTimeout;function X(){var t=e.getBoundingClientRect();return"transform:translate3D("+(t.left-(o[U]-t.width)/2)+"px, "+(t.top-(o[N]-t.height)/2)+"px, 0) scale3D("+e[U]/r[U]+", "+e[N]/r[N]+", 0)"}function K(t){var e=M.length-1;if(!d){if(t>0&&O===e||t<0&&!O){if(!H.loop)return rt(i,""),void V(rt,9,i,"animation:"+(t>0?"bpl":"bpf")+" .3s;transition:transform .35s");O=t>0?-1:e+1}if([(O=Math.max(0,Math.min(O+t,e)))-1,O,O+1].forEach(function(t){if(t=Math.max(0,Math.min(t,e)),!P[t]){var n=M[t].src,o=I[D]("IMG");o[Q]("load",tt.bind(null,n)),o.src=n,P[t]=o}}),P[O].complete)return Y(t);d=!0,rt(g,"opacity:.4;"),o[B](g),P[O].onload=function(){x&&Y(t)},P[O].onerror=function(){M[O]={error:"Error loading image"},x&&Y(t)}}}function Y(t){d&&(o[W](g),d=!1);var n=M[O];if(n.error)alert(n.error);else{var a=o.querySelector("img:last-of-type");rt(i=r=P[O],"animation:"+(t>0?"bpfl":"bpfr")+" .35s;transition:transform .35s"),rt(a,"animation:"+(t>0?"bpfol":"bpfor")+" .35s both"),o[B](i),n.el&&(e=n.el)}C[R]=O+1+"/"+M.length,J(M[O].caption),k&&k([i,M[O]])}function $(t){~[1,4].indexOf(r.readyState)?(et(),V(function(){r.play()},99)):r.error?et(t):h=V($,35,t)}function Z(t){H.noLoader||(t&&rt(g,"top:"+e.offsetTop+"px;left:"+e.offsetLeft+"px;height:"+e[N]+"px;width:"+e[U]+"px"),e.parentElement[t?B:W](g),d=t)}function J(t){t&&(b[R]=t),rt(y,"opacity:"+(t?"1;"+F:"0"))}function tt(t){!~z.indexOf(t)&&z.push(t)}function et(t){if(d&&Z(),A&&A(),"string"==typeof t)return ot(),H.onError?H.onError():alert("Error: The requested "+t+" could not be loaded.");_&&tt(u),rt(r,X()),rt(o,"opacity:1;"+F),T=V(T,410),w=!0,x=!!M,V(function(){rt(r,"transition:transform .35s;transform:none"),v&&V(J,250,v)},60)}function nt(t){var e=t.target,n=[y,m,a,s,b,L,E,g];e&&e.blur(),S||~n.indexOf(e)||(r.style.cssText+=X(),rt(o,F),V(ot,350),G(T),w=!1,S=!0)}function ot(){if(I.body[W](o),o[W](r),rt(o,""),(r===c?l:r).removeAttribute("src"),J(!1),x){for(var t=o.querySelectorAll("img"),e=0;e<t.length;e++)o[W](t[e]);d&&o[W](g),o[W](C),x=M=!1,P={},q||o[W](E),q||o[W](L),i.onload=et,i.onerror=et.bind(null,"image")}H.onClose&&H.onClose(),S=d=!1}function rt(t,e){t.style.cssText=e}t.exports=function(t){var S;n||function(){var t;function e(t){var e=I[D]("button");return e.className=t,e[R]='<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48"><path d="M28 24L47 5a3 3 0 1 0-4-4L24 20 5 1a3 3 0 1 0-4 4l19 19L1 43a3 3 0 1 0 4 4l19-19 19 19a3 3 0 0 0 4 0v-4L28 24z"/></svg>',e}function r(t,e){var n=I[D]("button");return n.className="bp-lr",n[R]='<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 129 129" height="70" fill="#fff"><path d="M88.6 121.3c.8.8 1.8 1.2 2.9 1.2s2.1-.4 2.9-1.2a4.1 4.1 0 0 0 0-5.8l-51-51 51-51a4.1 4.1 0 0 0-5.8-5.8l-54 53.9a4.1 4.1 0 0 0 0 5.8l54 53.9z"/></svg>',rt(n,e),n.onclick=function(e){e.stopPropagation(),K(t)},n}var u=I[D]("STYLE");u[R]="#bp_caption,#bp_container{bottom:0;left:0;right:0;position:fixed;opacity:0}#bp_container>*,#bp_loader{position:absolute;right:0;z-index:10}#bp_container,#bp_caption,#bp_container svg{pointer-events:none}#bp_container{top:0;z-index:9999;background:rgba(0,0,0,.7);opacity:0;transition:opacity .35s}#bp_loader{top:0;left:0;bottom:0;display:flex;margin:0;cursor:wait;z-index:9;background:0 0}#bp_loader svg{width:50%;max-width:300px;max-height:50%;margin:auto;animation:bpturn 1s infinite linear}#bp_aud,#bp_container img,#bp_sv,#bp_vid{user-select:none;max-height:96%;max-width:96%;top:0;bottom:0;left:0;margin:auto;box-shadow:0 0 3em rgba(0,0,0,.4);z-index:-1}#bp_sv{height:0;padding-bottom:54%;background-color:#000;width:96%}#bp_caption{font-size:.9em;padding:1.3em;background:rgba(15,15,15,.94);color:#fff;text-align:center;transition:opacity .3s}#bp_aud{width:650px;top:calc(50% - 20px);bottom:auto;box-shadow:none}#bp_count{left:0;right:auto;padding:14px;color:rgba(255,255,255,.7);font-size:22px;cursor:default}#bp_container button{position:absolute;border:0;outline:0;background:0 0;cursor:pointer;transition:all .1s}#bp_container>.bp-x{height:41px;width:41px;border-radius:100%;top:8px;right:14px;opacity:.8;line-height:1}#bp_container>.bp-x:focus,#bp_container>.bp-x:hover{background:rgba(255,255,255,.2)}.bp-x svg,.bp-xc svg{height:21px;width:20px;fill:#fff;vertical-align:top;}.bp-xc svg{width:16px}#bp_container .bp-xc{left:2%;bottom:100%;padding:9px 20px 7px;background:#d04444;border-radius:2px 2px 0 0;opacity:.85}#bp_container .bp-xc:focus,#bp_container .bp-xc:hover{opacity:1}.bp-lr{top:50%;top:calc(50% - 130px);padding:99px 0;width:6%;background:0 0;border:0;opacity:.4;transition:opacity .1s}.bp-lr:focus,.bp-lr:hover{opacity:.8}@keyframes bpf{50%{transform:translatex(15px)}100%{transform:none}}@keyframes bpl{50%{transform:translatex(-15px)}100%{transform:none}}@keyframes bpfl{0%{opacity:0;transform:translatex(70px)}100%{opacity:1;transform:none}}@keyframes bpfr{0%{opacity:0;transform:translatex(-70px)}100%{opacity:1;transform:none}}@keyframes bpfol{0%{opacity:1;transform:none}100%{opacity:0;transform:translatex(-70px)}}@keyframes bpfor{0%{opacity:1;transform:none}100%{opacity:0;transform:translatex(70px)}}@keyframes bpturn{0%{transform:none}100%{transform:rotate(360deg)}}@media (max-width:600px){.bp-lr{font-size:15vw}}@media (min-aspect-ratio:9/5){#bp_sv{height:98%;width:170.6vh;padding:0}}",I.head[B](u),(o=I[D]("DIV")).id="bp_container",o.onclick=nt,p=e("bp-x"),o[B](p),"ontouchstart"in j&&(q=!0,o.ontouchstart=function(e){t=e.changedTouches[0].pageX},o.ontouchmove=function(t){t.preventDefault()},o.ontouchend=function(e){if(x){var n=e.changedTouches[0].pageX-t;n<-30&&K(1),n>30&&K(-1)}});i=I[D]("IMG"),(a=I[D]("VIDEO")).id="bp_vid",a.setAttribute("playsinline",!0),a.controls=!0,a.loop=!0,(s=I[D]("audio")).id="bp_aud",s.controls=!0,s.loop=!0,(C=I[D]("span")).id="bp_count",(y=I[D]("DIV")).id="bp_caption",(m=e("bp-xc")).onclick=J.bind(null,!1),y[B](m),b=I[D]("SPAN"),y[B](b),o[B](y),E=r(1,"transform:scalex(-1)"),L=r(-1,"left:0;right:auto"),(g=I[D]("DIV")).id="bp_loader",g[R]='<svg xmlns="http://www.w3.org/2000/svg" viewbox="0 0 32 32" fill="#fff" opacity=".8"><path d="M16 0a16 16 0 0 0 0 32 16 16 0 0 0 0-32m0 4a12 12 0 0 1 0 24 12 12 0 0 1 0-24" fill="#000" opacity=".5"/><path d="M16 0a16 16 0 0 1 16 16h-4A12 12 0 0 0 16 4z"/></svg>',(c=I[D]("DIV")).id="bp_sv",(l=I[D]("IFRAME")).setAttribute("allowfullscreen",!0),l.allow="autoplay; fullscreen",l.onload=et,rt(l,"border:0;position:absolute;height:100%;width:100%;left:0;top:0"),c[B](l),i.onload=et,i.onerror=et.bind(null,"image"),j[Q]("resize",function(){x||d&&Z(!0)}),I[Q]("keyup",function(t){var e=t.keyCode;27===e&&w&&nt(o),x&&(39===e&&K(1),37===e&&K(-1),38===e&&K(10),40===e&&K(-10))}),I[Q]("keydown",function(t){x&&~[37,38,39,40].indexOf(t.keyCode)&&t.preventDefault()}),I[Q]("focus",function(t){w&&!o.contains(t.target)&&(t.stopPropagation(),p.focus())},!0),n=!0}(),d&&(G(h),ot()),H=t,f=t.ytSrc||t.vimeoSrc,A=t.animationStart,T=t.animationEnd,k=t.onChangeImage,e=t.el,_=!1,v=e.getAttribute("data-caption"),t.gallery?function(t){if(Array.isArray(t))O=0,M=t,v=t[0].caption;else{var n=(M=[].slice.call("string"==typeof t?I.querySelectorAll(t+" [data-bp]"):t)).indexOf(e);O=-1!==n?n:0,M=M.map(function(t){return{el:t,src:t.getAttribute("data-bp"),caption:t.getAttribute("data-caption")}})}_=!0,u=M[O].src,!~z.indexOf(u)&&Z(!0),M.length>1?(o[B](C),C[R]=O+1+"/"+M.length,q||(o[B](E),o[B](L))):M=!1;(r=i).src=u}(t.gallery):f||t.iframeSrc?(Z(!0),r=c,function(){var t;H.ytSrc?t="https://www.youtube.com/embed/"+f+"?html5=1&rel=0&playsinline=1&autoplay=1":H.vimeoSrc?t="https://player.vimeo.com/video/"+f+"?autoplay=1":H.iframeSrc&&(t=H.iframeSrc);l.src=t}()):t.imgSrc?(_=!0,u=t.imgSrc,!~z.indexOf(u)&&Z(!0),(r=i).src=u):t.audio?(Z(!0),(r=s).src=t.audio,$("audio file")):t.vidSrc?(Z(!0),S=t.vidSrc,Array.isArray(S)?(r=a.cloneNode(),S.forEach(function(t){var e=I[D]("SOURCE");e.src=t,e.type="video/"+t.match(/.(\w+)$/)[1],r[B](e)})):(r=a).src=S,$("video")):(r=i).src="IMG"===e.tagName?e.src:j.getComputedStyle(e).backgroundImage.replace(/^url|[(|)|'|"]/g,""),o[B](r),I.body[B](o)}}()},function(t,e){var n={utf8:{stringToBytes:function(t){return n.bin.stringToBytes(unescape(encodeURIComponent(t)))},bytesToString:function(t){return decodeURIComponent(escape(n.bin.bytesToString(t)))}},bin:{stringToBytes:function(t){for(var e=[],n=0;n<t.length;n++)e.push(255&t.charCodeAt(n));return e},bytesToString:function(t){for(var e=[],n=0;n<t.length;n++)e.push(String.fromCharCode(t[n]));return e.join("")}}};t.exports=n},function(t,e,n){window,t.exports=function(t){var e={};function n(o){if(e[o])return e[o].exports;var r=e[o]={i:o,l:!1,exports:{}};return t[o].call(r.exports,r,r.exports,n),r.l=!0,r.exports}return n.m=t,n.c=e,n.d=function(t,e,o){n.o(t,e)||Object.defineProperty(t,e,{enumerable:!0,get:o})},n.r=function(t){"undefined"!=typeof Symbol&&Symbol.toStringTag&&Object.defineProperty(t,Symbol.toStringTag,{value:"Module"}),Object.defineProperty(t,"__esModule",{value:!0})},n.t=function(t,e){if(1&e&&(t=n(t)),8&e)return t;if(4&e&&"object"==typeof t&&t&&t.__esModule)return t;var o=Object.create(null);if(n.r(o),Object.defineProperty(o,"default",{enumerable:!0,value:t}),2&e&&"string"!=typeof t)for(var r in t)n.d(o,r,function(e){return t[e]}.bind(null,r));return o},n.n=function(t){var e=t&&t.__esModule?function(){return t.default}:function(){return t};return n.d(e,"a",e),e},n.o=function(t,e){return Object.prototype.hasOwnProperty.call(t,e)},n.p="",n(n.s=0)}([function(t,e,n){"use strict";n.r(e),n.d(e,"divideNumbers",function(){return r}),n.d(e,"hasComma",function(){return i}),n.d(e,"isFloat",function(){return a}),n.d(e,"decimalPlaces",function(){return s}),e.default=function(t){var e=arguments.length>1&&void 0!==arguments[1]?arguments[1]:{},n=e.action,i=void 0===n?"start":n,a=e.duration,s=void 0===a?1e3:a,c=e.delay,l=void 0===c?16:c,u=e.lang,p=void 0===u?void 0:u;if("stop"!==i){if(o(t),/[0-9]/.test(t.innerHTML)){var f=r(t.innerHTML,{duration:s||t.getAttribute("data-duration"),lang:p||document.querySelector("html").getAttribute("lang")||void 0,delay:l||t.getAttribute("data-delay")});t._countUpOrigInnerHTML=t.innerHTML,t.innerHTML=f[0],t.style.visibility="visible",t.countUpTimeout=setTimeout(function e(){t.innerHTML=f.shift(),f.length?(clearTimeout(t.countUpTimeout),t.countUpTimeout=setTimeout(e,l)):t._countUpOrigInnerHTML=void 0},l)}}else o(t)};var o=function(t){clearTimeout(t.countUpTimeout),t._countUpOrigInnerHTML&&(t.innerHTML=t._countUpOrigInnerHTML,t._countUpOrigInnerHTML=void 0),t.style.visibility=""},r=function(t){for(var e=arguments.length>1&&void 0!==arguments[1]?arguments[1]:{},n=e.duration,o=void 0===n?1e3:n,r=e.delay,i=void 0===r?16:r,a=e.lang,s=void 0===a?void 0:a,c=o/i,l=t.toString().split(/(<[^>]+>|[0-9.][,.0-9]*[0-9]*)/),u=[],p=0;p<c;p++)u.push("");for(var f=0;f<l.length;f++)if(/([0-9.][,.0-9]*[0-9]*)/.test(l[f])&&!/<[^>]+>/.test(l[f])){var d=l[f],h=/[0-9]+,[0-9]+/.test(d);d=d.replace(/,/g,"");for(var g=/^[0-9]+\.[0-9]+$/.test(d),y=g?(d.split(".")[1]||[]).length:0,b=u.length-1,v=c;v>=1;v--){var m=parseInt(d/c*v,10);g&&(m=parseFloat(d/c*v).toFixed(y),m=parseFloat(m).toLocaleString(s)),h&&(m=m.toLocaleString(s)),u[b--]+=m}}else for(var w=0;w<c;w++)u[w]+=l[f];return u[u.length]=t.toString(),u},i=function(t){return/[0-9]+,[0-9]+/.test(t)},a=function(t){return/^[0-9]+\.[0-9]+$/.test(t)},s=function(t){return a(t)?(t.split(".")[1]||[]).length:0}}])},function(t,e,n){var o,r,i,a,s;o=n(21),r=n(10).utf8,i=n(22),a=n(10).bin,(s=function(t,e){t.constructor==String?t=e&&"binary"===e.encoding?a.stringToBytes(t):r.stringToBytes(t):i(t)?t=Array.prototype.slice.call(t,0):Array.isArray(t)||(t=t.toString());for(var n=o.bytesToWords(t),c=8*t.length,l=1732584193,u=-271733879,p=-1732584194,f=271733878,d=0;d<n.length;d++)n[d]=16711935&(n[d]<<8|n[d]>>>24)|4278255360&(n[d]<<24|n[d]>>>8);n[c>>>5]|=128<<c%32,n[14+(c+64>>>9<<4)]=c;var h=s._ff,g=s._gg,y=s._hh,b=s._ii;for(d=0;d<n.length;d+=16){var v=l,m=u,w=p,x=f;l=h(l,u,p,f,n[d+0],7,-680876936),f=h(f,l,u,p,n[d+1],12,-389564586),p=h(p,f,l,u,n[d+2],17,606105819),u=h(u,p,f,l,n[d+3],22,-1044525330),l=h(l,u,p,f,n[d+4],7,-176418897),f=h(f,l,u,p,n[d+5],12,1200080426),p=h(p,f,l,u,n[d+6],17,-1473231341),u=h(u,p,f,l,n[d+7],22,-45705983),l=h(l,u,p,f,n[d+8],7,1770035416),f=h(f,l,u,p,n[d+9],12,-1958414417),p=h(p,f,l,u,n[d+10],17,-42063),u=h(u,p,f,l,n[d+11],22,-1990404162),l=h(l,u,p,f,n[d+12],7,1804603682),f=h(f,l,u,p,n[d+13],12,-40341101),p=h(p,f,l,u,n[d+14],17,-1502002290),l=g(l,u=h(u,p,f,l,n[d+15],22,1236535329),p,f,n[d+1],5,-165796510),f=g(f,l,u,p,n[d+6],9,-1069501632),p=g(p,f,l,u,n[d+11],14,643717713),u=g(u,p,f,l,n[d+0],20,-373897302),l=g(l,u,p,f,n[d+5],5,-701558691),f=g(f,l,u,p,n[d+10],9,38016083),p=g(p,f,l,u,n[d+15],14,-660478335),u=g(u,p,f,l,n[d+4],20,-405537848),l=g(l,u,p,f,n[d+9],5,568446438),f=g(f,l,u,p,n[d+14],9,-1019803690),p=g(p,f,l,u,n[d+3],14,-187363961),u=g(u,p,f,l,n[d+8],20,1163531501),l=g(l,u,p,f,n[d+13],5,-1444681467),f=g(f,l,u,p,n[d+2],9,-51403784),p=g(p,f,l,u,n[d+7],14,1735328473),l=y(l,u=g(u,p,f,l,n[d+12],20,-1926607734),p,f,n[d+5],4,-378558),f=y(f,l,u,p,n[d+8],11,-2022574463),p=y(p,f,l,u,n[d+11],16,1839030562),u=y(u,p,f,l,n[d+14],23,-35309556),l=y(l,u,p,f,n[d+1],4,-1530992060),f=y(f,l,u,p,n[d+4],11,1272893353),p=y(p,f,l,u,n[d+7],16,-155497632),u=y(u,p,f,l,n[d+10],23,-1094730640),l=y(l,u,p,f,n[d+13],4,681279174),f=y(f,l,u,p,n[d+0],11,-358537222),p=y(p,f,l,u,n[d+3],16,-722521979),u=y(u,p,f,l,n[d+6],23,76029189),l=y(l,u,p,f,n[d+9],4,-640364487),f=y(f,l,u,p,n[d+12],11,-421815835),p=y(p,f,l,u,n[d+15],16,530742520),l=b(l,u=y(u,p,f,l,n[d+2],23,-995338651),p,f,n[d+0],6,-198630844),f=b(f,l,u,p,n[d+7],10,1126891415),p=b(p,f,l,u,n[d+14],15,-1416354905),u=b(u,p,f,l,n[d+5],21,-57434055),l=b(l,u,p,f,n[d+12],6,1700485571),f=b(f,l,u,p,n[d+3],10,-1894986606),p=b(p,f,l,u,n[d+10],15,-1051523),u=b(u,p,f,l,n[d+1],21,-2054922799),l=b(l,u,p,f,n[d+8],6,1873313359),f=b(f,l,u,p,n[d+15],10,-30611744),p=b(p,f,l,u,n[d+6],15,-1560198380),u=b(u,p,f,l,n[d+13],21,1309151649),l=b(l,u,p,f,n[d+4],6,-145523070),f=b(f,l,u,p,n[d+11],10,-1120210379),p=b(p,f,l,u,n[d+2],15,718787259),u=b(u,p,f,l,n[d+9],21,-343485551),l=l+v>>>0,u=u+m>>>0,p=p+w>>>0,f=f+x>>>0}return o.endian([l,u,p,f])})._ff=function(t,e,n,o,r,i,a){var s=t+(e&n|~e&o)+(r>>>0)+a;return(s<<i|s>>>32-i)+e},s._gg=function(t,e,n,o,r,i,a){var s=t+(e&o|n&~o)+(r>>>0)+a;return(s<<i|s>>>32-i)+e},s._hh=function(t,e,n,o,r,i,a){var s=t+(e^n^o)+(r>>>0)+a;return(s<<i|s>>>32-i)+e},s._ii=function(t,e,n,o,r,i,a){var s=t+(n^(e|~o))+(r>>>0)+a;return(s<<i|s>>>32-i)+e},s._blocksize=16,s._digestsize=16,t.exports=function(t,e){if(null==t)throw new Error("Illegal argument "+t);var n=o.wordsToBytes(s(t,e));return e&&e.asBytes?n:e&&e.asString?a.bytesToString(n):o.bytesToHex(n)}},function(t,e,n){"use strict";n.r(e);n(14);var o=n(15);o.keys().forEach(function(t){return o(t)})},function(t,e){window.NodeList&&!window.NodeList.prototype.forEach&&(window.NodeList.prototype.forEach=Array.prototype.forEach)},function(t,e,n){var o={"./accordion/frontend.js":16,"./count-up/frontend.js":17,"./expand/frontend.js":19,"./notification/frontend.js":20,"./video-popup/frontend.js":23};function r(t){var e=i(t);return n(e)}function i(t){if(!n.o(o,t)){var e=new Error("Cannot find module '"+t+"'");throw e.code="MODULE_NOT_FOUND",e}return o[t]}r.keys=function(){return Object.keys(o)},r.resolve=i,t.exports=r,r.id=15},function(t,e,n){"use strict";n.r(e),n.d(e,"openAccordion",function(){return r}),n.d(e,"detectMaxHeight",function(){return i}),n.d(e,"init",function(){return s}),n.d(e,"initAll",function(){return c});var o=n(3),r=function(t){t.classList.toggle("ugb-accordion--open"),t.setAttribute("aria-expanded",t.classList.contains("ugb-accordion--open")?"true":"false")},i=function(t){var e=t.classList.contains("ugb-accordion--open");e||(t.style.display="none",t.classList.toggle("ugb-accordion--open"),t.style.display="");var n=t.querySelector(".ugb-accordion__text").clientHeight;e||(t.style.display="none",t.classList.toggle("ugb-accordion--open"),t.style.display=""),t.style.setProperty("--max-height","".concat(n+50,"px"))},a=1,s=function(t){i(t);var e=t.querySelector(".ugb-accordion__heading");e.addEventListener("click",function(e){e.preventDefault(),r(t)}),e.addEventListener("keypress",function(e){e.preventDefault(),r(t)});var n=t.querySelector(".ugb-accordion__heading h4"),o=t.querySelector(".ugb-accordion__text");n.setAttribute("id","ugb-accordion-".concat(a,"__heading")),n.setAttribute("aria-controls","ugb-accordion-".concat(a,"__text")),o.setAttribute("id","ugb-accordion-".concat(a,"__text")),o.setAttribute("aria-labelledby","ugb-accordion-".concat(a,"__heading")),a++},c=function(){var t=document.querySelectorAll(".ugb-accordion");Array.prototype.forEach.call(t,function(t){return s(t)})};Object(o.a)(c)},function(t,e,n){"use strict";n.r(e);var o=n(11),r=n.n(o),i=n(3);Object(i.a)(function(){n(18),document.querySelectorAll(".ugb-countup .ugb-counter, .ugb-countup__counter").forEach(function(t){t.classList.add("ugb-countup--hide"),new Waypoint({element:t,handler:function(){r()(t),t.classList.remove("ugb-countup--hide"),this.destroy()},offset:"bottom-in-view"})})})},function(t,e){
/*!
Waypoints - 4.0.1
Copyright © 2011-2016 Caleb Troughton
Licensed under the MIT license.
https://github.com/imakewebthings/waypoints/blob/master/licenses.txt
*/
!function(){"use strict";var t=0,e={};function n(o){if(!o)throw new Error("No options passed to Waypoint constructor");if(!o.element)throw new Error("No element option passed to Waypoint constructor");if(!o.handler)throw new Error("No handler option passed to Waypoint constructor");this.key="waypoint-"+t,this.options=n.Adapter.extend({},n.defaults,o),this.element=this.options.element,this.adapter=new n.Adapter(this.element),this.callback=o.handler,this.axis=this.options.horizontal?"horizontal":"vertical",this.enabled=this.options.enabled,this.triggerPoint=null,this.group=n.Group.findOrCreate({name:this.options.group,axis:this.axis}),this.context=n.Context.findOrCreateByElement(this.options.context),n.offsetAliases[this.options.offset]&&(this.options.offset=n.offsetAliases[this.options.offset]),this.group.add(this),this.context.add(this),e[this.key]=this,t+=1}n.prototype.queueTrigger=function(t){this.group.queueTrigger(this,t)},n.prototype.trigger=function(t){this.enabled&&this.callback&&this.callback.apply(this,t)},n.prototype.destroy=function(){this.context.remove(this),this.group.remove(this),delete e[this.key]},n.prototype.disable=function(){return this.enabled=!1,this},n.prototype.enable=function(){return this.context.refresh(),this.enabled=!0,this},n.prototype.next=function(){return this.group.next(this)},n.prototype.previous=function(){return this.group.previous(this)},n.invokeAll=function(t){var n=[];for(var o in e)n.push(e[o]);for(var r=0,i=n.length;r<i;r++)n[r][t]()},n.destroyAll=function(){n.invokeAll("destroy")},n.disableAll=function(){n.invokeAll("disable")},n.enableAll=function(){for(var t in n.Context.refreshAll(),e)e[t].enabled=!0;return this},n.refreshAll=function(){n.Context.refreshAll()},n.viewportHeight=function(){return window.innerHeight||document.documentElement.clientHeight},n.viewportWidth=function(){return document.documentElement.clientWidth},n.adapters=[],n.defaults={context:window,continuous:!0,enabled:!0,group:"default",horizontal:!1,offset:0},n.offsetAliases={"bottom-in-view":function(){return this.context.innerHeight()-this.adapter.outerHeight()},"right-in-view":function(){return this.context.innerWidth()-this.adapter.outerWidth()}},window.Waypoint=n}(),function(){"use strict";function t(t){window.setTimeout(t,1e3/60)}var e=0,n={},o=window.Waypoint,r=window.onload;function i(t){this.element=t,this.Adapter=o.Adapter,this.adapter=new this.Adapter(t),this.key="waypoint-context-"+e,this.didScroll=!1,this.didResize=!1,this.oldScroll={x:this.adapter.scrollLeft(),y:this.adapter.scrollTop()},this.waypoints={vertical:{},horizontal:{}},t.waypointContextKey=this.key,n[t.waypointContextKey]=this,e+=1,o.windowContext||(o.windowContext=!0,o.windowContext=new i(window)),this.createThrottledScrollHandler(),this.createThrottledResizeHandler()}i.prototype.add=function(t){var e=t.options.horizontal?"horizontal":"vertical";this.waypoints[e][t.key]=t,this.refresh()},i.prototype.checkEmpty=function(){var t=this.Adapter.isEmptyObject(this.waypoints.horizontal),e=this.Adapter.isEmptyObject(this.waypoints.vertical),o=this.element==this.element.window;t&&e&&!o&&(this.adapter.off(".waypoints"),delete n[this.key])},i.prototype.createThrottledResizeHandler=function(){var t=this;function e(){t.handleResize(),t.didResize=!1}this.adapter.on("resize.waypoints",function(){t.didResize||(t.didResize=!0,o.requestAnimationFrame(e))})},i.prototype.createThrottledScrollHandler=function(){var t=this;function e(){t.handleScroll(),t.didScroll=!1}this.adapter.on("scroll.waypoints",function(){t.didScroll&&!o.isTouch||(t.didScroll=!0,o.requestAnimationFrame(e))})},i.prototype.handleResize=function(){o.Context.refreshAll()},i.prototype.handleScroll=function(){var t={},e={horizontal:{newScroll:this.adapter.scrollLeft(),oldScroll:this.oldScroll.x,forward:"right",backward:"left"},vertical:{newScroll:this.adapter.scrollTop(),oldScroll:this.oldScroll.y,forward:"down",backward:"up"}};for(var n in e){var o=e[n],r=o.newScroll>o.oldScroll?o.forward:o.backward;for(var i in this.waypoints[n]){var a=this.waypoints[n][i];if(null!==a.triggerPoint){var s=o.oldScroll<a.triggerPoint,c=o.newScroll>=a.triggerPoint;(s&&c||!s&&!c)&&(a.queueTrigger(r),t[a.group.id]=a.group)}}}for(var l in t)t[l].flushTriggers();this.oldScroll={x:e.horizontal.newScroll,y:e.vertical.newScroll}},i.prototype.innerHeight=function(){return this.element==this.element.window?o.viewportHeight():this.adapter.innerHeight()},i.prototype.remove=function(t){delete this.waypoints[t.axis][t.key],this.checkEmpty()},i.prototype.innerWidth=function(){return this.element==this.element.window?o.viewportWidth():this.adapter.innerWidth()},i.prototype.destroy=function(){var t=[];for(var e in this.waypoints)for(var n in this.waypoints[e])t.push(this.waypoints[e][n]);for(var o=0,r=t.length;o<r;o++)t[o].destroy()},i.prototype.refresh=function(){var t,e=this.element==this.element.window,n=e?void 0:this.adapter.offset(),r={};for(var i in this.handleScroll(),t={horizontal:{contextOffset:e?0:n.left,contextScroll:e?0:this.oldScroll.x,contextDimension:this.innerWidth(),oldScroll:this.oldScroll.x,forward:"right",backward:"left",offsetProp:"left"},vertical:{contextOffset:e?0:n.top,contextScroll:e?0:this.oldScroll.y,contextDimension:this.innerHeight(),oldScroll:this.oldScroll.y,forward:"down",backward:"up",offsetProp:"top"}}){var a=t[i];for(var s in this.waypoints[i]){var c,l,u,p,f=this.waypoints[i][s],d=f.options.offset,h=f.triggerPoint,g=0,y=null==h;f.element!==f.element.window&&(g=f.adapter.offset()[a.offsetProp]),"function"==typeof d?d=d.apply(f):"string"==typeof d&&(d=parseFloat(d),f.options.offset.indexOf("%")>-1&&(d=Math.ceil(a.contextDimension*d/100))),c=a.contextScroll-a.contextOffset,f.triggerPoint=Math.floor(g+c-d),l=h<a.oldScroll,u=f.triggerPoint>=a.oldScroll,p=!l&&!u,!y&&(l&&u)?(f.queueTrigger(a.backward),r[f.group.id]=f.group):!y&&p?(f.queueTrigger(a.forward),r[f.group.id]=f.group):y&&a.oldScroll>=f.triggerPoint&&(f.queueTrigger(a.forward),r[f.group.id]=f.group)}}return o.requestAnimationFrame(function(){for(var t in r)r[t].flushTriggers()}),this},i.findOrCreateByElement=function(t){return i.findByElement(t)||new i(t)},i.refreshAll=function(){for(var t in n)n[t].refresh()},i.findByElement=function(t){return n[t.waypointContextKey]},window.onload=function(){r&&r(),i.refreshAll()},o.requestAnimationFrame=function(e){(window.requestAnimationFrame||window.mozRequestAnimationFrame||window.webkitRequestAnimationFrame||t).call(window,e)},o.Context=i}(),function(){"use strict";function t(t,e){return t.triggerPoint-e.triggerPoint}function e(t,e){return e.triggerPoint-t.triggerPoint}var n={vertical:{},horizontal:{}},o=window.Waypoint;function r(t){this.name=t.name,this.axis=t.axis,this.id=this.name+"-"+this.axis,this.waypoints=[],this.clearTriggerQueues(),n[this.axis][this.name]=this}r.prototype.add=function(t){this.waypoints.push(t)},r.prototype.clearTriggerQueues=function(){this.triggerQueues={up:[],down:[],left:[],right:[]}},r.prototype.flushTriggers=function(){for(var n in this.triggerQueues){var o=this.triggerQueues[n],r="up"===n||"left"===n;o.sort(r?e:t);for(var i=0,a=o.length;i<a;i+=1){var s=o[i];(s.options.continuous||i===o.length-1)&&s.trigger([n])}}this.clearTriggerQueues()},r.prototype.next=function(e){this.waypoints.sort(t);var n=o.Adapter.inArray(e,this.waypoints);return n===this.waypoints.length-1?null:this.waypoints[n+1]},r.prototype.previous=function(e){this.waypoints.sort(t);var n=o.Adapter.inArray(e,this.waypoints);return n?this.waypoints[n-1]:null},r.prototype.queueTrigger=function(t,e){this.triggerQueues[e].push(t)},r.prototype.remove=function(t){var e=o.Adapter.inArray(t,this.waypoints);e>-1&&this.waypoints.splice(e,1)},r.prototype.first=function(){return this.waypoints[0]},r.prototype.last=function(){return this.waypoints[this.waypoints.length-1]},r.findOrCreate=function(t){return n[t.axis][t.name]||new r(t)},o.Group=r}(),function(){"use strict";var t=window.Waypoint;function e(t){return t===t.window}function n(t){return e(t)?t:t.defaultView}function o(t){this.element=t,this.handlers={}}o.prototype.innerHeight=function(){return e(this.element)?this.element.innerHeight:this.element.clientHeight},o.prototype.innerWidth=function(){return e(this.element)?this.element.innerWidth:this.element.clientWidth},o.prototype.off=function(t,e){function n(t,e,n){for(var o=0,r=e.length-1;o<r;o++){var i=e[o];n&&n!==i||t.removeEventListener(i)}}var o=t.split("."),r=o[0],i=o[1],a=this.element;if(i&&this.handlers[i]&&r)n(a,this.handlers[i][r],e),this.handlers[i][r]=[];else if(r)for(var s in this.handlers)n(a,this.handlers[s][r]||[],e),this.handlers[s][r]=[];else if(i&&this.handlers[i]){for(var c in this.handlers[i])n(a,this.handlers[i][c],e);this.handlers[i]={}}},o.prototype.offset=function(){if(!this.element.ownerDocument)return null;var t=this.element.ownerDocument.documentElement,e=n(this.element.ownerDocument),o={top:0,left:0};return this.element.getBoundingClientRect&&(o=this.element.getBoundingClientRect()),{top:o.top+e.pageYOffset-t.clientTop,left:o.left+e.pageXOffset-t.clientLeft}},o.prototype.on=function(t,e){var n=t.split("."),o=n[0],r=n[1]||"__default",i=this.handlers[r]=this.handlers[r]||{};(i[o]=i[o]||[]).push(e),this.element.addEventListener(o,e)},o.prototype.outerHeight=function(t){var n,o=this.innerHeight();return t&&!e(this.element)&&(n=window.getComputedStyle(this.element),o+=parseInt(n.marginTop,10),o+=parseInt(n.marginBottom,10)),o},o.prototype.outerWidth=function(t){var n,o=this.innerWidth();return t&&!e(this.element)&&(n=window.getComputedStyle(this.element),o+=parseInt(n.marginLeft,10),o+=parseInt(n.marginRight,10)),o},o.prototype.scrollLeft=function(){var t=n(this.element);return t?t.pageXOffset:this.element.scrollLeft},o.prototype.scrollTop=function(){var t=n(this.element);return t?t.pageYOffset:this.element.scrollTop},o.extend=function(){var t=Array.prototype.slice.call(arguments);function e(t,e){if("object"==typeof t&&"object"==typeof e)for(var n in e)e.hasOwnProperty(n)&&(t[n]=e[n]);return t}for(var n=1,o=t.length;n<o;n++)e(t[0],t[n]);return t[0]},o.inArray=function(t,e,n){return null==e?-1:e.indexOf(t,n)},o.isEmptyObject=function(t){for(var e in t)return!1;return!0},t.adapters.push({name:"noframework",Adapter:o}),t.Adapter=o}()},function(t,e,n){"use strict";n.r(e);var o=n(3);Object(o.a)(function(){document.querySelectorAll(".ugb-expand").forEach(function(t){var e=t.querySelector(".ugb-expand__toggle"),n=function(n){t.classList.toggle("ugb-expand--more");var o=t.classList.contains("ugb-expand--more");e.setAttribute("aria-expanded",o?"true":"false"),n.preventDefault()};e&&(e.addEventListener("click",n),e.addEventListener("tapEnd",n))})}),Object(o.a)(function(){document.querySelectorAll(".ugb-expand").forEach(function(t){var e=t.querySelector(".ugb-expand-button"),n=function(e){t.classList.toggle("ugb-more"),e.preventDefault()};e&&(e.addEventListener("click",n),e.addEventListener("tapEnd",n))})})},function(t,e,n){"use strict";n.r(e);var o=n(3),r=n(12),i=n.n(r);Object(o.a)(function(){document.querySelectorAll(".ugb-notification.ugb-notification--dismissible").forEach(function(t){var e=t.getAttribute("data-uid")?t.getAttribute("data-uid"):i()(t.outerHTML).substr(0,6);t.querySelector(".ugb-notification__close-button").addEventListener("click",function(n){n.preventDefault(),localStorage.setItem("stckbl-notif-".concat(e),1),t.style.display=""}),t.querySelector(".ugb-notification__close-button").addEventListener("keypress",function(n){n.preventDefault(),localStorage.setItem("stckbl-notif-".concat(e),1),t.style.display=""}),window.location.search.match(/preview=\w+/)?t.style.display="block":localStorage.getItem("stckbl-notif-".concat(e))||(t.style.display="block")})}),Object(o.a)(function(){document.querySelectorAll(".ugb-notification.dismissible-true[data-uid]").forEach(function(t){var e=t.getAttribute("data-uid");t.querySelector(".close-button").addEventListener("click",function(){localStorage.setItem("stckbl-notif-".concat(e),1),t.style.display=""}),window.location.search.match(/preview=\w+/)?t.style.display="block":localStorage.getItem("stckbl-notif-".concat(e))||(t.style.display="block")})})},function(t,e){var n,o;n="ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/",o={rotl:function(t,e){return t<<e|t>>>32-e},rotr:function(t,e){return t<<32-e|t>>>e},endian:function(t){if(t.constructor==Number)return 16711935&o.rotl(t,8)|4278255360&o.rotl(t,24);for(var e=0;e<t.length;e++)t[e]=o.endian(t[e]);return t},randomBytes:function(t){for(var e=[];t>0;t--)e.push(Math.floor(256*Math.random()));return e},bytesToWords:function(t){for(var e=[],n=0,o=0;n<t.length;n++,o+=8)e[o>>>5]|=t[n]<<24-o%32;return e},wordsToBytes:function(t){for(var e=[],n=0;n<32*t.length;n+=8)e.push(t[n>>>5]>>>24-n%32&255);return e},bytesToHex:function(t){for(var e=[],n=0;n<t.length;n++)e.push((t[n]>>>4).toString(16)),e.push((15&t[n]).toString(16));return e.join("")},hexToBytes:function(t){for(var e=[],n=0;n<t.length;n+=2)e.push(parseInt(t.substr(n,2),16));return e},bytesToBase64:function(t){for(var e=[],o=0;o<t.length;o+=3)for(var r=t[o]<<16|t[o+1]<<8|t[o+2],i=0;i<4;i++)8*o+6*i<=8*t.length?e.push(n.charAt(r>>>6*(3-i)&63)):e.push("=");return e.join("")},base64ToBytes:function(t){t=t.replace(/[^A-Z0-9+\/]/gi,"");for(var e=[],o=0,r=0;o<t.length;r=++o%4)0!=r&&e.push((n.indexOf(t.charAt(o-1))&Math.pow(2,-2*r+8)-1)<<2*r|n.indexOf(t.charAt(o))>>>6-2*r);return e}},t.exports=o},function(t,e){function n(t){return!!t.constructor&&"function"==typeof t.constructor.isBuffer&&t.constructor.isBuffer(t)}
/*!
 * Determine if an object is a Buffer
 *
 * @author   Feross Aboukhadijeh <https://feross.org>
 * @license  MIT
 */
t.exports=function(t){return null!=t&&(n(t)||function(t){return"function"==typeof t.readFloatLE&&"function"==typeof t.slice&&n(t.slice(0,0))}(t)||!!t._isBuffer)}},function(t,e,n){"use strict";n.r(e);var o=n(9),r=n.n(o),i=n(3);Object(i.a)(function(){var t=document.querySelectorAll(".ugb-video-popup");t.forEach(function(t){t.querySelector("a").addEventListener("click",function(e){e.preventDefault(),function(t){if(r.a){var e=t.getAttribute("data-video"),n={el:t,noLoader:!0};e.match(/^\d+$/g)?n.vimeoSrc=e:e.match(/^https?:\/\//g)?n.vidSrc=e:n.ytSrc=e,r()(n)}}(t)})})})}]);