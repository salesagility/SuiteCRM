{*

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




*}


{literal}
<script type="text/javascript">
if(typeof SugarFeed == 'undefined') { // since the dashlet can be included multiple times a page, don't redefine these functions
	SugarFeed = function() {
	    return {
	    	/**
	    	 * Called when the textarea is blurred
	    	 */
	        pushUserFeed: function(id) {
	        	ajaxStatus.showStatus('{/literal}{$saving}{literal}'); // show that AJAX call is happening
	        	// what data to post to the dashlet
    	    	
    	    	postData = 'to_pdf=1&module=Home&action=CallMethodDashlet&method=pushUserFeed&id=' + id ;
				YAHOO.util.Connect.setForm(document.getElementById('form_' + id));
				var cObj = YAHOO.util.Connect.asyncRequest('POST','index.php', 
								  {success: SugarFeed.saved, failure: SugarFeed.saved, argument: id}, postData);
	        },
		    /**
	    	 * handle the response of the saveText method
	    	 */
	        saved: function(data) {
	        	SUGAR.mySugar.retrieveDashlet(data.argument);
	           	ajaxStatus.flashStatus('{/literal}{$done}{literal}');
	        }, 
	        deleteFeed: function(record, id){
				postData = 'to_pdf=1&module=Home&action=CallMethodDashlet&method=deleteUserFeed&id=' + id + '&record=' +  record;
				var cObj = YAHOO.util.Connect.asyncRequest('POST','index.php', 
								  {success: SugarFeed.saved, failure: SugarFeed.saved, argument: id}, postData);	        
	        },
            buildReplyForm: function(record, id, elem) {
               // See if we already have a blockquote
               var myParentElem = elem.parentNode.parentNode.parentNode;
               
               var blockElem = myParentElem.getElementsByTagName('blockquote')[0];
               if ( typeof(blockElem) == 'undefined' || typeof(blockElem[0]) == 'undefined' ) {
                  // Need to create a blockquote element
                  // With a "clear" div in front of it.
                  var divElem = document.createElement('div');
                  divElem.className = 'clear';
                  myParentElem.appendChild(divElem);
                  blockElem = document.createElement('blockquote');
                  myParentElem.appendChild(blockElem);
               } else {
                 // Should only be one child blockquote element, so we'll just grab the first one
                 blockElem = blockElem[0];
               }

               // Move the reply form up over here
               var formElem = document.getElementById('SugarFeedReplyForm_'+id);
               formElem.parentNode.removeChild(formElem);
               blockElem.appendChild(formElem);
               formElem.getElementsByTagName('div')[0].style.display = 'block';
               formElem.parentFeed.value = record;

            },
            replyToFeed: function( id ) {
	        	ajaxStatus.showStatus('{/literal}{$saving}{literal}'); // show that AJAX call is happening
	        	// what data to post to the dashlet
    	    	
                var formElem = document.getElementById('SugarFeedReplyForm_' + id);
    	    	postData = 'to_pdf=1&module=Home&action=CallMethodDashlet&method=pushUserFeedReply&id=' + id ;
				YAHOO.util.Connect.setForm(formElem);
				var cObj = YAHOO.util.Connect.asyncRequest('POST','index.php', 
								  {success: SugarFeed.saved, failure: SugarFeed.saved, argument: id}, postData);
               
            },
            loaded: function(id) {
            	var scrollConent;
            	scrollContent = new iScroll('contentScroller' + id);
            }
	    };
	}();
}

if(SUGAR.util.isTouchScreen()) {
	document.addEventListener('DOMContentLoaded', function(){SugarFeed.loaded('{/literal}{$idjs}{literal}')}, false);	
}
</script>
{/literal}
<script type="text/javascript" src="{sugar_getjspath file="include/javascript/popup_helper.js"}">
</script>