/*
 Copyright (c) 2010, Yahoo! Inc. All rights reserved.
 Code licensed under the BSD License:
 http://developer.yahoo.com/yui/license.html
 version: 3.3.0
 build: 3167
 */
YUI.add('autocomplete-highlighters-accentfold',function(Y){var Highlight=Y.Highlight,YArray=Y.Array;Y.mix(Y.namespace('AutoCompleteHighlighters'),{charMatchFold:function(query,results){var queryChars=YArray.unique(query.split(''));return YArray.map(results,function(result){return Highlight.allFold(result.text,queryChars);});},phraseMatchFold:function(query,results){return YArray.map(results,function(result){return Highlight.allFold(result.text,[query]);});},startsWithFold:function(query,results){return YArray.map(results,function(result){return Highlight.allFold(result.text,[query],{startsWith:true});});},wordMatchFold:function(query,results){return YArray.map(results,function(result){return Highlight.wordsFold(result.text,query);});}});},'3.3.0',{requires:['array-extras','highlight-accentfold']});