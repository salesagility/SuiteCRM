<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
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
/**
 * Provides dropdown list of Users or Contacts based on linked project resources
 * See modules/AM_ProjectHolidays/showResources.js for on change function
 */

class AM_ProjectHolidaysViewEdit extends ViewEdit
{

    public function display()
    {
        global $mod_strings;

        if ($_REQUEST['return_module'] == 'Project'){

            $project = new Project();
            $project->retrieve($_REQUEST['return_id']);

            //Get project resources (users & contacts)
            $resources1 = $project->get_linked_beans('project_users_1','User');
            $resources2 = $project->get_linked_beans('project_contacts_1','Contact');
            //sort into descending order
            ksort($resources1);
            ksort($resources2);

            echo "<script type='text/javascript'>";
            echo "var users = [];";
            echo "var contacts = [];";

            foreach($resources1 as $user){
                echo "var user = ['".$user->id."', '".$user->name."', 'User'];";
                echo "users.push(user);";
            }

            foreach($resources2 as $contact){
                echo "var user = ['".$contact->id."', '".$contact->name."', 'Contact'];";
                echo "contacts.push(user);";
            }

            echo "</script>";

        }
        parent::display();
    }

}