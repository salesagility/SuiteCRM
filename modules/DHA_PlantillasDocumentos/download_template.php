<?php
/**
 * This file is part of Mail Merge Reports by Izertis.
 * Copyright (C) 2015 Izertis. 
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
 * You can contact Izertis at email address info@izertis.com.
 * You can contact SinergiaTIC Association at email address info@sinergiacrm.org.
 */

   // Basado en el fichero /download.php
   // Ver tambien la funcion 'DescargarInforme'
   
   // Si se usa desde el controller.php, hay que tener en cuenta lo siguiente
   //    $this->view = '';
   //    $GLOBALS['view'] = '';

   // Si se usa sin pasar por el controller.php (si el fichero se llamara download.php y la accion tambien se llama download) 
   // hay que desactivar en la vista activa el footer, el header, etc. de esta forma
   //    $this->options['show_header'] = false;
   //    $this->options['show_footer'] = false; ....


   if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
   
   $id = '';
   $module = '';
   
   if (isset($_REQUEST['record']) && !empty($_REQUEST['record']))
      $id = $_REQUEST['record'];
      
   if (isset($_REQUEST['id']) && !empty($_REQUEST['id']))
      $id = $_REQUEST['id'];      
      
   if (isset($_REQUEST['module']) && !empty($_REQUEST['module']))
      $module = $_REQUEST['module'];
      
   if (isset($_REQUEST['type']) && !empty($_REQUEST['type']))
      $module = $_REQUEST['type'];       

   if(empty($id) || empty($module) || !isset($_SESSION['authenticated_user_id'])) {
      die("Not a Valid Call");
   }

   ini_set('zlib.output_compression','Off'); //bug 27089, if use gzip here, the Content-Length in header may be incorrect.
   
   // cn: bug 8753: current_user's preferred export charset not being honored
   $GLOBALS['current_user']->retrieve($_SESSION['authenticated_user_id']);
   $GLOBALS['current_language'] = $_SESSION['authenticated_user_language'];
   $app_strings = return_application_language($GLOBALS['current_language']);
   $mod_strings = return_module_language($GLOBALS['current_language'], 'ACL');
   
   $focus = SugarModule::get($module)->loadBean();
   if(!$focus->ACLAccess('view')){
      die($mod_strings['LBL_NO_ACCESS']);
   } 
   $focus->retrieve($id);  

   $download_location = '';
   if ( isset($focus->doc_local_location) && !empty($focus->doc_local_location) ) {
      //$download_location = getcwd() . "/". $focus->doc_local_location;  // no es necesario
      $download_location = $focus->doc_local_location;
   }

   if(!file_exists( $download_location ) || strpos($download_location, "..")) {
      die($app_strings['ERR_INVALID_FILE_REFERENCE']);
   } 

   $file_mime_type = $focus->file_mime_type;
   // Error detectado por Kirill Belousov con nombres de ficheros en cirilico y que contienen espacios en blanco. 
   // Ver https://www.sugaroutfitters.com/support/mail-merge-reports/440 y https://forum.owncloud.org/viewtopic.php?f=3&t=2185
   //$name = basename($focus->filename);
   $name = $focus->filename;

   if(isset($_SERVER['HTTP_USER_AGENT']) && preg_match("/MSIE/", $_SERVER['HTTP_USER_AGENT'])) {
      $name = urlencode($name);
      $name = str_replace("+", "_", $name);
   }
   
   clearstatcache();
   $filesize = filesize($download_location);

   header("Pragma: public");
   header("Cache-Control: maxage=1, post-check=0, pre-check=0");
   //header("Content-Type: application/force-download");
   header("Content-type: application/octet-stream");
   header("Content-Disposition: attachment; filename=\"".$name."\";");
   // disable content type sniffing in MSIE
   header("X-Content-Type-Options: nosniff");
   header("Content-Length: " . $filesize);
   //header("Expires: 0");   
   header('Expires: ' . gmdate('D, d M Y H:i:s \G\M\T', time() + 2592000));
   set_time_limit(0);

   // código antiguo :
   // @ob_end_clean();
   // ob_start();
   // readfile($download_location);
   // @ob_flush();
   
   // When output_buffering = On, ob_get_level() may return 1 even if ob_end_clean() returns false 
   // This happens on some QA stacks. See Bug#64860
   // STIC-Custom 20220504 MHP - Change the call order of functions
   // STIC#727
   // while (ob_get_level() && @ob_end_clean()){
   while (@ob_end_clean() && ob_get_level()){
      readfile($download_location);
   }  
   // END STIC-Custom

?>
