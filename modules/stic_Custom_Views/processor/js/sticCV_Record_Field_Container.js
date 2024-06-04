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
var sticCV_Record_Field_Container = class sticCV_Record_Field_Container extends sticCV_Element_Div {
  constructor(field, $fieldElement) {
    super(field.customView, $fieldElement);

    // Make same height Header and Content
    this.$element.css("align-items", "stretch");

    this.field = field;
  }
  applyAction(action) {
    switch (action.action) {
      case "color":
      case "bold":
      case "italic":
      case "underline":
        // Do nothing - These container field actions are made in Header + Content
        return this;
      case "background":
        // Adapt the the style of Header and Content
        this.field.header.applyAction({
          action: "style",
          value: { "border-top-right-radius": 0, "border-bottom-right-radius": 0 }
        });
        this.field.content.applyAction({
          action: "style",
          value: { "border-top-left-radius": 0, "border-bottom-left-radius": 0 }
        });
        sticCVUtils.style(this.field.content.$readonlyLabel, this.field.customView, {
          "border-top-left-radius": 0,
          "border-bottom-left-radius": 0
        });
        switch (this.field.customView.view) {
          case "detailview":
            this.field.content.applyAction({ action: "style", value: { "margin-left": 0 } });
            break;
          case "editview":
          case "quickcreate":
            this.field.header.applyAction({ action: "style", value: { "margin-left": 0, "margin-right": 0 } });
            break;
        }

        return this;
    }
    return super.applyAction(action);
  }
};
