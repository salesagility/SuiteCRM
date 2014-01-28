<?php
function install_colourSelector() {

    require_once('modules/Administration/Administration.php');

    global $sugar_config;

    $sugar_config['colourselector']['version'] = '1.0';
    if(!isset($sugar_config['colourselector']['menu'])) $sugar_config['colourselector']['menu'] = '#121212';
    if(!isset($sugar_config['colourselector']['menufrom'])) $sugar_config['colourselector']['menufrom'] = '#121212';
    if(!isset($sugar_config['colourselector']['menuto'])) $sugar_config['colourselector']['menuto'] = '#333333';
    if(!isset($sugar_config['colourselector']['menufont'])) $sugar_config['colourselector']['menufont'] = '#cccccc';
    if(!isset($sugar_config['colourselector']['menubrd'])) $sugar_config['colourselector']['menubrd'] = '#f10202';
    if(!isset($sugar_config['colourselector']['pageheader'])) $sugar_config['colourselector']['pageheader'] = '#f10202';
    if(!isset($sugar_config['colourselector']['pagelink'])) $sugar_config['colourselector']['pagelink'] = '#f10202';
    if(!isset($sugar_config['colourselector']['dashlet'])) $sugar_config['colourselector']['dashlet'] = '#777777';
    if(!isset($sugar_config['colourselector']['button1'])) $sugar_config['colourselector']['button1'] = '#ffffff';
    if(!isset($sugar_config['colourselector']['button2'])) $sugar_config['colourselector']['button2'] = '#f3f3f3';
    if(!isset($sugar_config['colourselector']['button3'])) $sugar_config['colourselector']['button3'] = '#ededed';
    if(!isset($sugar_config['colourselector']['button4'])) $sugar_config['colourselector']['button4'] = '#ffffff';
    if(!isset($sugar_config['colourselector']['buttonhover'])) $sugar_config['colourselector']['buttonhover'] = '#f10202';
    if(!isset($sugar_config['colourselector']['modlinkvisited'])) $sugar_config['colourselector']['modlinkvisited'] = '#cccccc';
    if(!isset($sugar_config['colourselector']['modlisthover'])) $sugar_config['colourselector']['modlisthover'] = '#565656';
    if(!isset($sugar_config['colourselector']['modlinkhover'])) $sugar_config['colourselector']['modlinkhover'] = '#ffffff';
    if(!isset($sugar_config['colourselector']['cssmenu'])) $sugar_config['colourselector']['cssmenu'] = '#333333';
    if(!isset($sugar_config['colourselector']['cssmenulink'])) $sugar_config['colourselector']['cssmenulink'] = '#cccccc';

    ksort($sugar_config);
    write_array_to_file('sugar_config', $sugar_config, 'config.php');

}
?>
