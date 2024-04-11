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
var sticCV_Record_Tab_Content = class sticCV_Record_Tab_Content extends sticCV_Element_FieldContainer {
  constructor(tab) {
    super(tab.customView, tab.customView.$elementView.find("div.tab-content > div[data-id=" + tab.name + "]"));

    // Fix padding for Tabs
    if (this.$element.css("padding") == "0px" && this.$element.parent().css("padding") != "0px") {
      var parentPadding = this.$element.parent().css("padding");
      this.$element.parent().css("padding", "0px");
      this.$element.parent().children().css("padding", parentPadding);
    }
    this.tabIndex = this.$element.index();
    // Add panels to Tab content
    this.$element = this.$element.add(
      tab.customView.$elementView.find("div.panel-content > div.tab-panel-" + this.tabIndex)
    );
  }

  applyAction(action) {
    switch (action.action) {
      case "background":
        sticCVUtils.background(this.$element.first(), this.customView, action.value);
        return this;
    }
    return super.applyAction(action);
  }
};
