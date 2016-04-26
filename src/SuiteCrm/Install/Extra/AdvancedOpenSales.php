<?php
/**
 * Created by Adam Jakab.
 * Date: 26/04/16
 * Time: 10.00
 */

namespace SuiteCrm\Install\Extra;

/**
 * Class AdvancedOpenSales
 * @package SuiteCrm\Install\Extra
 */
class AdvancedOpenSales implements ExtraInterface
{
    /**
     * @param array $config
     */
    public function execute($config) {
        /** array $sugar_config */
        global $sugar_config;
        $sugar_config['aos']['version'] = '5.3.3';
        if(!isset($sugar_config['aos']['contracts']['renewalReminderPeriod'])) $sugar_config['aos']['contracts']['renewalReminderPeriod'] = '14';
        if(!isset($sugar_config['aos']['lineItems']['totalTax'])) $sugar_config['aos']['lineItems']['totalTax'] = false;
        if(!isset($sugar_config['aos']['lineItems']['enableGroups'])) $sugar_config['aos']['lineItems']['enableGroups'] = true;
        if(!isset($sugar_config['aos']['invoices']['initialNumber'])) $sugar_config['aos']['invoices']['initialNumber'] = '1';
        if(!isset($sugar_config['aos']['quotes']['initialNumber'])) $sugar_config['aos']['quotes']['initialNumber'] = '1';
        ksort($sugar_config);
        write_array_to_file('sugar_config', $sugar_config, 'config.php');
    }
}