<?php


class SuiteLoggerTest extends SuiteCRM\StateCheckerUnitAbstract
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    /**
     * @var string $oldLogLevel
     */
    private static $oldLogLevel;

    /**
     * @var \SuiteCRM\Utility\SuiteLogger $logger
     */
    private static $logger;

    public function _before()
    {
        parent::_before();
        if (self::$logger === null) {
            self::$logger = new \SuiteCRM\Utility\SuiteLogger();
        }
        $loggerManager = LoggerManager::getLogger();

        if (self::$logger === null) {
            self::$oldLogLevel = $loggerManager::getLogLevel();
        }

        $loggerManager::setLogLevel('debug');
    }

    public function _after()
    {
        $loggerManager = LoggerManager::getLogger();
        $loggerManager::setLogLevel(self::$oldLogLevel);
        parent::_after();
    }

    public function testLogEmergency()
    {
        self::markTestIncomplete();
        self::$logger->emergency('test');
        $lastLine = $this->getLastLogMessage();
        preg_match('/\[EMERGENCY\] test/', $lastLine, $matches);
        $this->assertNotEmpty($matches);
    }

    public function testLogAlert()
    {
        self::markTestIncomplete('need to fix: Failed asserting that an array is not empty.');
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

    public function testLogInvalid()
    {
        $this->tester->expectException(
            new \Psr\Log\InvalidArgumentException(),
            function() {
                self::$logger->log('invalid-level', 'hello');
            }
        );
    }

    public function testInterpolate()
    {
        self::$logger->error('test {a}', array('a' => 'apple'));
        $lastLine = $this->getLastLogMessage();
        preg_match('/\[ERROR\] test apple/', $lastLine, $matches);
        $this->assertNotEmpty($matches);
    }

    private function getLastLogMessage() {
        $paths = new \SuiteCRM\Utility\Paths();
        $loggerPath = $paths->getProjectPath().'/suitecrm.log';
        $data = file($loggerPath);

        if(empty($data)) {
            $line = '';
        } else {
            $line = $data[count($data)-1];
        }

        return $line;
    }
}