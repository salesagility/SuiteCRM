// **************************************//
// How to start                          //
// **************************************//

For all enabled modules, there is a new "Generate Document" action in ListView (need at least one record selected) and  new "Generate Document" button in DetailView.
To enable/disable MailMerge Reports for a specific module, go to config interface in Administration module.

Some example templates will be installed by default for the Opportunities module. Please, open MailMerge Reports ListView to see them.
Then go to Opportunities module (ListView or DetailView) to run some of the examples.

Go to MailMerge Reports module, and click on "Available variables list & Generate basic template" menu.
Then select one module and select some fields to create a basic template.
Once basic template is created, you can modify it according to your needs.


// **************************************//
// Basic version limitations             //
// **************************************//

The following features are limited in basic version:

  - Related and subpanel modules fields (parent modules and subpanel modules).
  - Custom fields (created in Studio)
  - MailMerge Reports calculated fields (see "Calculated Fields" section)
  - Limited to 30 records per report
  - Roles-based permissions to access templates
  - Attach generated documents to Email
  - Attach generated documents to Note
  - No support for SugarCRM 7.x yet
  - No support for .xlsx, .ods and .xlsm template files
  - No selection of Templates through standard popups when we have a big set of Templates in a Module


// **************************************//
// Premium version notes                 //
// **************************************//

Related and subpanel module list:
  - Only fields with 'reportable' = true will be listed in link modules list. The ‘reportable’ default value is true (i.e. if 'reportable' is not defined, 'reportable' will be true)
  - If field is defined as 'reportable' = false, it will not be listed.


// **************************************//
// SugarCRM 7 Notes                      //
// **************************************//

- If you are updating from SugarCRM from 6.x version to 7.x it's important to uninstall previously the component, without removing tables (remember), and install again after the update

- No module will be enabled in the component installation process to be linked automatically with the component.
  It will be always necessary to open the "Mail Merge Reports config" page after installing (through the Admin module) and to select which modules you need to be enabled.

- It is mandatory to perform a Repair and Rebuild always after enabling or disabling modules in the "Mail Merge Reports config" page.
  After that always refresh current page in the browser to see changes.

- Example. After installing, go to "Mail Merge Reports config" page (in the Admin module), enable Opportunities module and save config.
  Run the Repair and Rebuild process.
  Then go to the Opportunities module. Once the page is loaded, then refresh the browser window. After that, this module will be linked with MMR.
  In the Opportunities List view, select one or several records and then select "Generate Document" in the dropdown actions of the List view
  to view the MMR panel with the options to generate desired document.

- There is no integration with the Record view yet for new sidecar modules (like old DetailView).
  Integration is developed only for the List view for now.
  The "bwc" modules (old style modules) still have this integration for both ListView and DetailView.

- "Attach to note" option will be available only if one record is selected (if more than one record is selected, this option will remain hidden)
  and if the parent module is linked with the Notes module

- Module label will be "Document templates" in main menu instead "Mail Merge Reports" like old SugarCRM versions.

- If you get Elasticsearch error messages while installing the component, like 'MapperParsingException[Analyzer [gs_analyzer_string] not found for field [gs_string]]' or 'Elastica\Exception\ResponseException' with message 'IndexMissingException ....'
  please, review this community blog entry: https://community.sugarcrm.com/thread/28425. There explains how to re-index your elasticsearch indexes to avoid this problems.
  That is :
     Navigate to 'Admin > Search' then please follow 'System/Indexing Full Text Search - Administration Guide documentation' (https://support.sugarcrm.com/Documentation/Sugar_Versions/7.7/Ult/Administration_Guide/System/#Indexing_Full_Text_Search).
     IMPORTANT: You would need to click "Delete existing data when index is performed ...".

- As a recommendation, outside the component, install the JSMIn php extension if you wish to speed up the process of generate minified javascript files.
  This is a internal process that SugarCRM do as administrative task (generate javascript cache files).
  This comment can be found in the source code of SugarCRM: "If the JSMIn extension is loaded, use that as it can be as much as 1000x faster than JShrink"


// **************************************//
// IMPORTANT SugarCRM 7.7.2 and later Notes
// **************************************//

There is a major bug in SugarCRM 7.7.2 (and probably higher versions) that causes SugarCRM components to not load.
This error occurs only if we have some value assigned to the php parameter 'upload_tmp_dir'.
When this error happens, it will not let us upload the component to the Module Loader, and an error appear in sugarcrm.log of type 'File name violation: file outside basedir'.

To solve this problem, either we must assign to 'upload_tmp_dir' php parameter the value returned for the 'sys_get_temp_dir()' function,
or else assign the value that we have in 'upload_tmp_dir' parameter to 'sys_temp_dir' parameter in php.ini.
Second option is available only from php 5.5.0.

See https://community.sugarcrm.com/thread/29009-module-loader-file-outside-basedir
See the bug in the validateFilePath function in /src/Util/Files/FileLoader.php.


// **************************************//
// Compatibility                         //
// **************************************//

Starting from version 2.0, the component is compatible with SugarCRM PRO, but ...
- MailMerge Reports is not compatible with Sugar On-Demand
- MailMerge Reports can not be installed on SugarCRM with ModuleScanner activated ($sugar_config['moduleInstaller']['packageScan'] = true;)


// **************************************//
// Troubleshooting                       //
// **************************************//

Sometimes, specially in Sugar 6.4.X, Opportunities template examples installed by default don't work the first time (the button "Generate Document" doesn't do anything).
When this occurs, try to refresh Opportunities ListView (click on menu "View Opportunities") or try first to generate basic template through "Available variables list & Generate basic template".

