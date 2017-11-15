<?php

include_once __DIR__ . '/../../../../include/Exceptions/SuiteException.php';

class FactorAuthFactory {

    const DEFAULT_FACTOR_AUTH_INTERFACE = 'FactorAuthEmailCode';

    /**
     * @var FactorAuthInterface[]
     */
    protected static $instances = array();

    /**
     * @return FactorAuthInterface
     * @throws SuiteException
     */
    public function getFactorAuth() {
        global $current_user;
        if (!$current_user->id) {
            throw new SuiteException('User is not identified for factor authentication.');
        }
        if (!$current_user->factor_auth) {
            throw new SuiteException('User factor auth is not set. See user profile page.');
        }
        $factorAuthClass = $current_user->factor_auth_interface ?: self::DEFAULT_FACTOR_AUTH_INTERFACE;
        if (!isset(self::$instances[$factorAuthClass])) {
            include_once __DIR__ . DIRECTORY_SEPARATOR . $factorAuthClass . '.php';
            self::$instances[$factorAuthClass] = new $factorAuthClass();
        }
        return self::$instances[$factorAuthClass];
    }

}