<?php

class stic_Payment_CommitmentsController extends SugarController
{

    /**
     * Execute stic_Payment_CommitmentsUtils::recalculateAllFuturePaymentsViaSQL() method.
     * It is possible to force the execution of this action by executing this command from the browser console:
     * location.href='index.php?module=stic_Payment_Commitments&action=recalculateAllFuturePaymentsViaSQL'
     *
     * @return bool True if the operation was successful.
     */
    public function action_recalculateAllFuturePaymentsViaSQL()
    {

        $startTime = microtime(true);
        $startMemoryUsage = memory_get_usage();

        require_once 'modules/stic_Payment_Commitments/Utils.php';
        stic_Payment_CommitmentsUtils::recalculateAllFuturePaymentsViaSQL();

        $endTime = microtime(true);
        $endMemoryUsage = memory_get_usage();

        $executionTime = $endTime - $startTime;
        $memoryUsage = $endMemoryUsage - $startMemoryUsage;
        $memoryUsageInMb = round($memoryUsage / 1024 / 1024, 2);

        $GLOBALS['log']->debug('Line ' . __LINE__ . ': ' . __METHOD__ . ": The recalculateAllFuturePaymentsViaSQL method has been executed in {$executionTime} seconds, using {$memoryUsageInMb} MB of memory");

        SugarApplication::redirect('index.php?module=stic_Payment_Commitments&action=index');

        return true;
    }

    /**
     * Execute stic_Payment_CommitmentsUtils::recalculateCurrentYearTotalPaidViaSQL() method.
     * It is possible to force the execution of this action by executing this command from the browser console:
     * location.href='index.php?module=stic_Payment_Commitments&action=recalculateCurrentYearTotalPaidViaSQL'
     *
     * @return bool True if the operation was successful.
     */
    public function action_recalculateCurrentYearTotalPaidViaSQL()
    {

        $startTime = microtime(true);
        $startMemoryUsage = memory_get_usage();

        require_once 'modules/stic_Payment_Commitments/Utils.php';
        stic_Payment_CommitmentsUtils::recalculateCurrentYearTotalPaidViaSQL();

        $endTime = microtime(true);
        $endMemoryUsage = memory_get_usage();

        $executionTime = $endTime - $startTime;
        $memoryUsage = $endMemoryUsage - $startMemoryUsage;
        $memoryUsageInMb = round($memoryUsage / 1024 / 1024, 2);

        $GLOBALS['log']->debug('Line ' . __LINE__ . ': ' . __METHOD__ . ": The recalculateCurrentYearTotalPaidViaSQL method has been executed in {$executionTime} seconds, using {$memoryUsageInMb} MB of memory");

        SugarApplication::redirect('index.php?module=stic_Payment_Commitments&action=index');

        return true;
    }
}