If some labels are missing in interfaces (or value lists) or some PHP warnings about "invalid argument in foreach" then
try "Quick Repair and Rebuild"  (in SugarCRM Admin->Repair->Quick Repair and Rebuild) and "Rebuild Javascript Languages" (in SugarCRM Admin->Repair->Rebuild Javascript Languages).

If the component doesn't work, try the following:

  - Try "Quick Repair and Rebuild"  (in SugarCRM Admin->Repair->Quick Repair and Rebuild) and "Rebuild Javascript Languages" (in SugarCRM Admin->Repair->Rebuild Javascript Languages)

  - Uninstall the component and change the following SugarCRM config.php variables:
         'dir_mode' => 1533,    (Sugar default is 1528)
         'file_mode' => 436,    (Sugar default is 432)
    Then reinstall the component.

  - In Linux, check that the file system have the appropriate rights. Try to execute the following commands if needed (substitute SUGARDIR for SugarCRM installation dir, and APACHEUSER for webserver system user) ...
         find SUGARDIR -type d -exec chmod 775 {} \;
         find SUGARDIR -type f -exec chmod 664 {} \;
         chmod 644 SUGARDIR/index.php
         chmod 755 SUGARDIR
         chown -R APACHEUSER:APACHEUSER SUGARDIR
    If more rights are required, change 775 to 777 and 664 to 666 (don't change 644 for index.php)


// **************************************//
// Config Variables                      //
// **************************************//

The following config variables will be created in config_override.php after install (you can go to config interface in Administration module to modify them):

  - $sugar_config['DHA_templates_default_lang']
      Default language for templates. It will affect to dates, numbers and boolean fields format. See Languages section for available options

  - $sugar_config['DHA_templates_dir']
      Template files folder. The default value is 'document_templates/'  (slash character included). It must be inside SugarCrm folders structure.

  - $sugar_config['DHA_OpenOffice_exe']
      For pdf export. Full path to LibreOffice or Apache OpenOffice exe.
      Examples :
         [WINDOWS] 'C:\Program Files (x86)\LibreOffice 3.5\program\swriter.exe'
         [LINUX] '/usr/lib/libreoffice/program/soffice'

  - $sugar_config['DHA_OpenOffice_cde']
      For pdf export (Only for Linux). Full path to LibreOffice cde-package (download from https://www.sugaroutfitters.com/addons/mail-merge-reports ).
      Useful for web hosting services where you can't install LibreOffice or Apache OpenOffice.
      Examples :
         [LINUX] '/home/USER_NAME/cde-libreoffice-pdf/libreoffice.cde'
         [LINUX] '/var/www/vhosts/DOMAIN_NAME/httpdocs/cde-libreoffice-pdf/libreoffice.cde'

  - $sugar_config['DHA_OpenOffice_HOME']
      LibreOffice working directory (Only for Linux). Required for PDF generation if HOME system environment variable does not point to a directory that has write permission for the user that runs the web server
      Example :
         [LINUX] '/tmp'

  - $sugar_config['DHA_templates_historical_enabled_modules']  (array)
      Used only when reinstall component. This parameter not define which modules are enabled, only which modules will be enabled when component is reinstalled.
      If this parameter is not set, when install/reinstall component all modules will be enabled.

  - $sugar_config['DHA_templates_enabled_roles']  (array)
      Used to store roles-based permissions. Array key is the Role id.
      If this parameter is not set, Roles will have 'ALLOW_ALL' permissions.
      If a User has multiple Roles assigned, we will use the more restrictive Role.
      If a User do not have any Role assigned or User is admin, the permission level will be 'ALLOW_ALL'.
      Examples :
         $sugar_config['DHA_templates_enabled_roles']['ea07afb0-a405-3a54-5e67-501666fa4fbf'] = 'ALLOW_ALL';
         $sugar_config['DHA_templates_enabled_roles']['c2350435-9b4c-aac4-814e-4cf6141e08a0'] = 'ALLOW_DOCX';
         $sugar_config['DHA_templates_enabled_roles']['7bea0520-2932-f002-9cad-524c4b2f88ab'] = 'ALLOW_PDF';
         $sugar_config['DHA_templates_enabled_roles']['dead1fdd-b76a-bba0-3ff6-524c4bfada4c'] = 'ALLOW_NONE';

Note: 'DHA_OpenOffice_exe' config variable have preference over 'DHA_OpenOffice_cde', so leave empty 'DHA_OpenOffice_exe' if you plan to use 'DHA_OpenOffice_cde'.


// **************************************//
// Languages                             //
// **************************************//

The language selected for templates will affect to dates, numbers and boolean fields format.
There is a global default language ("DHA_templates_default_lang" config variable), but each template will have its own associated language.

Available options:

  'es' => 'Spanish',
  'ca' => 'Catalan',
  'es_AR' => 'Spanish (Argentina)',
  'es_MX' => 'Spanish (Mexico)',
  'en_US' => 'English (United States)',
  'en_GB' => 'English (United Kingdom)',
  'de' => 'German',
  'fr' => 'French',
  'fr_BE' => 'French (Belgium)',
  'it_IT' => 'Italian',
  'pt_BR' => 'Portuguese (Brazil)',
  'nl' => 'Dutch',
  'dk' => 'Danish',
  'ru' => 'Russian',
  'sv' => 'Swedish',
  'pl' => 'Polish',
  'bg' => 'Bulgarian',
  'hu_HU' => 'Hungarian',
  'cs' => 'Czech',
  'et' => 'Estonian',
  'lt' => 'Lithuanian',
  'tr_TR' => 'Turkish',
  'he' => 'Hebrew (Israel)',
  'id' => 'Indonesian',
  'sk_SK' => 'Slovak',

If you need to add a new language, follow this steps:
  - Add a new item to 'dha_plantillasdocumentos_idiomas_dom' global list
  - Add a new item in $lang_format_config (in 'modules/DHA_PlantillasDocumentos/lang_format_config.php' file or create new 'custom/modules/DHA_PlantillasDocumentos/lang_format_config.php').

If you need to modify output format in some language, edit 'modules/DHA_PlantillasDocumentos/lang_format_config.php' file or create new 'custom/modules/DHA_PlantillasDocumentos/lang_format_config.php'.

The php date function manual can help you with date formats: http://php.net/manual/en/function.date.php


// **************************************//
// Calculated Fields                     //
// **************************************//

(*) Premium version only

You can create calculated fields for each module by creating a file called 'DHA_DocumentTemplatesCalculatedFields.php' in module folder or in custom/modules folder.
The class name for this files will be "MODULENAME_DocumentTemplatesCalculatedFields" or "CustomMODULENAME_DocumentTemplatesCalculatedFields" (substitute MODULENAME).
This class can be customized too (custom directory).
All calculated fields will be prefixed with "cf_" automatically.
To create some calculated field, you must override "SetCalcFieldsDefs" and "CalcFields" functions.
With calculated fields class you can undefine some fields too (use "UndefFieldsDefs" function), order rows (use "OrderRows" or "BeforeMergeBlock") or filter rows (use "ShowRow" function) ... even change data before the report is generated (use "BeforeMergeBlock").

See examples in 'custom/modules/Opportunities/DHA_DocumentTemplatesCalculatedFields.php'


// **************************************//
// Excel (.xlsx) and Calc Spreadsheet (.ods) Documents
// **************************************//

(*) Premium version only

- Submodule merge ("a_subx" blocks) are not allowed in this type of document, but you can merge fields from related modules (not subpanels)

- Only two types of blocks are allowed: "tbs:row" and "tbs:cell"

- Date cells needs to be formated as date (or time or long date) in the template. Otherwise dates will be displayed as numbers (but cell format can be changed once template is merged)

- Do not use a formula in a cell that may have its position changed after the merge (for example under a block). Otherwise Excel will raise an error message.
  If a formula uses a reference to a cell that has moved during the merge, then the reference will not be arranged to be the new cell reference.
  Example of a valid formula :
      =SUM( E20 : INDIRECT(ADDRESS(ROW()-1;COLUMN())) )
  Example of a valid formula (spanish):
      =SUMA( E20 : INDIRECTO(DIRECCION(FILA()-1;COLUMNA())) )

- When you put a field into a cell, then by default Excel assumes the cell has a string content and will not use the format you expect for the cell.
  But you can change the type of data in a cell using parameter « ope ». Example: [a.date_entered;ope=tbs:date] Supported types are listed below.

      Type of data      Parameter ope
      ------------      -------------
      Number            tbs:num
      Boolean           tbs:bool
      Date/time         tbs:date


// **************************************//
// PDF Documents                         //
// **************************************//

Option 1
-----------
Install LibreOffice (http://libreoffice.org ) or Apache OpenOffice (http://www.openoffice.org ) and set 'DHA_OpenOffice_exe' config variable (see "Config Variables" section) if you want PDF document generation.
If everything is correctly configured, a new button "Generate PDF Document" will appear beside the "Generate Document" button.

In Linux servers, the installation should be LibreOffice headless.
In order to install LibreOffice headless on a server, the following guide can be followed:

   http://diegolamonica.info/how-to-make-libreoffice-headless-to-work-on-centos-6-3

A summary of the steps for the installation of LibreOffice headless in CentOs (other Linux flawors should be very similar):

  yum install libreoffice-headless.x86_64
  yum install libreoffice-writer

Optional, install MsCoreFonts:

  wget -O msttcore-fonts-installer-2.6-1.noarch.rpm http://downloads.sourceforge.net/project/mscorefonts2/rpms/msttcore-fonts-installer-2.6-1.noarch.rpm?r=http%3A%2F%2Fsourceforge.net%2Fprojects%2Fmscorefonts2%2Ffiles%2Frpms%2F&ts=1446040793&use_mirror=vorboss
  yum install curl cabextract xorg-x11-font-utils fontconfig
  yum localinstall msttcore-fonts-installer-2.6-1.noarch.rpm

Once installed, configure the parameters "LibreOffice exe/binary path" and "LibreOffice working directory" in Admin/Mail Merge Reports Config window.
Last parameter is recommended to be configured, for example to the '/tmp' directory.
The "LibreOffice cde path" parameter must be empty.
View also 'Config Variables' section above, in this document.



Option 2 (Only for Linux) - OBSOLETE, NOT SUPPORTED
-----------
In web hosting services where you can't install LibreOffice or Apache OpenOffice, download LibreOffice cde-package (from https://www.sugaroutfitters.com/addons/mail-merge-reports ).
Unpack tar file anywhere and set 'DHA_OpenOffice_cde' config variable (see "Config Variables" section).
If everything is correctly configured, a new button "Generate PDF Document" will appear beside the "Generate Document" button.
This command will unpack tar file in current directory:
   tar xvzf cde-libreoffice-odt_docx_export_pdf.tar.gz
If pdf generation does not work, try this command to change the owner and group of the cde-package folder to the Apache server user (or any server you are using).
Substitute APACHE_SERVER_USER and APACHE_SERVER_GROUP to real Apache user and group.
   chown -R APACHE_SERVER_USER:APACHE_SERVER_GROUP cde-libreoffice-pdf

Important: cde-package don't work with virtualized servers

Note: 'DHA_OpenOffice_exe' config variable have preference over 'DHA_OpenOffice_cde', so leave empty 'DHA_OpenOffice_exe' if you plan to use 'DHA_OpenOffice_cde'.
Note: Set 'DHA_OpenOffice_HOME' if HOME system environment variable does not point to a directory that has write permission for the user that runs the web server.


// **************************************//
// Generate Documents by URL             //
// **************************************//

Create a standard SugarCRM url with theese parameters:

- 'module' leave as 'DHA_PlantillasDocumentos'
- 'action' leave as 'generatedocument'
- 'moduloplantilladocumento' is the target module
- 'mode' leave as 'selected'
- 'uid' is a comma separated list of uids from the target records
- 'enPDF' in pdf'? true/false
- 'plantilladocumento_id' is the used document template id


// **************************************//
// Libraries                             //
// **************************************//

MailMerge Reports makes use of these libraries:

   JAVASCRIPT - jQuery 1.7.2 (http://jquery.com) - Only needed until SugarCrm 6.5.0
   JAVASCRIPT - TableSorter 2.0.3 (http://tablesorter.com)
   PHP - TinyButStrong 3.9.0 (http://www.tinybutstrong.com)
   PHP - OpenTBS 1.9.2 (http://www.tinybutstrong.com/plugins)
   ICONS - Fugue Icons (http://p.yusukekamiyamane.com)


// **************************************//
// Contact                               //
// **************************************//

Izertis
soportedesarrollo@izertis.com
www.sigisoftware.com

