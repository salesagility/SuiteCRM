<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
/*********************************************************************************
 * SugarCRM Community Edition is a customer relationship management program developed by
 * SugarCRM, Inc. Copyright (C) 2004-2013 SugarCRM Inc.
 * 
 * This program is free software; you can redistribute it and/or modify it under
 * the terms of the GNU Affero General Public License version 3 as published by the
 * Free Software Foundation with the addition of the following permission added
 * to Section 15 as permitted in Section 7(a): FOR ANY PART OF THE COVERED WORK
 * IN WHICH THE COPYRIGHT IS OWNED BY SUGARCRM, SUGARCRM DISCLAIMS THE WARRANTY
 * OF NON INFRINGEMENT OF THIRD PARTY RIGHTS.
 * 
 * This program is distributed in the hope that it will be useful, but WITHOUT
 * ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS
 * FOR A PARTICULAR PURPOSE.  See the GNU Affero General Public License for more
 * details.
 * 
 * You should have received a copy of the GNU Affero General Public License along with
 * this program; if not, see http://www.gnu.org/licenses or write to the Free
 * Software Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA
 * 02110-1301 USA.
 * 
 * You can contact SugarCRM, Inc. headquarters at 10050 North Wolfe Road,
 * SW2-130, Cupertino, CA 95014, USA. or at email address contact@sugarcrm.com.
 * 
 * The interactive user interfaces in modified source and object code versions
 * of this program must display Appropriate Legal Notices, as required under
 * Section 5 of the GNU Affero General Public License version 3.
 * 
 * In accordance with Section 7(b) of the GNU Affero General Public License version 3,
 * these Appropriate Legal Notices must retain the display of the "Powered by
 * SugarCRM" logo. If the display of the logo is not reasonably feasible for
 * technical reasons, the Appropriate Legal Notices must display the words
 * "Powered by SugarCRM".
 ********************************************************************************/

require_once('modules/SugarFeed/linkHandlers/Link.php');

class FeedLinkHandlerImage extends FeedLinkHandlerLink {
    function getDisplay(&$data) {
        $imageData = unserialize(base64_decode($data['LINK_URL']));
        if ( $imageData['width'] != 0 ) {
            $image_style = 'width: '.$imageData['width'].'px; height: '.$imageData['height'].'px; border: 0px;';
        } else {
            // Unknown width/height
            // Set it to a max width of 425 px, and include a tweak so that IE 6 can actually handle it.
            $image_style = 'width: expression(this.scrollWidth > 425 ? \'425px\':\'auto\'); max-width: 425px;';
        }
        return '<div style="padding-left:10px"><!--not_in_theme!--><img src="'. $imageData['url']. '" style="'.$image_style.'"></div>';
    }

    function handleInput($feed, $link_type, $link_url) {
        parent::handleInput($feed, $link_type, $link_url);

        // The FeedLinkHandlerLink class will help sort this url out for us
        $link_url = $feed->link_url;

        $imageData = @getimagesize($link_url);

        if ( ! isset($imageData) ) {
            // The image didn't pull down properly, could be a link and allow_url_fopen could be disabled
            $imageData[0] = 0;
            $imageData[1] = 0;
        } else {
            if ( max($imageData[0],$imageData[1]) > 425 ) {
                // This is a large image, we need to set some specific width/height properties so that the browser can scale it.
                $scale = 425 / max($imageData[0],$imageData[1]);
                $imageData[0] = floor($imageData[0]*$scale);
                $imageData[1] = floor($imageData[1]*$scale);
            }
        }

        $feed->link_url = base64_encode(serialize(array('url'=>$link_url,'width'=>$imageData[0],'height'=>$imageData[1])));
    }
}