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

class FeedLinkHandlerYoutube extends FeedLinkHandlerLink {
    function getDisplay(&$data) {
        return '<div style="padding-left:10px"><object width="425" height="344"><param name="movie" value="http://www.youtube.com/v/' . $data['LINK_URL'] . '&hl=en&fs=1"></param><param name="allowFullScreen" value="true"></param><param name="wmode" value="opaque" /><embed src="http://www.youtube.com/v/' . $data['LINK_URL'] . '&hl=en&fs=1" type="application/x-shockwave-flash" allowfullscreen="false" wmode="opaque" width="425" height="344"></embed></object></div>';
    }
    
    function handleInput($feed, $link_type, $link_url) {
        $match = array();
        preg_match('/v=([^\&]+)/', $link_url, $match);
		
        if(!empty($match[1])){
            $feed->link_type = $link_type;
            $feed->link_url = $match[1];
        }
    }
}