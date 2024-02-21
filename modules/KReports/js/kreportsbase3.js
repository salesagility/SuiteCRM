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

function getUnionId() {
  if (!mainModuleTreePanel.collapsed) {
    return "root";
  } else {
    return K.kreports.unionTree.bd(null);
  }
}
Ext.define("K.kreports.EditViewWhereclause.bN", {
  extend: "Ext.data.Model",
  fields: [
    { name: "unionid", mapping: "unionid" },
    { name: "id", mapping: "id" },
    { name: "group", mapping: "group" },
    { name: "type", mapping: "type" },
    { name: "parent", mapping: "parent" },
    { name: "notexists", mapping: "notexists" }
  ]
});
K.kreports.EditViewWhereclause.A = new K.kreports.kreportsJsonStore({
  model: K.kreports.EditViewWhereclause.bN,
  domElement: "wheregroups",
  idProperty: ""
});
K.kreports.EditViewWhereclause.bV = new Ext.data.TreeStore({
  root: {
    text: "root",
    selected: true,
    leaf: false,
    draggable: false,
    id: "root"
  }
});
var currentNode = K.kreports.EditViewWhereclause.bV.getRootNode();
var initialTreeBuild = function() {
  K.kreports.EditViewWhereclause.bV.getRootNode().removeAll();
  buildTreeFromNode(K.kreports.EditViewWhereclause.bV.getRootNode(), "root");
  bR(K.kreports.EditViewWhereclause.bV.getRootNode());
};
var buildTreeFromNode = function(parentnode, nodeid) {
  K.kreports.EditViewWhereclause.A.clearFilter();
  K.kreports.EditViewWhereclause.A.filter("unionid", getUnionId());
  if (nodeid != "root") {
    dy = K.kreports.EditViewWhereclause.A.getAt(
      K.kreports.EditViewWhereclause.A.find("id", nodeid)
    );
    var cl = parentnode.appendChild({
      text: dy.data.group,
      id: dy.data.id,
      selected: true,
      draggable: false
    });
  } else {
    foundIndex = K.kreports.EditViewWhereclause.A.find("id", "root");
    if (foundIndex == -1) {
      addWhereGroupNode(K.kreports.EditViewWhereclause.bV.getRootNode());
    }
    var cl = K.kreports.EditViewWhereclause.bV.getRootNode();
  }
  K.kreports.EditViewWhereclause.A.filter([
    { property: "parent", value: nodeid },
    { property: "unionid", value: getUnionId() }
  ]);
  var addChild = function(record) {
    buildTreeFromNode(cl, record.get("id"));
  };
  K.kreports.EditViewWhereclause.A.each(addChild);
  K.kreports.EditViewWhereclause.A.clearFilter();
};
var addWhereGroupNode = function(cl) {
  if (cl.data.id != "root") {
    var NodeRecord = K.kreports.EditViewWhereclause.A.add({
      unionid: getUnionId(),
      id: cl.data.id,
      group: cl.data.text,
      parent: cl.parentNode.get("id"),
      type: "AND"
    });
  } else {
    var NodeRecord = K.kreports.EditViewWhereclause.A.add({
      unionid: getUnionId(),
      id: cl.data.id,
      group: cl.data.text,
      parent: "-",
      type: "AND"
    });
  }
};
var updateWhereGroupNodeType = function(id, df) {
  var aq = K.kreports.EditViewWhereclause.A.find("id", id);
  if (aq != -1) {
    var aJ = K.kreports.EditViewWhereclause.A.getAt(aq);
    aJ.set("type", df);
  }
};
var aI = function(id, cU) {
  var aq = K.kreports.EditViewWhereclause.A.find("id", id);
  if (aq != -1) {
    var aJ = K.kreports.EditViewWhereclause.A.getAt(aq);
    if (cU) {
      aJ.set("notexists", "1");
    } else {
      aJ.set("notexists", "");
    }
  }
};
var bo = function(id, cs) {
  var aq = K.kreports.EditViewWhereclause.A.find("id", id);
  if (aq != -1) {
    var aJ = K.kreports.EditViewWhereclause.A.getAt(aq);
    aJ.set("group", cs);
  }
};
var ao = new Ext.Button({
  text: bi("LBL_ADD_BUTTON_LABEL"),
  icon: "modules/KReports/images/link_add.png",
  handler: function() {
    Ext.Msg.prompt(
      bi("LBL_ADD_GROUP_NAME"),
      bi("LBL_CHANGE_GROUP_NAME_PROMPT"),
      function(btn, text) {
        if (btn == "ok") {
          var ChildNode = currentNode.appendChild({
            id: kGuid(),
            text: text,
            selected: true,
            draggable: false
          });
          addWhereGroupNode(ChildNode);
          if (!currentNode.isExpanded()) currentNode.expand();
          by.getSelectionModel().select(ChildNode);
          bR(ChildNode);
          au.disable();
        }
      }
    );
  }
});
var au = new Ext.Button({
  text: bi("LBL_DELETE_BUTTON_LABEL"),
  icon: "modules/KReports/images/link_delete.png",
  handler: function() {
    var aq = K.kreports.EditViewWhereclause.A.find("id", currentNode.get("id"));
    if (aq != -1) {
      var aJ = K.kreports.EditViewWhereclause.A.getAt(aq);
      K.kreports.EditViewWhereclause.A.remove(aJ);
    }
    currentNode.remove();
  },
  disabled: true
});
var aP = new Ext.Button({
  text: bi("LBL_EDIT_BUTTON_LABEL"),
  icon: "modules/KReports/images/link_edit.png",
  handler: function() {
    Ext.Msg.prompt(
      bi("LBL_CHANGE_GROUP_NAME"),
      bi("LBL_CHANGE_GROUP_NAME_PROMPT"),
      function(btn, text) {
        if (btn == "ok") {
          bo(currentNode.get("id"), text);
          currentNode.set("text", text);
        }
      }
    );
  },
  disabled: true
});
var aT = new Ext.form.ComboBox({
  store: ["AND", "OR"],
  name: "group Clause",
  typeAhead: true,
  editable: false,
  mode: "local",
  triggerAction: "all",
  emptyText: "Select a type.",
  selectOnFocus: true,
  value: "AND",
  width: 50,
  listeners: {
    select: function() {
      updateWhereGroupNodeType(currentNode.get("id"), aT.value);
    }
  }
});
var aa = new Ext.form.Label({ text: bi("LBL_SELECTION_CLAUSE") });
var groupExistsCheckbox = new Ext.form.Checkbox({
  boxLabel: "where Exists",
  name: "where Exists Checkbox"
});
groupExistsCheckbox.on("check", function() {
  aI(currentNode.get("id"), groupExistsCheckbox.checked);
});
var bR = function(n) {
  K.kreports.EditViewWhereclause.af.clearFilter(true);
  K.kreports.EditViewWhereclause.A.filter("unionid", getUnionId());
  var aq = K.kreports.EditViewWhereclause.A.find("id", n.get("id"));
  if (aq != -1) {
    var aJ = K.kreports.EditViewWhereclause.A.getAt(aq);
    aT.setValue(aJ.data.type);
    if (aJ.data.notexists == "1") {
      groupExistsCheckbox.setValue(true);
    } else {
      groupExistsCheckbox.setValue(false);
    }
  }
  K.kreports.EditViewWhereclause.af.filter([
    { property: "groupid", value: n.get("id") },
    { property: "unionid", value: getUnionId() }
  ]);
  if (n.parentNode != null) {
    if (n.hasChildNodes() || K.kreports.EditViewWhereclause.af.getCount() > 0) {
      au.disable();
    } else {
      au.enable();
    }
    aP.enable();
    currentNode = n;
  } else {
    au.disable();
    aP.disable();
    currentNode = n;
  }
};
var by = new Ext.tree.Panel({
  id: "wheretreepanel",
  store: K.kreports.EditViewWhereclause.bV,
  split: true,
  flex: 50,
  minSize: 100,
  autoScroll: true,
  rootVisible: true,
  lines: false,
  singleExpand: true,
  useArrows: true,
  enableDragDrop: false,
  listeners: {
    itemclick: function(dw, dj) {
      bR(dj);
    }
  },
  tbar: new Ext.Toolbar({
    items: [
      ao,
      au,
      aP,
      { xtype: "tbseparator" },
      aa,
      { xtype: "tbspacer", width: 10 },
      aT
    ]
  })
});
var deletechild = function(n) {
  n.destroy();
};
var bE = function() {
  by.root.eachChild(deletechild);
};
Ext.define("K.kreports.EditViewWhereclause.aU", {
  extend: "Ext.data.Model",
  fields: [
    { name: "unionid", mapping: "unionid" },
    { name: "sequence", mapping: "sequence" },
    { name: "fieldid", mapping: "fieldid" },
    { name: "name", mapping: "name" },
    { name: "fixedvalue", mapping: "fixedvalue" },
    { name: "groupid", mapping: "groupid" },
    { name: "path", mapping: "path" },
    { name: "displaypath", mapping: "displaypath" },
    { name: "referencefieldid", mapping: "referencefieldid" },
    { name: "operator", mapping: "operator" },
    { name: "type", mapping: "type" },
    { name: "value", mapping: "value" },
    { name: "valuekey", mapping: "valuekey" },
    { name: "valueto", mapping: "valueto" },
    { name: "valuetokey", mapping: "valuetokey" },
    { name: "jointype", mapping: "jointype" },
    { name: "context", mapping: "context" },
    { name: "reference", mapping: "reference" },
    { name: "include", mapping: "include" },
    { name: "usereditable", mapping: "usereditable" },
    { name: "dashleteditable", mapping: "dashleteditable" },
    { name: "exportpdf", mapping: "exportpdf" },
    { name: "customsqlfunction", mapping: "customsqlfunction" }
  ]
});
K.kreports.EditViewWhereclause.af = new K.kreports.kreportsJsonStore({
  model: K.kreports.EditViewWhereclause.aU,
  domElement: "whereconditions",
  paramsAsHash: true
});
K.kreports.EditViewWhereclause.bf = [
  {
    text: bi("LBL_FIELDNAME"),
    readOnly: true,
    dataIndex: "displaypath",
    width: 150,
    sortable: true,
    hidden: false
  },
  {
    text: bi("LBL_FULLPATH"),
    readOnly: true,
    dataIndex: "path",
    width: 150,
    sortable: true,
    hidden: true
  },
  {
    id: "sequence",
    text: bi("LBL_SEQUENCE"),
    dataIndex: "sequence",
    sortable: true,
    editor: new Ext.form.TextField(),
    width: 30
  },
  {
    id: "exportpdf",
    text: bi("LBL_EXPORTPDF"),
    dataIndex: "exportpdf",
    sortable: true,
    hidden: true,
    renderer: function(value, metaData, record, rowIndex, colIndex, store) {
      if (value != "") return bi("LBL_UEOPTION_" + value.toUpperCase());
      else return value;
    },
    editor: new Ext.form.ComboBox({
      typeAhead: true,
      triggerAction: "all",
      lazyRender: true,
      mode: "local",
      store: new Ext.data.ArrayStore({
        id: 0,
        fields: ["value", "text"],
        data: [["no", bi("LBL_UEOPTION_NO")], ["yes", bi("LBL_UEOPTION_YES")]]
      }),
      displayField: "text",
      valueField: "value"
    }),
    width: 60
  },
  {
    text: bi("LBL_NAME"),
    dataIndex: "name",
    sortable: true,
    editor: new Ext.form.TextField(),
    width: 150
  },
  {
    text: bi("LBL_FIXEDVALUE"),
    dataIndex: "fixedvalue",
    sortable: true,
    editor: new Ext.form.TextField(),
    width: 150
  },
  {
    id: "type",
    text: bi("LBL_TYPE"),
    dataIndex: "type",
    sortable: false,
    hidden: true,
    width: 50
  },
  {
    id: "operator",
    text: bi("LBL_OPERATOR"),
    readOnly: true,
    dataIndex: "operator",
    width: 150,
    sortable: true,
    hidden: false,
    renderer: function(value, metaData, record, rowIndex, colIndex, store) {
      return bi("LBL_OP_" + value.toUpperCase());
    },
    editor: new Ext.form.TextField()
  },
  {
    id: "value",
    text: bi("LBL_VALUE_FROM"),
    dataIndex: "value",
    sortable: true,
    hidden: false,
    width: 100,
    editor: new Ext.form.TextField()
  },
  {
    id: "valueto",
    text: bi("LBL_VALUE_TO"),
    dataIndex: "valueto",
    sortable: true,
    hidden: false,
    width: 100,
    editor: new Ext.form.TextField()
  },
  {
    text: bi("LBL_JOIN_TYPE"),
    readOnly: true,
    dataIndex: "jointype",
    width: 80,
    sortable: true,
    hidden: false,
    renderer: function(value, metaData, record, rowIndex, colIndex, store) {
      return value;
    },
    editor: new Ext.form.ComboBox({
      typeAhead: true,
      triggerAction: "all",
      lazyRender: true,
      mode: "local",
      store: new Ext.data.ArrayStore({
        id: 0,
        fields: ["jointype"],
        data: [["required"], ["notexisting"], ["optional"]]
      }),
      displayField: "jointype"
    })
  },
  {
    text: bi("LBL_USEREDITABLE"),
    readOnly: true,
    dataIndex: "usereditable",
    width: 80,
    sortable: true,
    hidden: false,
    renderer: function(value, metaData, record, rowIndex, colIndex, store) {
      return bi("LBL_UEOPTION_" + value.toUpperCase());
    },
    editor: new Ext.form.ComboBox({
      typeAhead: true,
      triggerAction: "all",
      lazyRender: true,
      mode: "local",
      store: new Ext.data.ArrayStore({
        id: 0,
        fields: ["value", "text"],
        data: [
          ["yes", bi("LBL_UEOPTION_YES")],
          ["yfo", bi("LBL_UEOPTION_YFO")],
          ["yo1", bi("LBL_UEOPTION_YO1")],
          ["yo2", bi("LBL_UEOPTION_YO2")],
          ["no", bi("LBL_UEOPTION_NO")]
        ]
      }),
      displayField: "text",
      valueField: "value"
    })
  },
  {
    text: bi("LBL_DASHLETEDITABLE"),
    readOnly: true,
    hidden: true,
    dataIndex: "dashleteditable",
    width: 50,
    sortable: true,
    renderer: function(value, metaData, record, rowIndex, colIndex, store) {
      return bi("LBL_DEOPTION_" + value.toUpperCase());
    },
    editor: new Ext.form.ComboBox({
      typeAhead: true,
      triggerAction: "all",
      lazyRender: true,
      mode: "local",
      store: new Ext.data.ArrayStore({
        id: 0,
        fields: ["value", "text"],
        data: [["yes", bi("LBL_DEOPTION_YES")], ["no", bi("LBL_DEOPTION_NO")]]
      }),
      displayField: "text",
      valueField: "value"
    })
  },
  {
    id: "context",
    text: bi("LBL_QUERYCONTEXT"),
    dataIndex: "context",
    sortable: true,
    hidden: false,
    width: 150,
    editor: new Ext.form.TextField()
  },
  {
    id: "reference",
    text: bi("LBL_QUERYREFERENCE"),
    dataIndex: "reference",
    sortable: true,
    hidden: false,
    width: 150,
    editor: new Ext.form.TextField()
  },
  {
    text: bi("LBL_CUSTOMSQLFUNCTION"),
    readOnly: true,
    dataIndex: "customsqlfunction",
    width: 70,
    sortable: false,
    hidden: true,
    editor: new Ext.form.TextField(),
    renderer: "base64Renderer"
  }
];
var bH = new Ext.grid.Panel({
  store: K.kreports.EditViewWhereclause.af,
  columns: K.kreports.EditViewWhereclause.bf,
  selModel: new Ext.selection.RowModel({ mode: "MULTI" }),
  width: "100%",
  flex: 100,
  plugins: [
    Ext.create("Ext.grid.plugin.CellEditing", {
      clicksToEdit: 1,
      listeners: {
        beforeedit: function(editor, e, Opts) {
          return bM(e, bH);
        },
        edit: function(editor, e) {
          aL(e);
        }
      }
    })
  ],
  viewConfig: {
    plugins: {
      dropGroup: "moduleFields",
      ptype: "gridviewdragdrop",
      enableDrop: true
    },
    markDirty: false,
    listeners: {
      beforedrop: function(
        node,
        data,
        overModel,
        dropPosition,
        dropFunctions,
        eOpts
      ) {
        for (
          var recordCounter = 0;
          recordCounter < data.records.length;
          recordCounter++
        ) {
          K.kreports.EditViewWhereclause.af.add({
            unionid: getUnionId(),
            fieldid: kGuid(),
            path:
              activeTreeNodePath + "::" + data.records[recordCounter].data.id,
            name: data.records[recordCounter].data.name,
            type: data.records[recordCounter].data.type,
            displaypath: FieldsListingEditorGrid.title,
            groupid: currentNode.get("id"),
            referencefieldid: "",
            operator: "ignore",
            jointype: "required",
            usereditable: "no",
            dashleteditable: "no",
            exportpdf: "no"
          });
        }
        au.disable();
        dropFunctions.cancelDrop();
        return true;
      }
    }
  },
  stripeRows: true,
  tbar: new Ext.Toolbar({
    items: [
      {
        text: bi("LBL_ADDEMTPY_BUTTON_LABEL"),
        icon: "modules/KReports/images/add.png",
        handler: function() {
          K.kreports.EditViewWhereclause.af.add({
            unionid: getUnionId(),
            fieldid: kGuid(),
            path: "",
            name: "enter name",
            type: "fixed",
            displaypath: "",
            groupid: currentNode.get("id"),
            referencefieldid: "",
            operator: "ignore",
            jointype: "required",
            usereditable: "no",
            dashleteditable: "no",
            exportpdf: "no"
          });
        }
      },
      {
        text: bi("LBL_DELETE_BUTTON_LABEL"),
        icon: "modules/KReports/images/delete.png",
        handler: function() {
          K.kreports.EditViewWhereclause.af.remove(
            bH.getSelectionModel().getSelection()
          );
          if (
            K.kreports.EditViewWhereclause.af.getTotalCount > 0 ||
            currentNode.parentNode === null
          ) {
            au.disable();
          } else {
            au.enable();
          }
        }
      }
    ]
  }),
  listeners: {
    click: function(e) {
      aF = e.getXY();
    }
  }
});
K.kreports.vboxWhere = new Ext.Panel({
  title: bi("LBL_WHERRE_CLAUSE_TITLE"),
  icon: "modules/KReports/images/selection.png",
  layout: "vbox",
  layoutConfig: { align: "stretch", pack: "start" },
  items: [by, bH]
});
Ext.namespace("K.kreports.mainListGrid");
K.kreports.mainListGrid.editorWindow = new Ext.window.Window({
  modal: true,
  height: 200,
  width: 400,
  layout: "fit",
  record: null,
  editedField: null,
  editedFieldText: null,
  title: "Editor",
  closeAction: "hide",
  items: [{ xtype: "textarea" }],
  buttons: [
    {
      text: "OK",
      handler: function() {
        if (
          K.kreports.mainListGrid.editorWindow.items.items[0].getValue() != ""
        )
          K.kreports.mainListGrid.editorWindow.record.set(
            K.kreports.mainListGrid.editorWindow.editedField,
            K.kreports.encode64(
              K.kreports.mainListGrid.editorWindow.items.items[0].getValue()
            )
          );
        else
          K.kreports.mainListGrid.editorWindow.record.set(
            K.kreports.mainListGrid.editorWindow.editedField,
            ""
          );
        K.kreports.mainListGrid.editorWindow.close();
      }
    },
    {
      text: "Cancel",
      handler: function() {
        K.kreports.mainListGrid.editorWindow.close();
      }
    }
  ],
  listeners: {
    show: function() {
      this.items.items[0].setValue(
        K.kreports.decode64(this.record.get(this.editedField))
      );
      this.setTitle(this.record.get("name") + " - " + this.editedFieldText);
    }
  }
});
K.kreports.mainListGrid.listedFields = [
  { name: "fieldid", mapping: "fieldid" },
  { name: "sequence", mapping: "sequence" },
  { name: "fieldname", mapping: "fieldname" },
  { name: "name", mapping: "name" },
  { name: "display", mapping: "display" },
  { name: "path", mapping: "path" },
  { name: "displaypath", mapping: "displaypath" },
  { name: "sort", mapping: "sort" },
  { name: "sortpriority", mapping: "sortpriority" },
  { name: "width", mapping: "width" },
  { name: "jointype", mapping: "jointype" },
  { name: "sqlfunction", mapping: "sqlfunction" },
  { name: "summaryfunction", mapping: "summaryfunction" },
  { name: "customsqlfunction", mapping: "customsqlfunction" },
  { name: "valuetype", mapping: "valuetype" },
  { name: "groupby", mapping: "groupby" },
  { name: "link", mapping: "link" },
  { name: "editable", mapping: "editable" },
  { name: "fixedvalue", mapping: "fixedvalue" },
  { name: "assigntovalue", mapping: "assigntovalue" },
  { name: "formulavalue", mapping: "formulavalue" },
  { name: "formulasequence", mapping: "formulasequence" },
  { name: "widget", mapping: "widget" },
  { name: "overridetype", mapping: "overridetype" },
  { name: "overridealignment", mapping: "overridealignment" }
];
K.kreports.mainListGrid.kreportsJsonStore = Ext.extend(
  K.kreports.kreportsJsonStore,
  {
    constructor: function(config) {
      K.kreports.mainListGrid.kreportsJsonStore.superclass.constructor.call(
        this,
        config
      );
    },
    add: function(records) {
      K.kreports.mainListGrid.kreportsJsonStore.superclass.add.call(
        this,
        records
      );
    },
    insert: function(position, records) {
      K.kreports.EditViewUniontree.unionmodulesStore.insertRecordsInUnion(
        position,
        records
      );
      K.kreports.mainListGrid.kreportsJsonStore.superclass.insert.call(
        this,
        position,
        records
      );
    },
    remove: function(record) {
      K.kreports.EditViewUniontree.unionmodulesStore.removeRecordsFromUnion(
        record
      );
      K.kreports.mainListGrid.kreportsJsonStore.superclass.remove.call(
        this,
        record
      );
    },
    afterEdit: function(record) {
      K.kreports.EditViewUniontree.unionmodulesStore.updateRecordsFromUnion(
        record
      );
      K.kreports.mainListGrid.kreportsJsonStore.superclass.afterEdit.call(
        this,
        record
      );
    }
  }
);
Ext.define("K.kreports.mainListGrid.listedFieldsModel", {
  extend: "Ext.data.Model",
  fields: K.kreports.mainListGrid.listedFields
});
var listGridStore = new K.kreports.mainListGrid.kreportsJsonStore({
  model: K.kreports.mainListGrid.listedFieldsModel,
  domElement: "listfields",
  ax: function() {
    var i = 0;
    while (i < this.getCount()) {
      currentSequence = i + 1;
      if (currentSequence < 10) var currentSequence = "0" + currentSequence;
      this.getAt(i).set("sequence", currentSequence);
      i++;
    }
  }
});
K.kreports.mainListGrid.listColumns = [
  {
    text: bi("LBL_SEQUENCE"),
    readOnly: true,
    dataIndex: "sequence",
    width: 30,
    sortable: true,
    hidden: true
  },
  {
    text: bi("LBL_FULLPATH"),
    readOnly: true,
    dataIndex: "path",
    width: 150,
    sortable: true,
    hidden: true
  },
  {
    text: bi("LBL_PATH"),
    readOnly: true,
    dataIndex: "displaypath",
    width: 150,
    sortable: false
  },
  {
    text: bi("LBL_FIELDNAME"),
    dataIndex: "fieldname",
    sortable: false,
    width: 150,
    hidden: true
  },
  {
    id: "columname",
    text: bi("LBL_NAME"),
    dataIndex: "name",
    sortable: false,
    width: 150,
    editor: new Ext.form.TextField()
  },
  {
    text: bi("LBL_JOIN_TYPE"),
    readOnly: true,
    dataIndex: "jointype",
    width: 70,
    sortable: true,
    hidden: false,
    editor: new Ext.form.ComboBox({
      typeAhead: true,
      triggerAction: "all",
      lazyRender: true,
      mode: "local",
      store: new Ext.data.ArrayStore({
        id: 0,
        fields: ["value", "text"],
        data: [
          ["optional", bi("LBL_JT_OPTIONAL")],
          ["required", bi("LBL_JT_REQUIRED")]
        ]
      }),
      valueField: "value",
      displayField: "text"
    }),
    renderer: function(value) {
      if (value != undefined && value != "-")
        return bi("LBL_JT_" + value.toUpperCase());
      else return value;
    }
  },
  {
    text: bi("LBL_SQLFUNCTION"),
    readOnly: true,
    dataIndex: "sqlfunction",
    width: 90,
    sortable: false,
    hidden: false,
    editor: new Ext.form.ComboBox({
      typeAhead: true,
      triggerAction: "all",
      lazyRender: true,
      mode: "local",
      store: new Ext.data.ArrayStore({
        id: 0,
        fields: ["value", "text"],
        data: [
          ["-", "-"],
          ["SUM", bi("LBL_FUNCTION_SUM")],
          ["COUNT", bi("LBL_FUNCTION_COUNT")],
          ["COUNT_DISTINCT", bi("LBL_FUNCTION_COUNT_DISTINCT")],
          ["MAX", bi("LBL_FUNCTION_MAX")],
          ["MIN", bi("LBL_FUNCTION_MIN")],
          ["AVG", bi("LBL_FUNCTION_AVG")],
          ["GROUP_CONCAT", bi("LBL_FUNCTION_GROUP_CONCAT")],
          ["GROUP_CONASC", bi("LBL_FUNCTION_GROUP_CONASC")],
          ["GROUP_CONDSC", bi("LBL_FUNCTION_GROUP_CONDSC")]
        ]
      }),
      valueField: "value",
      displayField: "text"
    }),
    renderer: function(value) {
      if (value != undefined && value != "-")
        return bi("LBL_FUNCTION_" + value.toUpperCase());
      else return value;
    }
  },
  {
    text: bi("LBL_CUSTOMSQLFUNCTION"),
    readOnly: true,
    dataIndex: "customsqlfunction",
    id: "customsqlfunction",
    width: 70,
    sortable: false,
    hidden: false,
    editor: new Ext.form.TextField(),
    renderer: "base64Renderer"
  },
  {
    text: bi("LBL_VALUETYPE"),
    readOnly: true,
    dataIndex: "valuetype",
    width: 70,
    sortable: false,
    hidden: false,
    editor: new Ext.form.ComboBox({
      typeAhead: true,
      triggerAction: "all",
      lazyRender: true,
      mode: "local",
      store: new Ext.data.ArrayStore({
        id: 0,
        fields: ["value", "text"],
        data: [
          ["-", "-"],
          ["TOFSUM", bi("LBL_VALUETYPE_TOFSUM")],
          ["POFSUM", bi("LBL_VALUETYPE_POFSUM")],
          ["POFCOUNT", bi("LBL_VALUETYPE_POFCOUNT")],
          ["POFAVG", bi("LBL_VALUETYPE_POFAVG")],
          ["DOFSUM", bi("LBL_VALUETYPE_DOFSUM")],
          ["DOFCOUNT", bi("LBL_VALUETYPE_DOFCOUNT")],
          ["DOFAVG", bi("LBL_VALUETYPE_DOFAVG")],
          ["C", bi("LBL_VALUETYPE_C")]
        ]
      }),
      valueField: "value",
      displayField: "text"
    }),
    renderer: function(value) {
      if (value != undefined && value != "-" && value != "")
        return bi("LBL_VALUETYPE_" + value.toUpperCase());
      else return value;
    }
  },
  {
    text: bi("LBL_GROUPBY"),
    readOnly: true,
    dataIndex: "groupby",
    width: 50,
    sortable: true,
    hidden: false,
    editor: new Ext.form.ComboBox({
      typeAhead: true,
      triggerAction: "all",
      lazyRender: true,
      mode: "local",
      store: new Ext.data.ArrayStore({
        id: 0,
        fields: ["value", "text"],
        data: [["no", bi("LBL_NO")], ["yes", bi("LBL_YES")]]
      }),
      valueField: "value",
      displayField: "text"
    }),
    renderer: function(value) {
      if (value != undefined) return bi("LBL_" + value.toUpperCase());
      else return value;
    }
  },
  {
    id: "fixedvalue",
    text: bi("LBL_FIXEDVALUE"),
    dataIndex: "fixedvalue",
    sortable: false,
    width: 80,
    editor: new Ext.form.TextField()
  },
  {
    id: "assigntovalue",
    text: bi("LBL_ASSIGNTOVALUE"),
    dataIndex: "assigntovalue",
    sortable: false,
    width: 60,
    editor: new Ext.form.TextField(),
    hidden: false
  },
  {
    id: "formulavalue",
    text: bi("LBL_FORMULAVALUE"),
    dataIndex: "formulavalue",
    sortable: false,
    width: 180,
    editor: new Ext.form.field.Text({
      listeners: {
        focus: function(tf) {
          if (tf.getValue() != undefined && tf.getValue() != "") {
            tf.setValue(K.kreports.decode64(tf.getValue()));
          }
        }
      }
    }),
    renderer: "base64Renderer",
    hidden: false
  },
  {
    id: "formulasequence",
    text: bi("LBL_FORMULASEQUENCE"),
    dataIndex: "formulasequence",
    sortable: false,
    width: 30,
    editor: new Ext.form.NumberField(),
    hidden: false
  }
];
var listGridDownButton = new Ext.Button({
  text: bi("LBL_DOWN"),
  icon: "modules/KReports/images/arrow_down.png"
});
K.kreports.mainListGrid.listGrid = new Ext.grid.Panel({
  store: listGridStore,
  border: false,
  columns: K.kreports.mainListGrid.listColumns,
  plugins: [
    Ext.create("Ext.grid.plugin.CellEditing", {
      clicksToEdit: 1,
      listeners: {
        beforeedit: function(editor, e) {
          if (
            e.column.id == "formulavalue" ||
            e.column.id == "customsqlfunction"
          ) {
            K.kreports.mainListGrid.editorWindow.record = e.record;
            K.kreports.mainListGrid.editorWindow.editedField = e.column.id;
            K.kreports.mainListGrid.editorWindow.editedFieldText =
              e.column.text;
            K.kreports.mainListGrid.editorWindow.show();
            return false;
            if (e.value != undefined && e.value != "") {
            }
          }
        },
        edit: function(editor, e) {
          if (e.column.id == "formulavalue")
            e.record.set("formulavalue", K.kreports.encode64(e.value));
        }
      }
    })
  ],
  sm: new Ext.selection.RowModel(),
  viewConfig: {
    plugins: {
      dropGroup: "moduleFields",
      dragGroup: "moduleFields",
      ptype: "gridviewdragdrop",
      enableDrop: true
    },
    markDirty: false,
    listeners: {
      beforedrop: function(
        node,
        data,
        overModel,
        dropPosition,
        dropFunctions,
        eOpts
      ) {
        if (
          data.records[0].$className ==
          "K.kreports.EditViewFieldgrid.FieldsDataModel"
        ) {
          for (
            var recordCounter = 0;
            recordCounter < data.records.length;
            recordCounter++
          ) {
            var storeIndex = this.getStore().indexOf(overModel);
            if (dropPosition == "after") storeIndex++;
            if (storeIndex == this.getStore().count())
              this.getStore().add({
                fieldid: kGuid(),
                path:
                  activeTreeNodePath +
                  "::" +
                  data.records[recordCounter].data.id,
                displaypath: FieldsListingEditorGrid.title,
                fieldname: data.records[recordCounter].data.name,
                name: data.records[recordCounter].data.name,
                display: "yes",
                sequence: this.getStore().getNextSequence(),
                width: "100",
                sort: "-",
                sortpriority: "",
                jointype: "required",
                sqlfunction: "-",
                summaryfunction: "",
                groupby: "no",
                link: "no",
                fixedvalue: ""
              });
            else
              this.getStore().insert(storeIndex, {
                fieldid: kGuid(),
                path:
                  activeTreeNodePath +
                  "::" +
                  data.records[recordCounter].data.id,
                displaypath: FieldsListingEditorGrid.title,
                fieldname: data.records[recordCounter].data.name,
                name: data.records[recordCounter].data.name,
                display: "yes",
                sequence: this.getStore().getNextSequence(),
                width: "100",
                sort: "-",
                sortpriority: "",
                jointype: "required",
                sqlfunction: "-",
                summaryfunction: "",
                groupby: "no",
                link: "no",
                fixedvalue: ""
              });
            this.getStore().ax();
          }
          dropFunctions.cancelDrop();
          return true;
        } else {
          var T = this.getStore();
          var be = 0;
          switch (dropPosition) {
            case "after":
              be = Number(overModel.get("sequence")) + 1;
              break;
            case "before":
              be = Number(overModel.get("sequence"));
              break;
          }
          for (
            var i = Number(data.records[0].get("sequence"));
            i < be - 1;
            i++
          ) {
            if (T.getAt(i).get("sequence") != data.records[0].data.sequence) {
              var aC = Number(T.getAt(i).get("sequence")) - 1;
              if (aC < 10) aC = "0" + aC;
              T.getAt(i).set("sequence", aC);
            }
          }
          for (var i = be - 1; i < T.getCount(); i++) {
            if (T.getAt(i).get("sequence") != data.records[0].data.sequence) {
              var aC = Number(T.getAt(i).get("sequence")) + 1;
              if (aC < 10) aC = "0" + aC;
              T.getAt(i).set("sequence", aC);
            }
          }
          if (be < 10) be = "0" + be;
          data.records[0].set("sequence", be);
          T.sort("sequence", "ASC");
          T.ax();
          dropFunctions.cancelDrop();
          return true;
        }
      },
      drop: function() {}
    }
  },
  stripeRows: true,
  width: "100%",
  tbar: new Ext.Toolbar({
    items: [
      {
        text: bi("LBL_ADDEMTPY_BUTTON_LABEL"),
        icon: "modules/KReports/images/add.png",
        handler: function() {
          listGridStore.add({
            fieldid: kGuid(),
            name: "enter name",
            path: "",
            displaypath: "",
            display: "yes",
            sequence: listGridStore.getNextSequence(),
            width: "100",
            sort: "-",
            sortpriority: "",
            jointype: "required",
            sqlfunction: "-",
            groupby: "no",
            link: "no",
            fixedvalue: ""
          });
        }
      },
      {
        text: bi("LBL_DELETE_BUTTON_LABEL"),
        icon: "modules/KReports/images/delete.png",
        handler: function() {
          listGridStore.remove(
            K.kreports.mainListGrid.listGrid.getSelectionModel().getSelection()
          );
        }
      },
      "-",
      {
        xtype: "numberfield",
        width: 200,
        allowDecimals: false,
        minValue: 0,
        fieldLabel: bi("LBL_SELECTION_LIMIT"),
        id: "listgridSelectionLimit",
        listeners: {
          change: function(value) {
            if (Ext.getCmp("listgridSelectionLimit").getValue() > 0)
              document.getElementById("selectionlimit").value =
                Ext.getCmp("listgridSelectionLimit").getValue() +
                " " +
                Ext.getCmp("listgridSelectionLimType").getValue();
            else document.getElementById("selectionlimit").value = "";
          },
          render: function() {
            if (document.getElementById("selectionlimit").value != "") {
              Ext.getCmp("listgridSelectionLimit").setRawValue(
                document.getElementById("selectionlimit").value.split(" ")[0]
              );
            }
          }
        }
      },
      {
        xtype: "combobox",
        id: "listgridSelectionLimType",
        typeAhead: true,
        triggerAction: "all",
        width: 100,
        lazyRender: true,
        mode: "local",
        store: new Ext.data.ArrayStore({
          id: 0,
          fields: ["value", "text"],
          data: [["r", bi("LBL_RECORDS")], ["p", bi("LBL_PERCENTAGE")]]
        }),
        valueField: "value",
        displayField: "text",
        listeners: {
          change: function(value) {
            if (Ext.getCmp("listgridSelectionLimit").getValue() > 0)
              document.getElementById("selectionlimit").value =
                Ext.getCmp("listgridSelectionLimit").getValue() +
                " " +
                Ext.getCmp("listgridSelectionLimType").getValue();
            else document.getElementById("selectionlimit").value = "";
          },
          render: function() {
            if (document.getElementById("selectionlimit").value != "") {
              Ext.getCmp("listgridSelectionLimType").setValue(
                document.getElementById("selectionlimit").value.split(" ")[1]
              );
            }
          }
        }
      }
    ]
  })
});
Ext.namespace("K.kreports.unionList");
Ext.define("K.kreports.unionList.unionListGridModel", {
  extend: "Ext.data.Model",
  fields: [
    { name: "joinid", mapping: "joinid" },
    { name: "fieldid", mapping: "fieldid" },
    { name: "sequence", mapping: "sequence" },
    { name: "name", mapping: "name" },
    { name: "unionfieldpath", mapping: "unionfieldpath" },
    { name: "unionfielddisplaypath", mapping: "unionfielddisplaypath" },
    { name: "unionfieldname", mapping: "unionfieldname" },
    { name: "path", mapping: "path" },
    { name: "displaypath", mapping: "displaypath" },
    { name: "fixedvalue", mapping: "fixedvalue" }
  ]
});
K.kreports.unionList.unionListGridStore = new K.kreports.kreportsJsonStore({
  model: K.kreports.unionList.unionListGridModel,
  domElement: "unionlistfields",
  deleteWithUnionId: function(nodeID) {
    this.clearFilter();
    var i = this.find("joinid", nodeID);
    while (i != -1) {
      this.removeAt(i);
      i = this.find("joinid", nodeID);
    }
    this.clearFilter();
  },
  listeners: {
    load: function(T) {
      T.each(function(cr) {
        listFieldRecord = listGridStore.getAt(
          listGridStore.find("fieldid", cr.data.fieldid)
        );
        cr.data.name = listFieldRecord.data.name;
        cr.data.sequence = listFieldRecord.data.sequence;
        cr.data.path = listFieldRecord.data.path;
        cr.data.displaypath = listFieldRecord.data.displaypath;
      });
    }
  }
});
K.kreports.unionList.thisUnionID = "";
K.kreports.unionList.aw = function(co) {
  K.kreports.unionList.thisUnionID = co;
  function aULR(r) {
    K.kreports.unionList.unionListGridStore.add({
      joinid: K.kreports.unionList.thisUnionID,
      fieldid: r.data.fieldid,
      sequence: r.data.sequence,
      unionfieldpath: "",
      unionfielddisplaypath: "",
      unionfieldname: "",
      fixedvalue: "",
      name: r.data.name,
      path: r.data.path,
      displaypath: r.data.displaypath
    });
  }
  listGridStore.each(aULR);
};
K.kreports.unionList.unionListColumns = [
  {
    text: bi("LBL_PATH"),
    dataIndex: "displaypath",
    width: 150,
    sortable: false
  },
  { text: bi("LBL_NAME"), dataIndex: "name", sortable: false, width: 100 },
  { text: "unionfieldpath", dataIndex: "unionfieldpath", width: 100 },
  {
    text: bi("LBL_UNIONFIELDDISPLAYPATH"),
    dataIndex: "unionfielddisplaypath",
    width: 150,
    sortable: false
  },
  {
    text: bi("LBL_UNIONFIELDNAME"),
    dataIndex: "unionfieldname",
    width: 100,
    sortable: false
  },
  {
    text: bi("LBL_FIXEDVALUE"),
    dataIndex: "fixedvalue",
    sortable: false,
    width: 80,
    editor: new Ext.form.TextField()
  }
];
K.kreports.unionList.unionListGrid = new Ext.grid.Panel({
  store: K.kreports.unionList.unionListGridStore,
  columns: K.kreports.unionList.unionListColumns,
  sm: new Ext.selection.RowModel(),
  plugins: [Ext.create("Ext.grid.plugin.CellEditing", { clicksToEdit: 1 })],
  viewConfig: {
    stripeRows: true,
    markDirty: false,
    plugins: {
      dropGroup: "moduleFields",
      dragGroup: "moduleFields",
      ptype: "gridviewdragdrop",
      enableDrop: true
    },
    listeners: {
      beforedrop: function(
        node,
        data,
        overModel,
        dropPosition,
        dropFunctions,
        eOpts
      ) {
        Ext.define("unionPopupFieldsModel", {
          extend: "Ext.data.Model",
          fields: [
            { name: "fieldid", mapping: "fieldid" },
            { name: "name", mapping: "name" },
            { name: "unionfielddisplaypath", mapping: "unionfielddisplaypath" },
            { name: "unionfieldname", mapping: "unionfieldname" }
          ]
        });
        var dz = new Ext.data.Store({ model: unionPopupFieldsModel });
        function addUnionPopupRow(record, index, allItems) {
          dz.add({
            fieldid: record.get("fieldid"),
            name: record.get("name"),
            unionfielddisplaypath: record.get("unionfielddisplaypath"),
            unionfieldname: record.get("unionfieldname")
          });
        }
        K.kreports.unionList.unionListGridStore.each(addUnionPopupRow);
        draggedRecord = data.records[0];
        var cO = new Ext.grid.Panel({
          store: dz,
          columns: [
            { hidden: true, dataIndex: "fieldid" },
            {
              text: bi("LBL_NAME"),
              dataIndex: "name",
              flex: 1,
              header: bi("LBL_MULTISELECT_TEXT_HEADER")
            },
            {
              text: bi("LBL_UNIONFIELDDISPLAYPATH"),
              dataIndex: "unionfielddisplaypath",
              width: 150,
              sortable: false
            },
            {
              text: bi("LBL_UNIONFIELDNAME"),
              dataIndex: "unionfieldname",
              width: 150,
              sortable: false
            }
          ],
          selModel: new Ext.selection.RowModel({ mode: "SINGLE" }),
          stripeRows: true,
          autoExpandColumn: "name",
          height: 350,
          width: 400
        });
        var setPathFromDialog = function() {
          win.hide();
          var cL = cO.getSelectionModel().getSelection();
          var cY = K.kreports.unionList.unionListGridStore.find(
            "fieldid",
            cL[0].get("fieldid")
          );
          var record = K.kreports.unionList.unionListGridStore.getAt(cY);
          record.set(
            "unionfieldpath",
            K.kreports.unionTree.bw(
              K.kreports.unionTree.unionTreePanel.getSelectionModel().selected
                .items[0]
            ) +
              "::" +
              draggedRecord.get("id")
          );
          record.set("unionfieldname", draggedRecord.data.name);
          record.set(
            "unionfielddisplaypath",
            K.kreports.unionTree.bc(
              K.kreports.unionTree.unionTreePanel.getSelectionModel().selected
                .items[0]
            )
          );
        };
        cO.on("celldblclick", setPathFromDialog);
        var win = new Ext.Window({
          title: bi("LBL_MUTLISELECT_POPUP_TITLE"),
          layout: "fit",
          width: 500,
          height: 300,
          closeAction: "hide",
          plain: true,
          draggable: true,
          modal: true,
          items: cO,
          buttons: [
            {
              text: bi("LBL_MUTLISELECT_CANCEL_BUTTON"),
              handler: function() {
                win.hide();
              }
            },
            {
              text: bi("LBL_MUTLISELECT_CLOSE_BUTTON"),
              handler: setPathFromDialog
            }
          ]
        });
        win.show(this);
        dropFunctions.cancelDrop();
        return true;
      }
    }
  },
  hidden: true
});
Ext.namespace("K.kreports.EditViewFieldgrid");
Ext.define("K.kreports.EditViewFieldgrid.FieldsDataModel", {
  extend: "Ext.data.Model",
  fields: [
    { name: "id", type: "string" },
    { name: "text", type: "string" },
    { name: "name", type: "string" },
    { name: "type", type: "string" },
    { name: "leaf", type: "boolean" }
  ]
});
K.kreports.EditViewFieldgrid.FieldsDataStore = new Ext.data.Store({
  model: K.kreports.EditViewFieldgrid.FieldsDataModel,
  proxy: {
    type: "ajax",
    url: "index.php?module=KReports&action=get_fields&to_pdf=true",
    reader: { type: "json" }
  },
  sortOnLoad: false,
  loadByNodeId: function(node) {
    K.kreports.EditViewFieldgrid.FieldsDataStore.getProxy().extraParams.nodeid = node.get(
      "id"
    );
    K.kreports.EditViewFieldgrid.FieldsDataStore.load();
    FieldsListingEditorGrid.setTitle(at(node));
    K.kreports.EditViewFieldgrid.searchField.setValue("");
    K.kreports.EditViewFieldgrid.FieldsDataStore.clearFilter(true);
  }
});
K.kreports.EditViewFieldgrid.FieldsColumns = [
  {
    text: "Fieldname",
    dataIndex: "text",
    width: 150,
    sortable: true,
    hidden: true
  },
  { text: "Type", dataIndex: "type", width: 100, sortable: true, hidden: true },
  { text: "Name", dataIndex: "name", sortable: true, width: 150 }
];
K.kreports.EditViewFieldgrid.searchField = new Ext.form.field.Text({
  enableKeyEvents: true,
  emptyText: bi("LBL_ENTER_SEARCH_TERM"),
  listeners: {
    keyup: function() {
      K.kreports.EditViewFieldgrid.FieldsDataStore.clearFilter(true);
      K.kreports.EditViewFieldgrid.FieldsDataStore.filter(
        "name",
        new RegExp(K.kreports.EditViewFieldgrid.searchField.getValue(), "i")
      );
    }
  }
});
FieldsListingEditorGrid = new Ext.grid.Panel({
  title: "select a module",
  store: K.kreports.EditViewFieldgrid.FieldsDataStore,
  columns: K.kreports.EditViewFieldgrid.FieldsColumns,
  selModel: new Ext.selection.RowModel({ mode: "SINGLE" }),
  flex: 1,
  height: 200,
  loadMask: true,
  region: "south",
  width: 200,
  maxSize: 200,
  frame: false,
  border: false,
  viewConfig: {
    stripeRows: true,
    forcefit: true,
    plugins: {
      dragGroup: "moduleFields",
      ptype: "gridviewdragdrop",
      enableDrop: false
    }
  },
  tbar: new Ext.Toolbar({ items: [K.kreports.EditViewFieldgrid.searchField] })
});
var bu = function(node) {
  var currentPath = node.get("id");
  var currentNode = node;
  while (currentNode.parentNode) {
    currentNode = currentNode.parentNode;
    currentPath = currentNode.get("id") + "::" + currentPath;
  }
  return currentPath;
};
var activeTreeNodePath = "";
var at = function(node) {
  activeTreeNodePath = bu(node);
  var currentPath = node.get("text");
  var currentNode = node;
  while (
    currentNode.parentNode &&
    currentNode.parentNode.get("id") != "unionroot"
  ) {
    currentNode = currentNode.parentNode;
    currentPath = currentNode.get("text") + "::" + currentPath;
  }
  return currentPath;
};
K.kreports.EditViewModuletree.modulesTreeStore = new Ext.data.TreeStore({
  proxy: {
    type: "ajax",
    url: "index.php?module=KReports&action=get_nodes&to_pdf=true",
    extraParams: { requester: "TREE" }
  },
  listeners: {
    beforeload: function(dx, node) {},
    load: function(dL, node) {
      K.kreports.EditViewFieldgrid.FieldsDataStore.getProxy().extraParams.nodeid =
        node.data.id;
      K.kreports.EditViewFieldgrid.FieldsDataStore.load();
    }
  },
  setInitialRootNode: function(root) {
    this.setRootNode({ text: root, draggable: false, id: "root:" + root });
    K.kreports.EditViewFieldgrid.FieldsDataStore.removeAll();
    K.kreports.EditViewFieldgrid.FieldsDataStore.loadByNodeId(
      mainModuleTreePanel.getStore().getRootNode()
    );
    document.getElementById("report_module").value = root;
    K.kreports.EditViewModuletree.modulesCombo.disable();
  }
});
Ext.define("K.kreports.EditViewModuletree.modulesModel", {
  extend: "Ext.data.Model",
  fields: [{ name: "module" }, { name: "description" }]
});
K.kreports.EditViewModuletree.modulesModel.modulesStore = new Ext.data.Store({
  model: K.kreports.EditViewModuletree.modulesModel,
  proxy: {
    type: "ajax",
    url: "index.php?module=KReports&action=get_modules&to_pdf=true",
    reader: { type: "json" }
  }
});
K.kreports.EditViewModuletree.modulesModel.modulesStore.load();
K.kreports.EditViewModuletree.modulesCombo = new Ext.form.ComboBox({
  store: K.kreports.EditViewModuletree.modulesModel.modulesStore,
  id: "module_combo",
  name: "module_combo",
  valueField: "module",
  displayField: "description",
  typeAhead: true,
  queryMode: "local",
  triggerAction: "all",
  emptyText: bi("LBL_SELECT_MODULE"),
  selectOnFocus: true,
  width: 135,
  listeners: {
    select: function() {
      K.kreports.EditViewModuletree.modulesTreeStore.setInitialRootNode(
        K.kreports.EditViewModuletree.modulesCombo.value
      );
    }
  },
  initializeCombo: function() {
    if (Ext.get("report_module").dom.value != "") {
      K.kreports.EditViewModuletree.modulesCombo.setValue(
        Ext.get("report_module").dom.value
      );
      K.kreports.EditViewModuletree.modulesCombo.fireEvent("select");
    }
  }
});
var mainModuleTreePanel = new Ext.tree.TreePanel({
  title: "Modules",
  id: "tree-panel",
  border: false,
  flex: 1,
  height: 300,
  width: 200,
  minSize: 100,
  autoScroll: true,
  rootVisible: true,
  lines: false,
  singleExpand: true,
  useArrows: true,
  enableDragDrop: false,
  store: K.kreports.EditViewModuletree.modulesTreeStore,
  tbar: new Ext.Toolbar({
    items: [K.kreports.EditViewModuletree.modulesCombo]
  }),
  listeners: {
    expandnode: function(node) {
      K.kreports.EditViewFieldgrid.FieldsDataStore.loadByNodeId(node);
    },
    itemclick: function(m, cr) {
      K.kreports.EditViewFieldgrid.FieldsDataStore.loadByNodeId(cr);
    },
    expand: function() {
      K.kreports.mainListGrid.listGrid.show();
      K.kreports.unionList.unionListGrid.hide();
      K.kreports.EditViewFieldgrid.FieldsDataStore.loadByNodeId(
        K.kreports.EditViewModuletree.modulesTreeStore.getRootNode()
      );
      mainModuleTreePanel
        .getSelectionModel()
        .select(K.kreports.EditViewModuletree.modulesTreeStore.getRootNode());
      initialTreeBuild();
    }
  }
});
Ext.namespace("K.kreports.unionTree");
K.kreports.EditViewUniontree.unionTreeStore = new Ext.data.TreeStore({
  proxy: {
    type: "ajax",
    url: "index.php?module=KReports&action=get_nodes&to_pdf=true",
    extraParams: { requester: "TREE" }
  },
  root: { text: "unionroot", draggable: false, id: "unionroot" }
});
Ext.define("K.kreports.EditViewUniontree.unionmoduleModel", {
  extend: "Ext.data.Model",
  fields: [
    { name: "unionid", mapping: "unionid" },
    { name: "module", mapping: "module" }
  ]
});
K.kreports.EditViewUniontree.unionmodulesStore = new K.kreports
  .kreportsJsonStore({
  model: K.kreports.EditViewUniontree.unionmoduleModel,
  domElement: "union_modules",
  addRecordsToUnion: function(records) {
    for (itemIndex = 0; itemIndex < this.data.items.length; itemIndex++) {
      if (records.length) {
        for (cY = 0; cY < records.length; cY++) {
          K.kreports.unionList.unionListGridStore.add({
            joinid: this.data.items[itemIndex].data.unionid,
            fieldid: records[cY].get("fieldid"),
            sequence: records[cY].get("sequence"),
            name: records[cY].get("name"),
            path: records[cY].get("path"),
            displaypath: records[cY].get("displaypath")
          });
        }
      } else {
        K.kreports.unionList.unionListGridStore.add({
          joinid: this.data.items[itemIndex].data.unionid,
          fieldid: records.fieldid,
          sequence: records.sequence,
          name: records.name,
          path: records.path,
          displaypath: records.displaypath
        });
      }
    }
    K.kreports.unionList.unionListGridStore.filter(
      "joinid",
      K.kreports.unionTree.bd()
    );
  },
  insertRecordsInUnion: function(position, records) {
    for (itemIndex = 0; itemIndex < this.data.items.length; itemIndex++) {
      if (records.length) {
        for (cY = 0; cY < records.length; cY++) {
          K.kreports.unionList.unionListGridStore.insert(position, {
            joinid: this.data.items[itemIndex].data.unionid,
            fieldid: records[cY].get("fieldid"),
            sequence: records[cY].get("sequence"),
            name: records[cY].get("name"),
            path: records[cY].get("path"),
            displaypath: records[cY].get("displaypath")
          });
        }
      } else {
        K.kreports.unionList.unionListGridStore.insert(position, {
          joinid: this.data.items[itemIndex].data.unionid,
          fieldid: records.fieldid,
          sequence: records.sequence,
          name: records.name,
          path: records.path,
          displaypath: records.displaypath
        });
      }
    }
    K.kreports.unionList.unionListGridStore.filter(
      "joinid",
      K.kreports.unionTree.bd()
    );
  },
  removeRecordsFromUnion: function(record) {
    if (record != undefined) {
      K.kreports.unionList.unionListGridStore.clearFilter(true);
      while (
        K.kreports.unionList.unionListGridStore.find(
          "fieldid",
          record[0].get("fieldid")
        ) != -1
      ) {
        K.kreports.unionList.unionListGridStore.remove(
          K.kreports.unionList.unionListGridStore.getAt(
            K.kreports.unionList.unionListGridStore.find(
              "fieldid",
              record[0].get("fieldid")
            )
          )
        );
      }
      K.kreports.unionList.unionListGridStore.filter(
        "joinid",
        K.kreports.unionTree.bd()
      );
    }
  },
  updateRecordsFromUnion: function(record) {
    K.kreports.unionList.unionListGridStore.clearFilter();
    var startIndex = 0;
    while (
      K.kreports.unionList.unionListGridStore.find(
        "fieldid",
        record.get("fieldid"),
        startIndex
      ) >= 0
    ) {
      dQ = K.kreports.unionList.unionListGridStore.getAt(
        K.kreports.unionList.unionListGridStore.find(
          "fieldid",
          record.get("fieldid"),
          startIndex
        )
      );
      dQ.set({
        sequence: record.get("sequence"),
        name: record.get("name"),
        path: record.get("path"),
        displaypath: record.get("displaypath")
      });
      startIndex = K.kreports.unionList.unionListGridStore.indexOf(dQ) + 1;
    }
    K.kreports.unionList.unionListGridStore.sort("sequence", "ASC");
    K.kreports.unionList.unionListGridStore.filter(
      "joinid",
      K.kreports.unionTree.bd()
    );
  }
});
var unionModules = "";
K.kreports.unionTree.bK = function() {
  K.kreports.EditViewUniontree.unionmodulesStore.loadDirect();
  for (
    i = 0;
    i < K.kreports.EditViewUniontree.unionmodulesStore.getCount();
    i++
  ) {
    K.kreports.EditViewUniontree.unionTreeStore
      .getRootNode()
      .appendChild({
        text: K.kreports.EditViewUniontree.unionmodulesStore
          .getAt(i)
          .get("module"),
        draggable: false,
        id:
          "union" +
          K.kreports.EditViewUniontree.unionmodulesStore
            .getAt(i)
            .get("unionid") +
          ":" +
          K.kreports.EditViewUniontree.unionmodulesStore.getAt(i).get("module")
      });
  }
  if (K.kreports.EditViewUniontree.unionmodulesStore.getCount() > 0) {
    K.kreports.unionTree.unionTreePanel
      .getSelectionModel()
      .select(K.kreports.unionTree.unionTreePanel.getRootNode().firstChild);
  }
};
K.kreports.unionTree.bw = function(node) {
  var currentPath = node.get("id");
  var currentNode = node;
  while (
    currentNode.parentNode &&
    currentNode.parentNode.get("id") != "unionroot"
  ) {
    currentNode = currentNode.parentNode;
    currentPath = currentNode.get("id") + "::" + currentPath;
  }
  return currentPath;
};
K.kreports.unionTree.bc = function(node) {
  activeTreeNodePath = bu(node);
  var currentPath = node.get("text");
  var currentNode = node;
  while (
    currentNode.parentNode &&
    currentNode.parentNode.get("id") != "unionroot"
  ) {
    currentNode = currentNode.parentNode;
    currentPath = currentNode.get("text") + "::" + currentPath;
  }
  return currentPath;
};
K.kreports.unionTree.isCurrentNodeUnionRoot = function(node) {
  if (node.parentNode.get("id") == "unionroot") return true;
  else return false;
};
K.kreports.unionTree.aA = function(node) {
  var currentNode = node;
  while (
    currentNode.parentNode &&
    currentNode.parentNode.get("id") != "unionroot"
  ) {
    currentNode = currentNode.parentNode;
  }
  return currentNode;
};
K.kreports.unionTree.bd = function(node) {
  if (node == null || node != undefined) {
    if (K.kreports.EditViewUniontree.unionmodulesStore.getCount() > 0) {
      node = K.kreports.unionTree.unionTreePanel.getSelectionModel().selected
        .items[0];
    } else return "";
  }
  var currentNode = node;
  while (
    currentNode.parentNode &&
    currentNode.parentNode.get("id") != "unionroot"
  ) {
    currentNode = currentNode.parentNode;
  }
  var splitArray = currentNode.get("id").split(":");
  return splitArray[0].replace("union", "");
};
Ext.define("K.kreports.EditViewUniontree.unionModulesComboModel", {
  extend: "Ext.data.Model",
  fields: [{ name: "module" }, { name: "description" }]
});
K.kreports.EditViewUniontree.unionModulesComboStore = new Ext.data.Store({
  model: K.kreports.EditViewUniontree.unionModulesComboModel,
  proxy: {
    type: "ajax",
    url: "index.php?module=KReports&action=get_modules&to_pdf=true",
    reader: { type: "json" }
  }
});
K.kreports.EditViewUniontree.unionModulesComboStore.load();
K.kreports.unionTree.unionModulesCombo = new Ext.form.ComboBox({
  store: K.kreports.EditViewUniontree.unionModulesComboStore,
  id: "union_module_combo",
  name: "union_module_combo",
  valueField: "module",
  displayField: "description",
  typeAhead: true,
  queryMode: "local",
  triggerAction: "all",
  emptyText: "Select a module.",
  selectOnFocus: true,
  width: 100,
  listeners: {
    select: function() {
      K.kreports.EditViewUniontree.unionModulesAddButton.enable();
    }
  }
});
K.kreports.unionTree.unionModulesRemoveButton = new Ext.Button({
  icon: "modules/KReports/images/delete.png",
  handler: function() {
    Ext.Msg.confirm(
      "remove Union Module",
      "remove the Union module and all related definitions",
      function(btn, text) {
        if (btn == "yes") {
          K.kreports.unionList.unionListGridStore.deleteWithUnionId(
            K.kreports.unionTree.bd(
              K.kreports.unionTree.unionTreePanel.getSelectionModel().selected
                .items[0]
            )
          );
          K.kreports.EditViewUniontree.unionmodulesStore.remove(
            K.kreports.EditViewUniontree.unionmodulesStore.getAt(
              K.kreports.EditViewUniontree.unionmodulesStore.find(
                "unionid",
                K.kreports.unionTree.unionTreePanel
                  .getSelectionModel()
                  .getSelection()[0]
                  .get("id")
                  .substring(5, 33)
              )
            )
          );
          K.kreports.unionTree.unionTreePanel
            .getSelectionModel()
            .getSelection()[0]
            .destroy();
          if (
            K.kreports.EditViewUniontree.unionTreeStore
              .getRootNode()
              .hasChildNodes()
          ) {
            K.kreports.unionTree.unionTreePanel
              .getSelectionModel()
              .select(
                K.kreports.EditViewUniontree.unionTreeStore.getRootNode()
                  .childNodes[0]
              );
          }
        }
      }
    );
  }
});
K.kreports.EditViewUniontree.unionModulesAddButton = new Ext.Button({
  icon: "modules/KReports/images/add.png",
  handler: function() {
    var cj = kGuid();
    K.kreports.EditViewUniontree.unionmodulesStore.add({
      unionid: cj,
      module: K.kreports.unionTree.unionModulesCombo.value
    });
    var dv = K.kreports.EditViewUniontree.unionTreeStore
      .getRootNode()
      .appendChild({
        text: K.kreports.unionTree.unionModulesCombo.value,
        draggable: false,
        id: "union" + cj + ":" + K.kreports.unionTree.unionModulesCombo.value
      });
    K.kreports.unionTree.unionTreePanel.getSelectionModel().select(dv);
    K.kreports.unionList.aw(cj);
    K.kreports.unionTree.unionModulesCombo.clearValue();
    K.kreports.EditViewUniontree.unionModulesAddButton.disable();
  },
  disabled: true
});
K.kreports.unionTree.unionTreePanelNodeChange = function() {};
K.kreports.unionTree.unionTreePanel = new Ext.tree.Panel({
  title: bi("LBL_UNIONTREE"),
  id: "uniontree-panel",
  flex: 1,
  split: true,
  width: 200,
  minSize: 100,
  autoScroll: true,
  rootVisible: false,
  lines: false,
  singleExpand: true,
  useArrows: true,
  disabled: false,
  store: K.kreports.EditViewUniontree.unionTreeStore,
  tbar: new Ext.Toolbar({
    items: [
      K.kreports.unionTree.unionModulesRemoveButton,
      "-",
      K.kreports.EditViewUniontree.unionModulesAddButton,
      K.kreports.unionTree.unionModulesCombo
    ]
  }),
  listeners: {
    expand: function() {
      K.kreports.unionList.unionListGrid.show();
      K.kreports.mainListGrid.listGrid.hide();
      if (
        K.kreports.EditViewUniontree.unionTreeStore
          .getRootNode()
          .hasChildNodes()
      ) {
        initialTreeBuild();
        K.kreports.EditViewFieldgrid.FieldsDataStore.loadByNodeId(
          K.kreports.unionTree.unionTreePanel.getSelectionModel().selected
            .items[0]
        );
      }
    },
    append: K.kreports.unionTree.unionTreePanelNodeChange,
    remove: K.kreports.unionTree.unionTreePanelNodeChange,
    select: function(dN, cr) {
      if (cr != null) {
        K.kreports.EditViewFieldgrid.FieldsDataStore.loadByNodeId(cr);
        K.kreports.unionList.unionListGridStore.clearFilter();
        K.kreports.unionList.unionListGridStore.filter(
          "joinid",
          K.kreports.unionTree.bd(cr)
        );
        initialTreeBuild();
      }
    }
  }
});
Ext.namespace("K.kreports.reportOptions");
K.kreports.reportOptions.dialog = new Ext.window.Window({
  title: bi("LBL_REPORT_OPTIONS"),
  width: 450,
  modal: true,
  closeAction: "hide",
  items: [
    {
      xtype: "fieldset",
      title: bi("LBL_AUTH_CHECK"),
      collapsible: false,
      width: 410,
      style: { "margin-left": "5px", "margin-right": "5px" },
      items: [
        {
          xtype: "radiogroup",
          id: "kreportoptionsauthCheck",
          fieldLabel: bi("LBL_AUTH_CHECK"),
          columns: 1,
          items: [
            { boxLabel: bi("LBL_AUTH_FULL"), name: "ac", inputValue: "full" },
            { boxLabel: bi("LBL_AUTH_TOP"), name: "ac", inputValue: "top" },
            { boxLabel: bi("LBL_AUTH_NONE"), name: "ac", inputValue: "none" }
          ]
        },
        {
          xtype: "checkbox",
          id: "kreportoptionsshowDeleted",
          fieldLabel: bi("LBL_SHOW_DELETED")
        }
      ]
    },
    {
      xtype: "fieldset",
      title: bi("LBL_FOLDED_PANELS"),
      collapsible: false,
      width: 410,
      style: { "margin-left": "5px", "margin-right": "5px" },
      items: [
        {
          xtype: "radiogroup",
          id: "kreportoptionsdynOptions",
          fieldLabel: bi("LBL_DYNOPTIONS"),
          items: [
            {
              boxLabel: bi("LBL_PANEL_OPEN"),
              name: "dopt",
              inputValue: "open"
            },
            {
              boxLabel: bi("LBL_PANEL_COLLAPSED"),
              name: "dopt",
              inputValue: "collapsed"
            }
          ]
        },
        {
          xtype: "radiogroup",
          id: "kreportoptionsResults",
          fieldLabel: bi("LBL_RESULTS"),
          items: [
            { boxLabel: bi("LBL_PANEL_OPEN"), name: "rs", inputValue: "open" },
            {
              boxLabel: bi("LBL_PANEL_COLLAPSED"),
              name: "rs",
              inputValue: "collapsed"
            }
          ]
        }
      ]
    },
    {
      xtype: "fieldset",
      title: bi("LBL_DATA_UPDATE"),
      collapsible: false,
      width: 410,
      style: { "margin-left": "5px", "margin-right": "5px" },
      items: [
        {
          xtype: "checkbox",
          id: "kreportoptionsupdateOnRequest",
          fieldLabel: bi("LBL_UPDATE_ON_REQUEST")
        }
      ]
    },
    {
      xtype: "fieldset",
      title: bi("LBL_TOOLBARITEMS_FS"),
      collapsible: false,
      width: 410,
      style: { "margin-left": "5px", "margin-right": "5px" },
      items: [
        {
          xtype: "checkboxgroup",
          columns: 1,
          fieldLabel: bi("LBL_TOOLBARITEMS_SHOW"),
          items: [
            {
              boxLabel: bi("LBL_SHOW_EXPORT"),
              name: "kreportoptionsItemsExport",
              checked: true,
              disabled: true
            },
            {
              boxLabel: bi("LBL_SHOW_SNAPSHOTS"),
              name: "kreportoptionsItemsSnapshot",
              id: "kreportoptionsitemSnapShot"
            },
            {
              boxLabel: bi("LBL_SHOW_TOOLS"),
              name: "kreportoptionsItemsTools",
              id: "kreportoptionsitemTools"
            }
          ]
        }
      ]
    }
  ],
  listeners: {
    show: function() {
      cT = Ext.JSON.decode(document.getElementById("reportoptions").value);
      if (cT.authCheck == undefined) cT.authCheck = "all";
      Ext.getCmp("kreportoptionsauthCheck").setValue({ ac: cT.authCheck });
      if (cT.showDeleted != undefined && cT.showDeleted == true)
        Ext.getCmp("kreportoptionsshowDeleted").setValue(true);
      // STIC-Custom 20230726 AAM - Change behaviour search options panel
      // STIC#1172
      // if (cT.optionsFolded == undefined || cT.optionsFolded == "open")
      if (cT.optionsFolded == undefined || cT.optionsFolded != "collapsed")
      // END STIC-Custom
      Ext.getCmp("kreportoptionsdynOptions").setValue({ dopt: "open" });
      else
        Ext.getCmp("kreportoptionsdynOptions").setValue({ dopt: "collapsed" });
      // STIC-Custom 20230726 AAM - Change behaviour of results panel
      // STIC#1174
      // if (cT.resultsFolded && cT.optionsFolded == "open")
        // Ext.getCmp("kreportoptionsResults").setValue({ rs: "collapsed" });
      // else Ext.getCmp("kreportoptionsResults").setValue({ rs: "open" });
      if (cT.resultsFolded == undefined || cT.resultsFolded != "collapsed")
        Ext.getCmp("kreportoptionsResults").setValue({ rs: "open" });
      else Ext.getCmp("kreportoptionsResults").setValue({ rs: "collapsed" });
      // END STIC-Custom
      if (cT.showSnapshots == undefined || cT.showSnapshots == false)
        Ext.getCmp("kreportoptionsitemSnapShot").setValue(false);
      else Ext.getCmp("kreportoptionsitemSnapShot").setValue(true);
      if (cT.showTools == undefined || cT.showTools == false)
        Ext.getCmp("kreportoptionsitemTools").setValue(true);
      else Ext.getCmp("kreportoptionsitemTools").setValue(true);
      if (cT.updateOnRequest != undefined && cT.updateOnRequest == true)
        Ext.getCmp("kreportoptionsupdateOnRequest").setRawValue(true);
    },
    hide: function() {
      K.kreports.reportOptions.cT = {};
      K.kreports.reportOptions.cT.authCheck = Ext.getCmp(
        "kreportoptionsauthCheck"
      ).getValue().ac;
      K.kreports.reportOptions.cT.showDeleted = Ext.getCmp(
        "kreportoptionsshowDeleted"
      ).getValue();
      K.kreports.reportOptions.cT.optionsFolded = Ext.getCmp(
        "kreportoptionsdynOptions"
      ).getValue().dopt;
      K.kreports.reportOptions.cT.resultsFolded = Ext.getCmp(
        "kreportoptionsResults"
      ).getValue().rs;
      K.kreports.reportOptions.cT.updateOnRequest = Ext.getCmp(
        "kreportoptionsupdateOnRequest"
      ).getValue();
      K.kreports.reportOptions.cT.showSnapshots = Ext.getCmp(
        "kreportoptionsitemSnapShot"
      ).getValue();
      K.kreports.reportOptions.cT.showTools = Ext.getCmp(
        "kreportoptionsitemTools"
      ).getValue();
      document.getElementById("reportoptions").value = Ext.JSON.encode(
        K.kreports.reportOptions.cT
      );
    }
  }
});

