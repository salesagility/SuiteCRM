/**
 *
 * SugarCRM Community Edition is a customer relationship management program developed by
 * SugarCRM, Inc. Copyright (C) 2004-2013 SugarCRM Inc.
 *
 * SuiteCRM is an extension to SugarCRM Community Edition developed by SalesAgility Ltd.
 * Copyright (C) 2011 - 2017 SalesAgility Ltd.
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
 * FOR A PARTICULAR PURPOSE. See the GNU Affero General Public License for more
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
 * SugarCRM" logo and "Supercharged by SuiteCRM" logo. If the display of the logos is not
 * reasonably feasible for technical reasons, the Appropriate Legal Notices must
 * display the words "Powered by SugarCRM" and "Supercharged by SuiteCRM".
 */


if (typeof(SUGAR.collection) == "undefined") {
  SUGAR.collection = function (form_name, field_name, module, popupData) {

    /*
     * boolean variable to handle expand/collapse views
     * false if the collection field is collapsed and true if the rows are expanded.
     */
    this.more_status = false;

    /*
     * Store the form name containing this field.  Example: EditView
     */
    this.form = form_name;

    /*
     * Store the name of the collection field. Example: account_name
     */
    this.field = field_name;


    /*
     * Store the unique form + field name that uses the combination of form and field
     */
    this.field_element_name = this.form + '_' + this.field;

    /*
     * Store the name of the module from where come the field. Example: Accounts
     */
    this.module = module;

    /*
     * Number of secondaries linked records (total of linked records - 1).
     */
    this.fields_count = 0;

    /*
     * Number of extra fields.
     */
    this.extra_fields_count = 0;

    /*
     * Set to true if it is the initialization.
     */
    this.first = true;

    /*
     * Name of the primary field. Example: "accounts_collection_0"
     */
    this.primary_field = "";

    /*
     * Store the row cloned in key "0" and the context cloned in key "1".
     */
    this.cloneField = new Array();

    /*
     * Store the sqs_objects for the cloned row encoded in JSON.
     */
    this.sqs_clone = "";

    /*
     * Store the name and the id of all the secondaries linked records. this is used to create the secondary rows.
     */
    this.secondaries_values = new Array();

    /*
     * Store all the extra fields which has been updated in the collection field to save on save of the main record.
     */
    this.update_fields = new Object();

    /*
     * boolean variable indicating whether or not to show the expand/collapse arrow
     */
    this.show_more_image = true;

  };

  SUGAR.collection.prototype = {
    /*
     * Remove the row designated by the passed 'id' or clear the row if there is only one row.
     */
    remove: function (num) {
      // if there is only one record, clear it instead of removing it
      // this is determined by the visibility of the drop down arrow element
      var radio_els = this.get_radios();
      var div_el;
      if (radio_els.length == 1) {
        div_el = document.getElementById(this.field_element_name + '_input_div_' + num);
        var input_els = div_el.getElementsByTagName('input');
        //Clear text field
        input_els[0].value = '';

        //Clear hidden field
        input_els[1].value = '';

        if (this.primary_field) {
          div_el = document.getElementById(this.field_element_name + '_radio_div_' + num);
          radio_els = div_el.getElementsByTagName('input');
          //Clear the radio field
          radio_els[0].checked = false;
        }
      } else {
        div_el = document.getElementById(this.field_element_name + '_input_div_' + num);
        if (!div_el)
          div_el = document.getElementById(this.field_element_name + '_radio_div_' + num);
        var tr_to_remove = document.getElementById('lineFields_' + this.field_element_name + '_' + num);
        div_el.parentNode.parentNode.parentNode.removeChild(tr_to_remove);

        var div_id = 'lineFields_' + this.field_element_name + '_' + num;
        if (typeof sqs_objects[div_id.replace("_field_", "_")] != 'undefined') {
          delete (sqs_objects[div_id.replace("_field_", "_")]);
        }
        var checked = false;
        for (var k = 0; k < radio_els.length; k++) {
          if (radio_els[k].checked) {
            checked = true;
          }
        }
        // If we remove an entry marked as the primary, set another record as the primary
        var primary_checked = document.forms[this.form].elements[this.field + "_allowed_to_check"];
        var allowed_to_check = true;
        if (primary_checked && primary_checked.value == 'false') {
          allowed_to_check = false;
        }
        if (/EditView/.test(this.form) && !checked && typeof radio_els[0] != 'undefined' && allowed_to_check) {
          radio_els[0].checked = true;
          this.changePrimary(true);
          this.js_more();
          this.js_more();
        }
        // if there is now only one record, hide the "more..." link
        if (radio_els.length == 1) {
          this.more_status = false;
          if (document.getElementById('more_' + this.field_element_name) && document.getElementById('more_' + this.field_element_name).style.display != 'none') {
            document.getElementById('more_' + this.field_element_name).style.display = 'none';
          }

          this.show_arrow_label(false);
          this.js_more();
        } else {
          this.js_more();
          this.js_more();
        }
      }
    },

    get_radios: function () {
      return YAHOO.util.Selector.query('input[name^=primary]', document.getElementById(this.field_element_name + '_table'));
    },

    /*
     * Add a new empty row.
     */
    add: function (values) {
      this.fields_count++;
      var Field0 = this.init_clone(values);
      this.cloneField[1].appendChild(Field0);
      //Enable quicksearch for this field
      enableQS(true);
      this.changePrimary(false);

      //If the arrow field and label are collapsed, un-collapse it
      if (document.getElementById('more_' + this.field_element_name) && document.getElementById('more_' + this.field_element_name).style.display == 'none') {
        document.getElementById('more_' + this.field_element_name).style.display = '';
      }

      if (!this.is_expanded()) {
        this.js_more();
        this.show_arrow_label(true);
      }
    },

    /*
     * Add the secondaries rows on load of the page.
     */
    add_secondaries: function () {
      var clone_id = this.form + '_' + this.field + '_collection_0';
      YAHOO.util.Event.onContentReady(clone_id, function (c) {
        c.create_clone();
        enableQS();
        c.changePrimary(true);
        for (key in c.secondaries_values) {
          if (isInteger(key)) {
            c.add(c.secondaries_values[key]);
          }
        }
        c.js_more();
        // Update the "hash" of the unchanged form, because this is just adding data, not actually changing anything
        initEditView(document.forms[c.form]);
      }, this);
    },
    /*
     * Create the new row from a cloned row.
     */
    init_clone: function (values) {

      //Safety check, this means that the clone field was not created yet
      if (typeof this.cloneField[0] == 'undefined') {
        return;
      }

      if (typeof values == "undefined") {
        values = new Array();
        values['name'] = "";
        values['id'] = "";
      }

      var count = this.fields_count;

      //Clone the table element containing the fields for each row, use safe_clone uder IE to prevent events from being cloned
      var Field0 = SUGAR.isIE ?
        SUGAR.collection.safe_clone(this.cloneField[0], true) :
        this.cloneField[0].cloneNode(true);

      Field0.id = "lineFields_" + this.field_element_name + "_" + count;

      for (var ii = 0; ii < Field0.childNodes.length; ii++) {
        if (typeof(Field0.childNodes[ii].tagName) != 'undefined' && Field0.childNodes[ii].tagName == "TD") {
          for (var jj = 0; jj < Field0.childNodes[ii].childNodes.length; jj++) {
            currentNode = Field0.childNodes[ii].childNodes[jj];
            this.process_node(Field0.childNodes[ii], currentNode, values);
          } //for
        } //if
      } //for
      return Field0;
    },
    /**
     * process_node
     *
     * method to process cloning of nodes, moved out of init_clone so that
     * this may be recursively called
     */
    process_node: function (parentNode, currentNode, values) {
      if (parentNode.className == 'td_extra_field') {
        // If this is an extra field
        if (parentNode.id) {
          parentNode.id = '';
        }
        var toreplace = this.field + "_collection_extra_0";
        var re = new RegExp(toreplace, 'g');
        parentNode.innerHTML = parentNode.innerHTML.replace(re, this.field + "_collection_extra_" + this.fields_count);
      } else if (currentNode.tagName && currentNode.tagName == 'SPAN') {
        //If it is our div element, recursively find all input elements to process
        currentNode.id = /_input/.test(currentNode.id) ? this.field_element_name + '_input_div_' + this.fields_count : this.field_element_name + '_radio_div_' + this.fields_count;
        if (/_input/.test(currentNode.id)) {
          currentNode.name = 'teamset_div';
        }

        var input_els = currentNode.getElementsByTagName('input');
        for (var x = 0; x < input_els.length; x++) {

          //if the input tag id is blank (IE bug), then set it equal to that of the parent span id
          if (typeof(input_els[x].id) == 'undefined' || input_els[x].id == '') {
            input_els[x].id = currentNode.id;
          }

          if (input_els[x].tagName && input_els[x].tagName == 'INPUT') {
            this.process_node(parentNode, input_els[x], values);
          }
        }
      } else if (currentNode.name) {
        // If this is a standard field
        var toreplace = this.field + "_collection_0";
        var re = new RegExp(toreplace, 'g');
        var name = currentNode.name;
        var new_name = name.replace(re, this.field + "_collection_" + this.fields_count);
        var new_id = currentNode.id.replace(re, this.field + "_collection_" + this.fields_count);

        switch (name) {
          case toreplace:
            var sqs_id = this.form + '_' + new_name;
            if (typeof this.sqs_clone != 'undefined') {
              var sqs_clone = YAHOO.lang.JSON.stringify(this.sqs_clone);
              SUGAR.util.globalEval('sqs_objects[sqs_id]=' + sqs_clone);

              for (var pop_field in sqs_objects[sqs_id]['populate_list']) {
                if (typeof sqs_objects[sqs_id]['populate_list'][pop_field] == 'string') {
                  sqs_objects[sqs_id]['populate_list'][pop_field] = sqs_objects[sqs_id]['populate_list'][pop_field].replace(RegExp('_0', 'g'), "_" + this.fields_count);
                }
              }
              for (var req_field in sqs_objects[sqs_id]['required_list']) {
                if (typeof sqs_objects[sqs_id]['required_list'][req_field] == 'string') {
                  sqs_objects[sqs_id]['required_list'][req_field] = sqs_objects[sqs_id]['required_list'][req_field].replace(RegExp('_0', 'g'), "_" + this.fields_count);
                }
              }
            }

            currentNode.name = new_name;
            currentNode.id = new_id;
            currentNode.value = values['name'];
            break;
          case "id_" + toreplace:
            currentNode.name = new_name.replace(RegExp('_0', 'g'), "_" + this.fields_count);
            currentNode.id = new_id.replace(RegExp('_0', 'g'), "_" + this.fields_count);
            currentNode.value = values['id'];
            break;
          case "btn_" + toreplace:
            currentNode.name = new_name;
            currentNode.attributes['onclick'].value = currentNode.attributes['onclick'].value.replace(re, this.field + "_collection_" + this.fields_count);
            currentNode.attributes['onclick'].value = currentNode.attributes['onclick'].value.replace(RegExp(this.field + "_collection_extra_0", 'g'), this.field + "_collection_extra_" + this.fields_count);
            break;
          case "allow_new_value_" + toreplace:
            currentNode.name = new_name;
            currentNode.id = new_id;
            break;
          case "remove_" + toreplace:
            currentNode.name = new_name;
            currentNode.id = new_id;
            currentNode.setAttribute('collection_id', this.field_element_name);
            currentNode.setAttribute('remove_id', this.fields_count);
            currentNode.onclick = function () {
              collection[this.getAttribute('collection_id')].remove(this.getAttribute('remove_id'));
            };
            break;
          case "primary_" + this.field + "_collection":
            currentNode.id = new_id;
            currentNode.value = this.fields_count;
            currentNode.checked = false; //Firefox
            currentNode.setAttribute('defaultChecked', '');
            break;
          default:
            alert(toreplace + '|' + currentNode.name + '|' + name + '|' + new_name);
            break;
        } //switch
      } //if-else

    },

    /*
     * Collapse or expand the rows to show for the editview(depending of the this.more_status attribute).
     */
    js_more: function (val) {
      if (this.show_more_image) {
        var more_ = document.getElementById('more_img_' + this.field_element_name);
        var arrow = document.getElementById('arrow_' + this.field);
        var radios = this.get_radios();
        // if we want to collapse
        if (this.more_status == false) {
          more_.src = "index.php?entryPoint=getImage&themeName=" + SUGAR.themes.theme_name + "&imageName=advanced_search.gif";
          this.more_status = true;
          // show the primary only and hidde the other one.
          var hidden_count = 0;
          for (var k = 0; k < radios.length; k++) {
            if (radios[k].type && radios[k].type == 'radio') {
              if (radios[k].checked) {
                radios[k].parentNode.parentNode.parentNode.style.display = '';
              } else {
                radios[k].parentNode.parentNode.parentNode.style.display = 'none';
                hidden_count++;
              }
            }
          }
          //rrs - add code to not remove the first field if non if the fields are selected as primary
          if (hidden_count == radios.length) {
            radios[0].parentNode.parentNode.parentNode.style.display = '';
          }

          arrow.value = 'hide';
        } else {
          more_.src = "index.php?entryPoint=getImage&themeName=" + SUGAR.themes.theme_name + "&imageName=basic_search.gif";
          this.more_status = false;
          // display all the records
          for (var k = 0; k < radios.length; k++) {
            if (isInteger(k)) {
              radios[k].parentNode.parentNode.parentNode.style.display = '';
            }
          }

          arrow.value = 'show';
        }

        var more_div = document.getElementById('more_div_' + this.field_element_name);
        if (more_div) {
          more_div.innerHTML = arrow.value == 'show' ? SUGAR.language.get('app_strings', 'LBL_HIDE') : SUGAR.language.get('app_strings', 'LBL_SHOW');
        }

      }
    },
    /*
     * Create the clone on load of the page and store it in this.cloneField
     */
    create_clone: function () {
      var oneField = document.getElementById('lineFields_' + this.field_element_name + '_0');
      this.cloneField[0] = SUGAR.isIE ?
        SUGAR.collection.safe_clone(oneField, true) :
        oneField.cloneNode(true);
      this.cloneField[1] = oneField.parentNode;
      //fixing bug @48829: Team field shows fully expanded multiple teams instead of hiding multiple teams
      //this.more_status = true;
      var clone_id = this.form + '_' + this.field + '_collection_0';

      if (typeof sqs_objects != 'undefined' && typeof sqs_objects[clone_id] != 'undefined') {
        var clone = YAHOO.lang.JSON.stringify(sqs_objects[clone_id]);
        SUGAR.util.globalEval('e=' + clone);
        this.sqs_clone = e;
      }
    },
    /**
     * Validates team set to check if the primary team id has been set or not
     */
    validateTemSet: function (formname, fieldname) {
      var table_element_id = formname + '_' + fieldname + '_table';
      if (document.getElementById(table_element_id)) {
        var input_elements = YAHOO.util.Selector.query('input[type=radio]', document.getElementById(table_element_id));
        var has_primary = false;
        var primary_field_id = fieldname + '_collection_0';
        for (t in input_elements) {
          primary_field_id = fieldname + '_collection_' + input_elements[t].value;
          if (input_elements[t].type && input_elements[t].type == 'radio' && input_elements[t].checked == true) {
            if (document.forms[formname].elements[primary_field_id].value != '') {
              has_primary = true;
            }
            break;
          }
        }
        if (!has_primary) {
          return false;
        }
        return true;
      }
      return true;
    },
    /**
     * return an array of teamids for a team field
     */
    getTeamIdsfromUI: function (formname, fieldname) {
      var team_ids = new Array();
      var table_element_id = formname + '_' + fieldname + '_table';
      if (document.getElementById(table_element_id)) {
        input_elements = YAHOO.util.Selector.query('input[type=hidden]', document.getElementById(table_element_id));
        for (t = 0; t < input_elements.length; t++) {
          if (input_elements[t].id.match(fieldname + "_collection_") != null) {
            team_ids.push(input_elements[t].value);
          } // if
        } // for
      } // if
      return team_ids;
    },
    /**
     * return a primary team id
     */
    getPrimaryTeamidsFromUI: function (formname, fieldname) {
      var table_element_id = formname + '_' + fieldname + '_table';
      if (document.getElementById(table_element_id)) {
        var input_elements = YAHOO.util.Selector.query('input[type=radio]', document.getElementById(table_element_id));
        for (t in input_elements) {
          var primary_field_id = 'id_' + document.forms[formname][fieldname].name + '_collection_' + input_elements[t].value;
          if (input_elements[t].type && input_elements[t].type == 'radio' && input_elements[t].checked == true) {
            if (document.forms[formname].elements[primary_field_id].value != '') {
              return document.forms[formname].elements[primary_field_id].value;
            } // if
          } // if
        } // for
      } // if
      return '';
    },
    /*
     * Change the primary row onchange of the radio button.
     */
    changePrimary: function (noAdd) {
      var old_primary = this.primary_field;
      var radios = this.get_radios();
      for (var k = 0; k < radios.length; k++) {
        var qs_id = radios[k].id.replace('primary_', '');
        if (radios[k].checked) {
          this.primary_field = qs_id;
        } else {
          qs_id = qs_id + '_' + k;
        }

        qs_id = this.form + '_' + qs_id;

        if (typeof sqs_objects != 'undefined' && typeof sqs_objects[qs_id] != 'undefined' && sqs_objects[qs_id]['primary_field_list']) {
          for (var ii = 0; ii < sqs_objects[qs_id]['primary_field_list'].length; ii++) {
            if (radios[k].checked && qs_id != old_primary) {
              sqs_objects[qs_id]['field_list'].push(sqs_objects[qs_id]['primary_field_list'][ii]);
              sqs_objects[qs_id]['populate_list'].push(sqs_objects[qs_id]['primary_populate_list'][ii]);
            } else if (old_primary == qs_id && !radios[k].checked) {
              sqs_objects[qs_id]['field_list'].pop();
              sqs_objects[qs_id]['populate_list'].pop();
            }
          }
        }
      }

      if (noAdd) {
        enableQS(false);
      }
      this.first = false;
    },
    /*
     * Collapse or expand the rows to show for the detailview.
     */
    js_more_detail: function (id) {
      var more_img = document.getElementById('more_img_' + id);
      if (more_img.style.display == 'inline') {
        more_img.src = "index.php?entryPoint=getImage&themeName=" + SUGAR.themes.theme_name + "&imageName=advanced_search.gif";
      } else {
        more_img.src = "index.php?entryPoint=getImage&themeName=" + SUGAR.themes.theme_name + "&imageName=basic_search.gif";
      }
    },
    /*
     * Replace the first field with the specified values
     */
    replace_first: function (values) {
      for (var i = 0; i <= this.fields_count; i++) {
        var div_el = document.getElementById(this.field_element_name + '_input_div_' + i);
        if (div_el) {
          var name_field = document.getElementById(this.field_element_name + "_collection_" + i);
          var id_field = document.getElementById("id_" + this.field_element_name + "_collection_" + i);
          name_field.value = values['name'];
          id_field.value = values['id'];
          break;
        }
      }
    },
    /*
     * Remove all empty fields from the widget.
     */
    clean_up: function () {
      //clean up any rows that have been added but do not contain any data
      var divsToClean = new Array();
      var isFirstFieldEmpty = false;
      var divCount = 0;
      for (var i = 0; i <= this.fields_count; i++) {
        var div_el = document.getElementById(this.field_element_name + '_input_div_' + i);
        if (div_el) {
          input_els = div_el.getElementsByTagName('input');
          for (var x = 0; x < input_els.length; x++) {
            if (input_els[x].id && input_els[x].name == (this.field + '_collection_' + i) && trim(input_els[x].value) == '') {
              if (divCount == 0) {
                isFirstFieldEmpty = true;
              } else {
                divsToClean.push(i);
              }
            }

          }
          divCount++;
        }
      }

      for (var j = 0; j < divsToClean.length; j++) {
        this.remove(divsToClean[j]);
      }
      return isFirstFieldEmpty;
    },

    show_arrow_label: function (show) {
      var more_div = document.getElementById('more_div_' + this.field_element_name);
      if (more_div) {
        more_div.style.display = show ? '' : 'none';
      }
    },

    /**
     * is_expanded
     * helper function to determine whether or not the widget is expanded (all teams are shown)
     */
    is_expanded: function () {
      var more_div = document.getElementById('more_div_' + this.field_element_name);
      if (more_div) {
        return more_div.style.display == '';
      }
      return false;
    }
  };

  SUGAR.collection.safe_clone = function (e, recursive) {
    if (e.nodeName == "#text") {
      return document.createTextNode(e.data);
    }
    if (!e.tagName) return false;

    var newNode = document.createElement(e.tagName);
    if (!newNode) return false;

    var properties = ['id', 'class', 'style', 'name', 'type', 'valign', 'border', 'width', 'height', 'top', 'bottom', 'left', 'right', 'scope', 'row', 'columns', 'src', 'href', 'className', 'align', 'nowrap'];

    //clee. - Bug: 44976 - IE7 just does not calculate height properties correctly for input elements
    if (SUGAR.isIE7 && e.tagName.toLowerCase() == 'input') {
      var properties = ['id', 'class', 'style', 'name', 'type', 'valign', 'border', 'width', 'top', 'bottom', 'left', 'right', 'scope', 'row', 'columns', 'src', 'href', 'className', 'align', 'nowrap'];
    }

    for (var i in properties) {
      if (e[properties[i]]) {
        //There are two groups of conditional checks here:
        //The first group is to ignore the style and type attributes for IE browsers
        //The second group is to ensure that only <a> and <iframe> tags have href attribute
        if ((properties[i] != 'style' || !SUGAR.isIE) &&
          //Only <a> and <iframe> tags can have hrefs
          (properties[i] != 'href' || e.tagName == 'a' || e.tagName == 'iframe')) {
          if (properties[i] == "type") {
            newNode.setAttribute(properties[i], e[properties[i]]);
          } else {
            newNode[properties[i]] = e[properties[i]];
          }
        }
      }
    }
    if (recursive) {
      for (var i in e.childNodes) {
        if (e.childNodes[i].nodeName && (!e.className || e.className != "yui-ac-container")) {
          var child = SUGAR.collection.safe_clone(e.childNodes[i], true);
          if (child) newNode.appendChild(child);
        }
      }
    }
    return newNode;
  }
}