<?php

// STIC-Custom 20220325 MHP - Show default actions (EDIT, DUPLICATE and DELETE) in detail view of Notes
// STIC#640 

include_once "custom/modules/Notes/metadata/detailviewdefs.php";

$viewdefs['Notes']['DetailView']['templateMeta']['form']['buttons'][0] = 'EDIT';
$viewdefs['Notes']['DetailView']['templateMeta']['form']['buttons'][1] = 'DUPLICATE';
$viewdefs['Notes']['DetailView']['templateMeta']['form']['buttons'][2] = 'DELETE';

if (write_array_to_file("viewdefs['Notes']", $viewdefs['Notes'], 'custom/modules/Notes/metadata/detailviewdefs.php')) {
    echo '<br /> - Fichero actualizado: custom/modules/Notes/metadata/detailviewdefs.php';
} else {
    echo '<br /> - Fallo en la actualización del fichero: custom/modules/Notes/metadata/detailviewdefs.php';
}