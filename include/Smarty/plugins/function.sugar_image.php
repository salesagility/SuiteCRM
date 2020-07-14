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

r40493 - 2008-10-13 14:10:05 -0700 (Mon, 13 Oct 2008) - jmertic - Globally change theme image access to use SugarTheme::getImageURL() and SugarTheme::getImage(), instead of previous methods of using getImagePath(), get_image(), or using the $image_path global.

r31169 - 2008-01-21 12:03:26 -0800 (Mon, 21 Jan 2008) - tyoung - Bug 19351 - now check that a subpanel is not getting its data from a datasource function before we add it to the list of editable subpanels. Uses the new altimage parameter to sugar_image to handle subpanels that don't have nice icons.
Also added support in the Smarty plugin sugar_image for an altimage parameter to use if the primary icon file is missing - this is used for example when displaying subpanels for which no icon file exists

r27371 - 2007-09-28 03:58:13 -0700 (Fri, 28 Sep 2007) - tyoung - Added optional parameter to sugar_image - if 'image' is set then use that as the base for the image filename instead of using the value of parameter 'name'. Required for images where the image title to be displayed under the image does not match the image filename, for example, title='Basic Search' and filename='BasicSearch'

r24875 - 2007-07-31 11:34:56 -0700 (Tue, 31 Jul 2007) - dwheeler - Updated sugar_image smarty function to use the new module image function.
Numerous bug fixes to wizard views, crumb fixes in label editor.
Added feedback for saving edited fields in list/subpanel views
Added saving of labels in list and subpanel views.

r24477 - 2007-07-19 18:01:09 -0700 (Thu, 19 Jul 2007) - majed - smarty get_image support


*/



function smarty_function_sugar_image($params, &$smarty)
{
    if (!isset($params['name'])) {
        $smarty->trigger_error("sugar_field: missing 'name' parameter");
        return;
    }
    $height = (!empty($params['height']))?$params['height']:'48';
    $width = (!empty($params['width']))?$params['width']:'48';
    $image = (!empty($params['image']))?$params['image']:$params['name'];
    $altimage = (!empty($params['altimage']))?$params['altimage']:$params['name'];
    return getStudioIcon($image, $altimage, $height, $width);
}
