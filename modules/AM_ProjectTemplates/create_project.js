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
 * @Package Project templates
 * @copyright Andrew Mclaughlan 2014
 * @author Andrew Mclaughlan <andrew@mclaughlan.info>
 */


function checkLength( o, n, min, max ) {
    if ( o.val().length > max || o.val().length < min ) {
        o.addClass( "ui-state-error" );
        updateTips( "Length of " + n + " must be between " +
            min + " and " + max + "." );
        return false;
    } else {
        return true;
    }
}

function checkRegexp( o, regexp, n ) {
    if ( !( regexp.test( o.val() ) ) ) {
        o.addClass( "ui-state-error" );
        updateTips( n );
        return false;
    } else {
        return true;
    }
}

function updateTips( t ) {
   var tips = $( ".validateTips" );
    tips
        .text( t )
        .addClass( "ui-state-highlight" );
    setTimeout(function() {
        tips.removeClass("ui-state-highlight", 1500);
    }, 500 );
}

function confirmation(id){
    $( "#dialog-confirm" ).dialog({
        height: 250,
        width: 350,
        modal: false,
        buttons: {
            "Create Project": function() {

                var name = $( "#p_name" );
                var start_date = $("#start_date"),
                allFields = $( [] ).add( name).add( start_date ),
                tips = $( ".validateTips" );

                if ( check_form('project_form') ) {
                    $( "#users tbody" ).append( "<tr>" +
                        "<td>" + name.val() + "</td>" +
                        "</tr>" );
                    $("#project_form").submit()
                    $( this ).dialog( "close" );
                    name.removeClass( "ui-state-error" );
                }
            },
            Cancel: function() {
                var name = $( "#p_name" );
                var start_date = $("#start_date");
                name.val('');
                start_date.val('');
                $( this ).dialog( "close" );
                name.removeClass( "ui-state-error" );
            }

        }
    });
}