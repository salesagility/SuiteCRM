/*
 Copyright (c) 2010, Yahoo! Inc. All rights reserved.
 Code licensed under the BSD License:
 http://developer.yahoo.com/yui/license.html
 version: 3.3.0
 build: 3167
 */
YUI.add('classnamemanager',function(Y){var CLASS_NAME_PREFIX='classNamePrefix',CLASS_NAME_DELIMITER='classNameDelimiter',CONFIG=Y.config;CONFIG[CLASS_NAME_PREFIX]=CONFIG[CLASS_NAME_PREFIX]||'yui3';CONFIG[CLASS_NAME_DELIMITER]=CONFIG[CLASS_NAME_DELIMITER]||'-';Y.ClassNameManager=function(){var sPrefix=CONFIG[CLASS_NAME_PREFIX],sDelimiter=CONFIG[CLASS_NAME_DELIMITER];return{getClassName:Y.cached(function(){var args=Y.Array(arguments);if(args[args.length-1]!==true){args.unshift(sPrefix);}else{args.pop();}
return args.join(sDelimiter);})};}();},'3.3.0');