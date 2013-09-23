/*
 Copyright (c) 2010, Yahoo! Inc. All rights reserved.
 Code licensed under the BSD License:
 http://developer.yahoo.com/yui/license.html
 version: 3.3.0
 build: 3167
 */
YUI.add('loader-rollup',function(Y){Y.Loader.prototype._rollup=function(){var i,j,m,s,r=this.required,roll,info=this.moduleInfo,rolled,c,smod;if(this.dirty||!this.rollups){this.rollups={};for(i in info){if(info.hasOwnProperty(i)){m=this.getModule(i);if(m&&m.rollup){this.rollups[i]=m;}}}
this.forceMap=(this.force)?Y.Array.hash(this.force):{};}
for(;;){rolled=false;for(i in this.rollups){if(this.rollups.hasOwnProperty(i)){if(!r[i]&&((!this.loaded[i])||this.forceMap[i])){m=this.getModule(i);s=m.supersedes||[];roll=false;if(!m.rollup){continue;}
c=0;for(j=0;j<s.length;j++){smod=info[s[j]];if(this.loaded[s[j]]&&!this.forceMap[s[j]]){roll=false;break;}else if(r[s[j]]&&m.type==smod.type){c++;roll=(c>=m.rollup);if(roll){break;}}}
if(roll){r[i]=true;rolled=true;this.getRequires(m);}}}}
if(!rolled){break;}}};},'3.3.0',{requires:['loader-base']});