/**
 * This file is part of KReporter. KReporter is an enhancement developed
 * by Christian Knoll. All rights are (c) 2012 by Christian Knoll
 *
 * This file has been modified by SinergiaTIC in SinergiaCRM.
 * SinergiaCRM is a work developed by SinergiaTIC Association, based on SuiteCRM.
 * Copyright (C) 2013 - 2023 SinergiaTIC Association
 * 
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU AFFERO GENERAL PUBLIC LICENSE as published by
 * the Free Software Foundation; either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU AFFERO GENERAL PUBLIC LICENSE
 * along with this program; if not, see http://www.gnu.org/licenses
 * or write to the Free Software Foundation,Inc., 51 Franklin Street,
 * Fifth Floor, Boston, MA 02110-1301  USA
 *
 * You can contact Christian Knoll at info@kreporter.org
 * You can contact SinergiaTIC Association at email address info@sinergiacrm.org.
 */

function kGuid() {
    function S4() {
        return (((1 + Math.random()) * 0x10000) | 0).toString(16).substring(1);
    }
    return "k" + S4() + S4() + S4() + S4() + S4() + S4() + S4();
}
Ext.namespace("K.kreports");
Ext.namespace("K.kreports.EditViewModuletree");
Ext.namespace("K.kreports.EditViewUniontree");
Ext.namespace("K.kreports.EditViewWhereclause");
K.kreports.runtime = new Object({ am: null, linkedFields: {} });
K.kreports.buildLinkedFields = function (T) {
    K.kreports.runtime.linkedFields = {};
    var modelFields = T.getProxy().getModel().getFields();
    for (var i = 0; i < modelFields.length; i++) {
        if (modelFields[i].linkInfo == undefined)
            K.kreports.runtime.linkedFields[modelFields[i].name] = null;
        else
            K.kreports.runtime.linkedFields[modelFields[i].name] =
                Ext.JSON.decode(modelFields[i].linkInfo);
    }
};
Ext.util.Format.kreportLinkBuilder = function (cV, J, R, T, m) {
    if (
        cV == undefined ||
        J == undefined ||
        R == undefined ||
        T == undefined ||
        m == undefined
    )
        return cV;
    var dk = J.get("unionid") != undefined ? J.get("unionid") : "root";
    var du = m.panel.columns[R].dataIndex;
    if (
        K.kreports.runtime.linkedFields[du] == undefined ||
        (K.kreports.runtime.linkedFields[du] != null &&
            J.get(K.kreports.runtime.linkedFields[du][dk].idfield) == undefined)
    ) {
        K.kreports.buildLinkedFields(T);
    }
    if (K.kreports.runtime.linkedFields[du] != null)
        return (
            '<a href="index.php?module=' +
            K.kreports.runtime.linkedFields[du][dk].module +
            "&action=DetailView&record=" +
            J.get(K.kreports.runtime.linkedFields[du][dk].idfield) +
            '" target="_newTab">' +
            cV +
            "</a>"
        );
    else return cV;
};
Ext.util.Format.fieldRenderer = function (cV, c, J, P, R, T, m) {
    if (cV == "" || cV == null) return cV;
    return Ext.util.Format.kreportLinkBuilder(cV, J, R, T, m);
};
Ext.util.Format.ktextRenderer = function (cV, c, J, P, R, T, m) {
    if (cV == "" || cV == null) return cV;
    c.style = "white-space: normal;";
    return Ext.util.Format.kreportLinkBuilder(
        cV.replace(/(?:\r\n|\r|\n)/g, "<br />"),
        J,
        R,
        T,
        m
    );
};
Ext.util.Format.base64Renderer = function (cV) {
    if (cV == "" || cV == null) return cV;
    return Ext.util.Format.htmlEncode(K.kreports.decode64(cV));
};
Ext.util.Format.kboolRenderer = function (cV, c, J, P, R, T, m) {
    if (cV == "" || cV == null) return cV;
    return Ext.util.Format.kreportLinkBuilder(bi("LBL_BOOL_" + cV), J, R, T, m);
};
Ext.util.Format.kcurrencyRenderer = function (cV, c, J, P, R, T, m) {
    if (cV == "" || cV == null) return cV;
    Ext.util.Format.decimalSeparator = dec_sep;
    Ext.util.Format.thousandSeparator = num_grp_sep;
    Ext.util.Format.currencySign = kreport_currencies["-99"];
    if (
        typeof J == "object" &&
        J.get(m.panel.columns[R].dataIndex + "_curid") != undefined
    )
        Ext.util.Format.currencySign =
            kreport_currencies[J.get(m.panel.columns[R].dataIndex + "_curid")];
    Ext.util.Format.currencyPrecision = 2;
    return Ext.util.Format.kreportLinkBuilder(
        Ext.util.Format.currency(cV),
        J,
        R,
        T,
        m
    );
};
Ext.util.Format.kpercentageRenderer = function (cV, c, J, P, R, T, m) {
    if (cV == "" || cV == null) return cV;
    return Ext.util.Format.kreportLinkBuilder(
        Ext.util.Format.round(cV, 2) + "%",
        J,
        R,
        T,
        m
    );
};
Ext.util.Format.knumberRenderer = function (cV, c, J, P, R, T, m) {
    if (cV == "" || cV == null) return cV;
    Ext.util.Format.decimalSeparator = dec_sep;
    Ext.util.Format.thousandSeparator = num_grp_sep;
    Ext.util.Format.currencySign = "";
    Ext.util.Format.currencyPrecision = 2;
    return Ext.util.Format.kreportLinkBuilder(
        Ext.util.Format.currency(cV),
        J,
        R,
        T,
        m
    );
};
Ext.util.Format.kintRenderer = function (cV, c, J, P, R, T, m) {
    if (cV == "" || cV == null) return cV;
    return Ext.util.Format.kreportLinkBuilder(cV, J, R, T, m);
};
Ext.util.Format.kdatetimeRenderer = function (cV, c, J, P, R, T, m) {
    if (cV == "" || cV == null) return cV;
    ret = Ext.util.Format.kreportLinkBuilder(
        Ext.Date.format(
            Ext.Date.add(
                new Date(cV.replace(/-/g, "/")),
                Ext.Date.SECOND,
                // STIC AAM 20210602 - Summertime isn't displayed properly in datetime fields STIC#228
                -(new Date(cV)).getTimezoneOffset() * 60
                // time_offset
            ),
            cal_date_format.replace(/%/g, "") + " " + kreport_tf
        ),
        J,
        R,
        T,
        m
    );
    return ret;
};
Ext.util.Format.kdatetutcRenderer = function (cV, c, J, P, R, T, m) {
    if (cV == "" || cV == null) return cV;
    return Ext.util.Format.kreportLinkBuilder(
        Ext.Date.format(
            new Date(cV.replace(/-/g, "/")),
            cal_date_format.replace(/%/g, "") + " " + kreport_tf
        ),
        J,
        R,
        T,
        m
    );
    return Ext.util.Format.kreportLinkBuilder(
        Ext.util.Format.date(
            cV.replace(/-/g, "/").split(" ")[0],
            cal_date_format.replace(/%/g, "")
        ) +
            " " +
            cV.split(" ")[1],
        J,
        R,
        T,
        m
    );
};
Ext.util.Format.kdateRenderer = function (cV, c, J, P, R, T, m) {
    if (cV == "" || cV == null) return cV;
    if (typeof cV == "object") cV = Ext.Date.format(cV, "Y-m-d");
    return Ext.util.Format.kreportLinkBuilder(
        Ext.util.Format.date(
            cV.replace(/-/g, "/"),
            cal_date_format.replace(/%/g, "")
        ),
        J,
        R,
        T,
        m
    );
};
K.kreports.sumplugin = function (records, fieldid, summaryfunction) {
    switch (summaryfunction) {
        case "sum":
            var di = 0;
            for (var cG = 0; cG < records.length; cG++) {
                if (isNaN(records[cG].get(fieldid))) return "isNaN";
                di = di + parseFloat(records[cG].get(fieldid));
            }
            return di;
            break;
        case "avg":
            var di = 0;
            for (var cG = 0; cG < records.length; cG++) {
                if (isNaN(records[cG].get(fieldid))) return "isNaN";
                di = di + parseFloat(records[cG].get(fieldid));
            }
            if (di == 0) return di;
            else return di / records.length;
            break;
        case "max":
            var currentValue = "";
            for (var cG = 0; cG < records.length; cG++) {
                if (
                    records[cG].get(fieldid) > currentValue ||
                    currentValue == ""
                )
                    currentValue = records[cG].get(fieldid);
            }
            return currentValue;
            break;
        case "min":
            var currentValue = "";
            for (var cG = 0; cG < records.length; cG++) {
                if (
                    records[cG].get(fieldid) < currentValue ||
                    currentValue == ""
                )
                    currentValue = records[cG].get(fieldid);
            }
            return currentValue;
            break;
        case "count":
            return records.length;
            break;
        default:
            return summaryfunction;
            break;
    }
    return "";
};
K.kreports.l =
    "ABCDEFGHIJKLMNOP" +
    "QRSTUVWXYZabcdef" +
    "ghijklmnopqrstuv" +
    "wxyz0123456789+/" +
    "=";
