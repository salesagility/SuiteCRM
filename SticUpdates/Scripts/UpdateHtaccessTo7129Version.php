<?php
// replace string in .htacccess

$filename = $_SERVER['DOCUMENT_ROOT'] . '/.htaccess';

if (file_exists($filename)) {
    $backup_filename = $filename . '.bak';
    copy($filename, $backup_filename);

    $file_contents = file_get_contents($filename);
    $new_contents = str_replace('(php|tpl)', '(php|tpl|phar)', $file_contents);
    file_put_contents($filename, $new_contents);
} else {
    echo "El archivo $filename no existe.";
}
