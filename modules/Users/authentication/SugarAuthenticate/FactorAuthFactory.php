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
    public function getFactorAuth($user = null) {
        if(null === $user) {
            global $current_user;
            $user = $current_user;
        }
        if (!$user || !$user->id) {
            throw new SuiteException('User is not identified for factor authentication.');
        }
        if (!$user->factor_auth) {
            throw new SuiteException('User factor auth is not set. See user profile page.');
        }
        $factorAuthClass = $user->factor_auth_interface ?: self::DEFAULT_FACTOR_AUTH_INTERFACE;
        if (!isset(self::$instances[$factorAuthClass])) {
            $factorAuthClassFile = __DIR__ . DIRECTORY_SEPARATOR . $factorAuthClass . '.php';
            include_once $factorAuthClassFile;
            self::$instances[$factorAuthClass] = new $factorAuthClass();
        }
        return self::$instances[$factorAuthClass];
    }

}