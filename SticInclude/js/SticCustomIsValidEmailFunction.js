/**
 * This overwrites the original function isValidEmail() in jssource/src_files/include/javascript/sugar_3.js 
 * and /include/javascript/sugar_3.js (minified version) to fix STIC#301
 */

function isValidEmail(emailStr) {
  
    /** STIC jch 20210720 solves STIC#301 */
    if (emailStr.startsWith(' ') || emailStr.endsWith(' ')) {
      return false;
    }
    /** end STIC */

    if (emailStr.length == 0) {
      return true;
    }
    // cn: bug 7128, a period at the end of the string mangles checks. (switched to accept spaces and delimiters)
    var lastChar = emailStr.charAt(emailStr.length - 1);
    if (!lastChar.match(/[^\.]/i)) {
      return false;
    }
    //bug 40068, According to rules in page 6 of http://www.apps.ietf.org/rfc/rfc3696.html#sec-3,
    //first character of local part of an email address
    //should not be a period i.e. '.'
  
    var firstLocalChar = emailStr.charAt(0);
    if (firstLocalChar.match(/\./)) {
      return false;
    }
  
    //bug 40068, According to rules in page 6 of http://www.apps.ietf.org/rfc/rfc3696.html#sec-3,
    //last character of local part of an email address
    //should not be a period i.e. '.'
  
    var pos = emailStr.lastIndexOf("@");
    var localPart = emailStr.substr(0, pos);
    var lastLocalChar = localPart.charAt(localPart.length - 1);
    if (lastLocalChar.match(/\./)) {
      return false;
    }
  
  
    var reg = /@.*?;/g;
    var results;
    while ((results = reg.exec(emailStr)) != null) {
      var original = results[0];
      parsedResult = results[0].replace(';', '::;::');
      emailStr = emailStr.replace(original, parsedResult);
    }
  
    reg = /.@.*?,/g;
    while ((results = reg.exec(emailStr)) != null) {
      var original = results[0];
      //Check if we were using ; as a delimiter. If so, skip the commas
      if (original.indexOf("::;::") == -1) {
        var parsedResult = results[0].replace(',', '::;::');
        emailStr = emailStr.replace(original, parsedResult);
      }
    }
  
    // mfh: bug 15010 - more practical implementation of RFC 2822 from http://www.regular-expressions.info/email.html, modifed to accept CAPITAL LETTERS
    //if(!/[a-zA-Z0-9!#$%&'*+/=?^_`{|}~-]+(?:\.[a-zA-Z0-9!#$%&'*+/=?^_`{|}~-]+)*@(?:[a-zA-Z0-9](?:[a-zA-Z0-9-]*[a-zA-Z0-9])?\.)+[a-zA-Z0-9](?:[a-zA-Z0-9-]*[a-zA-Z0-9])?/.test(emailStr))
    //	return false
  
    //bug 40068, According to rules in page 6 of http://www.apps.ietf.org/rfc/rfc3696.html#sec-3,
    //allowed special characters ! # $ % & ' * + - / = ?  ^ _ ` . { | } ~ in local part
    var emailArr = emailStr.split(/::;::/);
    for (var i = 0; i < emailArr.length; i++) {
      var emailAddress = emailArr[i];
      if (trim(emailAddress) != '') {
        if (!/^\s*[\w.%+\-&'#!\$\*=\?\^_`\{\}~\/]+@([A-Z0-9-]+\.)*[A-Z0-9-]+\.[\w-]{2,}\s*$/i.test(emailAddress) && !/^.*<[A-Z0-9._%+\-&'#!\$\*=\?\^_`\{\}~]+?@([A-Z0-9-]+\.)*[A-Z0-9-]+\.[\w-]{2,}>\s*$/i.test(emailAddress)) {
  
          return false;
        } // if
      }
    } // for
    return true;
  }
