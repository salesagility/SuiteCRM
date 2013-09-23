/*
 Copyright (c) 2010, Yahoo! Inc. All rights reserved.
 Code licensed under the BSD License:
 http://developer.yahoo.com/yui/license.html
 version: 3.3.0
 build: 3167
 */
YUI.add('autocomplete-filters-accentfold',function(Y){var AccentFold=Y.Text.AccentFold,WordBreak=Y.Text.WordBreak,YArray=Y.Array,YObject=Y.Object;Y.mix(Y.namespace('AutoCompleteFilters'),{charMatchFold:function(query,results){var queryChars=YArray.unique(AccentFold.fold(query).split(''));return YArray.filter(results,function(result){var text=AccentFold.fold(result.text);return YArray.every(queryChars,function(chr){return text.indexOf(chr)!==-1;});});},phraseMatchFold:function(query,results){query=AccentFold.fold(query);return YArray.filter(results,function(result){return AccentFold.fold(result.text).indexOf(query)!==-1;});},startsWithFold:function(query,results){query=AccentFold.fold(query);return YArray.filter(results,function(result){return AccentFold.fold(result.text).indexOf(query)===0;});},wordMatchFold:function(query,results){var queryWords=WordBreak.getUniqueWords(AccentFold.fold(query));return YArray.filter(results,function(result){var resultWords=YArray.hash(WordBreak.getUniqueWords(AccentFold.fold(result.text)));return YArray.every(queryWords,function(word){return YObject.owns(resultWords,word);});});}});},'3.3.0',{requires:['array-extras','text-accentfold','text-wordbreak']});