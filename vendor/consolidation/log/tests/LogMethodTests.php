<?php
namespace Consolidation\Log;

use Symfony\Component\Console\Output\BufferedOutput;
use Symfony\Component\Console\Output\OutputInterface;
use PHPUnit\Framework\TestCase;

class LogMethodTests extends TestCase
{
  protected $output;
  protected $logger;

  function setup(): void {
    $this->output = new BufferedOutput();
    $this->output->setVerbosity(OutputInterface::VERBOSITY_DEBUG);
    $this->logger = new Logger($this->output);
    $this->logger->setLogOutputStyler(new UnstyledLogOutputStyler());
  }

  function testError() {
    $this->logger->error('Do not enter - wrong way.');
    $outputText = rtrim($this->output->fetch());
    $this->assertEquals(' [error] Do not enter - wrong way.', $outputText);
  }

  function testWarning() {
    $this->logger->warning('Steep grade.');
    $outputText = rtrim($this->output->fetch());
    $this->assertEquals(' [warning] Steep grade.', $outputText);
  }

  function testNotice() {
    $this->logger->notice('No loitering.');
    $outputText = rtrim($this->output->fetch());
    $this->assertEquals(' [notice] No loitering.', $outputText);
  }

  function testInfo() {
    $this->logger->info('Scenic route.');
    $outputText = rtrim($this->output->fetch());
    $this->assertEquals(' [info] Scenic route.', $outputText);
  }

  function testDebug() {
    $this->logger->debug('Counter incremented.');
    $outputText = rtrim($this->output->fetch());
    $this->assertEquals(' [debug] Counter incremented.', $outputText);
  }

  function testSuccess() {
    $this->logger->success('It worked!');
    $outputText = rtrim($this->output->fetch());
    $this->assertEquals(' [success] It worked!', $outputText);
  }
}
