/**
 * This file is part of Mail Merge Reports by Izertis.
 * Copyright (C) 2015 Izertis. 
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
 * You can contact Izertis at email address info@izertis.com.
 */
function get_uids_massgeneratedocument (mode){
   // Basado en sugarListView.prototype.send_mass_update (la funcion para la recogida de datos del MassUpdate y del Borrado masivo)
   // Cuidado, se mira en los valores del form MassUpdate, pero los valores van a ir al form MassGenerateDocument
   
   var ar = new Array();

   switch(mode) {
      case 'selected':
         for(wp = 0; wp < document.MassUpdate.elements.length; wp++) {
            var reg_for_existing_uid = new RegExp('^'+RegExp.escape(document.MassUpdate.elements[wp].value)+'[\s]*,|,[\s]*'+RegExp.escape(document.MassUpdate.elements[wp].value)+'[\s]*,|,[\s]*'+RegExp.escape(document.MassUpdate.elements[wp].value)+'$|^'+RegExp.escape(document.MassUpdate.elements[wp].value)+'$');
            //when the uid is already in document.MassUpdate.uid.value, we should not add it to ar.
            if(typeof document.MassUpdate.elements[wp].name != 'undefined'
               && document.MassUpdate.elements[wp].name == 'mass[]'
               && document.MassUpdate.elements[wp].checked
               && !reg_for_existing_uid.test(document.MassUpdate.uid.value)) {
                     ar.push(document.MassUpdate.elements[wp].value);
            }
         }
         if(ar.length > 0) {
            if(document.MassUpdate.uid.value != '') document.MassUpdate.uid.value += ',';
            document.MassUpdate.uid.value += ar.join(',');
         }
         if(document.MassUpdate.uid.value == '') {
            alert(SUGAR.language.get("app_strings", "LBL_LISTVIEW_NO_SELECTED") );
            return false;
         }
         
         var resultado = document.MassUpdate.uid.value;
         break;
         
      case 'entire':
         // var entireInput = document.createElement('input');
         // entireInput.name = 'entire';
         // entireInput.type = 'hidden';
         // entireInput.value = 'index';
         // document.MassGenerateDocument.appendChild(entireInput);
         
         var resultado = 'all';
         break;
         
      default:
         return false;
   }
   
   return resultado;
}

// Ver las funciones getMassGenerateDocumentForm , handleMassGenerateDocument y action_generatedocument
$(function() {  
   $("#MassGenerateDocument_button_ListView").click(function(){
      if (document.MassUpdate.select_entire_list && document.MassUpdate.select_entire_list.value == 1)
         var mode = 'entire';
      else
         var mode = 'selected';
      
      var uids = get_uids_massgeneratedocument(mode);  // aqui se averigua la lista de ids seleccionados (caso de que el modo sea selected)
      if (uids){
         document.MassGenerateDocument.mode.value = mode;
         document.MassGenerateDocument.uid.value = uids;
         document.MassGenerateDocument.enPDF.value = false;
         document.MassGenerateDocument.submit();
      }
      return false; 
   }); 

   $("#MassGenerateDocument_button_DetailView").click(function(){  
      $("#MassGenerateDocument #MGD_mode").val('selected');
      $("#MassGenerateDocument #MGD_enPDF").val(false);
      $("#MassGenerateDocument").submit();
      return false; 
   });    

   $("#MassGenerateDocument_button_ListView_pdf").click(function(){
      if (document.MassUpdate.select_entire_list && document.MassUpdate.select_entire_list.value == 1)
         var mode = 'entire';
      else
         var mode = 'selected';
      
      var uids = get_uids_massgeneratedocument(mode);  // aqui se averigua la lista de ids seleccionados (caso de que el modo sea selected)
      if (uids){
         document.MassGenerateDocument.mode.value = mode;
         document.MassGenerateDocument.uid.value = uids;
         document.MassGenerateDocument.enPDF.value = true;
         document.MassGenerateDocument.submit();
      }
      return false; 
   }); 

   $("#MassGenerateDocument_button_DetailView_pdf").click(function(){  
      $("#MassGenerateDocument #MGD_mode").val('selected');
      $("#MassGenerateDocument #MGD_enPDF").val(true);
      $("#MassGenerateDocument").submit();
      return false; 
   });     
});  