K.kreports.encode64 = function (input) {
    input = escape(input);
    var output = "";
    var chr1,
        chr2,
        chr3 = "";
    var enc1,
        enc2,
        enc3,
        enc4 = "";
    var i = 0;
    do {
        chr1 = input.charCodeAt(i++);
        chr2 = input.charCodeAt(i++);
        chr3 = input.charCodeAt(i++);
        enc1 = chr1 >> 2;
        enc2 = ((chr1 & 3) << 4) | (chr2 >> 4);
        enc3 = ((chr2 & 15) << 2) | (chr3 >> 6);
        enc4 = chr3 & 63;
        if (isNaN(chr2)) {
            enc3 = enc4 = 64;
        } else if (isNaN(chr3)) {
            enc4 = 64;
        }
        output =
            output +
            K.kreports.l.charAt(enc1) +
            K.kreports.l.charAt(enc2) +
            K.kreports.l.charAt(enc3) +
            K.kreports.l.charAt(enc4);
        chr1 = chr2 = chr3 = "";
        enc1 = enc2 = enc3 = enc4 = "";
    } while (i < input.length);
    return output;
};
K.kreports.decode64 = function (input) {
    var output = "";
    var chr1,
        chr2,
        chr3 = "";
    var enc1,
        enc2,
        enc3,
        enc4 = "";
    var i = 0;
    var base64test = /[^A-Za-z0-9\+\/\=]/g;
    if (base64test.exec(input)) {
    }
    input = input.replace(/[^A-Za-z0-9\+\/\=]/g, "");
    do {
        enc1 = K.kreports.l.indexOf(input.charAt(i++));
        enc2 = K.kreports.l.indexOf(input.charAt(i++));
        enc3 = K.kreports.l.indexOf(input.charAt(i++));
        enc4 = K.kreports.l.indexOf(input.charAt(i++));
        chr1 = (enc1 << 2) | (enc2 >> 4);
        chr2 = ((enc2 & 15) << 4) | (enc3 >> 2);
        chr3 = ((enc3 & 3) << 6) | enc4;
        output = output + String.fromCharCode(chr1);
        if (enc3 != 64) {
            output = output + String.fromCharCode(chr2);
        }
        if (enc4 != 64) {
            output = output + String.fromCharCode(chr3);
        }
        chr1 = chr2 = chr3 = "";
        enc1 = enc2 = enc3 = enc4 = "";
    } while (i < input.length);
    return unescape(output);
};
K.kreports.EditView = false;
Ext.define("K.kreports.kreportsJsonStore", {
    extend: "Ext.data.JsonStore",
    domElement: "",
    constructor: function (config) {
        K.kreports.kreportsJsonStore.superclass.constructor.call(this, config);
    },
    loadData: function (o, append) {
        K.kreports.kreportsJsonStore.superclass.loadData.call(this, o, append);
    },
    writeJson: function () {
        jArray = new Array();
        if (this.isFiltered()) {
            for (i = 0; i < this.snapshot.items.length; i++) {
                jArray.push(Ext.JSON.encode(this.snapshot.items[i].data));
            }
        } else {
            for (i = 0; i < this.data.items.length; i++) {
                jArray.push(Ext.JSON.encode(this.data.items[i].data));
            }
        }
        document.getElementById(this.domElement).value =
            "[" + jArray.toString() + "]";
    },
    loadDirect: function () {
        if (document.getElementById(this.domElement).value != "")
            this.loadData(
                Ext.JSON.decode(document.getElementById(this.domElement).value)
            );
    },
    add: function (records) {
        K.kreports.kreportsJsonStore.superclass.add.call(this, records);
        this.writeJson();
    },
    remove: function (record) {
        K.kreports.kreportsJsonStore.superclass.remove.call(this, record);
        this.writeJson();
    },
    afterEdit: function (record) {
        K.kreports.kreportsJsonStore.superclass.afterEdit.call(this, record);
        this.writeJson();
    },
    getMaxSequence: function () {
        var maxSequence = 0;
        var i = 0;
        while (i < this.getCount()) {
            if (this.getAt(i).data.sequence > maxSequence)
                maxSequence = this.getAt(i).data.sequence;
            i++;
        }
        return parseInt(maxSequence, 10);
    },
    getNextSequence: function () {
        dO = this.getMaxSequence() + 1;
        if (dO < 10) dO = "0" + dO;
        return dO;
    },
});
Ext.define("Ext.grid.feature.KSummary", {
    extend: "Ext.grid.feature.Summary",
    alias: "feature.ksummary",
    generateSummaryData: function () {
        var me = this,
            data = {},
            store = me.view.store,
            reader = store.proxy.reader,
            columns = me.view.headerCt.getColumnsForTpl(),
            i,
            length,
            comp;
        for (i = 0, length = columns.length; i < length; ++i) {
            comp = Ext.getCmp(columns[i].id);
            if (
                reader.rawData != undefined &&
                reader.rawData[me.remoteSummary][columns[i].dataIndex] !=
                    undefined
            )
                data[comp.id] =
                    reader.rawData[me.remoteSummary][columns[i].dataIndex];
            else data[comp.id] = "";
        }
        return data;
    },
});
K.kreports.M = "PGI+S1JlcG9ydGVyIFYzLjE8L2I+";
K.kreports.H =
    "PGEgaHJlZj0iaHR0cDovL3d3dy5mYWNlYm9vay5jb20va3JlcG9ydGVyLm9yZyI+PGltZyBzcmM9ImRhdGE6aW1hZ2UvcG5nO2Jhc2U2NCxpVkJPUncwS0dnb0FBQUFOU1VoRVVnQUFBQkFBQUFBUUNBWUFBQUFmOC85aEFBQUFCSE5DU1ZRSUNBZ0lmQWhraUFBQUFBbHdTRmx6QUFBTEVnQUFDeElCMHQxKy9BQUFBQlYwUlZoMFEzSmxZWFJwYjI0Z1ZHbHRaUUEyTHpJMEx6QTU5c0ZyNHdBQUFCeDBSVmgwVTI5bWRIZGhjbVVBUVdSdlltVWdSbWx5WlhkdmNtdHpJRU5UTkFheTA2QUFBQUZQU1VSQlZEaU5sWks5U2dOQkZJWFByQlBVR0lqRUJIOEtHd1ZyeSszOUtiU3hVNS9BSmtVc3hFZlFON0FVQzBFUWJOSUlXdHZGVjdBeGliZ0drN2hoZis2OVl4RVRza0YyTjdlYUEvYzduRE16NnFoeVV3Qm1xc1pZTmlZWXBlUUY4UFkxa2E0dUZMSjJxWmlEVWlvVmJJekJwL05qZjdXb3FzTlEyVXBQNGEzUm1TUUFjck1aaEtHeU5RbWo3ZnFKQUlVZVBQZTdEODh2b2UzNklHRm9KZ2F6Sk1LWGxXMnNyUllCQUlkbkR3QUFKb1ltRnJDWVdJT0xFUmpBY0o5WW9Ja0pKUEVKMXYvZ2c5UDdhREttK0FwdSt5T2lPNjBHQUdBdXY1aXV3dk4xK1YrOVY3NGJxNUJ3aWVNejJPOVhpRW13ZFhJTEFIaTZPbzdvd1RBTE5CTWxQdU1vRU5GRTBDU01sZVY4S29QeFBlZTlEaTBzNkxhNm1NNU9KeG9FWGpBOCt6MGZ3Z0pMVEZCcjFoMzR2ZVR2UEFvMzZ3N0VCRFcxc1hOZUVzbzhHbU50cG5ZQW9KUzhXanJjL1FYbjZjYWMwcmJaL3dBQUFBQkpSVTVFcmtKZ2dnPT0iIC8+PC9hPiZuYnNwOzxhIGhyZWY9Imh0dHA6Ly93d3cueW91dHViZS5jb20vdXNlci90aGVLUmVwb3J0ZXIiPjxpbWcgc3JjPSJkYXRhOmltYWdlL3BuZztiYXNlNjQsaVZCT1J3MEtHZ29BQUFBTlNVaEVVZ0FBQUJBQUFBQVFDQVlBQUFBZjgvOWhBQUFBQkhOQ1NWUUlDQWdJZkFoa2lBQUFBQWx3U0ZsekFBQUxFZ0FBQ3hJQjB0MSsvQUFBQUJWMFJWaDBRM0psWVhScGIyNGdWR2x0WlFBMkx6STBMekE1OXNGcjR3QUFBQngwUlZoMFUyOW1kSGRoY21VQVFXUnZZbVVnUm1seVpYZHZjbXR6SUVOVE5BYXkwNkFBQUFGeVNVUkJWRGlObFpDOVNnTkJGSVcvR1lPZ2paQktVUHdob0tDeFVCQWlpMFc2Rkw2SmtrZHdueU85VlVxeFVHelNxSVdvSUNva0NHb25hS09JN3V6T25iR0lXVjJUWUR4d09Od3pNL2VlTytwK2ZUM3Z2ZDl6c01ZL29PRkVLYlhCYlJBY3Y5YnIvcjk0cmRmOWJSQWNjMWtxcFNhUTBiOXdXU3A1YmNSbW9qVWFqWUhYTUdMUlVmTGRJQXhEeXVVeVlSaWlsRW9KZENsQWxGZzRYQ3BtWXYxZW81OTY3LzNoVXRIclNLUnZ4Si9UZXRXUkNOcFk0YmxXUzgzMmtMWjIyS3QrcnRVd1ZsQTdoWUl2am80TS9IRS9jZlgrUWM0NElSWmg5Zm9tUFRoZFhNaGNYTDIrNmZJQWpCTjBiQzJ4dFJ6Tnp3RndORDlIeCtzUTZQSTYxSkU0WW1tbkFJaEZDSnF0akFJRXpSWVRtMXNFelZicVIrTFF4bG1NdEFuMDFmM1phV2FxVmZabnAxUGZPRXN1RnNkVGtqQ21kWm9Bb0hMMzBMT3UzRDJ3T3pYSmkzUEU0bERiK2Z6WnNGSXI0N21odE1sZmVIR09SeXZFM3AvbjhGSjVjeHcwSlZrZTZQVVhobEFYdzRyS0ozbVdmMkgwckN0ZUFBQUFBRWxGVGtTdVFtQ0MiIC8+PC9hPg==";
