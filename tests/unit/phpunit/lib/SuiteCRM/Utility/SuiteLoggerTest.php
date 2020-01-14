<?php

use SuiteCRM\Test\SuitePHPUnitFrameworkTestCase;
use SuiteCRM\Utility\Paths;
use SuiteCRM\Utility\SuiteLogger;

class SuiteLoggerTest extends SuitePHPUnitFrameworkTestCase
{
    /**
     * @var SuiteLogger
     */
    private static $logger;

    /**
     * @var string
     */
    private static $oldLogLevel;

    protected function setUp()
    {
        global $sugar_config;

        parent::setUp();
        if (self::$logger === null) {
            self::$logger = new SuiteLogger();
        }

        $loggerManager = LoggerManager::getLogger();
        self::$oldLogLevel = $loggerManager::getLogLevel();

        $loggerManager::setLogLevel('debug');
        $sugar_config['show_log_trace'] = false;
    }

    protected function tearDown()
    {
        $loggerManager = LoggerManager::getLogger();
        $loggerManager::setLogLevel(self::$oldLogLevel);
        self::$logger = null;
        parent::tearDown();
    }

    public function testLogEmergency()
    {
        self::$logger->emergency('test');
        $lastLine = $this->getLastLogMessage();
        preg_match('/\[EMERGENCY\] test/', $lastLine, $matches);
        $this->assertNotEmpty($matches);
    }

    public function testLogAlert()
    {
        self::$logger->alert('test');
        $lastLine = $this->getLastLogMessage();
        preg_match('/\[ALERT\] test/', $lastLine, $matches);
        $this->assertNotEmpty($matches);
    }

    public function testLogCritical()
    {
        self::$logger->critical('test');
        $lastLine = $this->getLastLogMessage();
        preg_match('/\[CRITICAL\] test/', $lastLine, $matches);
        $this->assertNotEmpty($matches);
    }

    public function testLogError()
    {
        self::$logger->error('test');
        $lastLine = $this->getLastLogMessage();
        preg_match('/\[ERROR\] test/', $lastLine, $matches);
        $this->assertNotEmpty($matches);
    }

    public function testLogWarning()
    {
        self::$logger->warning('test');
        $lastLine = $this->getLastLogMessage();
        preg_match('/\[WARNING\] test/', $lastLine, $matches);
        $this->assertNotEmpty($matches);
    }

    public function testLogNotice()
    {
        self::$logger->notice('test');
        $lastLine = $this->getLastLogMessage();
        preg_match('/\[NOTICE\] test/', $lastLine, $matches);
        $this->assertNotEmpty($matches);
    }

    public function testLogInfo()
    {
        self::$logger->info('test');
        $lastLine = $this->getLastLogMessage();
        preg_match('/\[INFO\] test/', $lastLine, $matches);
        $this->assertNotEmpty($matches);
    }

    public function testLogDebug()
    {
        self::$logger->debug('test');
        $lastLine = $this->getLastLogMessage();
        preg_match('/\[DEBUG\] test/', $lastLine, $matches);
        $this->assertNotEmpty($matches);
    }

    public function testInterpolate()
    {
        self::$logger->error('test {a}', ['a' => 'apple']);
        $lastLine = $this->getLastLogMessage();
        preg_match('/\[ERROR\] test apple/', $lastLine, $matches);
        $this->assertNotEmpty($matches);
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testInvalidLevel()
    {
        self::$logger->log('invalid', 'test');
    }

    private function getLastLogMessage()
    {
        $paths = new Paths();
        $loggerPath = $paths->getProjectPath() . '/suitecrm.log';
        $data = file($loggerPath);

        if (empty($data)) {
            $line = '';
        } else {
            $line = $data[count($data) - 1];
        }

        return $line;
    }
}
