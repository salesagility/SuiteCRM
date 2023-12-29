<?php

$htaccessPath = ".htaccess";
$htaccessBackupPath = ".htaccess_backup";
$htaccessSTICPath = "SticInstall/.htaccess";

copy($htaccessPath, $htaccessBackupPath);
copy($htaccessSTICPath, $htaccessPath);

echo "- Se ha creado un backup del fichero /web/.htaccess en /web/.htaccess_backup<br />";
echo "- Se ha copiado el fichero SticInstall/.htaccess en /web/.htaccess";
