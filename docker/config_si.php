<?php
// Look for ENVs first, then use the last possible case.
$sugar_config_si  = array (

  'dbUSRData' => isset($_ENV['DATABASE_USR_DATA']) ? $_ENV['DATABASE_USR_DATA'] : 'create',
  // ---------- Database Options ----------

  'setup_db_admin_password' => isset($_ENV['DATABASE_ROOT_PASSWORD']) ? $_ENV['DATABASE_ROOT_PASSWORD'] : 'automated_tests',
  'setup_db_admin_user_name' => isset($_ENV['DATABASE_ROOT_USERNAME']) ? $_ENV['DATABASE_ROOT_USERNAME'] : 'automated_tests',
  'setup_db_create_database' => isset($_ENV['DATABASE_CREATE_NEW']) ? $_ENV['DATABASE_CREATE_NEW'] : 1,
  'setup_db_database_name' => isset($_ENV['DATABASE_NAME']) ? $_ENV['DATABASE_NAME'] : 'automated_tests',
  'setup_db_drop_tables' => isset($_ENV['DATABASE_DROP_TABLES']) ? $_ENV['DATABASE_DROP_TABLES'] : 0,
  'setup_db_host_name' => isset($_ENV['DATABASE_HOST_NAME']) ? $_ENV['DATABASE_HOST_NAME'] : 'localhost',
  'setup_db_pop_demo_data' => isset($_ENV['DATABASE_DEMO_DATA']) ? $_ENV['DATABASE_DEMO_DATA'] : true,
  'setup_db_type' => isset($_ENV['DATABASE_TYPE']) ? $_ENV['DATABASE_TYPE'] : 'mysql',
  'setup_db_username_is_privileged' => isset($_ENV['DATABASE_USER_PRIVILEDGED']) ? $_ENV['DATABASE_USER_PRIVILEDGED'] : true,


  // ---------- Suite Site Options ----------
  
  'setup_site_admin_password' => isset($_ENV['SITE_ADMIN_PASSWORD']) ? $_ENV['SITE_ADMIN_PASSWORD'] : 'admin',
  'setup_site_admin_user_name' => isset($_ENV['SITE_ADMIN_USER']) ? $_ENV['SITE_ADMIN_USER'] : 'admin',
  'setup_site_url' => isset($_ENV['SITE_URL']) ? $_ENV['SITE_URL'] : 'http://localhost',
  'setup_system_name' => isset($_ENV['SITE_SYSTEM_NAME']) ? $_ENV['SITE_SYSTEM_NAME'] : 'SuiteCRM Docker Build',
  'setup_site_sugarbeet_automatic_checks' => true,
  'show_log_trace' => false,


  // ---------- Installation Defaults ----------

  'default_currency_iso4217' => isset($_ENV['DEFAULT_CURRENCY']) ? $_ENV['DEFAULT_CURRENCY'] : 'USD',
  'default_currency_name' => isset($_ENV['DEFAULT_CURRENCY_NAME']) ? $_ENV['DEFAULT_CURRENCY_NAME'] : 'US Dollar',
  'default_currency_significant_digits' => isset($_ENV['DEFAULT_CURRENCY_DIGITS']) ? $_ENV['DEFAULT_CURRENCY_DIGITS'] : '2',
  'default_currency_symbol' => isset($_ENV['DEFAULT_CURRENCY_SYMBOL']) ? $_ENV['DEFAULT_CURRENCY_SYMBOL'] : '$',
  'default_date_format' => isset($_ENV['DEFAULT_DATE_FORMAT']) ? $_ENV['DEFAULT_DATE_FORMAT'] : 'Y-m-d',
  'default_decimal_seperator' => isset($_ENV['DEFAULT_DECIMAL_SEPERATOR']) ? $_ENV['DEFAULT_DECIMAL_SEPERATOR'] : '.',
  'default_export_charset' => isset($_ENV['DEFAULT_EXPORT_CHARSET']) ? $_ENV['DEFAULT_EXPORT_CHARSET'] : 'ISO-8859-1',
  'default_language' => isset($_ENV['DEFAULT_LANGUAGE']) ? $_ENV['DEFAULT_LANGUAGE'] : 'en_us',
  'default_locale_name_format' => isset($_ENV['ENVIRONMENT_VARIABLE']) ? $_ENV['ENVIRONMENT_VARIABLE'] : 's f l',
  'default_number_grouping_seperator' => isset($_ENV['DEFAULT_NUMBER_GROUPING']) ? $_ENV['DEFAULT_NUMBER_GROUPING'] : ',',
  'default_time_format' => isset($_ENV['DEFAULT_TIME_FORMAT']) ? $_ENV['DEFAULT_TIME_FORMAT'] : 'H:i',
  'export_delimiter' => isset($_ENV['EXPORT_DEILIMITER']) ? $_ENV['EXPORT_DEILIMITER'] : ',',
  );