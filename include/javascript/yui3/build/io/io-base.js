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
_io.start=_ioStart;_io.complete=_ioComplete;_io.success=_ioSuccess;_io.failure=_ioFailure;_io.end=_ioEnd;_io._id=_id;_io._timeout=_timeout;_io.header=_setHeader;Y.io=_io;Y.io.http=_io;},'3.3.0',{requires:['event-custom-base','querystring-stringify-simple']});