Ext.define("U", {
    extend: "Ext.data.Model",
    fields: [
        { name: "lblid", type: "string" },
        { name: "value", type: "string" },
    ],
});
var f = new Ext.data.JsonStore({ model: U });
if (document.getElementById("jsonlanguage").value != "") {
    var jsonLanguage;
    eval("jsonLanguage = " + document.getElementById("jsonlanguage").value);
    f.loadData(Ext.JSON.decode(document.getElementById("jsonlanguage").value));
}
var bi = function (keyID) {
    var recordNumber = f.find("lblid", keyID);
    if (recordNumber >= 0) {
        return f.getAt(recordNumber).data.value;
    } else {
        return keyID;
    }
};
K.kreports.visualizationmanager = new Object({
    myID: "",
    registeredPlugins: new Array(),
    update: function () {
        if (K.kreports.visualizationmanager.registeredPlugins.length > 0) {
            Ext.Ajax.request({
                url: "index.php?module=KReports&to_pdf=true&action=update_visualization",
                method: "POST",
                timeout: 300000,
                success: function (ajaxResponse) {
                    var respJson = Ext.JSON.decode(ajaxResponse.responseText);
                    for (
                        var i = 0;
                        i <
                        K.kreports.visualizationmanager.registeredPlugins
                            .length;
                        i++
                    )
                        eval(
                            K.kreports.visualizationmanager.registeredPlugins[
                                i
                            ] +
                                ".update(K.kreports.decode64(respJson." +
                                K.kreports.visualizationmanager
                                    .registeredPlugins[i] +
                                "))"
                        );
                },
                failure: function () {},
                params: {
                    record: document.getElementById("recordid").value,
                    snapshotid: 0,
                    whereConditions: K.kreports.DetailView.ae(),
                },
            });
        }
    },
    exportVisualization: function () {
        if (this.registeredPlugins.length > 0) {
            var objectData = {};
            objectData.measures = {
                width: document.getElementById(this.myID).clientWidth,
                height: document.getElementById(this.myID).clientHeight,
            };
            objectData.objects = {};
            for (var i = 0; i < this.registeredPlugins.length; i++) {
                eval(
                    "var thisObject = " +
                        K.kreports.visualizationmanager.registeredPlugins[i]
                );
                if (typeof thisObject.exportVisualization == "function")
                    objectData.objects[
                        K.kreports.visualizationmanager.registeredPlugins[i]
                    ] = thisObject.exportVisualization();
                else
                    objectData.objects[
                        K.kreports.visualizationmanager.registeredPlugins[i]
                    ] = "";
            }
            return JSON.stringify(objectData);
        } else return "";
    },
});
