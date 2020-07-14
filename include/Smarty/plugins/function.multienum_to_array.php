<?php

/*

Modification information for LGPL compliance

r56990 - 2010-06-16 13:05:36 -0700 (Wed, 16 Jun 2010) - kjing - snapshot "Mango" svn branch to a new one for GitHub sync

r56989 - 2010-06-16 13:01:33 -0700 (Wed, 16 Jun 2010) - kjing - defunt "Mango" svn dev branch before github cutover

r55980 - 2010-04-19 13:31:28 -0700 (Mon, 19 Apr 2010) - kjing - create Mango (6.1) based on windex

r53116 - 2009-12-09 17:24:37 -0800 (Wed, 09 Dec 2009) - mitani - Merge Kobe into Windex Revision 51633 to 53087

r51719 - 2009-10-22 10:18:00 -0700 (Thu, 22 Oct 2009) - mitani - Converted to Build 3  tags and updated the build system

r51634 - 2009-10-19 13:32:22 -0700 (Mon, 19 Oct 2009) - mitani - Windex is the branch for Sugar Sales 1.0 development

r50983 - 2009-09-21 13:45:37 -0700 (Mon, 21 Sep 2009) - ajay - Merged code from branches/tokyo version 50739 thru 50982

r50883 - 2009-09-16 15:54:43 -0700 (Wed, 16 Sep 2009) - dwheeler - 30563,21574: Multienum values are now stored in the db with leading '^' characters to allow for simplified searching on multienums. To facilitate this, un/encodeMultiEnum functions have been added  and all calls to convert multienums to strings now go through those two functions. multienum_to_array is now a smarty function rather than modifier due to the fact that the way that smarty handles modifiers called on array values was breaking the detection of double calls to multienum_to_array.

r46872 - 2009-05-05 01:37:39 -0700 (Tue, 05 May 2009) - jchi - #27426 - Reverse the order of two conditions in modifier.multienum_to_array::smarty_modifier_multienum_to_array.
We should judge the empty string firstly.

r42807 - 2008-12-29 11:16:59 -0800 (Mon, 29 Dec 2008) - dwong - Branch from trunk/sugarcrm r42806 to branches/tokyo/sugarcrm

r39146 - 2008-08-26 17:16:04 -0700 (Tue, 26 Aug 2008) - awu - Merging pre_5_1_0 to trunk

r35784 - 2008-05-20 14:31:40 -0700 (Tue, 20 May 2008) - dwheeler - 21475: Converted multiselect DynamicField default value to be a multiselect.

r26565 - 2007-09-11 11:09:20 -0700 (Tue, 11 Sep 2007) - clee - Changed to just use explode function.  It is safer than split using commas because values themselves could have commas.

r26564 - 2007-09-11 11:03:41 -0700 (Tue, 11 Sep 2007) - clee - Fixed issues with multienum custom type.
Added:
trunk/include/SugarFields/Fields/MultiEnum/DetailView.tpl
trunk/include/Smarty/plugins/modifier.multienum_to_array.php
Touched:
trunk/include/SugarFields/Fields/MultiEnum/EditView.tpl
trunk/include/SugarFields/Fields/MultiEnum/SugarFieldMultiEnum.php
trunk/modules/DynamicFields/DynamicField.php (changed saving of default/empty values)
trunk/include/EditView/EditView2.php (removed comments)


*/


/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 */


/**
 * Smarty modifier to convert multienum separated value to Array
 *
 * Type:     function<br>
 * Name:     multienum_to_array<br>
 * Purpose:  Utility to transform multienum String to Array format
 * @author   Collin Lee <clee at sugarcrm dot com>
 * @param string The multienum field's value(s) as a String
 * @param default The multienum field's default value
 * @return Array
 */
function smarty_function_multienum_to_array($params, &$smarty)
{
    $ret = "";
    if (empty($params['string'])) {
        if (empty($params['default'])) {
            $ret = array();
        } elseif (is_array($params['default'])) {
            $ret = $params['default'];
        } else {
            $ret = unencodeMultienum($params['default']);
        }
    } else {
        if (is_array($params['string'])) {
            $ret = $params['string'];
        } else {
            $ret = unencodeMultienum($params['string']);
        }
    }
    
    
    if (!empty($params['assign'])) {
        $smarty->assign($params['assign'], $ret);
        return "";
    }
    
    return ($ret);
}
