/*
 Copyright (c) 2010, Yahoo! Inc. All rights reserved.
 Code licensed under the BSD License:
 http://developer.yahoo.com/yui/license.html
 version: 3.3.0
 build: 3167
 */
YUI.add('anim-curve',function(Y){Y.Anim.behaviors.curve={set:function(anim,att,from,to,elapsed,duration,fn){from=from.slice.call(from);to=to.slice.call(to);var t=fn(elapsed,0,100,duration)/ 100;to.unshift(from);anim._node.setXY(Y.Anim.getBezier(to,t));},get:function(anim,att){return anim._node.getXY();}};Y.Anim.getBezier=function(points,t){var n=points.length;var tmp=[];for(var i=0;i<n;++i){tmp[i]=[points[i][0],points[i][1]];}
for(var j=1;j<n;++j){for(i=0;i<n-j;++i){tmp[i][0]=(1-t)*tmp[i][0]+t*tmp[parseInt(i+1,10)][0];tmp[i][1]=(1-t)*tmp[i][1]+t*tmp[parseInt(i+1,10)][1];}}
return[tmp[0][0],tmp[0][1]];};},'3.3.0',{requires:['anim-xy']});