// STIC-Custom 20221027 MHP - Remove authorization validation panel if user is not admin
// STIC#897
is_admin = Ext.JSON.decode(document.getElementById("is_admin").value);
if (!is_admin) 
    K.kreports.reportOptions.dialog.items.items.shift();
// END STIC-Custom

Ext.namespace("K.kreports.mainEditToolbar");
Ext.define("K.kreports.mainEditToolbar.usernameModel", {
  extend: "Ext.data.Model",
  fields: [{ name: "value" }, { name: "text" }]
});
K.kreports.mainEditToolbar.username = new Ext.form.field.ComboBox({
  store: new Ext.data.Store({
    model: K.kreports.mainEditToolbar.usernameModel,
    proxy: {
      type: "ajax",
      url: "index.php?module=KReports&action=get_userids&to_pdf=true",
      reader: { type: "json", root: "data" }
    }
  }),
  fieldLabel: bi("LBL_ASSIGNED_USER_LABEL"),
  displayField: "text",
  valueField: "value",
  forceSelection: true,
  listConfig: { minWidth: 250 },
  typeAhead: false,
  loadingText: bi("LBL_SEARCHING"),
  width: 200,
  labelWidth: 50,
  pageSize: 10,
  hideTrigger: false,
  triggerAction: "all",
  initializeFromForm: function() {},
  listeners: {
    select: function(combo) {
      document.getElementById("assigned_user_id").value = combo.getValue();
    },
    beforerender: function() {
      this.initializeFromForm();
    }
  }
});
Ext.define("K.kreports.mainEditToolbar.teamnameModel", {
  extend: "Ext.data.Model",
  fields: [{ name: "value" }, { name: "text" }]
});
K.kreports.mainEditToolbar.teamname = new Ext.form.ComboBox({
  store: new Ext.data.Store({
    model: K.kreports.mainEditToolbar.teamnameModel,
    proxy: {
      type: "ajax",
      url: "index.php?module=KReports&action=get_teamids&to_pdf=true",
      reader: { type: "json", root: "data" }
    }
  }),
  fieldLabel: bi("LBL_ASSIGNED_TEAM_LABEL"),
  displayField: "text",
  valueField: "value",
  forceSelection: true,
  typeAhead: false,
  loadingText: bi("LBL_SEARCHING"),
  width: 200,
  labelWidth: 50,
  listConfig: { minWidth: 250 },
  pageSize: 10,
  hideTrigger: false,
  triggerAction: "all",
  initializeFromForm: function() {
    this.store.add({
      value: document.getElementById("team_id").value,
      text: document.getElementById("team_name").value
    });
    this.setValue(document.getElementById("team_id").value);
  },
  listeners: {
    select: function(combo, record) {
      document.getElementById("team_id").value = record[0].get("value");
    },
    beforerender: function() {
      this.initializeFromForm();
    }
  }
});
Ext.define("K.kreports.mainEditToolbar.securitygroupModel", {
  extend: "Ext.data.Model",
  fields: [{ name: "value" }, { name: "text" }]
});
K.kreports.mainEditToolbar.securitygroup = new Ext.form.ComboBox({
  store: new Ext.data.Store({
    model: K.kreports.mainEditToolbar.securitygroupModel,
    proxy: {
      type: "ajax",
      url: "index.php?module=KReports&action=get_securitygroups&to_pdf=true",
      reader: { type: "json", root: "data" }
    }
  }),
  fieldLabel: bi("LBL_ASSIGNED_SECURITYGROUP_LABEL"),
  displayField: "text",
  valueField: "value",
  forceSelection: true,
  typeAhead: false,
  loadingText: bi("LBL_SEARCHING"),
  width: 200,
  labelWidth: 50,
  listConfig: { minWidth: 250 },
  pageSize: 10,
  hideTrigger: false,
  triggerAction: "all",
  initializeFromForm: function() {
    this.store.add({
      value: document.getElementById("authaccess_id").value,
      text: document.getElementById("authaccess_name").value
    });
    this.setValue(document.getElementById("authaccess_id").value);
  },
  listeners: {
    select: function(combo, record) {
      document.getElementById("authaccess_id").value = record[0].get("value");
    },
    beforerender: function() {
      this.initializeFromForm();
    }
  }
});
Ext.define("K.kreports.mainEditToolbar.korgobjectnameModel", {
  extend: "Ext.data.Model",
  fields: [{ name: "value" }, { name: "text" }]
});
K.kreports.mainEditToolbar.korgobjectname = new Ext.form.ComboBox({
  store: new Ext.data.Store({
    model: K.kreports.mainEditToolbar.korgobjectnameModel,
    proxy: {
      type: "ajax",
      url: "index.php?module=KReports&action=get_korgobjects&to_pdf=true",
      reader: { type: "json", root: "data" }
    }
  }),
  fieldLabel: bi("LBL_KORGOBJECTS_LABEL"),
  displayField: "text",
  valueField: "value",
  forceSelection: true,
  typeAhead: false,
  loadingText: bi("LBL_SEARCHING"),
  width: 200,
  labelWidth: 50,
  listConfig: { minWidth: 250 },
  pageSize: 10,
  hideTrigger: false,
  triggerAction: "all",
  initializeFromForm: function() {
    K.kreports.mainEditToolbar.korgobjectname
      .getStore()
      .add({
        value: document.getElementById("authaccess_id").value,
        text: document.getElementById("authaccess_name").value
      });
    this.setValue(document.getElementById("authaccess_id").value);
  },
  listeners: {
    select: function(combo) {
      document.getElementById("authaccess_id").value = combo.getValue();
    },
    beforerender: function() {
      this.initializeFromForm();
    }
  }
});
K.kreports.mainEditToolbar.reportname = new Ext.form.field.Text({
  width: 200,
  labelWidth: 50,
  fieldLabel: bi("LBL_REPORT_NAME_LABEL"),
  setName: function(btnPressed, reportName) {
    K.kreports.mainEditToolbar.reportname.setValue(reportName);
  },
  listeners: {
    beforerender: function() {
      if (document.getElementById("name").value != "")
        this.setValue(document.getElementById("name").value);
      else {
        this.setValue(bi("LBL_DEFAULT_NAME"));
      }
    },
    change: function() {
      document.getElementById("name").value = this.getValue();
    }
  }
});
if (bi("report_status_options") != "") {
  eval(
    "K.kreports.mainEditToolbar.statusComboOptions = " +
      Ext.util.Format.htmlDecode(bi("report_status_options"))
  );
} else K.kreports.mainEditToolbar.statusComboOptions = [];
K.kreports.mainEditToolbar.statusCombo = new Ext.form.ComboBox({
  typeAhead: true,
  triggerAction: "all",
  lazyRender: true,
  mode: "local",
  store: new Ext.data.ArrayStore({
    fields: ["key", "displayText"],
    data: K.kreports.mainEditToolbar.statusComboOptions
  }),
  valueField: "key",
  displayField: "displayText",
  fieldLabel: bi("LBL_REPORT_STATUS"),
  listeners: {
    beforerender: function() {
      if (document.getElementById("report_status").value != "")
        this.setValue(document.getElementById("report_status").value);
    },
    change: function() {
      document.getElementById("report_status").value = this.getValue();
    }
  }
});
if (bi("report_segmentation_options") != "") {
  eval(
    "K.kreports.mainEditToolbar.scopeComboOptions = " +
      Ext.util.Format.htmlDecode(bi("report_segmentation_options"))
  );
} else K.kreports.mainEditToolbar.scopeComboOptions = [];
K.kreports.mainEditToolbar.scopeCombo = new Ext.form.ComboBox({
  typeAhead: true,
  triggerAction: "all",
  lazyRender: true,
  mode: "local",
  store: new Ext.data.ArrayStore({
    fields: ["key", "displayText"],
    data: K.kreports.mainEditToolbar.scopeComboOptions
  }),
  valueField: "key",
  displayField: "displayText",
  fieldLabel: bi("LBL_REPORT_SEGMENTATION"),
  listeners: {
    beforerender: function() {
      if (document.getElementById("report_segmentation").value != "")
        this.setValue(document.getElementById("report_segmentation").value);
    },
    change: function() {
      document.getElementById("report_segmentation").value = this.getValue();
    }
  }
});
K.kreports.mainEditToolbar.kauthCombo = null;
switch (kreportAuthCheck) {
  case "KAuthObjects":
    K.kreports.mainEditToolbar.kauthCombo =
      K.kreports.mainEditToolbar.korgobjectname;
    break;
  case "SecurityGroups":
    K.kreports.mainEditToolbar.kauthCombo =
      K.kreports.mainEditToolbar.securitygroup;
    break;
  case "PRO":
    K.kreports.mainEditToolbar.kauthCombo = K.kreports.mainEditToolbar.teamname;
    break;
}
K.kreports.mainEditToolbar.Toolbar = new Ext.Toolbar({
  initialize: function() {
    K.kreports.mainEditToolbar.username.setRawValue(
      document.getElementById("assigned_user_name").value
    );
  },
  items: [
    {
      xtype: "button",
      text: bi("LBL_SAVE_BUTTON_LABEL"),
      icon: "modules/KReports/images/save.png",
      handler: function() {
        K.kreports.presentationpanel.mainpanel.savePanel();
        K.kreports.visualizationpanel.mainpanel.savePanel();
        K.kreports.integrationpanel.mainpanel.savePanel();
        listGridStore.writeJson();
        var form = document.getElementById("EditView");
        form.action.value = "Save";
        form.submit();
      },
      disabled: false
    },
    {
      xtype: "button",
      text: bi("LBL_CANCEL_BUTTON_LABEL"),
      icon: "modules/KReports/images/cancel.png",
      handler: function() {
        var form = document.getElementById("EditView");
        if (form.record.value == "") form.action.value = "index";
        else form.action.value = "DetailView";
        form.module.value = "KReports";
        form.submit();
      },
      disabled: false
    },
    "-",
    K.kreports.mainEditToolbar.reportname,
    {
      xtype: "button",
      icon: "modules/KReports/images/longtext.png",
      handler: function() {
        K.kreports.mainEditToolbar.descriptionTextArea = new Ext.form
          .HtmlEditor({});
        K.kreports.mainEditToolbar.descriptionPopupwin = new Ext.Window({
          layout: "fit",
          width: 600,
          height: 400,
          closeAction: "close",
          plain: true,
          title: "Description",
          items: K.kreports.mainEditToolbar.descriptionTextArea,
          listeners: {
            beforeclose: function() {
              document.getElementById(
                "description"
              ).value = K.kreports.mainEditToolbar.descriptionTextArea.getValue();
            }
          }
        });
        K.kreports.mainEditToolbar.descriptionTextArea.setValue(
          document.getElementById("description").value
        );
        K.kreports.mainEditToolbar.descriptionPopupwin.show();
      },
      disabled: false
    },
    "-",
    K.kreports.mainEditToolbar.statusCombo,
    K.kreports.mainEditToolbar.scopeCombo,
    "-",
    K.kreports.mainEditToolbar.username,
    K.kreports.mainEditToolbar.kauthCombo,
    "-",
    {
      text: bi("LBL_REPORT_OPTIONS"),
      icon: "modules/KReports/images/tools.png",
      handler: function() {
        K.kreports.reportOptions.dialog.show();
      }
    },
    "->",
    {
      xtype: "tbtext",
      text: K.kreports.decode64(K.kreports.M),
      style: { fontWeight: "bold", fontStyle: "italic" }
    },
    {
      xtype: "tbitem",
      width: 38,
      html: K.kreports.decode64(K.kreports.H),
      style: { "margin-right": "5px" }
    }
  ]
});
Ext.namespace("K.kreports.presentationpanel");
Ext.define("K.kreports.presentationpanel.pluginsmodel", {
  extend: "Ext.data.Model",
  fields: [
    { name: "id", type: "string" },
    { name: "name", type: "string" },
    { name: "panel", type: "string" }
  ]
});
K.kreports.presentationpanel.pluginsstore = new Ext.data.Store({
  model: K.kreports.presentationpanel.pluginsmodel
});
K.kreports.presentationpanel.modelCombo = new Ext.form.ComboBox({
  store: K.kreports.presentationpanel.pluginsstore,
  name: "group Clause",
  typeAhead: true,
  fieldLabel: bi("LBL_PRESENTATION_PLUGIN"),
  displayField: "name",
  valueField: "id",
  editable: false,
  queryMode: "local",
  triggerAction: "all",
  emptyText: "Select a type.",
  selectOnFocus: true,
  listeners: {
    select: function(bs) {
      document.getElementById("listtype").value = bs.value;
      K.kreports.presentationpanel.panel.removeAll(false);
      K.kreports.presentationpanel.mainpanel.presentationPlugin = bs.value;
      var dh = K.kreports.presentationpanel.pluginsstore.findRecord(
        "id",
        bs.value
      );
      eval(
        "K.kreports.presentationpanel.mainpanel.presentationpanel = K.kreports.presentationpanel.panel.add(" +
          dh.get("panel") +
          ");"
      );
      eval(dh.get("panel") + ".initialize({});");
    }
  }
});
K.kreports.presentationpanel.toolbar = new Ext.Toolbar({
  width: "100%",
  items: [K.kreports.presentationpanel.modelCombo]
});
K.kreports.presentationpanel.panel = new Ext.Panel({
  width: "100%",
  layout: "fit",
  border: false,
  items: []
});
K.kreports.presentationpanel.mainpanel = new Ext.panel.Panel({
  title: bi("LBL_PRESENTATION"),
  icon: "modules/KReports/images/presentation.png",
  layout: "fit",
  border: false,
  presentationPlugin: "",
  presentationpanel: null,
  width: "100%",
  tbar: K.kreports.presentationpanel.toolbar,
  items: [K.kreports.presentationpanel.panel],
  listeners: {
    show: function() {
      if (typeof this.presentationpanel.updateHandler == "function")
        this.presentationpanel.updateHandler();
    }
  },
  initialize: function() {
    var dD = Ext.JSON.decode(kreporterPresentationPlugins);
    for (var dI in dD) {
      if (dD.hasOwnProperty(dI)) {
        K.kreports.presentationpanel.pluginsstore.add({
          id: dI,
          name: bi(dD[dI].displayname),
          panel: dD[dI].panel
        });
      }
    }
    var dM = { plugin: "standard", pluginData: {} };
    if (document.getElementById("presentation_params").value != "")
      dM = Ext.JSON.decode(
        document.getElementById("presentation_params").value
      );
    if (dM.plugin != undefined && dM.plugin != "") {
      K.kreports.presentationpanel.modelCombo.setValue(dM.plugin);
    } else if (document.getElementById("listtype").value != "")
      K.kreports.presentationpanel.modelCombo.setValue(
        document.getElementById("listtype").value
      );
    else {
      K.kreports.presentationpanel.modelCombo.setValue("standard");
    }
    K.kreports.presentationpanel.panel.removeAll(false);
    this.presentationPlugin = K.kreports.presentationpanel.modelCombo.value;
    var dh = K.kreports.presentationpanel.pluginsstore.findRecord(
      "id",
      K.kreports.presentationpanel.modelCombo.value
    );
    eval(
      "this.presentationpanel = K.kreports.presentationpanel.panel.add(" +
        dh.get("panel") +
        ");"
    );
    this.presentationpanel.initialize(dM.pluginData);
  },
  savePanel: function() {
    var dM = { plugin: this.presentationPlugin, pluginData: {} };
    if (typeof this.presentationpanel.getPanelData == "function")
      dM.pluginData = this.presentationpanel.getPanelData();
    document.getElementById("presentation_params").value = Ext.JSON.encode(dM);
  }
});
Ext.namespace("K.kreports.visualizationpanel");
Ext.define("K.kreports.visualizationpanel.pluginsmodel", {
  extend: "Ext.data.Model",
  fields: [
    { name: "id", type: "string" },
    { name: "name", type: "string" },
    { name: "panel", type: "string" }
  ]
});
K.kreports.visualizationpanel.pluginsstore = new Ext.data.Store({
  model: K.kreports.visualizationpanel.pluginsmodel
});
K.kreports.visualizationpanel.pluginCombo = new Ext.form.ComboBox({
  store: K.kreports.visualizationpanel.pluginsstore,
  typeAhead: true,
  fieldLabel: bi("LBL_VISUALIZATIONPLUGIN"),
  value: "googlecharts",
  displayField: "name",
  labelWidth: 50,
  valueField: "id",
  editable: false,
  queryMode: "local",
  triggerAction: "all",
  emptyText: "Select a type.",
  selectOnFocus: true,
  listeners: {
    select: function(bs) {
      K.kreports.visualizationpanel.mainpanel.setPluginPanel(
        bs.getValue(),
        false
      );
    }
  }
});
K.kreports.visualizationpanel.itemIndexSpinner = new Ext.form.field.Spinner({
  value: 0,
  max: 0,
  editable: false,
  width: 100,
  labelWidth: 50,
  fieldLabel: "Item",
  disabled: true,
  onSpinUp: function() {
    var me = this;
    K.kreports.visualizationpanel.mainpanel.setItemData(
      me.getValue(),
      K.kreports.visualizationpanel.pluginCombo.getValue(),
      K.kreports.visualizationpanel.mainpanel.chartPanel.getPanelData()
    );
    if (!me.readOnly) {
      var val = parseInt(me.getValue());
      if (val == me.max) me.setValue(1);
      else me.setValue(val + 1);
    }
    if (
      K.kreports.visualizationpanel.mainpanel.paramsArray[me.getValue()] ==
      undefined
    ) {
      K.kreports.visualizationpanel.mainpanel.paramsArray[
        me.getValue()
      ] = new Object();
      K.kreports.visualizationpanel.mainpanel.paramsArray[
        me.getValue()
      ].plugin =
        "googlecharts";
    }
    K.kreports.visualizationpanel.pluginCombo.setValue(
      K.kreports.visualizationpanel.mainpanel.paramsArray[me.getValue()].plugin
    );
    K.kreports.visualizationpanel.pluginCombo.fireEvent(
      "select",
      K.kreports.visualizationpanel.pluginCombo
    );
  },
  onSpinDown: function() {
    var me = this;
    K.kreports.visualizationpanel.mainpanel.setItemData(
      me.getValue(),
      K.kreports.visualizationpanel.pluginCombo.getValue(),
      K.kreports.visualizationpanel.mainpanel.chartPanel.getPanelData()
    );
    if (!me.readOnly) {
      var val = parseInt(me.getValue());
      if (val == 1 || val == 0) me.setValue(me.max);
      else me.setValue(val - 1);
    }
    if (
      K.kreports.visualizationpanel.mainpanel.paramsArray[me.getValue()] ==
      undefined
    ) {
      K.kreports.visualizationpanel.mainpanel.paramsArray[
        me.getValue()
      ] = new Object();
      K.kreports.visualizationpanel.mainpanel.paramsArray[
        me.getValue()
      ].plugin =
        "googlecharts";
    }
    K.kreports.visualizationpanel.pluginCombo.setValue(
      K.kreports.visualizationpanel.mainpanel.paramsArray[me.getValue()].plugin
    );
    K.kreports.visualizationpanel.pluginCombo.fireEvent(
      "select",
      K.kreports.visualizationpanel.pluginCombo
    );
  },
  setMaxValue: function(cq) {
    this.max = parseInt(cq);
    if (parseInt(this.getValue()) > parseInt(cq)) this.setValue(cq);
    if (this.getValue() == 0 && cq > 0) this.setValue(1);
    if (this.getValue() > 0) {
      if (
        K.kreports.visualizationpanel.mainpanel.paramsArray[this.getValue()] !=
        undefined
      )
        K.kreports.visualizationpanel.pluginCombo.setValue(
          K.kreports.visualizationpanel.mainpanel.paramsArray[this.getValue()]
            .plugin
        );
      else K.kreports.visualizationpanel.pluginCombo.setValue("googlecharts");
      K.kreports.visualizationpanel.pluginCombo.fireEvent(
        "select",
        K.kreports.visualizationpanel.pluginCombo
      );
    }
  }
});
K.kreports.visualizationpanel.itemHeightSpinner = new Ext.form.field.Spinner({
  value: 300,
  max: 600,
  step: 50,
  min: 100,
  editable: false,
  width: 150,
  labelWidth: 70,
  fieldLabel: bi("LBL_VISUALIZATION_HEIGHT"),
  disabled: true,
  onSpinUp: function() {
    var me = this;
    if (!me.readOnly) {
      var val = parseInt(me.getValue());
      if (val == me.max) me.setValue(me.min);
      else me.setValue(val + me.step);
    }
  },
  onSpinDown: function() {
    var me = this;
    if (!me.readOnly) {
      var val = parseInt(me.getValue());
      if (val == me.min) me.setValue(me.max);
      else me.setValue(val - me.step);
    }
  }
});
Ext.define("K.kreports.visualizationpanel.layoutModel", {
  extend: "Ext.data.Model",
  fields: [{ name: "name", type: "string" }, { name: "count", type: "int" }]
}), (K.kreports.visualizationpanel.layoutStore = new Ext.data.Store({
  model: K.kreports.visualizationpanel.layoutModel,
  data: kreportavailablelayouts
}));
K.kreports.visualizationpanel.layoutCombo = new Ext.form.field.ComboBox({
  store: K.kreports.visualizationpanel.layoutStore,
  valueField: "name",
  displayField: "name",
  typeAhead: true,
  width: 170,
  labelWidth: 70,
  fieldLabel: bi("LBL_VISUALIZATIONTOOLBAR_LAYOUT"),
  editable: false,
  queryMode: "local",
  triggerAction: "all",
  selectOnFocus: true,
  value: "-",
  listeners: {
    select: function(bs) {
      if (bs.getValue() != "-") {
        K.kreports.visualizationpanel.itemHeightSpinner.enable(true);
        K.kreports.visualizationpanel.itemIndexSpinner.enable(true);
        K.kreports.visualizationpanel.mainpanel.chartPanel.show();
        K.kreports.visualizationpanel.itemIndexSpinner.setMaxValue(
          this.getStore().findRecord("name", bs.getValue()).get("count")
        );
      } else {
        K.kreports.visualizationpanel.itemIndexSpinner.setMaxValue(0);
        K.kreports.visualizationpanel.itemHeightSpinner.disable(true);
        K.kreports.visualizationpanel.itemIndexSpinner.disable(true);
        K.kreports.visualizationpanel.mainpanel.chartPanel.hide();
      }
    }
  }
});
K.kreports.visualizationpanel.toolbar = new Ext.Toolbar({
  width: "100%",
  items: [
    K.kreports.visualizationpanel.layoutCombo,
    {
      xtype: "button",
      icon: "modules/KReports/images/preview.png",
      handler: function() {
        if (K.kreports.visualizationpanel.layoutCombo.getValue() != "")
          Ext.Ajax.request({
            url:
              "index.php?module=KReports&action=getVisualizationPreview&to_pdf=true&layout=" +
              K.kreports.visualizationpanel.layoutCombo.getValue(),
            params: { id: 1 },
            success: function(response) {
              Ext.create("Ext.window.Window", {
                title: "Preview",
                height: 300,
                width: 600,
                html: response.responseText
              }).show();
            }
          });
      }
    },
    { xtype: "tbseparator" },
    K.kreports.visualizationpanel.itemHeightSpinner,
    K.kreports.visualizationpanel.itemIndexSpinner,
    K.kreports.visualizationpanel.pluginCombo
  ]
});
K.kreports.visualizationpanel.panel = new Ext.Panel({
  width: "100%",
  border: false,
  layout: "fit",
  frame: false,
  items: []
});
K.kreports.visualizationpanel.mainpanel = new Ext.panel.Panel({
  title: bi("LBL_VISUALIZATION"),
  icon: "modules/KReports/images/visualization.png",
  layout: "fit",
  border: false,
  paramsArray: new Object({
    plugin: "googlecharts",
    layout: "-",
    chartheight: 300
  }),
  width: "100%",
  tbar: K.kreports.visualizationpanel.toolbar,
  items: [K.kreports.visualizationpanel.panel],
  initialize: function() {
    if (document.getElementById("visualization_params").value != "")
      this.paramsArray = Ext.JSON.decode(
        document.getElementById("visualization_params").value
      );
    if (this.paramsArray[1] == undefined) {
      this.paramsArray.layout = "-";
      this.paramsArray.height = 300;
    }
    var cx = Ext.JSON.decode(kreporterVisualizationPlugins);
    for (var db in cx) {
      if (cx.hasOwnProperty(db)) {
        K.kreports.visualizationpanel.pluginsstore.add({
          id: db,
          name: bi(cx[db].displayname),
          panel: cx[db].panel
        });
      }
    }
    K.kreports.visualizationpanel.pluginCombo.setValue(this.paramsArray.plugin);
    K.kreports.visualizationpanel.panel.removeAll(false);
    var dh = K.kreports.visualizationpanel.pluginsstore.findRecord(
      "id",
      K.kreports.visualizationpanel.pluginCombo.value
    );
    eval(
      "this.chartPanel = K.kreports.visualizationpanel.panel.add(" +
        dh.get("panel") +
        ");"
    );
    this.chartPanel.hide();
    K.kreports.visualizationpanel.layoutCombo.setValue(this.paramsArray.layout);
    K.kreports.visualizationpanel.layoutCombo.fireEvent(
      "select",
      K.kreports.visualizationpanel.layoutCombo
    );
    if (
      this.paramsArray.height != undefined &&
      this.paramsArray.height != "NaN"
    )
      K.kreports.visualizationpanel.itemHeightSpinner.setValue(
        this.paramsArray.height
      );
    else K.kreports.visualizationpanel.itemHeightSpinner.setValue(300);
  },
  setPluginPanel: function(itemPlugin, saveCurrent) {
    if (saveCurrent)
      this.setItemData(
        K.kreports.visualizationpanel.itemIndexSpinner.getValue(),
        K.kreports.visualizationpanel.pluginCombo.getValue(),
        this.chartPanel.getPanelData()
      );
    K.kreports.visualizationpanel.panel.removeAll(false);
    if (itemPlugin != "" && itemPlugin != undefined) {
      var dh = K.kreports.visualizationpanel.pluginsstore.findRecord(
        "id",
        itemPlugin
      );
      eval(
        "this.chartPanel = K.kreports.visualizationpanel.panel.add(" +
          dh.get("panel") +
          ");"
      );
      K.kreports.visualizationpanel.mainpanel.chartPanel.setPanelData(
        K.kreports.visualizationpanel.mainpanel.getItemData(
          K.kreports.visualizationpanel.itemIndexSpinner.getValue(),
          itemPlugin
        )
      );
    }
  },
  setItemData: function(itemIndex, itemPlugin, itemData) {
    if (this.paramsArray[itemIndex] == undefined)
      this.paramsArray[itemIndex] = new Object();
    this.paramsArray[itemIndex].plugin = itemPlugin;
    this.paramsArray[itemIndex][itemPlugin] = itemData;
  },
  getItemData: function(itemIndex, itemPlugin) {
    var itemData = new Object();
    if (this.paramsArray[itemIndex] == undefined)
      this.paramsArray[itemIndex] = new Object();
    if (this.paramsArray[itemIndex][itemPlugin] == undefined)
      this.paramsArray[itemIndex][itemPlugin] = new Object();
    return this.paramsArray[itemIndex][
      K.kreports.visualizationpanel.pluginCombo.getValue()
    ];
  },
  savePanel: function() {
    if (K.kreports.visualizationpanel.layoutCombo.getValue() != "-")
      this.setItemData(
        K.kreports.visualizationpanel.itemIndexSpinner.getValue(),
        K.kreports.visualizationpanel.pluginCombo.getValue(),
        this.chartPanel.getPanelData()
      );
    this.paramsArray.plugin = K.kreports.visualizationpanel.pluginCombo.getValue();
    this.paramsArray.layout = K.kreports.visualizationpanel.layoutCombo.getValue();
    this.paramsArray.height = K.kreports.visualizationpanel.itemHeightSpinner.getValue();
    document.getElementById("visualization_params").value = Ext.JSON.encode(
      this.paramsArray
    );
  }
});
Ext.namespace("K.kreports.integrationpanel");
Ext.Loader.setPath("Ext.ux", "custom/k/extjs4/ux");
Ext.require(["Ext.ux.CheckColumn"]);
Ext.define("K.kreports.integrationpanel.pluginsmodel", {
  extend: "Ext.data.Model",
  fields: [
    { name: "id", type: "string" },
    { name: "displayname", type: "string" },
    { name: "panel", type: "string" },
    { name: "active", type: "string" }
  ]
});
K.kreports.integrationpanel.pluginsstore = new Ext.data.Store({
  model: K.kreports.integrationpanel.pluginsmodel
});
K.kreports.integrationpanel.pluginGrid = new Ext.grid.Panel({
  width: 300,
  store: K.kreports.integrationpanel.pluginsstore,
  viewConfig: { markDirty: false },
  columns: [
    { text: "id", dataIndex: "id", hidden: true },
    {
      text: bi("LBL_INTEGRATION_PLUGINNAME"),
      dataIndex: "displayname",
      width: 270,
      menuDisabled: true,
      resizable: false,
      sortable: false
    },
    {
      menuDisabled: true,
      resizable: false,
      sortable: false,
      width: 28,
      dataIndex: "active",
      renderer: function(value) {
        switch (value) {
          case "1":
            return '<img src="modules/KReports/images/lightbulb.png"></img>';
            break;
          default:
            return '<img src="modules/KReports/images/lightbulb_off.png"></img>';
            break;
        }
      }
    }
  ],
  listeners: {
    cellclick: function(ca, td, cellIndex, record, tr, rowIndex) {
      if (cellIndex == 2)
        switch (record.get("active")) {
          case "1":
            record.set("active", "0");
            break;
          default:
            record.set("active", "1");
            break;
        }
    },
    select: function(row, model) {
      if (K.kreports.integrationpanel.mainpanel.activePanel != null) {
        K.kreports.integrationpanel.mainpanel.savePluginPanel();
        K.kreports.integrationpanel.pluginPanel.removeAll(false);
      }
      if (model.get("panel") != "") {
        eval(
          "K.kreports.integrationpanel.mainpanel.activePanel = K.kreports.integrationpanel.pluginPanel.add(" +
            model.get("panel") +
            ")"
        );
        K.kreports.integrationpanel.mainpanel.aM();
      } else K.kreports.integrationpanel.mainpanel.activePanel = null;
    }
  }
});
K.kreports.integrationpanel.pluginPanel = new Ext.panel.Panel({
  layout: "fit",
  border: false,
  flex: 1,
  items: []
});
K.kreports.integrationpanel.mainpanel = new Ext.panel.Panel({
  title: bi("LBL_INTEGRATION"),
  icon: "modules/KReports/images/integration.png",
  paramsArray: new Object(),
  layout: { type: "hbox", align: "stretch" },
  border: false,
  width: "100%",
  height: "100%",
  activePanel: null,
  items: [
    K.kreports.integrationpanel.pluginGrid,
    K.kreports.integrationpanel.pluginPanel
  ],
  initialize: function() {
    if (document.getElementById("integration_params").value != "")
      this.paramsArray = Ext.JSON.decode(
        document.getElementById("integration_params").value
      );
    var integrationPlugins = Ext.JSON.decode(kreporterIntegrationPlugins);
    for (var integrationDef in integrationPlugins) {
      if (integrationPlugins.hasOwnProperty(integrationDef)) {
        K.kreports.integrationpanel.pluginsstore.add({
          id: integrationDef,
          displayname:
            bi(integrationPlugins[integrationDef].displayname) != null
              ? bi(integrationPlugins[integrationDef].displayname)
              : integrationDef,
          panel: integrationPlugins[integrationDef].panel,
          active: this.checkPluginActive(integrationDef)
        });
      }
    }
  },
  getPluginData: function(dn) {
    if (this.paramsArray[dn] != undefined) return this.paramsArray[dn];
    else return false;
  },
  checkPluginActive: function(dn) {
    if (
      this.paramsArray.activePlugins != undefined &&
      this.paramsArray.activePlugins[dn] != ""
    )
      return this.paramsArray.activePlugins[dn];
    else return 0;
  },
  aM: function() {
    if (
      this.paramsArray[
        K.kreports.integrationpanel.mainpanel.activePanel.pluginid
      ] != undefined
    ) {
      K.kreports.integrationpanel.mainpanel.activePanel.setPanelData(
        this.paramsArray[
          K.kreports.integrationpanel.mainpanel.activePanel.pluginid
        ]
      );
    }
  },
  savePluginPanel: function() {
    this.paramsArray[
      K.kreports.integrationpanel.mainpanel.activePanel.pluginid
    ] = K.kreports.integrationpanel.mainpanel.activePanel.getPanelData();
  },
  savePanel: function() {
    if (this.activePanel != null) this.savePluginPanel();
    this.paramsArray.activePlugins = new Object();
    for (
      var i = 0;
      i < K.kreports.integrationpanel.pluginsstore.getCount();
      i++
    ) {
      this.paramsArray.activePlugins[
        K.kreports.integrationpanel.pluginsstore.getAt(i).get("id")
      ] = K.kreports.integrationpanel.pluginsstore.getAt(i).get("active");
    }
    document.getElementById("integration_params").value = Ext.JSON.encode(
      this.paramsArray
    );
  },
  listeners: {
    hide: function() {
      this.savePanel();
    }
  }
});
