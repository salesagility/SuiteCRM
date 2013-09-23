/*
 Copyright (c) 2010, Yahoo! Inc. All rights reserved.
 Code licensed under the BSD License:
 http://developer.yahoo.com/yui/license.html
 version: 3.3.0
 build: 3167
 */
YUI.add('widget-locale',function(Y){var TRUE=true,LOCALE="locale",INIT_VALUE="initValue",HYPHEN="-",EMPTY_STR="",Widget=Y.Widget;Widget.ATTRS[LOCALE]={value:"en"};Widget.ATTRS.strings.lazyAdd=false;Y.mix(Widget.prototype,{_setStrings:function(strings,locale){var strs=this._strs;locale=locale.toLowerCase();if(!strs[locale]){strs[locale]={};}
Y.aggregate(strs[locale],strings,TRUE);return strs[locale];},_getStrings:function(locale){return this._strs[locale.toLowerCase()];},getStrings:function(locale){locale=(locale||this.get(LOCALE)).toLowerCase();var defLocale=this.getDefaultLocale().toLowerCase(),defStrs=this._getStrings(defLocale),strs=(defStrs)?Y.merge(defStrs):{},localeSegments=locale.split(HYPHEN),localeStrs,i,l,lookup;if(locale!==defLocale||localeSegments.length>1){lookup=EMPTY_STR;for(i=0,l=localeSegments.length;i<l;++i){lookup+=localeSegments[i];localeStrs=this._getStrings(lookup);if(localeStrs){Y.aggregate(strs,localeStrs,TRUE);}
lookup+=HYPHEN;}}
return strs;},getString:function(key,locale){locale=(locale||this.get(LOCALE)).toLowerCase();var defLocale=(this.getDefaultLocale()).toLowerCase(),strs=this._getStrings(defLocale)||{},str=strs[key],idx=locale.lastIndexOf(HYPHEN);if(locale!==defLocale||idx!=-1){do{strs=this._getStrings(locale);if(strs&&key in strs){str=strs[key];break;}
idx=locale.lastIndexOf(HYPHEN);if(idx!=-1){locale=locale.substring(0,idx);}}while(idx!=-1);}
return str;},getDefaultLocale:function(){return this._state.get(LOCALE,INIT_VALUE);},_strSetter:function(val){return this._setStrings(val,this.get(LOCALE));},_strGetter:function(val){return this._getStrings(this.get(LOCALE));}},true);},'3.3.0',{requires:['widget-base']});