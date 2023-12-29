<?php

namespace Robo\Task\Development;

use Robo\Task\Base\Exec;

/**
 * Runs PHP server and stops it when task finishes.
 *
 * ``` php
 * <?php
 * // run server in /public directory
 * $this->taskServer(8000)
 *  ->dir('public')
 *  ->run();
 *
 * // run with IP 0.0.0.0
 * $this->taskServer(8000)
 *  ->host('0.0.0.0')
 *  ->run();
 *
 * // execute server in background
 * $this->taskServer(8000)
 *  ->background()
 *  ->run();
 * ?>
 * ```
 */
class PhpServer extends Exec
{
    /**
     * @var int
     */
    protected $port;

    /**
     * @var string
     */
    protected $host = '127.0.0.1';

    /**
     * {@inheritdoc}
     */
    protected $command = 'php -S %s:%d ';

    /**
     * @param int $port
     */
    public function __construct($port)
    {
        $this->port = $port;

        if (strtolower(PHP_OS) === 'linux') {
            $this->command = 'exec php -S %s:%d ';
        }
    }

    /**
     * @param string $host
     *
     * @return $this
     */
    public function host($host)
    {
        $this->host = $host;
        return $this;
    }

    /**
     * @param string $path
     *
     * @return $this
     */
    public function dir($path)
    {
        $this->command .= "-t $path";
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getCommand()
    {
        return sprintf($this->command . $this->arguments, $this->host, $this->port);
    }
}
