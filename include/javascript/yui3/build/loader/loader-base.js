/*
 Copyright (c) 2010, Yahoo! Inc. All rights reserved.
 Code licensed under the BSD License:
 http://developer.yahoo.com/yui/license.html
 version: 3.3.0
 build: 3167
 */
YUI.add('loader-base',function(Y){if(!YUI.Env[Y.version]){(function(){var VERSION=Y.version,BUILD='/build/',ROOT=VERSION+BUILD,CDN_BASE=Y.Env.base,GALLERY_VERSION='gallery-2010.12.16-18-24',TNT='2in3',TNT_VERSION='4',YUI2_VERSION='2.8.2',COMBO_BASE=CDN_BASE+'combo?',META={version:VERSION,root:ROOT,base:Y.Env.base,comboBase:COMBO_BASE,skin:{defaultSkin:'sam',base:'assets/skins/',path:'skin.css',after:['cssreset','cssfonts','cssgrids','cssbase','cssreset-context','cssfonts-context']},groups:{},patterns:{}},groups=META.groups,yui2Update=function(tnt,yui2){var root=TNT+'.'+
(tnt||TNT_VERSION)+'/'+
(yui2||YUI2_VERSION)+BUILD;groups.yui2.base=CDN_BASE+root;groups.yui2.root=root;},galleryUpdate=function(tag){var root=(tag||GALLERY_VERSION)+BUILD;groups.gallery.base=CDN_BASE+root;groups.gallery.root=root;};groups[VERSION]={};groups.gallery={ext:false,combine:true,comboBase:COMBO_BASE,update:galleryUpdate,patterns:{'gallery-':{},'gallerycss-':{type:'css'}}};groups.yui2={combine:true,ext:false,comboBase:COMBO_BASE,update:yui2Update,patterns:{'yui2-':{configFn:function(me){if(/-skin|reset|fonts|grids|base/.test(me.name)){me.type='css';me.path=me.path.replace(/\.js/,'.css');me.path=me.path.replace(/\/yui2-skin/,'/assets/skins/sam/yui2-skin');}}}}};galleryUpdate();yui2Update();YUI.Env[VERSION]=META;}());}
var NOT_FOUND={},NO_REQUIREMENTS=[],MAX_URL_LENGTH=(Y.UA.ie)?2048:8192,GLOBAL_ENV=YUI.Env,GLOBAL_LOADED=GLOBAL_ENV._loaded,CSS='css',JS='js',INTL='intl',VERSION=Y.version,ROOT_LANG='',YObject=Y.Object,oeach=YObject.each,YArray=Y.Array,_queue=GLOBAL_ENV._loaderQueue,META=GLOBAL_ENV[VERSION],SKIN_PREFIX='skin-',L=Y.Lang,ON_PAGE=GLOBAL_ENV.mods,modulekey,cache,_path=function(dir,file,type,nomin){var path=dir+'/'+file;if(!nomin){path+='-min';}
path+='.'+(type||CSS);return path;};Y.Env.meta=META;Y.Loader=function(o){var defaults=META.modules,self=this;modulekey=META.md5;self.context=Y;self.base=Y.Env.meta.base;self.comboBase=Y.Env.meta.comboBase;self.combine=o.base&&(o.base.indexOf(self.comboBase.substr(0,20))>-1);self.maxURLLength=MAX_URL_LENGTH;self.root=Y.Env.meta.root;self.timeout=0;self.forceMap={};self.allowRollup=true;self.filters={};self.required={};self.patterns={};self.moduleInfo={};self.groups=Y.merge(Y.Env.meta.groups);self.skin=Y.merge(Y.Env.meta.skin);self.conditions={};self.config=o;self._internal=true;cache=GLOBAL_ENV._renderedMods;if(cache){oeach(cache,function(v,k){self.moduleInfo[k]=Y.merge(v);});cache=GLOBAL_ENV._conditions;oeach(cache,function(v,k){self.conditions[k]=Y.merge(v);});}else{oeach(defaults,self.addModule,self);}
if(!GLOBAL_ENV._renderedMods){GLOBAL_ENV._renderedMods=Y.merge(self.moduleInfo);GLOBAL_ENV._conditions=Y.merge(self.conditions);}
self._inspectPage();self._internal=false;self._config(o);self.sorted=[];self.loaded=GLOBAL_LOADED[VERSION];self.dirty=true;self.inserted={};self.skipped={};self.tested={};};Y.Loader.prototype={FILTER_DEFS:{RAW:{'searchExp':'-min\\.js','replaceStr':'.js'},DEBUG:{'searchExp':'-min\\.js','replaceStr':'-debug.js'}},_inspectPage:function(){oeach(ON_PAGE,function(v,k){if(v.details){var m=this.moduleInfo[k],req=v.details.requires,mr=m&&m.requires;if(m){if(!m._inspected&&req&&mr.length!=req.length){delete m.expanded;}}else{m=this.addModule(v.details,k);}
m._inspected=true;}},this);},_requires:function(mod1,mod2){var i,rm,after_map,s,info=this.moduleInfo,m=info[mod1],other=info[mod2];if(!m||!other){return false;}
rm=m.expanded_map;after_map=m.after_map;if(after_map&&(mod2 in after_map)){return true;}
after_map=other.after_map;if(after_map&&(mod1 in after_map)){return false;}
s=info[mod2]&&info[mod2].supersedes;if(s){for(i=0;i<s.length;i++){if(this._requires(mod1,s[i])){return true;}}}
s=info[mod1]&&info[mod1].supersedes;if(s){for(i=0;i<s.length;i++){if(this._requires(mod2,s[i])){return false;}}}
if(rm&&(mod2 in rm)){return true;}
if(m.ext&&m.type==CSS&&!other.ext&&other.type==CSS){return true;}
return false;},_config:function(o){var i,j,val,f,group,groupName,self=this;if(o){for(i in o){if(o.hasOwnProperty(i)){val=o[i];if(i=='require'){self.require(val);}else if(i=='skin'){Y.mix(self.skin,o[i],true);}else if(i=='groups'){for(j in val){if(val.hasOwnProperty(j)){groupName=j;group=val[j];self.addGroup(group,groupName);}}}else if(i=='modules'){oeach(val,self.addModule,self);}else if(i=='gallery'){this.groups.gallery.update(val);}else if(i=='yui2'||i=='2in3'){this.groups.yui2.update(o['2in3'],o.yui2);}else if(i=='maxURLLength'){self[i]=Math.min(MAX_URL_LENGTH,val);}else{self[i]=val;}}}}
f=self.filter;if(L.isString(f)){f=f.toUpperCase();self.filterName=f;self.filter=self.FILTER_DEFS[f];if(f=='DEBUG'){self.require('yui-log','dump');}}},formatSkin:function(skin,mod){var s=SKIN_PREFIX+skin;if(mod){s=s+'-'+mod;}
return s;},_addSkin:function(skin,mod,parent){var mdef,pkg,name,info=this.moduleInfo,sinf=this.skin,ext=info[mod]&&info[mod].ext;if(mod){name=this.formatSkin(skin,mod);if(!info[name]){mdef=info[mod];pkg=mdef.pkg||mod;this.addModule({name:name,group:mdef.group,type:'css',after:sinf.after,path:(parent||pkg)+'/'+sinf.base+skin+'/'+mod+'.css',ext:ext});}}
return name;},addGroup:function(o,name){var mods=o.modules,self=this;name=name||o.name;o.name=name;self.groups[name]=o;if(o.patterns){oeach(o.patterns,function(v,k){v.group=name;self.patterns[k]=v;});}
if(mods){oeach(mods,function(v,k){v.group=name;self.addModule(v,k);},self);}},addModule:function(o,name){name=name||o.name;o.name=name;if(!o||!o.name){return null;}
if(!o.type){o.type=JS;}
if(!o.path&&!o.fullpath){o.path=_path(name,name,o.type);}
o.supersedes=o.supersedes||o.use;o.ext=('ext'in o)?o.ext:(this._internal)?false:true;o.requires=o.requires||[];var subs=o.submodules,i,l,sup,s,smod,plugins,plug,j,langs,packName,supName,flatSup,flatLang,lang,ret,overrides,skinname,when,conditions=this.conditions,trigger;this.moduleInfo[name]=o;if(!o.langPack&&o.lang){langs=YArray(o.lang);for(j=0;j<langs.length;j++){lang=langs[j];packName=this.getLangPackName(lang,name);smod=this.moduleInfo[packName];if(!smod){smod=this._addLangPack(lang,o,packName);}}}
if(subs){sup=o.supersedes||[];l=0;for(i in subs){if(subs.hasOwnProperty(i)){s=subs[i];s.path=s.path||_path(name,i,o.type);s.pkg=name;s.group=o.group;if(s.supersedes){sup=sup.concat(s.supersedes);}
smod=this.addModule(s,i);sup.push(i);if(smod.skinnable){o.skinnable=true;overrides=this.skin.overrides;if(overrides&&overrides[i]){for(j=0;j<overrides[i].length;j++){skinname=this._addSkin(overrides[i][j],i,name);sup.push(skinname);}}
skinname=this._addSkin(this.skin.defaultSkin,i,name);sup.push(skinname);}
if(s.lang&&s.lang.length){langs=YArray(s.lang);for(j=0;j<langs.length;j++){lang=langs[j];packName=this.getLangPackName(lang,name);supName=this.getLangPackName(lang,i);smod=this.moduleInfo[packName];if(!smod){smod=this._addLangPack(lang,o,packName);}
flatSup=flatSup||YArray.hash(smod.supersedes);if(!(supName in flatSup)){smod.supersedes.push(supName);}
o.lang=o.lang||[];flatLang=flatLang||YArray.hash(o.lang);if(!(lang in flatLang)){o.lang.push(lang);}
packName=this.getLangPackName(ROOT_LANG,name);supName=this.getLangPackName(ROOT_LANG,i);smod=this.moduleInfo[packName];if(!smod){smod=this._addLangPack(lang,o,packName);}
if(!(supName in flatSup)){smod.supersedes.push(supName);}}}
l++;}}
o.supersedes=YObject.keys(YArray.hash(sup));o.rollup=(l<4)?l:Math.min(l-1,4);}
plugins=o.plugins;if(plugins){for(i in plugins){if(plugins.hasOwnProperty(i)){plug=plugins[i];plug.pkg=name;plug.path=plug.path||_path(name,i,o.type);plug.requires=plug.requires||[];plug.group=o.group;this.addModule(plug,i);if(o.skinnable){this._addSkin(this.skin.defaultSkin,i,name);}}}}
if(o.condition){trigger=o.condition.trigger;when=o.condition.when;conditions[trigger]=conditions[trigger]||{};conditions[trigger][name]=o.condition;if(when&&when!='after'){if(when=='instead'){o.supersedes=o.supersedes||[];o.supersedes.push(trigger);}else{}}else{o.after=o.after||[];o.after.push(trigger);}}
if(o.after){o.after_map=YArray.hash(o.after);}
if(o.configFn){ret=o.configFn(o);if(ret===false){delete this.moduleInfo[name];o=null;}}
return o;},require:function(what){var a=(typeof what==='string')?arguments:what;this.dirty=true;Y.mix(this.required,YArray.hash(a));},getRequires:function(mod){if(!mod||mod._parsed){return NO_REQUIREMENTS;}
var i,m,j,add,packName,lang,name=mod.name,cond,go,adddef=ON_PAGE[name]&&ON_PAGE[name].details,d,r,old_mod,o,skinmod,skindef,intl=mod.lang||mod.intl,info=this.moduleInfo,hash;if(mod.temp&&adddef){old_mod=mod;mod=this.addModule(adddef,name);mod.group=old_mod.group;mod.pkg=old_mod.pkg;delete mod.expanded;}
if(mod.expanded&&(!this.lang||mod.langCache===this.lang)){return mod.expanded;}
d=[];hash={};r=mod.requires;o=mod.optional;mod._parsed=true;for(i=0;i<r.length;i++){if(!hash[r[i]]){d.push(r[i]);hash[r[i]]=true;m=this.getModule(r[i]);if(m){add=this.getRequires(m);intl=intl||(m.expanded_map&&(INTL in m.expanded_map));for(j=0;j<add.length;j++){d.push(add[j]);}}}}
r=mod.supersedes;if(r){for(i=0;i<r.length;i++){if(!hash[r[i]]){if(mod.submodules){d.push(r[i]);}
hash[r[i]]=true;m=this.getModule(r[i]);if(m){add=this.getRequires(m);intl=intl||(m.expanded_map&&(INTL in m.expanded_map));for(j=0;j<add.length;j++){d.push(add[j]);}}}}}
if(o&&this.loadOptional){for(i=0;i<o.length;i++){if(!hash[o[i]]){d.push(o[i]);hash[o[i]]=true;m=info[o[i]];if(m){add=this.getRequires(m);intl=intl||(m.expanded_map&&(INTL in m.expanded_map));for(j=0;j<add.length;j++){d.push(add[j]);}}}}}
cond=this.conditions[name];if(cond){oeach(cond,function(def,condmod){if(!hash[condmod]){go=def&&((def.ua&&Y.UA[def.ua])||(def.test&&def.test(Y,r)));if(go){hash[condmod]=true;d.push(condmod);m=this.getModule(condmod);if(m){add=this.getRequires(m);for(j=0;j<add.length;j++){d.push(add[j]);}}}}},this);}
if(mod.skinnable){skindef=this.skin.overrides;if(skindef&&skindef[name]){for(i=0;i<skindef[name].length;i++){skinmod=this._addSkin(skindef[name][i],name);d.push(skinmod);}}else{skinmod=this._addSkin(this.skin.defaultSkin,name);d.push(skinmod);}}
mod._parsed=false;if(intl){if(mod.lang&&!mod.langPack&&Y.Intl){lang=Y.Intl.lookupBestLang(this.lang||ROOT_LANG,mod.lang);mod.langCache=this.lang;packName=this.getLangPackName(lang,name);if(packName){d.unshift(packName);}}
d.unshift(INTL);}
mod.expanded_map=YArray.hash(d);mod.expanded=YObject.keys(mod.expanded_map);return mod.expanded;},getProvides:function(name){var m=this.getModule(name),o,s;if(!m){return NOT_FOUND;}
if(m&&!m.provides){o={};s=m.supersedes;if(s){YArray.each(s,function(v){Y.mix(o,this.getProvides(v));},this);}
o[name]=true;m.provides=o;}
return m.provides;},calculate:function(o,type){if(o||type||this.dirty){if(o){this._config(o);}
if(!this._init){this._setup();}
this._explode();if(this.allowRollup){this._rollup();}
this._reduce();this._sort();}},_addLangPack:function(lang,m,packName){var name=m.name,packPath,existing=this.moduleInfo[packName];if(!existing){packPath=_path((m.pkg||name),packName,JS,true);this.addModule({path:packPath,intl:true,langPack:true,ext:m.ext,group:m.group,supersedes:[]},packName,true);if(lang){Y.Env.lang=Y.Env.lang||{};Y.Env.lang[lang]=Y.Env.lang[lang]||{};Y.Env.lang[lang][name]=true;}}
return this.moduleInfo[packName];},_setup:function(){var info=this.moduleInfo,name,i,j,m,l,packName;for(name in info){if(info.hasOwnProperty(name)){m=info[name];if(m){m.requires=YObject.keys(YArray.hash(m.requires));if(m.lang&&m.lang.length){packName=this.getLangPackName(ROOT_LANG,name);this._addLangPack(null,m,packName);}}}}
l={};if(!this.ignoreRegistered){Y.mix(l,GLOBAL_ENV.mods);}
if(this.ignore){Y.mix(l,YArray.hash(this.ignore));}
for(j in l){if(l.hasOwnProperty(j)){Y.mix(l,this.getProvides(j));}}
if(this.force){for(i=0;i<this.force.length;i++){if(this.force[i]in l){delete l[this.force[i]];}}}
Y.mix(this.loaded,l);this._init=true;},getLangPackName:function(lang,mname){return('lang/'+mname+((lang)?'_'+lang:''));},_explode:function(){var r=this.required,m,reqs,done={},self=this;self.dirty=false;oeach(r,function(v,name){if(!done[name]){done[name]=true;m=self.getModule(name);if(m){var expound=m.expound;if(expound){r[expound]=self.getModule(expound);reqs=self.getRequires(r[expound]);Y.mix(r,YArray.hash(reqs));}
reqs=self.getRequires(m);Y.mix(r,YArray.hash(reqs));}}});},getModule:function(mname){if(!mname){return null;}
var p,found,pname,m=this.moduleInfo[mname],patterns=this.patterns;if(!m){for(pname in patterns){if(patterns.hasOwnProperty(pname)){p=patterns[pname];if(mname.indexOf(pname)>-1){found=p;break;}}}
if(found){if(p.action){p.action.call(this,mname,pname);}else{m=this.addModule(Y.merge(found),mname);m.temp=true;}}}
return m;},_rollup:function(){},_reduce:function(r){r=r||this.required;var i,j,s,m,type=this.loadType;for(i in r){if(r.hasOwnProperty(i)){m=this.getModule(i);if(((this.loaded[i]||ON_PAGE[i])&&!this.forceMap[i]&&!this.ignoreRegistered)||(type&&m&&m.type!=type)){delete r[i];}
s=m&&m.supersedes;if(s){for(j=0;j<s.length;j++){if(s[j]in r){delete r[s[j]];}}}}}
return r;},_finish:function(msg,success){_queue.running=false;var onEnd=this.onEnd;if(onEnd){onEnd.call(this.context,{msg:msg,data:this.data,success:success});}
this._continue();},_onSuccess:function(){var self=this,skipped=Y.merge(self.skipped),fn,failed=[],rreg=self.requireRegistration,success,msg;oeach(skipped,function(k){delete self.inserted[k];});self.skipped={};oeach(self.inserted,function(v,k){var mod=self.getModule(k);if(mod&&rreg&&mod.type==JS&&!(k in YUI.Env.mods)){failed.push(k);}else{Y.mix(self.loaded,self.getProvides(k));}});fn=self.onSuccess;msg=(failed.length)?'notregistered':'success';success=!(failed.length);if(fn){fn.call(self.context,{msg:msg,data:self.data,success:success,failed:failed,skipped:skipped});}
self._finish(msg,success);},_onFailure:function(o){var f=this.onFailure,msg='failure: '+o.msg;if(f){f.call(this.context,{msg:msg,data:this.data,success:false});}
this._finish(msg,false);},_onTimeout:function(){var f=this.onTimeout;if(f){f.call(this.context,{msg:'timeout',data:this.data,success:false});}
this._finish('timeout',false);},_sort:function(){var s=YObject.keys(this.required),done={},p=0,l,a,b,j,k,moved,doneKey;for(;;){l=s.length;moved=false;for(j=p;j<l;j++){a=s[j];for(k=j+1;k<l;k++){doneKey=a+s[k];if(!done[doneKey]&&this._requires(a,s[k])){b=s.splice(k,1);s.splice(j,0,b[0]);done[doneKey]=true;moved=true;break;}}
if(moved){break;}else{p++;}}
if(!moved){break;}}
this.sorted=s;},partial:function(partial,o,type){this.sorted=partial;this.insert(o,type,true);},_insert:function(source,o,type,skipcalc){if(source){this._config(source);}
if(!skipcalc){this.calculate(o);}
this.loadType=type;if(!type){var self=this;this._internalCallback=function(){var f=self.onCSS,n,p,sib;if(this.insertBefore&&Y.UA.ie){n=Y.config.doc.getElementById(this.insertBefore);p=n.parentNode;sib=n.nextSibling;p.removeChild(n);if(sib){p.insertBefore(n,sib);}else{p.appendChild(n);}}
if(f){f.call(self.context,Y);}
self._internalCallback=null;self._insert(null,null,JS);};this._insert(null,null,CSS);return;}
this._loading=true;this._combineComplete={};this.loadNext();},_continue:function(){if(!(_queue.running)&&_queue.size()>0){_queue.running=true;_queue.next()();}},insert:function(o,type,skipsort){var self=this,copy=Y.merge(this);delete copy.require;delete copy.dirty;_queue.add(function(){self._insert(copy,o,type,skipsort);});this._continue();},loadNext:function(mname){if(!this._loading){return;}
var s,len,i,m,url,fn,msg,attr,group,groupName,j,frag,comboSource,comboSources,mods,combining,urls,comboBase,self=this,type=self.loadType,handleSuccess=function(o){self.loadNext(o.data);},handleCombo=function(o){self._combineComplete[type]=true;var i,len=combining.length;for(i=0;i<len;i++){self.inserted[combining[i]]=true;}
handleSuccess(o);};if(self.combine&&(!self._combineComplete[type])){combining=[];self._combining=combining;s=self.sorted;len=s.length;comboBase=self.comboBase;url=comboBase;urls=[];comboSources={};for(i=0;i<len;i++){comboSource=comboBase;m=self.getModule(s[i]);groupName=m&&m.group;if(groupName){group=self.groups[groupName];if(!group.combine){m.combine=false;continue;}
m.combine=true;if(group.comboBase){comboSource=group.comboBase;}
if(group.root){m.root=group.root;}}
comboSources[comboSource]=comboSources[comboSource]||[];comboSources[comboSource].push(m);}
for(j in comboSources){if(comboSources.hasOwnProperty(j)){url=j;mods=comboSources[j];len=mods.length;for(i=0;i<len;i++){m=mods[i];if(m&&(m.type===type)&&(m.combine||!m.ext)){frag=(m.root||self.root)+m.path;if((url!==j)&&(i<(len-1))&&((frag.length+url.length)>self.maxURLLength)){urls.push(self._filter(url));url=j;}
url+=frag;if(i<(len-1)){url+='&';}
combining.push(m.name);}}
if(combining.length&&(url!=j)){urls.push(self._filter(url));}}}
if(combining.length){if(type===CSS){fn=Y.Get.css;attr=self.cssAttributes;}else{fn=Y.Get.script;attr=self.jsAttributes;}
fn(urls,{data:self._loading,onSuccess:handleCombo,onFailure:self._onFailure,onTimeout:self._onTimeout,insertBefore:self.insertBefore,charset:self.charset,attributes:attr,timeout:self.timeout,autopurge:false,context:self});return;}else{self._combineComplete[type]=true;}}
if(mname){if(mname!==self._loading){return;}
self.inserted[mname]=true;if(self.onProgress){self.onProgress.call(self.context,{name:mname,data:self.data});}}
s=self.sorted;len=s.length;for(i=0;i<len;i=i+1){if(s[i]in self.inserted){continue;}
if(s[i]===self._loading){return;}
m=self.getModule(s[i]);if(!m){if(!self.skipped[s[i]]){msg='Undefined module '+s[i]+' skipped';self.skipped[s[i]]=true;}
continue;}
group=(m.group&&self.groups[m.group])||NOT_FOUND;if(!type||type===m.type){self._loading=s[i];if(m.type===CSS){fn=Y.Get.css;attr=self.cssAttributes;}else{fn=Y.Get.script;attr=self.jsAttributes;}
url=(m.fullpath)?self._filter(m.fullpath,s[i]):self._url(m.path,s[i],group.base||m.base);fn(url,{data:s[i],onSuccess:handleSuccess,insertBefore:self.insertBefore,charset:self.charset,attributes:attr,onFailure:self._onFailure,onTimeout:self._onTimeout,timeout:self.timeout,autopurge:false,context:self});return;}}
self._loading=null;fn=self._internalCallback;if(fn){self._internalCallback=null;fn.call(self);}else{self._onSuccess();}},_filter:function(u,name){var f=this.filter,hasFilter=name&&(name in this.filters),modFilter=hasFilter&&this.filters[name];if(u){if(hasFilter){f=(L.isString(modFilter))?this.FILTER_DEFS[modFilter.toUpperCase()]||null:modFilter;}
if(f){u=u.replace(new RegExp(f.searchExp,'g'),f.replaceStr);}}
return u;},_url:function(path,name,base){return this._filter((base||this.base||'')+path,name);}};},'3.3.0',{requires:['get']});