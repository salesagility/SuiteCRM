<?php

/*

Modification information for LGPL compliance

r56990 - 2010-06-16 13:05:36 -0700 (Wed, 16 Jun 2010) - kjing - snapshot "Mango" svn branch to a new one for GitHub sync

r56989 - 2010-06-16 13:01:33 -0700 (Wed, 16 Jun 2010) - kjing - defunt "Mango" svn dev branch before github cutover

r55980 - 2010-04-19 13:31:28 -0700 (Mon, 19 Apr 2010) - kjing - create Mango (6.1) based on windex

r51719 - 2009-10-22 10:18:00 -0700 (Thu, 22 Oct 2009) - mitani - Converted to Build 3  tags and updated the build system 

r51634 - 2009-10-19 13:32:22 -0700 (Mon, 19 Oct 2009) - mitani - Windex is the branch for Sugar Sales 1.0 development

r50375 - 2009-08-24 18:07:43 -0700 (Mon, 24 Aug 2009) - dwong - branch kobe2 from tokyo r50372

r42807 - 2008-12-29 11:16:59 -0800 (Mon, 29 Dec 2008) - dwong - Branch from trunk/sugarcrm r42806 to branches/tokyo/sugarcrm

r34090 - 2008-04-14 11:15:00 -0700 (Mon, 14 Apr 2008) - dwheeler - 20936: Link field now uses the vardef's default value when creating generated links instead of the database value.

r34040 - 2008-04-11 11:48:13 -0700 (Fri, 11 Apr 2008) - dwheeler - Fixed Typo that prevented enum fields from being replaced properly.

r33968 - 2008-04-10 11:30:04 -0700 (Thu, 10 Apr 2008) - dwheeler - bug 20936: Added smarty function to find and replace dynamic strings for custom dynamic fields, now handles translating strings for enum variables. 


*/



/**
 * This function will replace fields taken from the fields variable
 * and insert them into the passed string replacing [variableName] 
 * tokens where found.
 *
 * @param unknown_type $params
 * @param unknown_type $smarty
 * @return unknown
 */
function smarty_function_sugar_replace_vars($params, &$smarty)
{
	if(empty($params['subject']))  {
	    $smarty->trigger_error("sugarvar: missing 'subject' parameter");
	    return;
	} 
	$fields = empty($params['fields']) ? $smarty->get_template_vars('fields') : $params['fields'];
	$lDelim = "[";
    $rDelim = "]";
    if ($params['use_curly'])
    {
        $lDelim = "{";
        $rDelim = "}";
    }
    $subject = $params['subject'];
	$matches = array();
	$count = preg_match_all('/\\' . $lDelim . '([^\\' . $rDelim . ']*)\\' . $rDelim . '/', $subject, $matches);
    for($i = 0; $i < $count; $i++) {
		$match = $matches[1][$i];
        //List views will have fields be an array where all the keys are upper case and the values are jsut strings
        if (!isset($fields[$match]) && isset($fields[strtoupper($match)]))
            $match = strtoupper($match);

        $value = isset($fields[$match]) ? $fields[$match] : null;
        if (!is_null($value)) {
            if (isset($value['function']['returns']) && $value['function']['returns'] == 'html')
            {
                $bean  = $smarty->get_template_vars('bean');
                $value = $bean->$match;
            }
            else if (is_array($value) && isset($value['value']))
            {
                $value = $value['value'];
            }

            if (isset($fields[$match]['type']) && $fields[$match]['type']=='enum'
				&& isset($fields[$match]['options']) && isset($fields[$match]['options'][$value]))
			{
				$subject = str_replace($matches[0][$i], $fields[$match]['options'][$value], $subject);
			} else 
			{
				$subject = str_replace($matches[0][$i], $value, $subject);
			}
		}
	}
		
	if (!empty($params['assign']))
	{
		$smarty->assign($params['assign'], $subject);
		return '';
	}
	
	return $subject;
}