SuiteCRM Console Installer
==========================

With the console installer it is now possible to install SuiteCRM from the console in a completely automatic manner
 by setting all configuration parameters when invoking the command.

Usage
-----

To use any of the console commands you must execute the 'console' file through the php interpreter in the root folder
 of your SuiteCRM deployment. On Linux, if your system is configured correctly, you can invoke the console by typing
 `./console` whilst on Windows (or if your php interpreter cannot be found automatically) you need to specify the path 
 to the php interpreter and pass the name of the console file as the first argument, like: `C:\PHP\php.exe console`.
 For more information on how to use the console please refer to the [console guide](../Console/README.md).
 
The command name for the installer is: `app:install` so to invoke the installer you'd type:
`./console app:install [options]`

To list all available options of the installer and to see the default values you can type:
`./console app:install --help`
  
Available Options
-----------------

###--database-type=DATABASE-TYPE
   Set the type of the database you want to use.
   
   *(possible values: mysql, mssql - default: **mysql**)*
   
###--database-host=DATABASE-HOST
   The FQDN(Fully Qualified Domain Name) or IP of the database server. Tipically it will be 'localhost'.
   
   *(possible values: any - default: **localhost**)*
   

 
*TO BE CONTINUED...*