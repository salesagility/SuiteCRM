What is silentupgrade.php?
---------------------------

The silentupgrade.php is a stand-alone PHP script that can be run from the command prompt for upgrading a SuiteCRM instance.
SuiteCRM comes with built-in Upgrade Wizard as part of the application that you invoke through a browser.  The Silent Upgrader is executed at the
commmand line on the server where the SuiteCRM instance is installed.

Why is silentupgrade.php useful for Upgrades?
------------------------------------------------------

SuiteCRM upgrades can potentially require resources that are sometimes beyond the Web execution environment settings.
Using the Silent Upgrader enables you to avoid some of the limitations that the Web application environment may have
that prevent the Upgrade Wizard from completing the upgrade.  The upload size limit (by PHP and sometimes even by Web server),
the CGI (or equivalent) timeout limit, and the MySQL (or equivalent) session timeout limit are some of the challenges people run into when upgrading.  The Silent Upgrader either avoids the limitations or better controls the settings in its stand-alone
execution environment.

Note: After upgrading, you will need to rebuild the relationship metadata. To do this, log in as the administrator. On the Administration Home page, select the Repair option in the Systems sub-panel and click Rebuild Relationships

How do you run silentupgrade.php?
---------------------------------

To execute the silentupgrade.php script, you need to supply the three parameters, as described in the Arguments section below.


Usage: php -f silentUpgrade.php [upgradeZipFile] [logFile] [pathToSuiteCRMInstance] [adminUser]

Arguments:

    upgradeZipFile      Full path to the upgrade zip file.
                        Such as SuiteCRM-Upgrade-7.10-to-7.10.7.zip

    logFile             Full path to an alternate log file.

    pathToSuiteCRMInstance Full path to the instance being upgraded.
                        
    adminUser           A valid admin user name 

Upgrading the SuiteCRM Database Schema:
-------------------------------------
The Silent Upgrader will automatically replace the current database schema with the 6.4.4 schema.


Compatibility matrix for the Silent Upgrader:
----------------------------------------------
| Comparability Matrix |   |
|---|---|
| PHP:  | 5.5.9, 5.6, 7.0, 7.1, 7.2, 7.3 (starting from SuiteCRM 7.10.17)  |
| Databases:  | MariaDB, MySQL, SQL |
| OS: | Windows, Linux, Mac |

For a complete compatibility matrix, please see the documentation at:
https://docs.suitecrm.com/admin/compatibility-matrix/

Note: The silentUpgrade.php script creates new files for the user who is running it. For example, for
the root user it create files as user/group root. Because Apache cannot read this, you must ensure that
the Web server user has the permissions to read and write the script.
