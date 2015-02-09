/**
 * jQuery JSON plugin 2.4.0
 *
 * @author Brantley Harris, 2009-2011
 * @author Timo Tijhof, 2011-2012
 * @source This plugin is heavily influenced by MochiKit's serializeJSON, which is
 *         copyrighted 2005 by Bob Ippolito.
 * @source Brantley Harris wrote this plugin. It is based somewhat on the JSON.org
 *         website's http://www.json.org/json2.js, which proclaims:
 *         "NO WARRANTY EXPRESSED OR IMPLIED. USE AT YOUR OWN RISK.", a sentiment that
 *         I uphold.
 * @license MIT License <http://www.opensource.org/licenses/mit-license.php>
 */

!function($){"use strict";var escape=/["\\\x00-\x1f\x7f-\x9f]/g,meta={"\b":"\\b","	":"\\t","\n":"\\n","\f":"\\f","\r":"\\r",'"':'\\"',"\\":"\\\\"},hasOwn=Object.prototype.hasOwnProperty;$.toJSON="object"==typeof JSON&&JSON.stringify?JSON.stringify:function(t){if(null===t)return"null";var e,r,n,o,i=$.type(t);if("undefined"===i)return void 0;if("number"===i||"boolean"===i)return String(t);if("string"===i)return $.quoteString(t);if("function"==typeof t.toJSON)return $.toJSON(t.toJSON());if("date"===i){var u=t.getUTCMonth()+1,f=t.getUTCDate(),s=t.getUTCFullYear(),a=t.getUTCHours(),l=t.getUTCMinutes(),c=t.getUTCSeconds(),p=t.getUTCMilliseconds();return 10>u&&(u="0"+u),10>f&&(f="0"+f),10>a&&(a="0"+a),10>l&&(l="0"+l),10>c&&(c="0"+c),100>p&&(p="0"+p),10>p&&(p="0"+p),'"'+s+"-"+u+"-"+f+"T"+a+":"+l+":"+c+"."+p+'Z"'}if(e=[],$.isArray(t)){for(r=0;r<t.length;r++)e.push($.toJSON(t[r])||"null");return"["+e.join(",")+"]"}if("object"==typeof t){for(r in t)if(hasOwn.call(t,r)){if(i=typeof r,"number"===i)n='"'+r+'"';else{if("string"!==i)continue;n=$.quoteString(r)}i=typeof t[r],"function"!==i&&"undefined"!==i&&(o=$.toJSON(t[r]),e.push(n+":"+o))}return"{"+e.join(",")+"}"}},$.evalJSON="object"==typeof JSON&&JSON.parse?JSON.parse:function(str){return eval("("+str+")")},$.secureEvalJSON="object"==typeof JSON&&JSON.parse?JSON.parse:function(str){var filtered=str.replace(/\\["\\\/bfnrtu]/g,"@").replace(/"[^"\\\n\r]*"|true|false|null|-?\d+(?:\.\d*)?(?:[eE][+\-]?\d+)?/g,"]").replace(/(?:^|:|,)(?:\s*\[)+/g,"");if(/^[\],:{}\s]*$/.test(filtered))return eval("("+str+")");throw new SyntaxError("Error parsing JSON, source is not valid.")},$.quoteString=function(t){return t.match(escape)?'"'+t.replace(escape,function(t){var e=meta[t];return"string"==typeof e?e:(e=t.charCodeAt(),"\\u00"+Math.floor(e/16).toString(16)+(e%16).toString(16))})+'"':'"'+t+'"'}}(jQuery);