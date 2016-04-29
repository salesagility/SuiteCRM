SuiteCRM Console Installer
==========================

With the console installer it is now possible to install SuiteCRM from the console in a completely automatic manner
 by setting all configuration parameters when invoking the command.

Invocation
----------

To use any of the console commands you must execute the 'console' file through the php interpreter in the root folder
 of your SuiteCRM deployment. On Linux, if your system is configured correctly, you can invoke the console by typing
 `./console` whilst on Windows (or if your php interpreter cannot be found automatically) you need to specify the path 
 to the php interpreter and pass the name of the console file as the first argument, like: `C:\PHP\php.exe console`.
 For more information on how to use the console please refer to the [console guide](../Console/README.md).
 
The command name for the installer is: `app:install` so to invoke the installer you'd type:
`./console app:install [options]`

To list all available options of the installer and to see the default values you can type:
`./console app:install --help`
  
Command Option Usage
--------------------

There are options and switches to be used after the command name separated by one space in the following manner:

`./console app:install --option-one=value-one --option-two=value-two --switch-one --switch-two`

Options require a value to be given (unless they have a default value).

Switches do not take a value, they are simply on/off switches.

Database Options
-----------------

####--database-type=DATABASE-TYPE
Set the type of the database you want to use.
*(possible values: mysql, mssql - default: **mysql**)*


####--database-host=DATABASE-HOST
The FQDN(Fully Qualified Domain Name) or IP of the database server. Tipically it will be 'localhost'.   
*(possible values: any - default: **localhost**)*


####--database-port=DATABASE-PORT
The port on which the database server is available.   
*(possible values: any numeric - default: **3306**)*


####--database-name=DATABASE-NAME
The name of the database.   
*(you must always provide this)*


####--database-username=DATABASE-USERNAME
The username to use to connect to the database.   
*(you must always provide this)*


####--database-password=DATABASE-PASSWORD
The password of the database user.   
*(self explanatory)*


####--database-host-instance=DATABASE-HOST-INSTANCE
The instance of the database host.   
*(optional)*


Install Options
-----------------

####--install-host-name=INSTALL-HOST-NAME
The FQDN of the site where you are deploying the application
*(possible values: any - default: **localhost**)*


####--install-system-name=INSTALL-SYSTEM-NAME
The name of the deployment. You will be able to change this later from system settings.
*(possible values: any - default: **SuiteCRM**)*


####--install-admin-username=INSTALL-ADMIN-USERNAME
The username of the administrator
*(possible values: any - default: **admin**)*


####--install-admin-password=INSTALL-ADMIN-PASSWORD
The password of the administrator
*(possible values: any - default: **admin**)*


Install Switches
-----------------

####--install-create-database

If the database server you are connecting to does not have the database you specified with the --database-name option
and therefore it must be created, you will need to use this switch to tell the installer to create it for you.
Also, if the database already exists and you use this switch, the installer will drop the entire database and 
will recreate it.


####--install-drop-tables

If the database you specified with the --database-name option already exists and you are re-installing the application
in the same database, by specifying this option, the installer will drop and recreate the tables.


####--install-demo-data

By specifying this switch you will get some demo data installed into your database tables to play around with.


####--install-check-updates

Set this to check for updates automatically


####--force

Once you have gone through the installation process the application will set the `installer_locked=true` in your 
config.php file and will block you from executing the installer again. This is for security reasons.

By setting this switch, this check will be skipped and you can install over and over again.
The same effect could be achieved by removing the `installer_locked` key from your configuration file.


####-v|vv|vvv

Increase the verbosity of messages output to the console: 
`-v` for normal output, 
`-vv` for more verbose output and 
`-vvv` for debug

If you omit this switch the installer should run with no output at all (only in case of errors).


Examples
--------

#####Install with MySql database on localhost:

`./console app:install -v --database-name=my_db --database-username=my_user --database-password=my_pwd 
--install-create-database`


#####Install with specific database host/port:

`./console app:install -v --database-type=mysql --database-host=my_server --database-port=9876 
--database-name=my_db --database-username=my_user --database-password=my_pwd 
--install-create-database`


#####Re-Install with MySql database on localhost:

`./console app:install -v --force
--database-name=my_db --database-username=my_user --database-password=my_pwd 
--install-create-database`

or

`./console app:install -v --force
--database-name=my_db --database-username=my_user --database-password=my_pwd 
--install-drop-tables`


