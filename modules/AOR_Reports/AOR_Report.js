/**
 * Advanced OpenReports, SugarCRM Reporting.
 * @package Advanced OpenReports for SugarCRM
 * @copyright SalesAgility Ltd http://www.salesagility.com
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
 * @author SalesAgility <info@salesagility.com>
 */

$(document).ready(function() {

    $('#download_pdf_button_old').click(function() {
        //Update the Detail view form to have the parameter info and reload the page
        var _form = $('#formDetailView');
        $('#formDetailView :input[name="action"]').val("DownloadPDF");
        //Add each parameter to the form in turn
        $('.aor_conditions_id').each(function(index, elem){
            $elem = $(elem);
            var ln = $elem.attr('id').substr(17);
            var id = $elem.val();
            _form.append('<input type="hidden" name="parameter_id[]" value="'+id+'">');
            var operator = $("#aor_conditions_operator\\["+ln+"\\]").val();
            _form.append('<input type="hidden" name="parameter_operator[]" value="'+operator+'">');
            var fieldType = $('#aor_conditions_value_type\\['+ln+'\\]').val();
            _form.append('<input type="hidden" name="parameter_type[]" value="'+fieldType+'">');
            var fieldInput = $('#aor_conditions_value\\['+ln+'\\]').val();
            _form.append('<input type="hidden" name="parameter_value[]" value="'+fieldInput+'">');
        });

        //Get the data url of each of the rgraph canvases for PDF generation on the server
        var encodedGraphs = [];
        var rgraphs = document.getElementsByClassName('resizableCanvas');
        for(var i = 0; i < rgraphs.length; i++)
        {
            //encodedGraphs.push(rgraphs[i].toDataURL());

            _form.append('<input type="hidden" id="graphsForPDF" name="graphsForPDF[]" value='+rgraphs[i].toDataURL()+'>');
        }

        //$('#formDetailView :input[name="encodedGraphs"]').val(JSON.stringify(encodedGraphs));
        //var graphString = JSON.stringify(encodedGraphs);

        _form.submit();

        //$('#graphsForPDF').remove();
        $("#formDetailView #graphsForPDF").remove();
    });

    $('#download_csv_button_old').click(function() {
        //Update the Detail view form to have the parameter info and reload the page
        var _form = $('#formDetailView');
        $('#formDetailView :input[name="action"]').val("Export");
        //Add each parameter to the form in turn
        $('.aor_conditions_id').each(function(index, elem){
            $elem = $(elem);
            var ln = $elem.attr('id').substr(17);
            var id = $elem.val();
            _form.append('<input type="hidden" name="parameter_id[]" value="'+id+'">');
            var operator = $("#aor_conditions_operator\\["+ln+"\\]").val();
            _form.append('<input type="hidden" name="parameter_operator[]" value="'+operator+'">');
            var fieldType = $('#aor_conditions_value_type\\['+ln+'\\]').val();
            _form.append('<input type="hidden" name="parameter_type[]" value="'+fieldType+'">');
            var fieldInput = $('#aor_conditions_value\\['+ln+'\\]').val();
            _form.append('<input type="hidden" name="parameter_value[]" value="'+fieldInput+'">');
        });
        _form.submit();
    });
});

function openProspectPopup(){

    var popupRequestData = {
        "call_back_function" : "setProspectReturn",
        "form_name" : "EditView",
        "field_to_name_array" : {
            "id" : "prospect_id"
        }
    };

    open_popup('ProspectLists', '600','400', '', true, false, popupRequestData);

}

function setProspectReturn(popup_reply_data){

    var callback = {
        success: function(result) {
            //report_rel_modules = result.responseText;
            //alert('pass '+result.responseText);
        },
        failure: function(result) {
            //alert('fail '+result.responseText);
        }
    }

    var prospect_id = popup_reply_data.name_to_value_array.prospect_id;
    var record = document.getElementsByName('record')[0].value;

    YAHOO.util.Connect.asyncRequest ("GET", "index.php?module=AOR_Reports&action=addToProspectList&record="+record+"&prospect_id="+prospect_id,callback);




}


function changeReportPage(record, offset, group){
    var callback = {
        success: function(result) {
           document.getElementById('report_table'+group).innerHTML = result.responseText;
        }
    }
    var query = "?module=AOR_Reports&action=changeReportPage&record="+record+"&offset="+offset+"&group="+group;
    $('.aor_conditions_id').each(function(index, elem){
        $elem = $(elem);
        var ln = $elem.attr('id').substr(17);
        var id = $elem.val();
        query += "&parameter_id[]="+id;
        var operator = $("#aor_conditions_operator\\["+ln+"\\]").val();
        query += "&parameter_operator[]="+operator;
        var fieldType = $('#aor_conditions_value_type\\['+ln+'\\]').val();
        query += "&parameter_type[]="+fieldType;
        var fieldInput = $('#aor_conditions_value\\['+ln+'\\]').val();
        query += "&parameter_value[]="+fieldInput;
    });

    YAHOO.util.Connect.asyncRequest ("GET", "index.php"+query,callback);
}