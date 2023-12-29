<?php
/**
 * This file is part of KReporter. KReporter is an enhancement developed
 * by Christian Knoll. All rights are (c) 2012 by Christian Knoll
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
 */
require_once('modules/KReports/Plugins/prototypes/kreportintegrationplugin.php');

class ksnapshot extends kreportintegrationplugin {

   public function __construct() {
      $this->pluginName = 'Snapshots';
   }

   public function getMenuItem() {
      
      return array(
          'jsFile' => 'modules/KReports/Plugins/Integration/ksnapshots/ksnapshot.js',
          'menuItem' => array(
              'icon' => $this->wrapText('modules/KReports/images/snapshot.png'),
              'text' => $this->wrapText($this->pluginName),
              'menu' => array(
                  // 'K.kreports.ksnapshot.snapshotCombo',
                  array(
                      'text' => $this->wrapText('take Snapshot'),
                      'icon' => $this->wrapText('modules/KReports/images/snapshot.png'),
                      'handler' => $this->wrapFunction('K.kreports.ksnapshot.takeSnapshot')
                  ),
                  'K.kreports.ksnapshot.snapshotCombo'
              )
      ));
   }

}