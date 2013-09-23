<?php
//implements Smarty 3 style {nocache}{/nocache} block to prevent caching of a section of a template.
//remove this upon upgrade to Smarty 3
function smarty_block_nocache($param, $content, &$smarty) {
   return $content;
} 
?>