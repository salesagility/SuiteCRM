/*
 Copyright (c) 2010, Yahoo! Inc. All rights reserved.
 Code licensed under the BSD License:
 http://developer.yahoo.com/yui/license.html
 version: 3.3.0
 build: 3167
 */
YUI.add('autocomplete-filters',function(Y){var YArray=Y.Array,YObject=Y.Object,WordBreak=Y.Text.WordBreak,Filters=Y.mix(Y.namespace('AutoCompleteFilters'),{charMatch:function(query,results,caseSensitive){var queryChars=YArray.unique((caseSensitive?query:query.toLowerCase()).split(''));return YArray.filter(results,function(result){result=result.text;if(!caseSensitive){result=result.toLowerCase();}
return YArray.every(queryChars,function(chr){return result.indexOf(chr)!==-1;});});},charMatchCase:function(query,results){return Filters.charMatch(query,results,true);},phraseMatch:function(query,results,caseSensitive){if(!caseSensitive){query=query.toLowerCase();}
return YArray.filter(results,function(result){return(caseSensitive?result.text:result.text.toLowerCase()).indexOf(query)!==-1;});},phraseMatchCase:function(query,results){return Filters.phraseMatch(query,results,true);},startsWith:function(query,results,caseSensitive){if(!caseSensitive){query=query.toLowerCase();}
return YArray.filter(results,function(result){return(caseSensitive?result.text:result.text.toLowerCase()).indexOf(query)===0;});},startsWithCase:function(query,results){return Filters.startsWith(query,results,true);},wordMatch:function(query,results,caseSensitive){var options={ignoreCase:!caseSensitive},queryWords=WordBreak.getUniqueWords(query,options);return YArray.filter(results,function(result){var resultWords=YArray.hash(WordBreak.getUniqueWords(result.text,options));return YArray.every(queryWords,function(word){return YObject.owns(resultWords,word);});});},wordMatchCase:function(query,results){return Filters.wordMatch(query,results,true);}});},'3.3.0',{requires:['array-extras','text-wordbreak']});