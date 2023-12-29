<?php
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
/*
 * Requerido a partir de la versión 7.7
 * Ver https://developer.sugarcrm.com/2015/12/01/csrf-tokens-in-sugar-7-7
 *     https://developer.sugarcrm.com/2016/11/15/security-changes-coming-in-sugar-7-8
 *
 * Basado en include\SugarSmarty\plugins\function.sugar_csrf_form_token.php
 * La forma de usar la variable original de Sugar en un form en Smarty es la siguiente (incluir en los tpl) ...
 *    {sugar_csrf_form_token}
 * o
 *    <input type="hidden" name="csrf_token" id="csrf_token" value="{sugar_csrf_form_token raw=1}" />
 */

use Sugarcrm\Sugarcrm\Security\Csrf\CsrfAuthenticator;

function get_sugar_csrf_form_token($raw){
   $csrf = CsrfAuthenticator::getInstance();

   if (!empty($raw)) {
      return $csrf->getFormToken();
   }

   return sprintf(
      '<input type="hidden" name="%s" id="%s" value="%s" />',
      $csrf::FORM_TOKEN_FIELD,
      $csrf::FORM_TOKEN_FIELD,
      $csrf->getFormToken()
   );
}


function get_sugar_csrf_form_token_id(){
   return CsrfAuthenticator::FORM_TOKEN_FIELD;
}
