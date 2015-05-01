/**
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
 * @copyright Andrew Mclaughlan 2014
 * @author Andrew Mclaughlan <andrew@mclaughlan.info>
 */
$(function() {
    $("#name").attr('readonly', true); //Set name to read only
});

function showResources(value){

    var resource_type = value.value;
    $("#resourse_select").css("visibility", "visible");

    if(resource_type == 'User'){
        //Clear options before inserting new ones
        $("#resourse_select").find('option').remove();
        $.each(users, function(index, value){
            $("#resourse_select").append($("<option>",{
                value: value[0],
                text: value[1]
            }));
        });
        showResourcesName();
    }
    else if(resource_type == 'Contact'){
        $("#resourse_select").find('option').remove();
        $.each(contacts, function(index, value){
            $("#resourse_select").append($("<option>",{
                value: value[0],
                text: value[1]
            }));
        });

        showResourcesName();
    }
}

function showResourcesName(){

    //Populate name with the selected user name
    var text = $("#resourse_select option:selected" ).text();
    $("#name").val(text);
}