/**
 * Formulas and Visibility System
 * @package Formulas and Visibility System for SuiteCRM
 * @copyright Antoni Pàmies
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
 * @author Antoni Pàmies <toni@arboli.net>
 */
(function(){
  if (typeof(APO) == 'undefined')
    APO = {};
  if (typeof(APO.forms) == 'undefined')
    APO.forms = {};

  var _fah = APO.forms.AssignmentHandler = function(){}

  _fah.getElement = function( element, inlinetd ){
    if (inlinetd){
      var field = $(apvi_element).closest('tr').find('td[field=' + element + ']');
      // current inline field edit
      if ( field[0] == apvi_element ){
        return $(field[0]).find('[id=' + element  + ']')[0];
      }
      switch ($(field).attr("type")){
        case "name":
          return $(field).find('a')[0];
          break;
        case "enum":
          return $(field)[0];
          break;
        case "bool":
          return $(field)[0].firstElementChild;
          break;
        default: 
          return $(field)[0];
          break;
      }
    } else {
      var field = YAHOO.util.Dom.get(element);
      return field;
    }
  }

  APO.forms = function( name, getbean, beep ){
    this.name = name;
    this.getbean = getbean;
    if (typeof(beep) == 'undefined'){
      this.beep = false;
    } else {
      this.beep = beep;
    }
    this.formulas = new Array();
    this.fields = new Array( new Array(), new Array());
    this.module = module_sugar_grp1;
    if (typeof(action_sugar_grp1) != "string" || action_sugar_grp1 == ""){
      this.view = name;
      this.inlinetd = false;  
    } else {
      if (action_sugar_grp1 == 'index'){
        this.view = name;
        this.inlinetd = true;  
      } else {
        this.view = action_sugar_grp1;
        this.inlinetd = false;  
      }
    }
    if (this.inlinetd){
      if (apvi_element!=null){
        this.id = $(apvi_element).closest('tr').find('[type=checkbox]').attr( "value" );
      } else {
        this.id = "";
      }
    } else {
      this.id = $("input[name=record]").attr( "value" );
    }
  }

  APO.forms.prototype.addPanelVisibility = function( field, fielddeps ) {
    this._addFormula( field, fielddeps, 'panelvisibility', '' );
  }

  APO.forms.prototype.addTabVisibility = function( name, field, fielddeps ) {
    this._addFormula( field, fielddeps, 'tabvisibility', name );
  }

  APO.forms.prototype.addVisibility = function( field, fielddeps ) {
    this._addFormula( field, fielddeps, 'visibility', '' );
  }

  APO.forms.prototype.addFormula = function( field, fielddeps ) {
    this._addFormula( field, fielddeps, 'formula', '' );
  }

  APO.forms.prototype._addFormula = function( field, fielddeps, type, tabname ) {
    if (type == 'tabvisibility'){
      var el = $('#content ul.nav.nav-tabs > li[role=presentation]')[field];
    } else {
      var el = _fah.getElement(field,this.inlinetd);
    }
    if (el){
      switch( type ){
        case 'tabvisibility':
        case 'panelvisibility':
        case 'visibility':
          break;
        case 'formula':
        default:
          if ((this.view == "EditView" || this.name == "InlineEditView") && !this.inlinetd){
            var original = $(el).css("background-color");
            el.disabled = true;
            if (this.view == "EditView"){
              original = this.colorLuminance(this.rgbtohex(original),-0.2);
              $(el).css("background-color", original);
            }
          }
          break;
      }
      if (type == 'tabvisibility' ){
        this.fields[0].push(tabname);
      } else {
        this.fields[0].push(field);
      }
      this.fields[1].push(el);
      if (!(fielddeps instanceof Array)) {
        fielddeps = [fielddeps];
      }
      for (var i = 0; i < fielddeps.length; i++) {
        var eld = _fah.getElement(fielddeps[i],this.inlinetd);
        var notfound = true;
        for (var j = 0; j < this.formulas.length; j++) {
          if(this.formulas[j][0] == fielddeps[i]){
            notfound = false;
            switch( type ){
              case 'tabvisibility':
                this.formulas[j][8].push(el);
                this.formulas[j][9].push(tabname);
                break;
              case 'panelvisibility':
                this.formulas[j][4].push(el);
                this.formulas[j][7].push(field);
                break;
              case 'visibility':
                this.formulas[j][2].push(el);
                this.formulas[j][5].push(field);
                break;
              case 'formula':
              default:
                this.formulas[j][3].push(el);
                this.formulas[j][6].push(field);
                break;
            }
            break;
          }
        }
        if (notfound){
          switch( type ){
            case 'tabvisibility':
              this.formulas.push( [fielddeps[i],eld,[],[],[],[],[],[],[el],[tabname]] );
              break;
            case 'panelvisibility':
              this.formulas.push( [fielddeps[i],eld,[],[],[el],[],[],[field],[],[]] );
              break;
            case 'visibility':
              this.formulas.push( [fielddeps[i],eld,[el],[],[],[field],[],[],[],[]] );
              break;
            case 'formula':
            default:
              this.formulas.push( [fielddeps[i],eld,[],[el],[],[],[field],[],[],[]] );
              break;
          }
        }
      }
    }
  }

  APO.forms.prototype.addTriggers = function( onFormLoad ){
    if (this.view == "EditView" || this.name == "InlineEditView"){
      for (var j = 0; j < this.formulas.length; j++) {
        if (this.formulas[j][1] == null)
          continue;
        if (this.formulas[j][1].type && this.formulas[j][1].type.toUpperCase() == "CHECKBOX") {
          YAHOO.util.Event.addListener(this.formulas[j][1], "click", APO.forms.FireTrigger, this, true);
        } else {
          YAHOO.util.Event.addListener(this.formulas[j][1], "change", APO.forms.FireTrigger, this, true);
        }
      }
    }
    if ( onFormLoad )
      this.OnloadFireTrigger( );
  }

  APO.forms.FireTrigger = function( e ){
    this._FireTrigger( e );
  }

  APO.forms.prototype.OnloadFireTrigger = function(){
    var e = {};
    e.target = {};
    e.target.name = '';
    e.type = 'onFormLoad';
    e.target.value = '';
    this._FireTrigger( e );
  }

  APO.forms.prototype.OnInlineCancelFireTrigger = function(field, value){
    var e = {};
    e.target = {};
    e.target.name = '';
    e.type = 'onInlineCancel';
    e.target.value = '';
    var el = _fah.getElement(field);
    this.setFieldValue( el, value);
    this._FireTrigger( e );
  }

  APO.forms.prototype.getFieldValuebyName = function( name ){
    var el = _fah.getElement(name);
    return this.getFieldValue( el );
  }

  APO.forms.prototype.getFieldValue = function( field ){
    if (field == null || field.tagName == null )
      return null;
    if ( field.tagName == "SELECT" ){
      if (field.selectedIndex == -1) {
        return null;
      } else {
        if (field.multiple){
          var retorna = "^";
          for (var i = 0; i < field.selectedOptions.length; i++) {
            if ( i>0 ){
              retorna += "^";
            }
            retorna += field.selectedOptions[i].value;
          }
          retorna += "^";
          return retorna;
        } else {
          return field.options[field.selectedIndex].value;
        }
      }
    }
    if (field.className && (field.className == "DateTimeCombo" || field.className == "Date")) {
      return SUGAR.util.DateUtils.parse(field.value, "user");
    }
    if (field.tagName == "INPUT" && field.type.toUpperCase() == "CHECKBOX") {
      return field.checked ? '1' : '0';
    }
    if (field.tagName == "SPAN") {
      return document.all ? trim(field.innerText) : trim(field.textContent);
    } 
    if (field.value !== null && typeof(field.value) != "undefined") {
      return field.value;
    }
    return YAHOO.lang.trim(field.innerText);
  }

  APO.forms.prototype.getFieldName = function( field, name ){
    if (this.inlinetd){
      return name;
    }
    if (field.tagName == "SELECT" && field.multiple){
      return field.id;
    }
    if (typeof(field.name) != 'undefined' && field.name != ""){
      return field.name;
    }
    if (typeof(field.id) != 'undefined' && field.id != ""){
      return field.id;
    }
    return name;
  }

  APO.forms.prototype.setFieldValue = function( field, value ){
    if (field.tagName == "SPAN" || field.tagName == "A") {
      field.innerHTML = value;
      field.textContent = value;
      return;
    }
    if ( field.tagName == "SELECT" ){
      if (value == null){
        field.selectedIndex = -1;
        return;
      }  
      if (field.multiple){
        var res = value.split("^");
        $("#"+field.id).val([]);
        for(var j=0; j < res.length; j++){
          if (res[j] == ""){
            continue;
          }
          $("#"+field.id+" option[values='"+res[j]+"']").prop("selected", true);
        }
        return;
      }
    }
    if (field.tagName == "INPUT" && field.type.toUpperCase() == "CHECKBOX") {
      if (value == '1'){
        field.checked = true;
      } else {
        field.checked = false;
      }
      field.value = value;
      return;
    }
    if (typeof(field.type) == 'undefined' || field.type == "" ){
      field.textContent = value;
    }
    field.value = value;
  }

  APO.forms.prototype._FireTrigger = function( e ){
    var valor = "{";
    var fieldsjson = "{";
    var panels = "{";
    var tabs = "{";
    var k = 0;
    var l = 0;
    var m = 0;
    for (var i = 0; i < this.formulas.length; i++) {
      if ( i>0 ){
        valor += ",";
      }
      value = this.getFieldValue( this.formulas[i][1] );
      if ( this.formulas[i][1] == null ){
        valor += '"' + this.formulas[i][0] + '":"__$NULL$__"';
      } else {
        valor += '"' + this.getFieldName(this.formulas[i][1],this.formulas[i][0]) + '":"' + value + '"';
      }
      if (this.formulas[i][0] == e.target.name || e.type == 'onFormLoad' || e.type == 'onInlineCancel' ){
        for (var j = 0; j < this.formulas[i][3].length; j++) {
          if ( k>0 ){
            fieldsjson += ",";
          }
          k = 1;
          fieldsjson += '"' + this.getFieldName(this.formulas[i][3][j],this.formulas[i][6][j]) + '":"' + this.getFieldValue( this.formulas[i][3][j] ) + '"';
        }
        for (var j = 0; j < this.formulas[i][2].length; j++) {
          if ( k>0 ){
            fieldsjson += ",";
          }
          k = 1;
          fieldsjson += '"' + this.getFieldName(this.formulas[i][2][j],this.formulas[i][5][j]) + '":"' + this.getFieldValue( this.formulas[i][2][j] ) + '"';
        }
        if (this.formulas[i][4].length>0){
          for (var j = 0; j < this.formulas[i][4].length; j++) {
            if ( l>0 ){
              panels += ",";
            }
            l = 1;
            panels += '"' + this.formulas[i][4][j].id  + '":"' + this.formulas[i][4][j].id  + '"';
          }
        }
        if (this.formulas[i][8].length>0){
          for (var j = 0; j < this.formulas[i][8].length; j++) {
            if ( m>0 ){
              tabs += ",";
            }
            m = 1;
            tabs += '"' + this.formulas[i][9][j]  + '":"' + this.formulas[i][9][j]  + '"';
          }
        }
      }
    }
    valor += "}";
    fieldsjson += "}";
    panels += "}";
    tabs += "}";
    
    $.ajaxSetup({"async": false});
    var result = $.post('index.php',
      {
          'module': 'Home',
          'action': 'getFormula',
          'view': this.view,
          'current_module': this.module,
          'id': this.id,
          'inlinetd': this.inlinetd,
          'getbean': this.getbean,
          'fieldsdeps': JSON.parse(valor),
          'fields': JSON.parse(fieldsjson),
          'panels': JSON.parse(panels),
          'tabs': JSON.parse(tabs),
          'event': { 'name':e.target.name, 'value':e.target.value, 'type':e.type },
          'to_pdf': true
      }, null, "json"
    );
    $.ajaxSetup({"async": true});

    try {
        var result = JSON.parse(result.responseText);
    } catch(e) {
        alert(SUGAR.language.translate('app_strings', 'LBL_LOADING_ERROR_INLINE_EDITING'));
        return false;
    }

    for (var j = 0; j < result['formulas'].length; j++) {
      for (var i = 0; i < this.fields[0].length; i++) {
        if (this.fields[0][i] == result['formulas'][j]['name'] ){
          this.setFieldValue( this.fields[1][i], result['formulas'][j]['value']);
          if (this.view == "EditView" || this.name == "InlineEditView"){
            if (this.name == "InlineEditView"){
              this.FlashField( this.fields[1][i].parentElement );
            } else {
              this.FlashField( this.fields[1][i] );
            }
            if (this.beep) {
              this.beepChangeField();
            }
          }
        }
      }
    }
    for (var j = 0; j < result['visibility'].length; j++) {
      for (var i = 0; i < this.fields[0].length; i++) {
        if (this.fields[0][i] == result['visibility'][j]['name'] ){
          if (result['visibility'][j]['value']){
            this.showElement( this.fields[1][i], this.fields[0][i], result['visibility'][j]['required'] );
          } else {
            this.hideElement( this.fields[1][i], this.fields[0][i], result['visibility'][j]['required'] );
          }
        }
      }
    }
    if (!this.inlinetd){
      for (var j = 0; j < result['panelvisibility'].length; j++) {
        for (var i = 0; i < this.fields[0].length; i++) {
          if (this.fields[0][i] == result['panelvisibility'][j]['name'] ){
            if (result['panelvisibility'][j]['value']){
              this.fields[1][i].hidden = false;
            } else {
              this.fields[1][i].hidden = true;
            }
          }
        }
      }
      for (var j = 0; j < result['tabvisibility'].length; j++) {
        for (var i = 0; i < this.fields[0].length; i++) {
          if (this.fields[0][i] == result['tabvisibility'][j]['name'] ){
            if (result['tabvisibility'][j]['value']){
              this.showTabElement(this.fields[1][i],true,result['tabvisibility'][j]['tab'],result['tabvisibility'][j]['focustab']);
            } else {
              this.showTabElement(this.fields[1][i],false,result['tabvisibility'][j]['tab'],result['tabvisibility'][j]['focustab']);
            }
          }
        }
      }
    }
  }

  APO.forms.prototype.showTabElement = function( el, visible, num, focus){
    var active = $('#content ul.nav.nav-tabs > li[role=presentation][class*=active').index();
    var options = $('#content ul.nav.nav-tabs > li[role=presentation]').size();
    if (visible){
      el.setAttribute('style','display:block;');
      if ( this.name == "InlineEditView" ){
        return;
      }
      switch( focus ){
        case '-1':
          break;
        case 'getfocus':
          $('#content ul.nav.nav-tabs > li[role=presentation]').eq(num).addClass('active');
          $('#content ul.nav.nav-tabs > li[role=presentation]').eq(active).removeClass('active');
          $('#content div.tab-content div.tab-pane-NOBOOTSTRAPTOGGLER').hide();
          $('#content div.tab-content div.tab-pane-NOBOOTSTRAPTOGGLER').eq(num).show().addClass('active').addClass('in');
          break;
      }
    } else {
      el.setAttribute('style','display:none;');
      var n = 0;
      switch( focus ){
        case '-1':
          if ( active == num ){
            n = num + 1;
          } else {
            n = active;
          }
          break;
        case 'next':
          n = num + 1;
          break;
        case 'previous':
          n = num - 1;
          break;
        default:
          n = parseInt(focus);
          if ( n == num ){
            n = num + 1;
          }
          break;
      }
      if ( n < 0 ){
        n = options - 1;
      }
      if ( n >= options ){
        n = 0;
      }
      if ( n == active && active != num ){
        return;
      }
      n = this.getValidTab( n, options );
      if ( n == active ){
        return;
      }
      $('#content ul.nav.nav-tabs > li[role=presentation]').eq(n).addClass('active');
      $('#content ul.nav.nav-tabs > li[role=presentation]').eq(active).removeClass('active');
      $('#content div.tab-content div.tab-pane-NOBOOTSTRAPTOGGLER').hide();
      $('#content div.tab-content div.tab-pane-NOBOOTSTRAPTOGGLER').eq(n).show().addClass('active').addClass('in');
    }
  }

  APO.forms.prototype.getValidTab = function( tab, size ){
    for(var j=1; j <= size; j++){
      var str = $('#content ul.nav.nav-tabs > li[role=presentation]').eq(tab).attr("style");
      if (typeof(str)=='undefined'){
        return tab;
      }
      if (str.indexOf("display:none;") < 0 ){
        return tab;
      }
      tab++;
      if (tab == size){
        tab = 0;
      }
    }
    return tab;
  }

  APO.forms.prototype.showElement = function( element, name, required ){
    if (this.inlinetd){
      var hie = $(element).hasClass("hiddenInlineEdit");
      if (hie){
        $(element).removeClass("hiddenInlineEdit");
        element.firstElementChild.hidden=false;
        $(element).addClass("inlineEdit");
        $(element).dblclick(function(e) {
          onInlineEditDblClick(this, e);
        });
      }
      element.style.color = "";
      return;
    }
    element.parentNode.parentElement.hidden = false;
    var row = YAHOO.util.Dom.getAncestorByClassName(element,'row');
    if (row.hasChildNodes()){
      var c = "edit-view-row-item";
      if (this.view != "EditView"){
        c = "detail-view-row-item";
      }
      var hideelement = true;
      for (var i = 0; i < row.childNodes.length; i++) {
        if ( typeof(row.childNodes[i].tagName) != 'undefined' && row.childNodes[i].tagName == "DIV" && row.childNodes[i].classList.contains(c) ){
          if (!row.childNodes[i].hidden){
            hideelement = false;
            break;
          }
        }
      }
      if (!hideelement){
        row.hidden = false;
        if (row.parentNode.classList.contains("tab-content")){
          row.parentNode.hidden = false;
        }
        if (row.parentNode.parentNode.parentNode.classList.contains("panel")){
          row.parentNode.parentNode.parentNode.hidden = false;
        }
      }
    }
    if (required && this.view == "EditView"){
      for (var i = 0; i < validate[this.view].length; i++) {
        if (validate[this.view][i][nameIndex] == name) {
          validate[this.view][i][requiredIndex] = true;
          return;
        }
      }
    }
  }

  APO.forms.prototype.hideElement = function( element, name, required ){
    if (this.inlinetd){
      var hie = $(element).hasClass("inlineEdit");
      if (hie){
        $(element).removeClass("inlineEdit");
        $(element).addClass("hiddenInlineEdit");
        $(element).unbind("dblclick");
        element.firstElementChild.hidden=true;
      }
      element.style.color = "transparent";
      return;
    }
    element.parentNode.parentElement.hidden = true;
    var row = YAHOO.util.Dom.getAncestorByClassName(element,'row');
    if (row.hasChildNodes()){
      var c = "edit-view-row-item";
      if (this.view != "EditView"){
        c = "detail-view-row-item";
      }
      var hideelement =  true;
      for (var i = 0; i < row.childNodes.length; i++) {
        if ( typeof(row.childNodes[i].tagName) != 'undefined' && row.childNodes[i].tagName == "DIV" && row.childNodes[i].classList.contains(c) ){
          if (!row.childNodes[i].hidden){
            hideelement = false;
            break;
          }
        }
      }
      if (hideelement){
        row.hidden = true;
        if (row.parentNode.classList.contains("tab-content")){
          row.parentNode.hidden = true;
        }
        if (row.parentNode.parentNode.parentNode.classList.contains("panel")){
          row.parentNode.parentNode.parentNode.hidden = true;
        }
      }
    }
    if (required && this.view == "EditView"){
      for (var i = 0; i < validate[this.view].length; i++) {
        if (validate[this.view][i][nameIndex] == name) {
          validate[this.view][i][requiredIndex] = false;
          return;
        }
      }
    }
  }

  var apo_beep = new Audio("data:audio/mpeg;base64,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wZ0G7jqlt/OcDIKX+/1NblSX+VKfQfP8xuJJGk7////rf////+PgXTv///1JThJJQainmySAB6imUyuVbVttUo7T4Csa821OuF88f62+CZHFnGf///mQgYIEO0SMF2NVy9NxYTdlqJ8AuS4zr//SJoTUJ+CaKKTcZvosrUPo8W/MUv0f033E9E/QpN6P///v/////WRR2mwUAYUABjabRu1vrOLKAF0kIdHjnEx/iNWo7jGn1////mApxNTJQQOU1Het/NoUFTMQs6Vja///THaGIl/0fojl8mjd/Jo8W+ZfpNpCajsz7////6kn/////WRRgDz//LD1KSTDjKOciSAKxdLx5S31uYqKIWj/+5JECgAC8V5M6g9rdFyr6Vo9rW6KtHcr5DEJQRkSpLRklSigvVc4QpmyPe9H3zHR1/in9P/8VNCMJOzYUDyVjfwHP0ZgiZt/3/+9EBnDKbegdUrckhgntHaQ9vX/X/9A/////+r/////mJ3/9ItRcoVRogAcmV9N8z0pvES8QQsKoMGXEymPQyWm6E4HQLqgpv/CZJAtYXQSwoF8e6SB56zABEoW+qgZjJAZovGr0Gl5/OjFKL3JwnaX9v7/X8y1f/////////49WAzMzEYYMZLq6CUANIqbDX7lisBIdraAEPwShTRc9WZ2vAqBc4NQ9GrUNaw0Czcrte0g1NEoiU8NFjx4NFh54FSwlOlgaCp0S3hqo8SLOh3/63f7P/KgKJxxhgGSnAFMCnIogwU5JoqBIDAuBIiNLETyFmiImtYiDTSlb8ziIFYSFv/QPC38zyxEOuPeVGHQ77r/1u/+kq49//6g4gjoVQSUMYQUSAP8PwRcZIyh2kCI2OwkZICZmaZxgnsNY8DmSCWX0idhtz3VTJSqErTSB//1X7TTTVVV//uSZB2P8xwRJ4HvYcItQlWBACM4AAABpAAAACAAADSAAAAEVf/+qCE000VVVVU0002//+qqqqummmmr///qqqppppoqqqqppppoqqATkEjIyIxBlBA5KwUEDBBwkFhYWFhUVFfiqhYWFhcVFRUVFv/Ff/xUVFRYWFpMQU1FMy45OS41qqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqg==");  

  APO.forms.prototype.beepChangeField = function(){
    apo_beep.play();
  }
 
  APO.forms.flashInProgress = {};
  APO.forms.prototype.FlashField = function (field, to_color) {
    if (typeof(field) == 'undefined')
      return;
    if (APO.forms.flashInProgress[field.id])
      return;
    APO.forms.flashInProgress[field.id] = true;
    var original = $(field).css("background-color");
    if (typeof(original) == 'undefined' || original == '') {
      original = '#FFFFFF';
    }
    if (typeof(to_color) == 'undefined')
      var to_color = '#FF8F8F';
    var oButtonAnim = new YAHOO.util.ColorAnim(field, { backgroundColor: { to: to_color } }, 0.2);
    oButtonAnim.onComplete.subscribe(function () {
      if (this.attributes.backgroundColor.to == to_color) {
        this.attributes.backgroundColor.to = original;
        this.animate();
      } else {
        field.style.backgroundColor = original;
        APO.forms.flashInProgress[field.id] = false;
      }
    });
    oButtonAnim.animate();
  }

  APO.forms.prototype.colorLuminance = function(hex, lum) {
    hex = String(hex).replace(/[^0-9a-f]/gi, '');
    if (hex.length < 6) {
       hex = hex[0]+hex[0]+hex[1]+hex[1]+hex[2]+hex[2];
    }
    lum = lum || 0;
    var rgb = "#", c, i;
    for (i = 0; i < 3; i++) {
       c = parseInt(hex.substr(i*2,2), 16);
       c = Math.round(Math.min(Math.max(0, c + (c * lum)), 255)).toString(16);
       rgb += ("00"+c).substr(c.length);
    }
    return rgb;
  }

  APO.forms.prototype.rgbtohex = function( rgb ){
    var col = rgb.split("(")[1].split(")")[0].split(", ");
    r = parseInt(col[0]).toString(16);
    r = r.length == 1 ? "0" + r : r;
    g = parseInt(col[1]).toString(16);
    g = g.length == 1 ? "0" + g : g;
    b = parseInt(col[2]).toString(16);
    b = b.length == 1 ? "0" + b : b;
    return "#" + r + g + b;
  }

})();
