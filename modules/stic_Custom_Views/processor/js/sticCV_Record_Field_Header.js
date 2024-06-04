/**
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
 */

/**
 * This file contains logic and functions needed to manage custom views behaviour
 *
 */
var sticCV_Record_Field_Header = class sticCV_Record_Field_Header extends sticCV_Element_Label {
  constructor(customView, $fieldElement) {
    super(customView, $fieldElement.children(".label"));

    // Fix size: same as Content
    if (this.customView.view == "detailview") {
      this.$element.css("min-height", "42px");
      this.$element.css("margin-top", "1px");
      this.$element.css("margin-bottom", "1px");
    } else if (this.customView.view == "editview" || this.customView.view == "quickcreate") {
      this.$element.css("min-height", "20px");
      this.$element.css("margin-left", "-5px");
      this.$element.css("margin-right", "5px");
      this.$element.css("padding-left", "5px");
    }
  }
};
