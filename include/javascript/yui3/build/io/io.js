/*
 Copyright (c) 2010, Yahoo! Inc. All rights reserved.
 Code licensed under the BSD License:
 http://developer.yahoo.com/yui/license.html
 version: 3.3.0
 build: 3167
 */
YUI.add('io-base',function(Y){var E_START='io:start',E_COMPLETE='io:complete',E_SUCCESS='io:success',E_FAILURE='io:failure',E_END='io:end',transactionId=0,_headers={'X-Requested-With':'XMLHttpRequest'},_timeout={},w=Y.config.win;function _xhr(){return w.XMLHttpRequest?new XMLHttpRequest():new ActiveXObject('Microsoft.XMLHTTP');}
function _id(){var id=transactionId;transactionId++;return id;}
function _create(c,i){var o={};o.id=Y.Lang.isNumber(i)?i:_id();c=c||{};if(!c.use&&!c.upload){o.c=_xhr();}
else if(c.use){if(c.use==='native'){if(w.XDomainRequest){o.c=new XDomainRequest();o.t=c.use;}
else{o.c=_xhr();}}
else{o.c=Y.io._transport[c.use];o.t=c.use;}}
else{o.c={};o.t='io:iframe';}
return o;}
function _destroy(o){if(w){if(o.c&&w.XMLHttpRequest){o.c.onreadystatechange=null;}
else if(Y.UA.ie===6&&!o.t){o.c.abort();}}
o.c=null;o=null;}
function _tE(e,c){var eT=new Y.EventTarget().publish('transaction:'+e),a=c.arguments,cT=c.context||Y;if(a){eT.on(c.on[e],cT,a);}
else{eT.on(c.on[e],cT);}
return eT;}
function _ioStart(id,c){var a=c.arguments;if(a){Y.fire(E_START,id,a);}
else{Y.fire(E_START,id);}
if(c.on&&c.on.start){_tE('start',c).fire(id);}}
function _ioComplete(o,c){var r=o.e?{status:0,statusText:o.e}:o.c,a=c.arguments;if(a){Y.fire(E_COMPLETE,o.id,r,a);}
else{Y.fire(E_COMPLETE,o.id,r);}
if(c.on&&c.on.complete){_tE('complete',c).fire(o.id,r);}}
function _ioEnd(o,c){var a=c.arguments;if(a){Y.fire(E_END,o.id,a);}
else{Y.fire(E_END,o.id);}
if(c.on&&c.on.end){_tE('end',c).fire(o.id);}
_destroy(o);}
function _ioSuccess(o,c){var a=c.arguments;if(a){Y.fire(E_SUCCESS,o.id,o.c,a);}
else{Y.fire(E_SUCCESS,o.id,o.c);}
if(c.on&&c.on.success){_tE('success',c).fire(o.id,o.c);}
_ioEnd(o,c);}
function _ioFailure(o,c){var r=o.e?{status:0,statusText:o.e}:o.c,a=c.arguments;if(a){Y.fire(E_FAILURE,o.id,r,a);}
else{Y.fire(E_FAILURE,o.id,r);}
if(c.on&&c.on.failure){_tE('failure',c).fire(o.id,r);}
_ioEnd(o,c);}
function _resend(o,uri,c,d){_destroy(o);c.xdr.use='flash';c.data=c.form&&d?d:null;return Y.io(uri,c,o.id);}
function _concat(s,d){s+=((s.indexOf('?')==-1)?'?':'&')+d;return s;}
function _setHeader(l,v){if(v){_headers[l]=v;}
else{delete _headers[l];}}
function _setHeaders(o,h){var p;h=h||{};for(p in _headers){if(_headers.hasOwnProperty(p)){if(!h[p]){h[p]=_headers[p];}}}
for(p in h){if(h.hasOwnProperty(p)){if(h[p]!=='disable'){o.setRequestHeader(p,h[p]);}}}}
function _ioCancel(o,s){if(o&&o.c){o.e=s;o.c.abort();}}
function _startTimeout(o,t){_timeout[o.id]=w.setTimeout(function(){_ioCancel(o,'timeout');},t);}
function _clearTimeout(id){w.clearTimeout(_timeout[id]);delete _timeout[id];}
function _handleResponse(o,c){var status;try{status=(o.c.status&&o.c.status!==0)?o.c.status:0;}
catch(e){status=0;}
if(status>=200&&status<300||status===1223){_ioSuccess(o,c);}
else{_ioFailure(o,c);}}
function _readyState(o,c){if(o.c.readyState===4){if(c.timeout){_clearTimeout(o.id);}
w.setTimeout(function(){_ioComplete(o,c);_handleResponse(o,c);},0);}}
function _io(uri,c,i){var f,o,d,m,r,s,oD,a,j,u=uri;c=Y.Object(c);o=_create(c.xdr||c.form,i);m=c.method?c.method=c.method.toUpperCase():c.method='GET';s=c.sync;oD=c.data;if(Y.Lang.isObject(c.data)&&Y.QueryString){c.data=Y.QueryString.stringify(c.data);}
if(c.form){if(c.form.upload){return Y.io.upload(o,uri,c);}
else{f=Y.io._serialize(c.form,c.data);if(m==='POST'||m==='PUT'){c.data=f;}
else if(m==='GET'){uri=_concat(uri,f);}}}
if(c.data&&m==='GET'){uri=_concat(uri,c.data);}
if(c.data&&m==='POST'){c.headers=Y.merge({'Content-Type':'application/x-www-form-urlencoded; charset=UTF-8'},c.headers);}
if(o.t){return Y.io.xdr(uri,o,c);}
if(!s){o.c.onreadystatechange=function(){_readyState(o,c);};}
try{o.c.open(m,uri,s?false:true);if(c.xdr&&c.xdr.credentials){o.c.withCredentials=true;}}
catch(e1){if(c.xdr){return _resend(o,u,c,oD);}}
_setHeaders(o.c,c.headers);_ioStart(o.id,c);try{o.c.send(c.data||'');if(s){d=o.c;a=['status','statusText','responseText','responseXML'];r=c.arguments?{id:o.id,arguments:c.arguments}:{id:o.id};for(j=0;j<4;j++){r[a[j]]=o.c[a[j]];}
r.getAllResponseHeaders=function(){return d.getAllResponseHeaders();};r.getResponseHeader=function(h){return d.getResponseHeader(h);};_ioComplete(o,c);_handleResponse(o,c);return r;}}
catch(e2){if(c.xdr){return _resend(o,u,c,oD);}}
if(c.timeout){_startTimeout(o,c.timeout);}
return{id:o.id,abort:function(){return o.c?_ioCancel(o,'abort'):false;},isInProgress:function(){return o.c?o.c.readyState!==4&&o.c.readyState!==0:false;}};}
_io.start=_ioStart;_io.complete=_ioComplete;_io.success=_ioSuccess;_io.failure=_ioFailure;_io.end=_ioEnd;_io._id=_id;_io._timeout=_timeout;_io.header=_setHeader;Y.io=_io;Y.io.http=_io;},'3.3.0',{requires:['event-custom-base','querystring-stringify-simple']});YUI.add('io-form',function(Y){var eUC=encodeURIComponent;Y.mix(Y.io,{_serialize:function(c,s){var data=[],useDf=c.useDisabled||false,item=0,id=(typeof c.id==='string')?c.id:c.id.getAttribute('id'),e,f,n,v,d,i,il,j,jl,o;if(!id){id=Y.guid('io:');c.id.setAttribute('id',id);}
f=Y.config.doc.getElementById(id);for(i=0,il=f.elements.length;i<il;++i){e=f.elements[i];d=e.disabled;n=e.name;if(useDf?n:n&&!d){n=eUC(n)+'=';v=eUC(e.value);switch(e.type){case'select-one':if(e.selectedIndex>-1){o=e.options[e.selectedIndex];data[item++]=n+eUC(o.attributes.value&&o.attributes.value.specified?o.value:o.text);}
break;case'select-multiple':if(e.selectedIndex>-1){for(j=e.selectedIndex,jl=e.options.length;j<jl;++j){o=e.options[j];if(o.selected){data[item++]=n+eUC(o.attributes.value&&o.attributes.value.specified?o.value:o.text);}}}
break;case'radio':case'checkbox':if(e.checked){data[item++]=n+v;}
break;case'file':case undefined:case'reset':case'button':break;case'submit':default:data[item++]=n+v;}}}
return s?data.join('&')+"&"+s:data.join('&');}},true);},'3.3.0',{requires:['io-base','node-base']});YUI.add('io-xdr',function(Y){var E_XDR_READY=Y.publish('io:xdrReady',{fireOnce:true}),_cB={},_rS={},d=Y.config.doc,w=Y.config.win,ie=w&&w.XDomainRequest;function _swf(uri,yid){var o='<object id="yuiIoSwf" type="application/x-shockwave-flash" data="'+
uri+'" width="0" height="0">'+'<param name="movie" value="'+uri+'">'+'<param name="FlashVars" value="yid='+yid+'">'+'<param name="allowScriptAccess" value="always">'+'</object>',c=d.createElement('div');d.body.appendChild(c);c.innerHTML=o;}
function _evt(o,c){o.c.onprogress=function(){_rS[o.id]=3;};o.c.onload=function(){_rS[o.id]=4;Y.io.xdrResponse(o,c,'success');};o.c.onerror=function(){_rS[o.id]=4;Y.io.xdrResponse(o,c,'failure');};if(c.timeout){o.c.ontimeout=function(){_rS[o.id]=4;Y.io.xdrResponse(o,c,'timeout');};o.c.timeout=c.timeout;}}
function _data(o,f,t){var s,x;if(!o.e){s=f?decodeURI(o.c.responseText):o.c.responseText;x=t==='xml'?Y.DataType.XML.parse(s):null;return{id:o.id,c:{responseText:s,responseXML:x}};}
else{return{id:o.id,e:o.e};}}
function _abort(o,c){return o.c.abort(o.id,c);}
function _isInProgress(o){return ie?_rS[o.id]!==4:o.c.isInProgress(o.id);}
Y.mix(Y.io,{_transport:{},xdr:function(uri,o,c){if(c.xdr.use==='flash'){_cB[o.id]={on:c.on,context:c.context,arguments:c.arguments};c.context=null;c.form=null;w.setTimeout(function(){if(o.c&&o.c.send){o.c.send(uri,c,o.id);}
else{Y.io.xdrResponse(o,c,'transport error');}},Y.io.xdr.delay);}
else if(ie){_evt(o,c);o.c.open(c.method||'GET',uri);o.c.send(c.data);}
else{o.c.send(uri,o,c);}
return{id:o.id,abort:function(){return o.c?_abort(o,c):false;},isInProgress:function(){return o.c?_isInProgress(o.id):false;}};},xdrResponse:function(o,c,e){var cb,m=ie?_rS:_cB,f=c.xdr.use==='flash'?true:false,t=c.xdr.dataType;c.on=c.on||{};if(f){cb=_cB[o.id]?_cB[o.id]:null;if(cb){c.on=cb.on;c.context=cb.context;c.arguments=cb.arguments;}}
switch(e){case'start':Y.io.start(o.id,c);break;case'complete':Y.io.complete(o,c);break;case'success':Y.io.success(t||f?_data(o,f,t):o,c);delete m[o.id];break;case'timeout':case'abort':case'transport error':o.e=e;case'failure':Y.io.failure(t||f?_data(o,f,t):o,c);delete m[o.id];break;}},xdrReady:function(id){Y.io.xdr.delay=0;Y.fire(E_XDR_READY,id);},transport:function(o){var yid=o.yid||Y.id,oid=o.id||'flash',src=Y.UA.ie?o.src+'?d='+new Date().valueOf().toString():o.src;if(oid==='native'||oid==='flash'){_swf(src,yid);this._transport.flash=d.getElementById('yuiIoSwf');}
else if(oid){this._transport[o.id]=o.src;}}});Y.io.xdr.delay=50;},'3.3.0',{requires:['io-base','datatype-xml']});YUI.add('io-upload-iframe',function(Y){var w=Y.config.win,d=Y.config.doc,_std=(d.documentMode&&d.documentMode>=8),_d=decodeURIComponent;function _addData(f,s){var o=[],m=s.split('='),i,l;for(i=0,l=m.length-1;i<l;i++){o[i]=d.createElement('input');o[i].type='hidden';o[i].name=_d(m[i].substring(m[i].lastIndexOf('&')+1));o[i].value=(i+1===l)?_d(m[i+1]):_d(m[i+1].substring(0,(m[i+1].lastIndexOf('&'))));f.appendChild(o[i]);}
return o;}
function _removeData(f,o){var i,l;for(i=0,l=o.length;i<l;i++){f.removeChild(o[i]);}}
function _setAttrs(f,id,uri){f.setAttribute('action',uri);f.setAttribute('method','POST');f.setAttribute('target','ioupload'+id);f.setAttribute(Y.UA.ie&&!_std?'encoding':'enctype','multipart/form-data');}
function _resetAttrs(f,a){var p;for(p in a){if(a.hasOwnProperty(p)){if(a[p]){f.setAttribute(p,f[p]);}
else{f.removeAttribute(p);}}}}
function _startTimeout(o,c){Y.io._timeout[o.id]=w.setTimeout(function(){var r={id:o.id,status:'timeout'};Y.io.complete(r,c);Y.io.end(r,c);},c.timeout);}
function _clearTimeout(id){w.clearTimeout(Y.io._timeout[id]);delete Y.io._timeout[id];}
function _destroy(id){Y.Event.purgeElement('#ioupload'+id,false);Y.one('body').removeChild(Y.one('#ioupload'+id));}
function _handle(o,c){var d=Y.one('#ioupload'+o.id).get('contentWindow.document'),b=d.one('body'),p;if(c.timeout){_clearTimeout(o.id);}
if(b){p=b.one('pre:first-child');o.c.responseText=p?p.get('text'):b.get('text');}
else{o.c.responseXML=d._node;}
Y.io.complete(o,c);Y.io.end(o,c);w.setTimeout(function(){_destroy(o.id);},0);}
function _create(o,c){var i=Y.Node.create('<iframe id="ioupload'+o.id+'" name="ioupload'+o.id+'" />');i._node.style.position='absolute';i._node.style.top='-1000px';i._node.style.left='-1000px';Y.one('body').appendChild(i);Y.on("load",function(){_handle(o,c);},'#ioupload'+o.id);}
function _send(o,uri,c){var f=(typeof c.form.id==='string')?d.getElementById(c.form.id):c.form.id,fields,attr={action:f.getAttribute('action'),target:f.getAttribute('target')};_setAttrs(f,o.id,uri);if(c.data){fields=_addData(f,c.data);}
if(c.timeout){_startTimeout(o,c);}
f.submit();Y.io.start(o.id,c);if(c.data){_removeData(f,fields);}
_resetAttrs(f,attr);return{id:o.id,abort:function(){var r={id:o.id,status:'abort'};if(Y.one('#ioupload'+o.id)){_destroy(o.id);Y.io.complete(r,c);Y.io.end(r,c);}
else{return false;}},isInProgress:function(){return Y.one('#ioupload'+o.id)?true:false;}};}
Y.mix(Y.io,{upload:function(o,uri,c){_create(o,c);return _send(o,uri,c);}});},'3.3.0',{requires:['io-base','node-base']});YUI.add('io-queue',function(Y){var _q=new Y.Queue(),_activeId,_qState=1;function _shift(){var o=_q.next();_activeId=o.id;_qState=0;Y.io(o.uri,o.cfg,o.id);}
function _unshift(o){_q.promote(o);}
function _queue(uri,c){var o={uri:uri,id:Y.io._id(),cfg:c};_q.add(o);if(_qState===1){_shift();}
return o;}
function _next(id){_qState=1;if(_activeId===id&&_q.size()>0){_shift();}}
function _remove(o){_q.remove(o);}
function _start(){_qState=1;if(_q.size()>0){_shift();}}
function _stop(){_qState=0;}
function _size(){return _q.size();}
_queue.size=_size;_queue.start=_start;_queue.stop=_stop;_queue.promote=_unshift;_queue.remove=_remove;Y.on('io:complete',function(id){_next(id);},Y.io);Y.mix(Y.io,{queue:_queue},true);},'3.3.0',{requires:['io-base','queue-promote']});YUI.add('io',function(Y){},'3.3.0',{use:['io-base','io-form','io-xdr','io-upload-iframe','io-queue']});