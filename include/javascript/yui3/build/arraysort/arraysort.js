/*
Copyright (c) 2010, Yahoo! Inc. All rights reserved.
Code licensed under the BSD License:
http://developer.yahoo.com/yui/license.html
version: 3.3.0
build: 3167
*/
YUI.add("arraysort",function(C){var B=C.Lang,A=B.isValue,D=B.isString;C.ArraySort={compare:function(F,E,G){if(!A(F)){if(!A(E)){return 0;}else{return 1;}}else{if(!A(E)){return -1;}}if(D(F)){F=F.toLowerCase();}if(D(E)){E=E.toLowerCase();}if(F<E){return(G)?1:-1;}else{if(F>E){return(G)?-1:1;}else{return 0;}}}};},"3.3.0",{requires:["yui-base"]});