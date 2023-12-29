{* 
 * This file is part of SinergiaCRM.
 * SinergiaCRM is a work developed by SinergiaTIC Association, based on SuiteCRM.
 * Copyright (C) 2013 - 2023 SinergiaTIC Association
 *
 * This program is free software; you can redistribute it and/or modify it under
 * the terms of the GNU Affero General Public License version 3 as published by the
 * Free Software Foundation.
 *
 * This program is distributed in the hope that it will be useful, but WITHOUT
 * ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS
 * FOR A PARTICULAR PURPOSE. See the GNU Affero General Public License for more
 * details.
 *
 * You should have received a copy of the GNU Affero General Public License along with
 * this program; if not, see http://www.gnu.org/licenses or write to the Free
 * Software Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA
 * 02110-1301 USA.
 *
 * You can contact SinergiaTIC Association at email address info@sinergiacrm.org.
 *}
<div class="moduleTitle">
	<h2 class="module-title-text">{$MOD.LBL_STIC_TEST_DATA_LINK_TITLE}</h2>
</div>
<div class="clear"></div>


<div class="actions">
	<div class="well col-md-6 text-center">
		<a href="index.php?module=Administration&action=insertSticData"><button type='button' class='button'><span
					class='glyphicon glyphicon-flash text-success'></span>
				{$MOD.LBL_STIC_TEST_DATA_INSERT_LINK_TITLE}</button></a>
		<p>{$MOD.LBL_STIC_TEST_DATA_INSERT_DESCRIPTION}
	</div>
	<div class="well col-md-6 text-center">
		<a href="index.php?module=Administration&action=removeSticData"><button type='button' class='button'><span
					class='glyphicon glyphicon-trash text-danger'></span>
				{$MOD.LBL_STIC_TEST_DATA_REMOVE_LINK_TITLE}</button></a>
		<p>{$MOD.LBL_STIC_TEST_DATA_REMOVE_DESCRIPTION}
	</div>
</div>
<div class="alert alert-danger"><span class="glyphicon glyphicon-exclamation-sign"></span> {$MOD.LBL_STIC_TEST_DATA_NOTICE}</div>
<script type="text/javascript">
	{literal}
		$(document).ready(function() {

			// Select and loop the container element of the elements you want to equalise
			$('.actions').each(function() {

				// Cache the highest
				var highestBox = 0;

				// Select and loop the elements you want to equalise
				$('.well', this).each(function() {

					// If this box is higher than the cached highest then store it
					if ($(this).height() > highestBox) {
						highestBox = $(this).height();
					}

				});

				// Set the height of all those children to whichever was highest 
				$('.well', this).height(highestBox);

			});

		});

	{/literal}
</script>
