<?php

use SuiteCRM\Test\SuitePHPUnitFrameworkTestCase;

/**
 * Class LoggerManagerTest
 */
class LoggerManagerTest extends SuitePHPUnitFrameworkTestCase
{
    /**
     * @var LoggerManager
     */
    private static $loggerManager;

    protected function setUp()
    {
        parent::setUp();

        if (self::$loggerManager === null) {
            self::$loggerManager = LoggerManager::getLogger();
        }
    }

    protected function tearDown()
    {
        self::$loggerManager = null;
        parent::tearDown();
    }

    public function testLoggerLevels()
    {
        $loggerManager = self::$loggerManager;
        $loggerManager::setLevelMapping('test', 125);

        $loggerLevels = $loggerManager::getLoggerLevels();
        $this->assertArrayHasKey('test', $loggerLevels);
    }

    public function testGetLogLevel()
    {
        $loggerManager = self::$loggerManager;
        $logLevel = $loggerManager::getLogLevel();
        $this->assertEquals('fatal', $logLevel);
    }

    public function testGetAvailableLoggers()
    {
        $loggerManager = self::$loggerManager;
        $loggers = $loggerManager::getAvailableLoggers();

        $this->assertContains('SugarLogger', $loggers);
    }

    public function testSetLoggerLevel()
    {
        $loggerManager = self::$loggerManager;
        $loggerManager->setLevel('debug');
        $logLevel = $loggerManager::getLogLevel();

        $this->assertEquals('debug', $logLevel);
    }
}
