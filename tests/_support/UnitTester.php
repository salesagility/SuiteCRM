<?php


/**
 * Inherited Methods
 * @method void wantToTest($text)
 * @method void wantTo($text)
 * @method void execute($callable)
 * @method void expectTo($prediction)
 * @method void expect($prediction)
 * @method void amGoingTo($argumentation)
 * @method void am($role)
 * @method void lookForwardTo($achieveValue)
 * @method void comment($description)
 * @method \Codeception\Lib\Friend haveFriend($name, $actorClass = NULL)
 *
 * @SuppressWarnings(PHPMD)
*/
class UnitTester extends \Codeception\Actor
{
    use _generated\UnitTesterActions;

    /**
     * @return \Psr\Container\ContainerInterface
     */
    public function getContainerInterface()
    {
        // load PSR 11 interface
        if (isset($GLOBALS['container']) === false) {
            $paths = new \SuiteCRM\Utility\Paths();
            /** @noinspection PhpIncludeInspection */
            require $paths->getContainersFilePath();
        }

        return $GLOBALS['container'];
    }
    /**
     * Define custom actions here
     */
}
