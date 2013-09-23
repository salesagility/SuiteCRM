/*
 Copyright (c) 2010, Yahoo! Inc. All rights reserved.
 Code licensed under the BSD License:
 http://developer.yahoo.com/yui/license.html
 version: 3.3.0
 build: 3167
 */
YUI.add('editor-para',function(Y){var EditorPara=function(){EditorPara.superclass.constructor.apply(this,arguments);},HOST='host',BODY='body',NODE_CHANGE='nodeChange',PARENT_NODE='parentNode',FIRST_P=BODY+' > p',P='p',BR='<br>',FC='firstChild',LI='li';Y.extend(EditorPara,Y.Base,{_fixFirstPara:function(){var host=this.get(HOST),inst=host.getInstance(),sel;inst.one('body').set('innerHTML','<'+P+'>'+inst.Selection.CURSOR+'</'+P+'>');var n=inst.one(FIRST_P);sel=new inst.Selection();sel.selectNode(n,true,false);},_onNodeChange:function(e){var host=this.get(HOST),inst=host.getInstance(),html,txt,par,d,sel,btag=inst.Selection.DEFAULT_BLOCK_TAG,inHTML,txt2,childs,aNode,index,node2,top,n,sib,ps,br,item,p,imgs,t,LAST_CHILD=':last-child';switch(e.changedType){case'enter-up':var para=((this._lastPara)?this._lastPara:e.changedNode),b=para.one('br.yui-cursor');if(this._lastPara){delete this._lastPara;}
if(b){if(b.previous()||b.next()){b.remove();}}
if(!para.test(btag)){var para2=para.ancestor(btag);if(para2){para=para2;para2=null;}}
if(para.test(btag)){var prev=para.previous(),lc,lc2,found=false;if(prev){lc=prev.one(LAST_CHILD);while(!found){if(lc){lc2=lc.one(LAST_CHILD);if(lc2){lc=lc2;}else{found=true;}}else{found=true;}}
if(lc){host.copyStyles(lc,para);}}}
break;case'enter':if(Y.UA.webkit){if(e.changedEvent.shiftKey){host.execCommand('insertbr');e.changedEvent.preventDefault();}}
if(Y.UA.gecko&&host.get('defaultblock')!=='p'){par=e.changedNode;if(!par.test(LI)&&!par.ancestor(LI)){if(!par.test(btag)){par=par.ancestor(btag);}
d=inst.Node.create('<'+btag+'></'+btag+'>');par.insert(d,'after');sel=new inst.Selection();if(sel.anchorOffset){inHTML=sel.anchorNode.get('textContent');txt=inst.one(inst.config.doc.createTextNode(inHTML.substr(0,sel.anchorOffset)));txt2=inst.one(inst.config.doc.createTextNode(inHTML.substr(sel.anchorOffset)));aNode=sel.anchorNode;aNode.setContent('');node2=aNode.cloneNode();node2.append(txt2);top=false;sib=aNode;while(!top){sib=sib.get(PARENT_NODE);if(sib&&!sib.test(btag)){n=sib.cloneNode();n.set('innerHTML','');n.append(node2);childs=sib.get('childNodes');var start=false;childs.each(function(c){if(start){n.append(c);}
if(c===aNode){start=true;}});aNode=sib;node2=n;}else{top=true;}}
txt2=node2;sel.anchorNode.append(txt);if(txt2){d.append(txt2);}}
if(d.get(FC)){d=d.get(FC);}
d.prepend(inst.Selection.CURSOR);sel.focusCursor(true,true);html=inst.Selection.getText(d);if(html!==''){inst.Selection.cleanCursor();}
e.changedEvent.preventDefault();}}
break;case'keydown':if(inst.config.doc.childNodes.length<2){var cont=inst.config.doc.body.innerHTML;if(cont&&cont.length<5&&cont.toLowerCase()==BR){this._fixFirstPara();}}
break;case'backspace-up':case'backspace-down':case'delete-up':if(!Y.UA.ie){ps=inst.all(FIRST_P);item=inst.one(BODY);if(ps.item(0)){item=ps.item(0);}
br=item.one('br');if(br){br.removeAttribute('id');br.removeAttribute('class');}
txt=inst.Selection.getText(item);txt=txt.replace(/ /g,'').replace(/\n/g,'');imgs=item.all('img');if(txt.length===0&&!imgs.size()){if(!item.test(P)){this._fixFirstPara();}
p=null;if(e.changedNode&&e.changedNode.test(P)){p=e.changedNode;}
if(!p&&host._lastPara&&host._lastPara.inDoc()){p=host._lastPara;}
if(p&&!p.test(P)){p=p.ancestor(P);}
if(p){if(!p.previous()&&p.get(PARENT_NODE)&&p.get(PARENT_NODE).test(BODY)){e.changedEvent.frameEvent.halt();}}}
if(Y.UA.webkit){if(e.changedNode){item=e.changedNode;if(item.test('li')&&(!item.previous()&&!item.next())){html=item.get('innerHTML').replace(BR,'');if(html===''){if(item.get(PARENT_NODE)){item.get(PARENT_NODE).replace(inst.Node.create(BR));e.changedEvent.frameEvent.halt();e.preventDefault();inst.Selection.filterBlocks();}}}}}}
if(Y.UA.gecko){d=e.changedNode;t=inst.config.doc.createTextNode(' ');d.appendChild(t);d.removeChild(t);}
break;}
if(Y.UA.gecko){if(e.changedNode&&!e.changedNode.test(btag)){var p=e.changedNode.ancestor(btag);if(p){this._lastPara=p;}}}},_afterEditorReady:function(){var host=this.get(HOST),inst=host.getInstance(),btag;if(inst){inst.Selection.filterBlocks();btag=inst.Selection.DEFAULT_BLOCK_TAG;FIRST_P=BODY+' > '+btag;P=btag;}},_afterContentChange:function(){var host=this.get(HOST),inst=host.getInstance();if(inst&&inst.Selection){inst.Selection.filterBlocks();}},_afterPaste:function(){var host=this.get(HOST),inst=host.getInstance(),sel=new inst.Selection();Y.later(50,host,function(){inst.Selection.filterBlocks();});},initializer:function(){var host=this.get(HOST);if(host.editorBR){Y.error('Can not plug EditorPara and EditorBR at the same time.');return;}
host.on(NODE_CHANGE,Y.bind(this._onNodeChange,this));host.after('ready',Y.bind(this._afterEditorReady,this));host.after('contentChange',Y.bind(this._afterContentChange,this));if(Y.Env.webkit){host.after('dom:paste',Y.bind(this._afterPaste,this));}}},{NAME:'editorPara',NS:'editorPara',ATTRS:{host:{value:false}}});Y.namespace('Plugin');Y.Plugin.EditorPara=EditorPara;},'3.3.0',{requires:['node'],skinnable:false});