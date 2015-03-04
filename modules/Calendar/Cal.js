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
var CAL = {};
CAL.slot_height = 14;
CAL.dropped = 0;
CAL.records_openable = true;
CAL.moved_from_cell = "";
CAL.deleted_id = "";
CAL.deleted_module = "";
CAL.tmp_header = "";
CAL.disable_creating = false;
CAL.record_editable = false;
CAL.shared_users = {};
CAL.shared_users_count = 0;
CAL.script_evaled = false;
CAL.editDialog = false;
CAL.settingsDialog = false;
CAL.sharedDialog = false;
CAL.basic = {};
CAL.basic.items = {};
CAL.update_dd = new YAHOO.util.CustomEvent("update_dd");
CAL.dd_registry = new Object();
CAL.resize_registry = new Object();
CAL.print = false;
CAL.dom = YAHOO.util.Dom;
CAL.get = YAHOO.util.Dom.get;
CAL.query = YAHOO.util.Selector.query;
CAL.arrange_slot = function (cell_id) {
    if (!cell_id)
        return;
    cellElm = document.getElementById(cell_id);
    if (cellElm) {
        var total_height = 0;
        var prev_i = 0;
        var first = 1;
        var top = 0;
        var height = 0;
        var cnt = 0;
        var child_cnt = cellElm.childNodes.length;
        for (var i = 0; i < child_cnt; i++) {
            var width_p = (92 / child_cnt);
            width = width_p.toString() + "%";
            if (cellElm.childNodes[i].tagName == "DIV") {
                cellElm.childNodes[i].style.top = "-1px";
                cellElm.childNodes[i].style.left = "-" + (cnt + 1) + "px";
                cellElm.childNodes[i].style.width = width
                cnt++;
                prev_i = i;
            }
        }
    }
}
CAL.arrange_column = function (column) {
    for (var i = 0; i < column.childNodes.length; i++) {
        for (var j = 0; j < column.childNodes[i].childNodes.length; j++) {
            var el = column.childNodes[i].childNodes[j];
            if (YAHOO.util.Dom.hasClass(el, "empty")) {
                el.parentNode.removeChild(el);
                j--;
            }
        }
    }
    var slots = column.childNodes;
    var start = 0;
    var end = slots.length;
    var slot_count = end;
    var level = 0;
    var affected_slots = new Array();
    var affected_items = Array();
    var ol = new Array();
    find_overlapping(null, start, end, level, null);
    for (var i = 0; i < ol.length; i++) {
        var ol_group = ol[i];
        var depth = ol_group.depth;
        for (var j = 0; j < ol_group.items.length; j++) {
            var el_id = ol_group.items[j]['id'];
            var level = ol_group.items[j]['level'];
            var el = CAL.get(el_id);
            var node = el;
            var pos = 0;
            while (node.previousSibling) {
                pos++;
                node = node.previousSibling;
            }
            insert_empty_items(el, level - 1 - pos, false);
        }
    }
    for (var i = 0; i < ol.length; i++) {
        var ol_group = ol[i];
        var depth = ol_group.depth;
        for (var j = 0; j < ol_group.items.length; j++) {
            var el_id = ol_group.items[j]['id'];
            var el = CAL.get(el_id);
            var cnt = el.parentNode.childNodes.length;
            insert_empty_items(el, depth - cnt, true);
        }
    }
    CAL.each(affected_slots, function (i, v) {
        CAL.arrange_slot(affected_slots[i]);
    });
    function find_overlapping(el, start, end, level, ol_group) {
        if (level > 20)
            return;
        var depth = level;
        if (el != null) {
            if (level == 1) {
                ol_group = {};
                ol_group.items = new Array();
            }
            ol_group.items.push({id: el.id, level: level});
            affected_items.push(el.id);
        }
        for (var i = start; i < end; i++) {
            if (i >= slot_count)
                break;
            if (typeof slots[i].childNodes != 'undefined' && typeof slots[i].childNodes[0] != 'undefined') {
                var pos = 0;
                if (i == start) {
                    var node = slots[i].childNodes[0];
                    while (node.nextSibling && CAL.contains(affected_items, node.id)) {
                        node = node.nextSibling;
                        pos++;
                    }
                }
                var current = slots[i].childNodes[pos];
                var slots_takes = parseInt(current.getAttribute('duration_coef'));
                if (CAL.contains(affected_items, current.id))
                    continue;
                if (pos == 0) {
                    var slot_id = current.parentNode.id;
                    if (!CAL.contains(affected_slots, slot_id))
                        affected_slots.push(slot_id);
                }
                if (slots_takes > 0) {
                    var k = find_overlapping(current, i, i + slots_takes, level + 1, ol_group);
                    if (k > depth)
                        depth = k;
                }
            }
        }
        if (level == 1) {
            ol_group.depth = depth;
            ol.push(ol_group);
        }
        return depth;
    }

    function insert_empty_items(el, count, to_end) {
        var slot = el.parentNode;
        for (var i = 0; i < count; i++) {
            var empty = document.createElement("div");
            empty.className = "act_item empty";
            empty.style.zIndex = "-1";
            empty.style.width = "1px";
            if (to_end == true) {
                slot.appendChild(empty);
            } else {
                slot.insertBefore(empty, slot.firstChild);
            }
        }
    }
}
CAL.arrange_advanced = function () {
    var nodes = CAL.query("#cal-grid .col");
    for (var i = 0; i < nodes.length; i++) {
        CAL.arrange_column(nodes[i]);
    }
    CAL.update_dd.fire();
}
CAL.create_item = function (params) {
    var item = params.item;
    var id = params.id + params.id_suffix;
    var el = document.createElement("div");
    var elHead = document.createElement("div");
    elHead.setAttribute("class", "head");
    var elHeadInfo = document.createElement("div");
    elHeadInfo.setAttribute("class", "adicon");
    elHeadInfo.setAttribute("id", "div_" + id);
    var params_click = new Object();
    params_click.id = id;
    YAHOO.util.Event.on(elHeadInfo, "click", function (e) {
        YAHOO.util.Event.stopPropagation(e);
        CAL.show_additional_details(params_click.id);
    }, params_click);
    var head_text = document.createElement("div");
    head_text.innerHTML = params.head_text;
    elHead.appendChild(elHeadInfo);
    elHead.appendChild(head_text);
    el.appendChild(elHead);
    if (params.type == "advanced") {
        var elContent = document.createElement("div");
        elContent.setAttribute("class", "content");
        if (params.content_style != "") {
            elContent.style[params.content_style] = params.content_style_value;
        }
        elContent.innerHTML = params.item_text;
        el.appendChild(elContent);
        var related_to = document.createElement("div");
        related_to.setAttribute("class", "content");
        if (params.content_style != "") {
            related_to.style[params.content_style] = params.content_style_value;
        }
        if (params.related_to) {
            related_to.innerHTML = params.related_to;
        }
        el.appendChild(related_to);
    }
    el.setAttribute("id", id);
    el.className = "act_item" + " " + item.type + "_item";
    el.style.backgroundColor = CAL.activity_colors[item.module_name]['body'];
    el.style.borderColor = CAL.activity_colors[item.module_name]['border'];
    el.setAttribute("record", params.id);
    el.setAttribute("module_name", item.module_name);
    el.setAttribute("record", item.record);
    el.setAttribute("status", item.status);
    el.setAttribute("detail", item.detail);
    el.setAttribute("edit", item.edit);
    if (typeof item.repeat_parent_id != "undefined" && item.repeat_parent_id != "")
        el.setAttribute("repeat_parent_id", item.repeat_parent_id);
    if (params.type == "basic") {
        el.style.left = "-1px";
        el.style.display = "block";
        el.setAttribute("days", params.days);
        el.style.width = ((params.days) * 100) + "%";
        el.style.top = parseInt(params.position * CAL.slot_height - params.slot.childNodes.length * (CAL.slot_height + 1)) + "px";
    } else {
        el.style.height = parseInt((CAL.slot_height + 1) * params.duration_coef - 1) + "px";
        el.setAttribute("duration_coef", params.duration_coef);
    }
    YAHOO.util.Event.on(el, "mouseover", function () {
        if (!CAL.records_openable)
            return;
        CAL.disable_creating = true;
        var e;
        if (e = CAL.get(el.id))
            e.style.zIndex = 2;
    });
    YAHOO.util.Event.on(el, "mouseout", function (event) {
        if (!CAL.records_openable)
            return;
        var node = event.toElement || event.relatedTarget;
        var i = 3;
        while (i > 0) {
            if (node == this)
                return; else
                node = node.parentNode;
            i--;
        }
        CAL.get(el.id).style.zIndex = '';
        CAL.disable_creating = false;
    });
    CAL.clear_additional_details(params.id);
    return el;
}
CAL.make_draggable = function (id, type) {
    var border;
    var prefix;
    var id_prefix;
    border = "cal-grid";
    if (type == "basic") {
        if (CAL.view != "month" && CAL.view != "shared")
            border = "cal-multiday-bar";
        prefix = "basic_";
        id_prefix = "b_";
    } else {
        if (CAL.view != "month")
            border = "cal-scrollable";
        prefix = "";
        id_prefix = "t_";
    }
    var dd = new YAHOO.util.DDCAL(id, prefix + "cal", {isTarget: false, cont: border});
    CAL.dd_registry[id] = dd;
    dd.onInvalidDrop = function (e) {
        if (type == "basic") {
            CAL.basic.populate_grid();
            CAL.fit_grid();
        } else {
            CAL.arrange_slot(this.el.parentNode.getAttribute("id"));
            if (CAL.dropped == 0) {
                this.el.childNodes[0].innerHTML = CAL.tmp_header;
            }
        }
        CAL.records_openable = true;
        CAL.disable_creating = false;
    }
    dd.onMouseDown = function (e) {
        YAHOO.util.DDM.mode = YAHOO.util.DDM.POINT;
        YAHOO.util.DDM.clickPixelThresh = 20;
    }
    dd.onMouseUp = function (e) {
        YAHOO.util.DDM.mode = YAHOO.util.DDM.INTERSECT;
        YAHOO.util.DDM.clickPixelThresh = 3;
    }
    dd.startDrag = function (x, y) {
        this.el = document.getElementById(this.id);
        this.el.style.zIndex = 5;
        CAL.dropped = 0;
        CAL.records_openable = false;
        CAL.disable_creating = true;
        CAL.tmp_header = this.el.childNodes[0].innerHTML;
        CAL.moved_from_cell = this.el.parentNode.id;
        this.setDelta(2, 2);
    }
    dd.endDrag = function (x, y) {
        this.el = document.getElementById(this.id);
        this.el.style.zIndex = "";
        var nodes = CAL.query("#cal-grid div." + prefix + "slot");
        CAL.each(nodes, function (i, v) {
            YAHOO.util.Dom.removeClass(nodes[i], "slot_active");
        });
    }
    dd.onDragDrop = function (e, id) {
        var slot = document.getElementById(id);
        YAHOO.util.Dom.removeClass(slot, "slot_active");
        if (CAL.dropped)
            return;
        CAL.dropped = 1;
        this.el.style.position = "relative";
        this.el.style.cssFloat = "none";
        if (type == "advanced") {
            if (CAL.view != 'shared') {
                var box_id = this.id;
                var slot_id = id;
                var ex_slot_id = CAL.moved_from_cell;
                CAL.move_activity(box_id, slot_id, ex_slot_id);
            } else {
                var record = this.el.getAttribute("record");
                var tid = id;
                var tar = tid.split("_");
                var timestamp = tar[1];
                var tid = CAL.moved_from_cell;
                var tar = tid.split("_");
                var ex_timestamp = tar[1];
                for (i = 0; i < CAL.shared_users_count; i++) {
                    var box_id = record + "____" + i;
                    var slot_id = id_prefix + timestamp + "_" + i;
                    var ex_slot_id = id_prefix + ex_timestamp + "_" + i;
                    CAL.move_activity(box_id, slot_id, ex_slot_id);
                }
            }
        }
        var callback = {
            success: function (o) {
                try {
                    res = eval("(" + o.responseText + ")");
                } catch (err) {
                    alert(CAL.lbl_error_saving);
                    ajaxStatus.hideStatus();
                    return;
                }
                if (res.access == 'yes') {
                    CAL.add_item(res);
                    CAL.disable_creating = false;
                    CAL.records_openable = true;
                    CAL.update_vcal();
                    ajaxStatus.hideStatus();
                } else {
                    if (res.errorMessage != 'undefined') {
                        alert(res.errorMessage);
                    }
                    CAL.refresh();
                    ajaxStatus.hideStatus();
                }
            }
        };
        ajaxStatus.showStatus(SUGAR.language.get('app_strings', 'LBL_SAVING'));
        var url = "index.php?module=Calendar&action=Reschedule&sugar_body_only=true";
        var data = {
            "current_module": this.el.getAttribute("module_name"),
            "record": this.el.getAttribute("record"),
            "datetime": slot.getAttribute("datetime"),
            "calendar_style": type
        };
        YAHOO.util.Connect.asyncRequest('POST', url, callback, CAL.toURI(data));
        YAHOO.util.Dom.removeClass(slot, "slot_active");
    }
    dd.onDragOver = function (e, id) {
        var slot = document.getElementById(id);
        if (!YAHOO.util.Dom.hasClass(slot, "slot_active"))
            YAHOO.util.Dom.addClass(slot, "slot_active");
        if (type == "advanced")
            this.el.childNodes[0].childNodes[1].childNodes[0].innerHTML = slot.getAttribute('time');
    }
    dd.onDragOut = function (e, id) {
        var slot = document.getElementById(id);
        YAHOO.util.Dom.removeClass(slot, "slot_active");
    }
}
CAL.make_resizable = function (id, slot) {
    var pos = 0, e = slot;
    while (e = e.previousSibling) {
        pos++;
    }
    var max_height = (CAL.cells_per_day - pos) * (CAL.slot_height + 1) - 1;
    var old_width;
    var resize = new YAHOO.util.Resize(id, {handles: ['b'], maxHeight: max_height});
    CAL.resize_registry[id] = resize;
    resize.on('startResize', function (e) {
        var el = CAL.get(id);
        if (el) {
            el.style.zIndex = 3;
        }
        CAL.records_openable = false;
        CAL.disable_creating = true;
    });
    resize.on('endResize', function (e) {
        elm_id = id;
        var duration = e.height / (CAL.slot_height + 1) * CAL.t_step;
        var remainder = duration % 15;
        if (remainder > 7.5)
            remainder = (-1) * (15 - remainder);
        duration = duration - remainder;
        var duration_hours = parseInt(duration / 60);
        var duration_minutes = duration % 60;
        var new_size = (duration / CAL.t_step) * (CAL.slot_height + 1) - 1;
        var el = CAL.get(elm_id);
        if (el) {
            el.style.zIndex = '';
            el.style.height = new_size + "px";
            CAL.arrange_slot(slot.id);
            var nodes = CAL.query("#cal-grid div.act_item");
            CAL.each(nodes, function (i, v) {
                nodes[i].style.zIndex = '';
            });
            var duration_coef = duration / CAL.t_step;
            el.setAttribute("duration_coef", duration_coef);
            if (duration_coef < 1.75) {
                el.childNodes[1].style.display = "none";
                if (el.childNodes[2]) {
                    el.childNodes[2].style.display = "none";
                }
            }
            else {
                el.childNodes[1].style.display = "";
                if (el.childNodes[2]) {
                    el.childNodes[2].style.display = "";
                }
            }
            var callback = {
                success: function (o) {
                    try {
                        res = eval("(" + o.responseText + ")");
                    } catch (err) {
                        alert(CAL.lbl_error_saving);
                        ajaxStatus.hideStatus();
                        return;
                    }
                    if (res.access == 'yes') {
                        CAL.update_vcal();
                        CAL.clear_additional_details(el.getAttribute("record"));
                        CAL.arrange_column(slot.parentNode);
                        CAL.update_dd.fire();
                        ajaxStatus.hideStatus();
                        CAL.disable_creating = false;
                        CAL.records_openable = true;
                    }
                }
            };
            ajaxStatus.showStatus(SUGAR.language.get('app_strings', 'LBL_SAVING'));
            var url = "index.php?module=Calendar&action=Resize&sugar_body_only=true";
            var data = {
                "current_module": el.getAttribute("module_name"),
                "record": el.getAttribute("record"),
                "duration_hours": duration_hours,
                "duration_minutes": duration_minutes
            };
            YAHOO.util.Connect.asyncRequest('POST', url, callback, CAL.toURI(data));
        }
    });
}
CAL.destroy_ui = function (id) {
    if (CAL.items_resizable && typeof CAL.resize_registry[id] != "undefined") {
        CAL.resize_registry[id].destroy();
        delete CAL.resize_registry[id];
    }
    if (CAL.items_draggable && typeof CAL.dd_registry[id] != "undefined")
        CAL.dd_registry[id].unreg();
    delete CAL.dd_registry[id];
}
CAL.basic.remove = function (item) {
    if (typeof CAL.basic.items[item.user_id] == 'undefined')
        CAL.basic.items[item.user_id] = new Object();
    delete CAL.basic.items[item.user_id][item.record];
}
CAL.basic.add = function (item) {
    if (typeof CAL.basic.items[item.user_id] == 'undefined')
        CAL.basic.items[item.user_id] = new Object();
    CAL.basic.items[item.user_id][item.record] = item;
}
CAL.basic.populate_grid = function () {
    var nodes = CAL.query("#cal-grid .cal-basic .col .act_item");
    CAL.each(nodes, function (i, v) {
        nodes[i].parentNode.removeChild(nodes[i]);
    });
    var users_arr = new Array();
    if (CAL.view != "shared") {
        users_arr.push(CAL.current_user_id);
    } else {
        CAL.each(CAL.shared_users, function (i, v) {
            users_arr.push(i);
        });
    }
    for (ui = 0; ui < users_arr.length; ui++) {
        var user_id = users_arr[ui];
        suffix = "";
        id_suffix = "";
        if (CAL.view == 'shared') {
            suffix = "_" + CAL.shared_users[user_id];
            id_suffix = '____' + CAL.shared_users[user_id];
        }
        var step = 7;
        if (CAL.view == "day")
            step = 1;
        var portions_count = 1;
        if (CAL.view == "month") {
            var e = CAL.get("b_" + CAL.grid_start_ts + suffix);
            if (e)
                portions_count = e.parentNode.parentNode.parentNode.parentNode.parentNode.childNodes.length; else
                continue;
        }
        var start = CAL.grid_start_ts;
        for (w = 0; w < portions_count; w++) {
            var end = start + step * 3600 * 24;
            var portion = Array();
            CAL.each(CAL.basic.items[user_id], function (id, item) {
                var c = !((item.ts_start < start && item.ts_end <= start) || (end <= item.ts_start && end <= item.ts_end));
                if (c) {
                    if (item.ts_start < start)
                        var from = start; else
                        var from = item.ts_start;
                    if (end <= item.ts_end)
                        var to = end; else
                        var to = item.ts_end;
                    portion.push({id: id, offset: item.offset, from: from, to: to});
                }
            });
            portion.sort(function (a, b) {
                return a.offset - b.offset;
            });
            var equalizer = Array();
            for (i = 0; i < step; i++) {
                equalizer[i] = 0;
            }
            var max_pos = 0;
            CAL.each(portion, function (i, v) {
                var from = (portion[i].from - start) / (3600 * 24);
                var to = (portion[i].to - start) / (3600 * 24);
                var pos = 0;
                for (d = from; d < to; d++) {
                    if (equalizer[d] > pos)
                        pos = equalizer[d];
                }
                for (d = from; d < to; d++) {
                    equalizer[d] = pos + 1;
                }
                portion[i].position = pos;
                portion[i].days = to - from;
                if (pos > max_pos)
                    max_pos = pos;
                var item = CAL.basic.items[user_id][portion[i].id];
                var slot = CAL.get("b_" + portion[i].from + suffix);
                if (slot) {
                    var time_start = item.time_start;
                    if (item.ts_start < start)
                        time_start = "...&nbsp;";
                    var head_text = CAL.get_header_text(item.type, time_start, item.name, item.record);
                    var el = CAL.create_item({
                        item: item,
                        type: 'basic',
                        head_text: head_text,
                        id: portion[i].id,
                        position: portion[i].position,
                        slot: slot,
                        id_suffix: id_suffix,
                        days: portion[i].days
                    });
                    YAHOO.util.Event.on(el, "click", function () {
                        if (this.getAttribute('detail') == "1")
                            CAL.load_form(this.getAttribute('module_name'), this.getAttribute('record'), false);
                    });
                    slot.appendChild(el);
                    if (CAL.items_draggable && item.edit == 1) {
                        CAL.make_draggable(el.getAttribute("id"), "basic");
                    }
                }
            });
            h = parseInt((max_pos + 1) * CAL.slot_height + (CAL.slot_height + 1));
            if (h < CAL.basic.min_height)
                h = CAL.basic.min_height;
            var height_string = h + "px";
            if(CAL.get("b_" + start + suffix)){
                var row = CAL.get("b_" + start + suffix).parentNode.parentNode;
                row.parentNode.childNodes[0].childNodes[0].style.height = height_string;
                CAL.each(row.childNodes, function (i, v) {
                    if (typeof row.childNodes[i] == 'object')
                        row.childNodes[i].childNodes[0].style.height = height_string;
                });
            }
            start = start + step * 3600 * 24;
        }
    }
}
CAL.add_item_to_grid = function (item) {
    var suffix = "";
    var id_suffix = "";
    if (item.user_id != "" && CAL.view == 'shared') {
        suffix = "_" + CAL.shared_users[item.user_id];
        id_suffix = '____' + CAL.shared_users[item.user_id];
    }
    var e = CAL.get(item.record + id_suffix);
    if (e) {
        e.parentNode.removeChild(e);
        CAL.destroy_ui(item.record + id_suffix);
    }
    CAL.basic.remove(item);
    if (CAL.style == "basic" || item.days > 1) {
        CAL.basic.add(item);
        return;
    }
    var head_text = CAL.get_header_text(item.type, item.time_start, item.name, item.record);
    var time_cell = item.timestamp - item.timestamp % (CAL.t_step * 60);
    var duration_coef;
    if (item.module_name == 'Tasks') {
        duration_coef = 1;
    } else {
        if ((item.duration_minutes < CAL.t_step) && (item.duration_hours == 0))
            duration_coef = 1; else
            duration_coef = (parseInt(item.duration_hours) * 60 + parseInt(item.duration_minutes)) / CAL.t_step;
    }
    var item_text = SUGAR.language.languages.app_list_strings[item.type + '_status_dom'][item.status];
    var related_to = item.related_to;
    var content_style = "";
    var content_style_value = "";
    if (duration_coef < 1.75) {
        content_style = "display";
        content_style_value = "none";
    }
    var elm_id = item.record + id_suffix;
    var el = CAL.create_item({
        item: item,
        type: 'advanced',
        head_text: head_text,
        duration_coef: duration_coef,
        id: item.record,
        id_suffix: id_suffix,
        item_text: item_text,
        content_style: content_style,
        content_style_value: content_style_value,
        related_to: related_to
    });
    YAHOO.util.Event.on(el, "click", function () {
        if (this.getAttribute('detail') == "1")
            CAL.load_form(this.getAttribute('module_name'), this.getAttribute('record'), false);
    });
    var slot;
    if (slot = CAL.get("t_" + time_cell + suffix)) {
        slot.appendChild(el);
        if (item.edit == 1) {
            if (CAL.items_draggable)
                CAL.make_draggable(elm_id, "advanced");
            if (item.module_name != "Tasks" && CAL.items_resizable)
                CAL.make_resizable(elm_id, slot);
        }
        CAL.cut_record(item.record + id_suffix);
        if (CAL.view == "shared") {
            var end_time = $("#" + slot.id).parents("div:first").children("div:last").attr("time");
            var end_time_id = $("#" + slot.id).parents("div:first").children("div:last").attr("id");
            if (end_time && end_time_id) {
                var end_timestamp = parseInt(end_time_id.match(/t_([0-9]+)_.*/)[1]) + 1800;
                var share_coef = (end_timestamp - parseInt(item.timestamp)) / 1800;
                if (share_coef < duration_coef)
                    el.style.height = parseInt((CAL.slot_height + 1) * share_coef - 1) + "px";
            }
        }
    }
}
CAL.get_header_text = function (type, time_start, text, record) {
    var start_text = (CAL.view == 'month') ? ("<span class='start_time'>" + time_start + "</span> " + text) : text;
    return start_text;
}
CAL.cut_record = function (id) {
    var el = CAL.get(id);
    if (!el)
        return;
    var duration_coef = el.getAttribute("duration_coef");
    real_celcount = CAL.cells_per_day;
    var celpos = 0;
    var s = el.parentNode;
    while (s.previousSibling) {
        celpos++;
        s = s.previousSibling;
    }
    celpos = celpos + 1;
    if (real_celcount - celpos - duration_coef < 0)
        duration_coef = real_celcount - celpos + 1;
    el.style.height = parseInt((CAL.slot_height + 1) * duration_coef - 1) + "px";
}
CAL.init_edit_dialog = function (params) {
    CAL.editDialog = false;
    var rd = CAL.get("cal-edit");
    var content = CAL.get("edit-dialog-content");
    if (CAL.dashlet && rd) {
        document.getElementById("content").appendChild(rd);
    }
    rd.style.width = params.width + "px";
    content.style.height = params.height + "px";
    content.style.overflow = "auto";
    content.style.padding = "0";
    CAL.editDialog = new YAHOO.widget.Dialog("cal-edit", {
        draggable: true,
        visible: false,
        modal: true,
        close: true,
        y: 1,
        zIndex: 10
    });
    var listeners = new YAHOO.util.KeyListener(document, {keys: 27}, {
        fn: function () {
            CAL.editDialog.cancel();
        }
    });
    CAL.editDialog.cfg.queueProperty("keylisteners", listeners);
    CAL.editDialog.cancelEvent.subscribe(function (e, a, o) {
        CAL.close_edit_dialog();
    });
    rd.style.display = "block";
    CAL.editDialog.render();
    rd.style.overflow = "auto";
    rd.style.overflowX = "hidden";
    rd.style.outline = "0 none";
    rd.style.height = "auto";
}
CAL.open_edit_dialog = function (params) {
    document.getElementById("form_content").innerHTML = "";
    CAL.editDialog.center();
    CAL.editDialog.show();
    var nodes = CAL.query("#cal-tabs li a");
    CAL.each(nodes, function (i, v) {
        YAHOO.util.Event.on(nodes[i], 'click', function () {
            CAL.select_tab(this.getAttribute("tabname"));
        });
    });
    stay_on_tab = false
    if (typeof params != "undefined" && typeof params.stay_on_tab != "undefined" && params.stay_on_tab)
        stay_on_tab = true;
    if (!stay_on_tab) {
        var nodes_li = CAL.query("#cal-tabs li");
        CAL.each(nodes_li, function (j, v) {
            CAL.dom.removeClass(nodes_li[j], "selected");
            if (j == 0)
                CAL.dom.addClass(nodes_li[j], "selected");
        });
        var nodes = CAL.query(".yui-nav");
        CAL.each(nodes, function (i, v) {
            nodes[i].style.overflowX = "visible";
        });
    }
}
CAL.close_edit_dialog = function () {
    CAL.reset_edit_dialog();
}
CAL.remove_edit_dialog = function () {
    var rd_c = CAL.get("cal-edit_c");
    if (rd_c) {
        rd_c.parentNode.removeChild(rd_c);
    }
}
CAL.reset_edit_dialog = function () {
    var e;
    document.forms["CalendarEditView"].elements["current_module"].value = "Meetings";
    CAL.get("radio_call").removeAttribute("disabled");
    CAL.get("radio_meeting").removeAttribute("disabled");
    CAL.get("radio_call").checked = false;
    CAL.get("radio_meeting").checked = true;
    CAL.get("send_invites").value = "";
    if (e = CAL.get("record"))
        e.value = "";
    if (e = CAL.get("list_div_win"))
        e.style.display = "none";
    if (typeof SugarWidgetSchedulerSearch.hideCreateForm != 'undefined')
        SugarWidgetSchedulerSearch.hideCreateForm();
    $("#scheduler .schedulerInvitees").css("display", "");
    $("#create-invitees-title").css("display", "");
    $("#create-invitees-buttons").css("display", "");
    if (CAL.enable_repeat) {
        CAL.reset_repeat_form();
    }
    CAL.GR_update_focus("Meetings", "");
    CAL.select_tab("cal-tab-1");
    QSFieldsArray = new Array();
    QSProcessedFieldsArray = new Array();
}
CAL.reset_repeat_form = function () {
    document.forms['CalendarRepeatForm'].reset();
    var fields = ['type', 'interval', 'count', 'until', 'dow'];
    CAL.each(fields, function (i, field) {
        CAL.get('repeat_' + field).value = "";
    });
    toggle_repeat_type();
    CAL.get("repeat_parent_id").value = "";
    CAL.get("edit_all_recurrences").value = "";
    CAL.get("edit_all_recurrences_block").style.display = "none";
    CAL.get("cal-repeat-block").style.display = "none";
}
CAL.select_tab = function (tid) {
    var nodes_li = CAL.query("#cal-tabs li");
    CAL.each(nodes_li, function (j, v) {
        CAL.dom.removeClass(nodes_li[j], "selected");
    });
    CAL.dom.addClass(CAL.get(tid + "-link").parentNode, "selected");
    var nodes = CAL.query("#cal-tabs .yui-content");
    CAL.each(nodes, function (i, v) {
        nodes[i].style.display = "none";
    });
    var nodes = CAL.query("#cal-tabs #" + tid);
    CAL.each(nodes, function (i, v) {
        nodes[i].style.display = "block";
    });
}
CAL.fill_repeat_data = function () {
    if (CAL.enable_repeat && (CAL.get("current_module").value == "Meetings" || CAL.get("current_module").value == "Calls")) {
        if (repeat_type = document.forms['CalendarRepeatForm'].repeat_type.value) {
            document.forms['CalendarEditView'].repeat_type.value = repeat_type;
            document.forms['CalendarEditView'].repeat_interval.value = document.forms['CalendarRepeatForm'].repeat_interval.value;
            if (document.getElementById("repeat_count_radio").checked) {
                document.forms['CalendarEditView'].repeat_count.value = document.forms['CalendarRepeatForm'].repeat_count.value;
                document.forms['CalendarEditView'].repeat_until.value = "";
            } else {
                document.forms['CalendarEditView'].repeat_until.value = document.forms['CalendarRepeatForm'].repeat_until.value;
                document.forms['CalendarEditView'].repeat_count.value = "";
            }
            if (repeat_type == 'Weekly') {
                var repeat_dow = "";
                for (var i = 0; i < 7; i++)
                    if (CAL.get("repeat_dow_" + i).checked)
                        repeat_dow += i.toString();
                CAL.get("repeat_dow").value = repeat_dow;
            }
        }
    }
}
CAL.fill_repeat_tab = function (data) {
    if (!CAL.enable_repeat)
        return;
    if (typeof data.repeat_parent_id != "undefined") {
        CAL.get("cal-repeat-block").style.display = "none";
        CAL.get("edit_all_recurrences_block").style.display = "";
        CAL.get("edit_all_recurrences").value = "";
        CAL.get("repeat_parent_id").value = data.repeat_parent_id;
        return;
    }
    CAL.get("cal-repeat-block").style.display = "";
    var repeat_type = "";
    var set_default_repeat_until = true;
    if (typeof data.repeat_type != "undefined") {
        repeat_type = data.repeat_type;
        document.forms['CalendarRepeatForm'].repeat_type.value = data.repeat_type;
        document.forms['CalendarRepeatForm'].repeat_interval.value = data.repeat_interval;
        if (data.repeat_count != '' && data.repeat_count != 0) {
            document.forms['CalendarRepeatForm'].repeat_count.value = data.repeat_count;
            CAL.get("repeat_count_radio").checked = true;
            CAL.get("repeat_until_radio").checked = false;
        } else {
            document.forms['CalendarRepeatForm'].repeat_until.value = data.repeat_until;
            CAL.get("repeat_until_radio").checked = true;
            CAL.get("repeat_count_radio").checked = false;
            set_default_repeat_until = false;
        }
        if (data.repeat_type == "Weekly") {
            var arr = data.repeat_dow.split("");
            CAL.each(arr, function (i, d) {
                CAL.get("repeat_dow_" + d).checked = true;
            });
        }
        CAL.get("cal-repeat-block").style.display = "";
        CAL.get("edit_all_recurrences_block").style.display = "none";
        toggle_repeat_type();
    }
    CAL.get("edit_all_recurrences").value = "true";
    if (typeof data.current_dow != "undefined" && repeat_type != "Weekly")
        CAL.get("repeat_dow_" + data.current_dow).checked = true;
    if (typeof data.default_repeat_until != "undefined" && set_default_repeat_until)
        CAL.get("repeat_until_input").value = data.default_repeat_until;
}
CAL.repeat_tab_handle = function (module_name) {
    if (!CAL.enable_repeat)
        return;
    CAL.reset_repeat_form();
    if (module_name == "Meetings" || module_name == "Calls") {
        CAL.get("tab_repeat").style.display = "";
    } else {
        CAL.get("tab_repeat").style.display = "none";
    }
    clear_all_errors();
    toggle_repeat_type();
}
CAL.GR_update_user = function (user_id) {
    var callback = {
        success: function (o) {
            res = eval(o.responseText);
            GLOBAL_REGISTRY.focus.users_arr_hash = undefined;
        }
    };
    var data = {"users": user_id};
    var url = "index.php?module=Calendar&action=GetGRUsers&sugar_body_only=true";
    YAHOO.util.Connect.asyncRequest('POST', url, callback, CAL.toURI(data));
}
CAL.GR_update_focus = function (module, record) {
    if (record == "") {
        GLOBAL_REGISTRY["focus"] = {"module": module, users_arr: [], fields: {"id": "-1"}};
        SugarWidgetScheduler.update_time();
    } else {
        var callback = {
            success: function (o) {
                res = eval(o.responseText);
                SugarWidgetScheduler.update_time();
                if (CAL.record_editable) {
                    CAL.enable_buttons();
                }
            }
        };
        var url = 'index.php?module=Calendar&action=GetGR&sugar_body_only=true&type=' + module + '&record=' + record;
        YAHOO.util.Connect.asyncRequest('POST', url, callback, false);
    }
}
CAL.toggle_settings = function () {
    var sd = CAL.get("settings_dialog");
    if (!CAL.settingsDialog) {
        CAL.settingsDialog = new YAHOO.widget.Dialog("settings_dialog", {
            fixedcenter: true,
            draggable: false,
            visible: false,
            modal: true,
            close: true
        });
        var listeners = new YAHOO.util.KeyListener(document, {keys: 27}, {
            fn: function () {
                CAL.settingsDialog.cancel();
            }
        });
        CAL.settingsDialog.cfg.queueProperty("keylisteners", listeners);
    }
    CAL.settingsDialog.cancelEvent.subscribe(function (e, a, o) {
        CAL.get("form_settings").reset();
    });
    sd.style.display = "block";
    CAL.settingsDialog.render();
    CAL.settingsDialog.show();
}
CAL.fill_invitees = function () {
    CAL.get("user_invitees").value = "";
    CAL.get("contact_invitees").value = "";
    CAL.get("lead_invitees").value = "";
    CAL.each(GLOBAL_REGISTRY['focus'].users_arr, function (i, v) {
        var field_name = "";
        if (v.module == "User")
            field_name = "user_invitees";
        if (v.module == "Contact")
            field_name = "contact_invitees";
        if (v.module == "Lead")
            field_name = "lead_invitees";
        var str = CAL.get(field_name).value;
        CAL.get(field_name).value = str + v.fields.id + ",";
    });
}
CAL.repeat_type_selected = function () {
    var rt;
    if (rt = CAL.get("repeat_type")) {
        if (rt.value == 'Weekly') {
            var nodes = CAL.query(".weeks_checks_div");
            CAL.each(nodes, function (i, v) {
                nodes[i].style.display = "block";
            });
        } else {
            var nodes = CAL.query(".weeks_checks_div");
            CAL.each(nodes, function (i, v) {
                nodes[i].style.display = "none";
            });
        }
        if (rt.value == '') {
            CAL.get("repeat_interval").setAttribute("disabled", "disabled");
            CAL.get("repeat_end_date").setAttribute("disabled", "disabled");
        } else {
            CAL.get("repeat_interval").removeAttribute("disabled");
            CAL.get("repeat_end_date").removeAttribute("disabled");
        }
    }
}
CAL.load_form = function (module_name, record, edit_all_recurrences) {
    CAL.disable_creating = true;
    var e;
    var to_open = true;
    if (module_name == "Tasks")
        to_open = false;
    if (to_open && CAL.records_openable) {
        CAL.get("form_content").style.display = "none";
        CAL.disable_buttons();
        CAL.get("title-cal-edit").innerHTML = CAL.lbl_loading;
        CAL.repeat_tab_handle(module_name);
        ajaxStatus.showStatus(SUGAR.language.get('app_strings', 'LBL_LOADING'));
        params = {};
        if (edit_all_recurrences)
            params = {stay_on_tab: true};
        CAL.open_edit_dialog(params);
        CAL.get("record").value = "";
        if (!edit_all_recurrences)
            edit_all_recurrences = "";
        var callback = {
            success: function (o) {
                try {
                    res = eval("(" + o.responseText + ")");
                } catch (err) {
                    alert(CAL.lbl_error_loading);
                    CAL.editDialog.cancel();
                    ajaxStatus.hideStatus();
                    return;
                }
                if (res.access == 'yes') {
                    var fc = document.getElementById("form_content");
                    CAL.script_evaled = false;
                    fc.innerHTML = '<script type="text/javascript">CAL.script_evaled = true;</script>' + res.html;
                    if (!CAL.script_evaled) {
                        SUGAR.util.evalScript(res.html);
                    }
                    CAL.get("record").value = res.record;
                    CAL.get("current_module").value = res.module_name;
                    var mod_name = res.module_name;
                    if (mod_name == "Meetings")
                        CAL.get("radio_meeting").checked = true;
                    if (mod_name == "Calls")
                        CAL.get("radio_call").checked = true;
                    if (res.edit == 1) {
                        CAL.record_editable = true;
                    } else {
                        CAL.record_editable = false;
                    }
                    CAL.get("radio_call").setAttribute("disabled", "disabled");
                    CAL.get("radio_meeting").setAttribute("disabled", "disabled");
                    eval(res.gr);
                    SugarWidgetScheduler.update_time();
                    if (CAL.record_editable) {
                        CAL.enable_buttons();
                    }
                    CAL.get("form_content").style.display = "";
                    if (typeof res.repeat != "undefined") {
                        CAL.fill_repeat_tab(res.repeat);
                    }
                    CAL.get("title-cal-edit").innerHTML = CAL.lbl_edit;
                    ajaxStatus.hideStatus();
                    CAL.get("btn-save").focus();
                    setTimeout(function () {
                        if (!res.edit) {
                            $("#scheduler .schedulerInvitees").css("display", "none");
                            $("#create-invitees-buttons").css("display", "none");
                            $("#create-invitees-title").css("display", "none");
                        }
                        enableQS(false);
                        disableOnUnloadEditView();
                    }, 500);
                } else
                    alert(CAL.lbl_error_loading);
            }, failure: function () {
                alert(CAL.lbl_error_loading);
            }
        };
        var url = "index.php?module=Calendar&action=QuickEdit&sugar_body_only=true";
        var data = {"current_module": module_name, "record": record, "edit_all_recurrences": edit_all_recurrences};
        YAHOO.util.Connect.asyncRequest('POST', url, callback, CAL.toURI(data));
    }
}
CAL.edit_all_recurrences = function () {
    var record = CAL.get("record").value;
    if (CAL.get("repeat_parent_id").value != "") {
        record = CAL.get("repeat_parent_id").value;
        CAL.get("repeat_parent_id").value = "";
    }
    var module = CAL.get("current_module").value;
    if (record != "") {
        CAL.load_form(module, record, true);
    }
}
CAL.remove_shared = function (record_id, edit_all_recurrences) {
    if (typeof edit_all_recurrences == "undefined")
        edit_all_recurrences = false;
    var e;
    var arr = new Array();
    if (CAL.enable_repeat && edit_all_recurrences) {
        var nodes = CAL.query("div.act_item[repeat_parent_id='" + record_id + "']");
        CAL.each(nodes, function (i, v) {
            var record = nodes[i].getAttribute("record");
            if (!CAL.contains(arr, record))
                arr.push(record);
            nodes[i].parentNode.removeChild(nodes[i]);
            CAL.destroy_ui(nodes[i].id);
        });
    }
    CAL.each(CAL.shared_users, function (user_id, v) {
        if (e = CAL.get(record_id + '____' + v)) {
            CAL.destroy_ui(e.id);
            e.parentNode.removeChild(e);
        }
        CAL.basic.remove({record: record_id, user_id: user_id});
        CAL.each(arr, function (i, id) {
            CAL.basic.remove({record: id, user_id: user_id});
        });
    });
}
CAL.add_item = function (item) {
    var edit_all_recurrences = false;
    if (typeof item.edit_all_recurrences != "undefined" && item.edit_all_recurrences == 'true')
        edit_all_recurrences = true;
    if (CAL.view != 'shared') {
        var arr = new Array();
        if (CAL.enable_repeat && edit_all_recurrences) {
            var nodes = CAL.query("div.act_item[repeat_parent_id='" + item.record + "']");
            CAL.each(nodes, function (i, v) {
                var record = nodes[i].getAttribute("record");
                if (!CAL.contains(arr, record))
                    arr.push(record);
                nodes[i].parentNode.removeChild(nodes[i]);
            });
        }
        CAL.each(arr, function (i, id) {
            CAL.basic.remove({record: id, user_id: CAL.current_user_id});
        });
        CAL.add_item_to_grid(item);
        var record_id = item.record;
        if (CAL.enable_repeat && typeof item.repeat != "undefined") {
            CAL.each(item.repeat, function (j, r) {
                var clone = CAL.clone(item);
                clone.record = r.id;
                clone.timestamp = r.timestamp;
                clone.ts_start = r.ts_start;
                clone.ts_end = r.ts_end;
                clone.repeat_parent_id = record_id;
                CAL.add_item_to_grid(clone);
            });
        }
    } else {
        CAL.remove_shared(item.record, edit_all_recurrences);
        record_id = item.record;
        CAL.each(item.users, function (i, user_id) {
            item.user_id = user_id;
            CAL.add_item_to_grid(item);
            if (CAL.enable_repeat && typeof item.repeat != "undefined") {
                CAL.each(item.repeat, function (j, r) {
                    var clone = CAL.clone(item);
                    clone.record = r.id;
                    clone.timestamp = r.timestamp;
                    clone.ts_start = r.ts_start;
                    clone.ts_end = r.ts_end;
                    clone.repeat_parent_id = record_id;
                    CAL.add_item_to_grid(clone);
                });
            }
        });
    }
    CAL.arrange_advanced();
    CAL.basic.populate_grid();
    CAL.fit_grid();
}
CAL.move_activity = function (box_id, slot_id, ex_slot_id) {
    var u, s;
    if (u = CAL.get(box_id)) {
        if (s = CAL.get(slot_id)) {
            s.appendChild(u);
            CAL.destroy_ui(box_id);
            CAL.arrange_column(document.getElementById(slot_id).parentNode);
            CAL.arrange_column(document.getElementById(ex_slot_id).parentNode);
            CAL.update_dd.fire();
            CAL.cut_record(box_id);
            var start_text = CAL.get_header_text(CAL.act_types[u.getAttribute('module_name')], s.getAttribute('time'), ' ... ', u.getAttribute('record'));
            var date_field = "date_start";
            if (u.getAttribute('module_name') == "Tasks")
                date_field = "date_due";
            u.setAttribute(date_field, s.getAttribute("datetime"));
            u.childNodes[0].childNodes[1].innerHTML = start_text;
        }
    }
}
CAL.change_activity_type = function (mod_name) {
    if (typeof CAL.current_params.module_name != "undefined")
        if (CAL.current_params.module_name == mod_name)
            return;
    var e, user_name, user_id, date_start;
    CAL.get("title-cal-edit").innerHTML = CAL.lbl_loading;
    document.forms["CalendarEditView"].elements["current_module"].value = mod_name;
    CAL.current_params.module_name = mod_name;
    QSFieldsArray = new Array();
    QSProcessedFieldsArray = new Array();
    CAL.load_create_form(CAL.current_params);
}
CAL.load_create_form = function (params) {
    CAL.disable_buttons();
    ajaxStatus.showStatus(SUGAR.language.get('app_strings', 'LBL_LOADING'));
    CAL.repeat_tab_handle(CAL.current_params.module_name);
    var callback = {
        success: function (o) {
            try {
                res = eval("(" + o.responseText + ")");
            } catch (err) {
                alert(CAL.lbl_error_loading);
                CAL.editDialog.cancel();
                ajaxStatus.hideStatus();
                return;
            }
            if (res.access == 'yes') {
                var fc = document.getElementById("form_content");
                CAL.script_evaled = false;
                fc.innerHTML = '<script type="text/javascript">CAL.script_evaled = true;</script>' + res.html;
                if (!CAL.script_evaled) {
                    SUGAR.util.evalScript(res.html);
                }
                CAL.get("record").value = "";
                CAL.get("current_module").value = res.module_name;
                var mod_name = res.module_name;
                if (res.edit == 1) {
                    CAL.record_editable = true;
                } else {
                    CAL.record_editable = false;
                }
                CAL.get("title-cal-edit").innerHTML = CAL.lbl_create_new;
                if (typeof res.repeat != "undefined") {
                    CAL.fill_repeat_tab(res.repeat);
                }
                CAL.enable_buttons();
                setTimeout(function () {
                    SugarWidgetScheduler.update_time();
                    enableQS(false);
                    disableOnUnloadEditView();
                }, 500);
                ajaxStatus.hideStatus();
            } else {
                alert(CAL.lbl_error_loading);
                ajaxStatus.hideStatus();
            }
        }, failure: function () {
            alert(CAL.lbl_error_loading);
            ajaxStatus.hideStatus();
        }
    };
    var url = "index.php?module=Calendar&action=QuickEdit&sugar_body_only=true";
    var data = {
        "current_module": params.module_name,
        "assigned_user_id": params.user_id,
        "assigned_user_name": params.user_name,
        "date_start": params.date_start
    };
    YAHOO.util.Connect.asyncRequest('POST', url, callback, CAL.toURI(data));
}
CAL.full_form = function () {
    var e = document.createElement('input');
    e.setAttribute('type', 'hidden');
    e.setAttribute('name', 'module');
    e.value = CAL.get('current_module').value;
    CAL.get('form_content').parentNode.appendChild(e);
    var e = document.createElement('input');
    e.setAttribute('type', 'hidden');
    e.setAttribute('name', 'action');
    e.value = 'EditView';
    CAL.get('form_content').parentNode.appendChild(e);
    document.forms['CalendarEditView'].action = "index.php";
    document.forms['CalendarEditView'].full_form = "true";
    document.forms['CalendarEditView'].submit();
}
CAL.disable_buttons = function () {
    CAL.get("btn-save").setAttribute("disabled", "disabled");
    CAL.get("btn-send-invites").setAttribute("disabled", "disabled");
    CAL.get("btn-delete").setAttribute("disabled", "disabled");
    CAL.get("btn-full-form").setAttribute("disabled", "disabled");
    if (CAL.enable_repeat) {
        CAL.get("btn-edit-all-recurrences").setAttribute("disabled", "disabled");
        CAL.get("btn-remove-all-recurrences").setAttribute("disabled", "disabled");
    }
}
CAL.enable_buttons = function () {
    CAL.get("btn-save").removeAttribute("disabled");
    CAL.get("btn-send-invites").removeAttribute("disabled");
    if (CAL.get("record").value != "")
        CAL.get("btn-delete").removeAttribute("disabled");
    CAL.get("btn-full-form").removeAttribute("disabled");
    if (CAL.enable_repeat) {
        CAL.get("btn-edit-all-recurrences").removeAttribute("disabled");
        CAL.get("btn-remove-all-recurrences").removeAttribute("disabled");
    }
}
CAL.dialog_create = function (cell) {
    var e, user_id, user_name;
    CAL.get("title-cal-edit").innerHTML = CAL.lbl_loading;
    CAL.open_edit_dialog();
    CAL.disable_buttons();
    var module_name = CAL.get("current_module").value;
    if (CAL.view == 'shared') {
        parentWithUserValues = $('div[user_id][user_name]');
        user_name = parentWithUserValues.attr('user_name');
        user_id = parentWithUserValues.attr('user_id');
        if (parentWithUserValues.length > 1) {
            var theUserName, theUserId;
            var theUser = cell.parentNode;
            while (theUser) {
                if (theUser.getAttribute("user_name") && theUser.getAttribute("user_id")) {
                    theUserName = theUser.getAttribute("user_name");
                    theUserId = theUser.getAttribute("user_id");
                    break;
                }
                else {
                    theUser = theUser.parentNode;
                }
            }
            if (theUserName && theUserId) {
                user_name = theUserName;
                user_id = theUserId;
            }
        }
        CAL.GR_update_user(user_id);
    } else {
        user_id = CAL.current_user_id;
        user_name = CAL.current_user_name;
        CAL.GR_update_user(CAL.current_user_id);
    }
    var params = {
        'module_name': module_name,
        'user_id': user_id,
        'user_name': user_name,
        'date_start': cell.getAttribute("datetime")
    };
    CAL.current_params = params;
    CAL.load_create_form(CAL.current_params);
}
CAL.dialog_save = function () {
    CAL.disable_buttons();
    ajaxStatus.showStatus(SUGAR.language.get('app_strings', 'LBL_SAVING'));
    if (CAL.get("send_invites").value == "1") {
        CAL.get("title-cal-edit").innerHTML = CAL.lbl_sending;
    } else {
        CAL.get("title-cal-edit").innerHTML = CAL.lbl_saving;
    }
    CAL.fill_invitees();
    CAL.fill_repeat_data();
    var callback = {
        success: function (o) {
            try {
                res = eval("(" + o.responseText + ")");
            } catch (err) {
                alert(CAL.lbl_error_saving);
                CAL.editDialog.cancel();
                ajaxStatus.hideStatus();
                return;
            }
            if (res.access == 'yes') {
                if (typeof res.limit_error != "undefined") {
                    var alert_msg = CAL.lbl_repeat_limit_error;
                    alert(alert_msg.replace("\$limit", res.limit));
                    CAL.get("title-cal-edit").innerHTML = CAL.lbl_edit;
                    ajaxStatus.hideStatus();
                    CAL.enable_buttons();
                    return;
                }
                CAL.add_item(res);
                CAL.editDialog.cancel();
                CAL.update_vcal();
                ajaxStatus.hideStatus();
            } else {
                alert(CAL.lbl_error_saving);
                ajaxStatus.hideStatus();
            }
        }, failure: function () {
            alert(CAL.lbl_error_saving);
            ajaxStatus.hideStatus();
        }
    };
    var url = "index.php?module=Calendar&action=SaveActivity&sugar_body_only=true";
    YAHOO.util.Connect.setForm(CAL.get("CalendarEditView"));
    YAHOO.util.Connect.asyncRequest('POST', url, callback, false);
}
CAL.remove_all_recurrences = function () {
    if (confirm(CAL.lbl_confirm_remove_all_recurring)) {
        if (CAL.get("repeat_parent_id").value != '') {
            CAL.get("record").value = CAL.get("repeat_parent_id").value;
        }
        CAL.get("edit_all_recurrences").value = true;
        CAL.dialog_remove();
    }
}
CAL.dialog_remove = function () {
    CAL.deleted_id = CAL.get("record").value;
    CAL.deleted_module = CAL.get("current_module").value;
    var remove_all_recurrences = CAL.get("edit_all_recurrences").value;
    var isRecurrence = false;
    if (CAL.enable_repeat) {
        if (CAL.get("repeat_parent_id").value != '') {
            var isRecurrence = true;
        } else {
            if (document.CalendarRepeatForm.repeat_type.value != '') {
                var isRecurrence = true;
            }
        }
    }
    var callback = {
        success: function (o) {
            try {
                res = eval("(" + o.responseText + ")");
            } catch (err) {
                alert(CAL.lbl_error_saving);
                CAL.editDialog.cancel();
                ajaxStatus.hideStatus();
                return;
            }
            var e, cell_id;
            if (e = CAL.get(CAL.deleted_id))
                cell_id = e.parentNode.id;
            if (CAL.view == 'shared') {
                if (remove_all_recurrences && isRecurrence) {
                    CAL.refresh();
                } else {
                    CAL.remove_shared(CAL.deleted_id, remove_all_recurrences);
                }
            } else {
                if (e = CAL.get(CAL.deleted_id)) {
                    e.parentNode.removeChild(e);
                    CAL.destroy_ui(CAL.deleted_id);
                }
                CAL.basic.remove({record: CAL.deleted_id, user_id: CAL.current_user_id});
                if (CAL.enable_repeat && remove_all_recurrences && isRecurrence) {
                    CAL.refresh();
                }
            }
            CAL.records_openable = true;
            CAL.disable_creating = false;
            CAL.arrange_advanced();
            CAL.basic.populate_grid();
            CAL.fit_grid();
        }, failure: function () {
            alert(CAL.lbl_error_saving);
        }
    };
    var data = {
        "current_module": CAL.deleted_module,
        "record": CAL.deleted_id,
        "remove_all_recurrences": remove_all_recurrences
    };
    var url = "index.php?module=Calendar&action=Remove&sugar_body_only=true";
    YAHOO.util.Connect.asyncRequest('POST', url, callback, CAL.toURI(data));
    CAL.editDialog.cancel();
}
CAL.refresh = function () {
    var callback = {
        success: function (o) {
            try {
                var activities = eval("(" + o.responseText + ")");
            } catch (err) {
                alert(CAL.lbl_error_saving);
                ajaxStatus.hideStatus();
                return;
            }
            CAL.each(activities, function (i, v) {
                CAL.add_item_to_grid(activities[i]);
            });
            CAL.arrange_advanced();
            CAL.basic.populate_grid();
            CAL.fit_grid();
            CAL.update_dd.fire();
        }
    }
    var data = {"view": CAL.view, "year": CAL.year, "month": CAL.month, "day": CAL.day};
    var url = "index.php?module=Calendar&action=getActivities&sugar_body_only=true";
    YAHOO.util.Connect.asyncRequest('POST', url, callback, CAL.toURI(data));
    CAL.clear();
}
CAL.clear = function () {
    CAL.basic.items = {};
    var nodes = CAL.query("#cal-grid div.act_item");
    CAL.each(nodes, function (i, v) {
        nodes[i].parentNode.removeChild(nodes[i]);
    });
}
CAL.show_additional_details = function (id) {
    var obj = CAL.get(id);
    var record = obj.getAttribute("record");
    var module_name = obj.getAttribute("module_name");
    SUGAR.util.getAdditionalDetails(module_name, record, 'div_' + id, true);
    return;
}
CAL.clear_additional_details = function (id) {
    if (typeof SUGAR.util.additionalDetailsCache[id] != "undefined")
        SUGAR.util.additionalDetailsCache[id] = undefined;
    if (typeof SUGAR.util.additionalDetailsCalls[id] != "undefined")
        SUGAR.util.additionalDetailsCalls[id] = undefined;
}
CAL.toggle_shared_edit = function () {
    var sd = CAL.get("shared_cal_edit");
    if (!CAL.sharedDialog) {
        CAL.sharedDialog = new YAHOO.widget.Dialog("shared_cal_edit", {
            fixedcenter: true,
            draggable: false,
            visible: false,
            modal: true,
            close: true
        });
        var listeners = new YAHOO.util.KeyListener(document, {keys: 27}, {
            fn: function () {
                CAL.sharedDialog.cancel();
            }
        });
        CAL.sharedDialog.cfg.queueProperty("keylisteners", listeners);
    }
    CAL.sharedDialog.cancelEvent.subscribe(function (e, a, o) {
    });
    sd.style.display = "block";
    CAL.sharedDialog.render();
    CAL.sharedDialog.show();
}
CAL.goto_date_call = function () {
    var date_string = CAL.get("goto_date").value;
    var date_arr = [];
    date_arr = date_string.split("/");
    window.location.href = "index.php?module=Calendar&view=" + CAL.view + "&day=" + date_arr[1] + "&month=" + date_arr[0] + "&year=" + date_arr[2];
}
CAL.check_forms = function () {
    if (!(check_form('CalendarEditView') && cal_isValidDuration())) {
        CAL.select_tab("cal-tab-1");
        return false;
    }
    if (CAL.enable_repeat && CAL.get("edit_all_recurrences").value != "") {
        lastSubmitTime = lastSubmitTime - 2001;
        if (!check_form('CalendarRepeatForm')) {
            CAL.select_tab("cal-tab-3");
            return false;
        }
    }
    return true;
}
CAL.toURI = function (a) {
    t = [];
    for (x in a) {
        if (!(a[x].constructor.toString().indexOf('Array') == -1)) {
            for (i in a[x])
                t.push(x + "[]=" + encodeURIComponent(a[x][i]));
        } else
            t.push(x + "=" + encodeURIComponent(a[x]));
    }
    return t.join("&");
}
CAL.each = function (object, callback) {
    if (typeof object == "undefined")
        return;
    var name, i = 0, length = object.length, isObj = (length === undefined) || (typeof(object) === "function");
    if (isObj) {
        for (name in object) {
            if (callback.call(object[name], name, object[name]) === false) {
                break;
            }
        }
    } else {
        for (; i < length;) {
            if (callback.call(object[i], i, object[i++]) === false) {
                break;
            }
        }
    }
    return object;
}
CAL.clone = function (o) {
    var c = new Object();
    for (var e in o)
        c[e] = o[e];
    return c;
}
CAL.contains = function (a, obj) {
    var i = a.length;
    while (i--)
        if (a[i] === obj)
            return true;
    return false;
}
CAL.update_vcal = function () {
    var v = CAL.current_user_id;
    var callback = {
        success: function (result) {
            if (typeof GLOBAL_REGISTRY.freebusy == 'undefined') {
                GLOBAL_REGISTRY.freebusy = new Object();
            }
            if (typeof GLOBAL_REGISTRY.freebusy_adjusted == 'undefined') {
                GLOBAL_REGISTRY.freebusy_adjusted = new Object();
            }
            GLOBAL_REGISTRY.freebusy[v] = SugarVCalClient.parseResults(result.responseText, false);
            GLOBAL_REGISTRY.freebusy_adjusted[v] = SugarVCalClient.parseResults(result.responseText, true);
            SugarWidgetScheduler.update_time();
        }
    };
    var url = "vcal_server.php?type=vfb&source=outlook&user_id=" + v;
    YAHOO.util.Connect.asyncRequest('GET', url, callback, false);
}
CAL.fit_grid = function (control_call) {
    if (CAL.view == 'year') {
        return;
    }
    var container_width = document.getElementById("cal-width-helper").offsetWidth;
    var left_column_width = 53;
    var scroll_padding = 0;
    if (CAL.print) {
        if (CAL.view == "day")
            container_width = 720; else
            container_width = 800;
    }
    else {
        var is_scrollable = document.getElementById("cal-scrollable");
        if (is_scrollable) {
            scroll_padding = 30;
        }
    }
    var data_width = container_width - left_column_width - scroll_padding;
    var num_columns;
    if (CAL.view == "day") {
        num_columns = 1;
        if (typeof control_call == "undefined" || !control_call) {
            setTimeout(function () {
                CAL.fit_grid(true);
                setTimeout(function () {
                    CAL.fit_grid(true);
                }, 100);
            }, 100);
        }
    } else {
        num_columns = 7;
    }
    var columns_width = CAL.calculate_columns_width(data_width, num_columns);
    var cell_nodes = CAL.query("#cal-grid div.col");
    CAL.each(cell_nodes, function (i) {
        cell_nodes[i].style.width = columns_width[i % num_columns] + "px";
    });
    if(document.getElementById("cal-grid")){
        document.getElementById("cal-grid").style.visibility = "";
    }
};
CAL.calculate_columns_width = function (width, count) {
    var result = [];
    var integer = Math.floor(width / count);
    var remainder = width - count * integer;
    var dispensed = 0;
    for (var i = 1, value; i <= count; i++) {
        value = integer;
        if (dispensed * count < i * remainder) {
            value++;
            dispensed++;
        }
        result.push(value);
    }
    return result;
};
YAHOO.util.DDCAL = function (id, sGroup, config) {
    this.cont = config.cont;
    YAHOO.util.DDCAL.superclass.constructor.apply(this, arguments);
}
YAHOO.extend(YAHOO.util.DDCAL, YAHOO.util.DD, {
    cont: null, init: function () {
        YAHOO.util.DDCAL.superclass.init.apply(this, arguments);
        this.initConstraints();
        CAL.update_dd.subscribe(function (type, args, dd) {
            dd.resetConstraints();
            dd.initConstraints();
        }, this);
    }, initConstraints: function () {
        var region = YAHOO.util.Dom.getRegion(this.cont);
        var el = this.getEl();
        var xy = YAHOO.util.Dom.getXY(el);
        var width = parseInt(YAHOO.util.Dom.getStyle(el, 'width'), 10);
        var height = parseInt(YAHOO.util.Dom.getStyle(el, 'height'), 10);
        var left = xy[0] - region.left;
        var right = region.right - xy[0] - width;
        var top = xy[1] - region.top;
        var bottom = region.bottom - xy[1] - height;
        if (xy) {
            this.setXConstraint(left, right);
            this.setYConstraint(top, bottom);
        }
    }
});
CAL.remove_edit_dialog();
var cal_loaded = true;