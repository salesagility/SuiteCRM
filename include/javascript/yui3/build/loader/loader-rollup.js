/*
Copyright (c) 2010, Yahoo! Inc. All rights reserved.
Code licensed under the BSD License:
http://developer.yahoo.com/yui/license.html
version: 3.3.0
build: 3167
*/
YUI.add("loader-rollup",function(A){A.Loader.prototype._rollup=function(){var H,G,F,K,B=this.required,D,E=this.moduleInfo,C,I,J;if(this.dirty||!this.rollups){this.rollups={};for(H in E){if(E.hasOwnProperty(H)){F=this.getModule(H);if(F&&F.rollup){this.rollups[H]=F;}}}this.forceMap=(this.force)?A.Array.hash(this.force):{};}for(;;){C=false;for(H in this.rollups){if(this.rollups.hasOwnProperty(H)){if(!B[H]&&((!this.loaded[H])||this.forceMap[H])){F=this.getModule(H);K=F.supersedes||[];D=false;if(!F.rollup){continue;}I=0;for(G=0;G<K.length;G++){J=E[K[G]];if(this.loaded[K[G]]&&!this.forceMap[K[G]]){D=false;break;}else{if(B[K[G]]&&F.type==J.type){I++;D=(I>=F.rollup);if(D){break;}}}}if(D){B[H]=true;C=true;this.getRequires(F);}}}}if(!C){break;}}};},"3.3.0",{requires:["loader-base"]});