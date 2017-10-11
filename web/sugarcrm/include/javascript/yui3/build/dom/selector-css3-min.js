/*
 Copyright (c) 2009, Yahoo! Inc. All rights reserved.
 Code licensed under the BSD License:
 http://developer.yahoo.net/yui/license.txt
 version: 3.0.0
 build: 1549
 */
YUI.add("selector-css3",function(A){A.Selector._reNth=/^(?:([\-]?\d*)(n){1}|(odd|even)$)*([\-+]?\d*)$/;A.Selector._getNth=function(C,L,N,G){A.Selector._reNth.test(L);var K=parseInt(RegExp.$1,10),B=RegExp.$2,H=RegExp.$3,I=parseInt(RegExp.$4,10)||0,M=[],J=A.Selector._children(C.parentNode,N),E;if(H){K=2;E="+";B="n";I=(H==="odd")?1:0;}else{if(isNaN(K)){K=(B)?1:0;}}if(K===0){if(G){I=J.length-I+1;}if(J[I-1]===C){return true;}else{return false;}}else{if(K<0){G=!!G;K=Math.abs(K);}}if(!G){for(var D=I-1,F=J.length;D<F;D+=K){if(D>=0&&J[D]===C){return true;}}}else{for(var D=J.length-I,F=J.length;D>=0;D-=K){if(D<F&&J[D]===C){return true;}}}return false;};A.mix(A.Selector.pseudos,{"root":function(B){return B===B.ownerDocument.documentElement;},"nth-child":function(B,C){return A.Selector._getNth(B,C);},"nth-last-child":function(B,C){return A.Selector._getNth(B,C,null,true);},"nth-of-type":function(B,C){return A.Selector._getNth(B,C,B.tagName);},"nth-last-of-type":function(B,C){return A.Selector._getNth(B,C,B.tagName,true);},"last-child":function(C){var B=A.Selector._children(C.parentNode);return B[B.length-1]===C;},"first-of-type":function(B){return A.Selector._children(B.parentNode,B.tagName)[0]===B;},"last-of-type":function(C){var B=A.Selector._children(C.parentNode,C.tagName);return B[B.length-1]===C;},"only-child":function(C){var B=A.Selector._children(C.parentNode);return B.length===1&&B[0]===C;},"only-of-type":function(C){var B=A.Selector._children(C.parentNode,C.tagName);return B.length===1&&B[0]===C;},"empty":function(B){return B.childNodes.length===0;},"not":function(B,C){return!A.Selector.test(B,C);},"contains":function(B,C){var D=B.innerText||B.textContent||"";return D.indexOf(C)>-1;},"checked":function(B){return B.checked===true;}});A.mix(A.Selector.operators,{"^=":"^{val}","$=":"{val}$","*=":"{val}"});A.Selector.combinators["~"]={axis:"previousSibling"};},"3.0.0",{requires:["dom-base","selector-native","selector-css2"]});