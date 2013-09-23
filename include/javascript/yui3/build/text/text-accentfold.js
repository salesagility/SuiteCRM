/*
 Copyright (c) 2010, Yahoo! Inc. All rights reserved.
 Code licensed under the BSD License:
 http://developer.yahoo.com/yui/license.html
 version: 3.3.0
 build: 3167
 */
YUI.add('text-accentfold',function(Y){var YArray=Y.Array,Text=Y.Text,FoldData=Text.Data.AccentFold,AccentFold={canFold:function(string){var letter;for(letter in FoldData){if(FoldData.hasOwnProperty(letter)&&string.search(FoldData[letter])!==-1){return true;}}
return false;},compare:function(a,b,func){var aFolded=AccentFold.fold(a),bFolded=AccentFold.fold(b);return func?!!func(aFolded,bFolded):aFolded===bFolded;},filter:function(haystack,func){return YArray.filter(haystack,function(item){return func(AccentFold.fold(item));});},fold:function(input){if(Y.Lang.isArray(input)){return YArray.map(input,AccentFold.fold);}
input=input.toLowerCase();Y.Object.each(FoldData,function(regex,letter){input=input.replace(regex,letter);});return input;}};Text.AccentFold=AccentFold;},'3.3.0',{requires:['array-extras','text-data-accentfold']});