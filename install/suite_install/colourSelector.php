<?php
function install_colourSelector() {

    require_once('modules/Administration/Administration.php');

    global $sugar_config;

    $sugar_config['colourselector']['version'] = '1.1.0';
    if(!isset($sugar_config['colourselector']['navbar'])) $sugar_config['colourselector']['navbar'] = '#121212';
    if(!isset($sugar_config['colourselector']['navbarfont'])) $sugar_config['colourselector']['navbarfont'] = '#cccccc';
    if(!isset($sugar_config['colourselector']['navbarlinkhover'])) $sugar_config['colourselector']['navbarlinkhover'] = '#cccccc';
    if(!isset($sugar_config['colourselector']['pageheader'])) $sugar_config['colourselector']['pageheader'] = '#f10202';
    if(!isset($sugar_config['colourselector']['pagelink'])) $sugar_config['colourselector']['pagelink'] = '#f10202';
    if(!isset($sugar_config['colourselector']['dashlet'])) $sugar_config['colourselector']['dashlet'] = '#777777';
    if(!isset($sugar_config['colourselector']['button1'])) $sugar_config['colourselector']['button1'] = '#ffffff';
    if(!isset($sugar_config['colourselector']['buttonhover'])) $sugar_config['colourselector']['buttonhover'] = '#ffffff';
    if(!isset($sugar_config['colourselector']['buttoncolour'])) $sugar_config['colourselector']['buttoncolour'] = '#121212';
    if(!isset($sugar_config['colourselector']['buttoncolourhover'])) $sugar_config['colourselector']['buttoncolourhover'] = '#ffffff';
    if(!isset($sugar_config['colourselector']['navbarlihover'])) $sugar_config['colourselector']['navbarlihover'] = '#565656';
    if(!isset($sugar_config['colourselector']['bavbarhover'])) $sugar_config['colourselector']['bavbarhover'] = '#ffffff';
    if(!isset($sugar_config['colourselector']['dropdownmenu'])) $sugar_config['colourselector']['dropdownmenu'] = '#333333';
    if(!isset($sugar_config['colourselector']['dropdownmenulink'])) $sugar_config['colourselector']['dropdownmenulink'] = '#cccccc';

    ksort($sugar_config);
    write_array_to_file('sugar_config', $sugar_config, 'config.php');

}
?>
