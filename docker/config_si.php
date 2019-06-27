<?php
// Look for ENVs first, then use the last possible case.
$sugar_config_si  = array (

  'dbUSRData' => getenv('DATABASE_USR_DATA'),
  // ---------- Database Options ----------

  'setup_db_admin_password' => getenv('DATABASE_ROOT_PASSWORD'),
  'setup_db_admin_user_name' => getenv('DATABASE_ROOT_USERNAME'),
  'setup_db_create_database' => getenv('DATABASE_CREATE_NEW'),
  'setup_db_database_name' => getenv('DATABASE_NAME'),
  'setup_db_drop_tables' => getenv('DATABASE_DROP_TABLES'),
  'setup_db_host_name' => getenv('DATABASE_HOST_NAME'),
  'setup_db_pop_demo_data' => getenv('DATABASE_DEMO_DATA'),
  'setup_db_type' => getenv('DATABASE_TYPE'),
  'setup_db_username_is_privileged' => getenv('DATABASE_USER_PRIVILEDGED'),


  // ---------- Suite Site Options ----------
  
  'setup_site_admin_password' => getenv('SITE_ADMIN_PASSWORD'),
  'setup_site_admin_user_name' => getenv('SITE_ADMIN_USER'),
  'setup_site_url' => getenv('SITE_URL'),
  'setup_system_name' => getenv('SITE_SYSTEM_NAME'),
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