<?php

/**
 * This script find and replace the field "name" in the Search definition custom file of the Documents module for the field "document_name".
 * It also removes the field "NAME" from the ListView definition custom file.
 * 
 * This script can be used as an example for future usages. 
 * 
 * In the first case it uses str_replace to replace a predefined string.
 * 
 * In the second case it uses preg_replace to find a pattern
 * 
 */


// Pattern editviewdefs.php
$patternEditViewDef="/([01]) [>=]*[ \n]*[( ]{0,2}array[( ]{0,2}\n[' a-z]*=> '($FIELD)'[\w (\n'a-z=>_,A-Z0-9]*\),/";
$replaceEditViewDef="\1 =>'', // Deleted from update";

// Pattern detailviewdefs.php
$patternDetailViewDef="/([01]) [>=]*[ \n]*[( ]{0,2}array[( ]{0,2}\n[' a-z]*=> '($FIELD)'[\w (\n'a-z=>_,A-Z0-9]*\),/";
$replaceDetailViewDef="\1 =>'', // Deleted from update";

// Pattern quickcreateviewdefs.php
$patternQuickCreateViewDef="/([01]) [>=]*[ \n]*[( ]{0,2}array[( ]{0,2}\n[' a-z]*=> '($FIELD)'[\w (\n'a-z=>_,A-Z0-9]*\),/";
$replaceQuickCreateViewDef="\1 =>'', // Deleted from update";

// Pattern listviewdefs.php
$patternListViewDef="/'($FIELD)['=>\n(,%\w\d ]*\),/";
$replaceListViewDef="// Deleted from update";

// Pattern searchdefs.php
$patternSearchDef="/'($FIELD)['=>\n(,%\w\d ]*\),/";
$replaceSearchDef="// Deleted from update";

// Pattern SearchFields.php
$patternSearchField="/'[a-z_]*range_$FIELD'[ _a-zA-Z0-9=>',(\r\n]*\),/";
$replaceSearchField="// Deleted from update";

// Pattern dashletviewdefs.php
$patternDashletViewDef="/'($FIELD)['=>\n(,%\w\d ]*\),/";
$replaceDashletViewDef="// Deleted from update";

// Pattern subpanels.php
$patternSubpanel="/'($FIELD)['=>\n(,%\w\d ]*\),/";
$replaceSubpanel="// Deleted from update";

// Pattern whereClauses popupdefs.php
$patternWhereClausesPopupDef="/.*_cstm.$FIELD.*/";
$replaceWhereClausesPopupDef="// Deleted from update";
// Pattern searchInputs popupdefs.php
$patternSearchInputsPopupDef="/[0-9]{1,2}[ =>]*'$FIELD',/";
$replaceSearchInputsPopupDef="// Deleted from update";
// Pattern searchDefs popupdefs.php
$patternSearchDefsPopupDef="/'($FIELD)['=>\n(,%\w\d ]*\),/";
$replaceSearchDefsPopupDef="// Deleted from update";
// Pattern listviewdefslistviewdefspopupdefs.php
$patternListviewdefsPopupDef="/'($UPPER_FIELD)['=>\n(,%\w\d ]*\),/";
$replaceListviewdefsPopupDef="// Deleted from update";


echo "----- Starting replacing scripts ------ <br>";

echo "1 - Replacing the field name for document_name in searchdefs in Documents module<br>";

$pathFile = 'custom/modules/Documents/metadata/searchdefs.php';
if ($fileContent = file_get_contents($pathFile)) {
    echo "1 - Search definition file found ---> Proceed<br>";

    $stringToSearch = "'name' => 'name'";
    $stringToReplace = "'name' => 'document_name'";
    $fileContent = str_replace($stringToSearch, $stringToReplace, $fileContent);
    if (!file_put_contents($pathFile,$fileContent)) {
        echo "There was a problem saving the file<br>".$pathFile;
    }
}
else {
    echo "File not found ---> quit<br>".$pathFile;
}

echo "1 - End replacing field<br><br>";

echo "2 - Removing name field from listviewdefs in Documents module<br>";

$pathFile = 'custom/modules/Documents/metadata/listviewdefs.php';
if ($fileContent = file_get_contents($pathFile)) {
    echo "2 - Search definition file found ---> Proceed<br>";

    $field = "NAME";
    $patternListViewDef="/'($field)['=>\n(,%\w\d ]*\),/";
    $replaceListViewDef="// [".$field."] Deleted from update";

    $fileContent = preg_replace($patternListViewDef, $replaceListViewDef, $fileContent);
    if (!file_put_contents($pathFile,$fileContent)) {
        echo "There was a problem saving the file<br>";
    }
}
else {
    echo "File not found ---> quit<br>".$pathFile;
}

echo "2 - End of replacing script<br><br>";
