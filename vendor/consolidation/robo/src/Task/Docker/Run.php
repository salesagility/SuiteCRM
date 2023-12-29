<?php

namespace Robo\Task\Docker;

use Robo\Common\CommandReceiver;

/**
 * Performs `docker run` on a container.
 *
 * ```php
 * <?php
 * $this->taskDockerRun('mysql')->run();
 *
 * $result = $this->taskDockerRun('my_db_image')
 *      ->env('DB', 'database_name')
 *      ->volume('/path/to/data', '/data')
 *      ->detached()
 *      ->publish(3306)
 *      ->name('my_mysql')
 *      ->run();
 *
 * // retrieve container's cid:
 * $this->say("Running container ".$result->getCid());
 *
 * // execute script inside container
 * $result = $this->taskDockerRun('db')
 *      ->exec('prepare_test_data.sh')
 *      ->run();
 *
 * $this->taskDockerCommit($result)
 *      ->name('test_db')
 *      ->run();
 *
 * // link containers
 * $mysql = $this->taskDockerRun('mysql')
 *      ->name('wp_db') // important to set name for linked container
 *      ->env('MYSQL_ROOT_PASSWORD', '123456')
 *      ->run();
 *
 * $this->taskDockerRun('wordpress')
 *      ->link($mysql)
 *      ->publish(80, 8080)
 *      ->detached()
 *      ->run();
 *
 * ?>
 * ```
 *
 */
class Run extends Base
{
    use CommandReceiver;

    /**
     * @var string
     */
    protected $image = '';

    /**
     * @var string
     */
    protected $run = '';

    /**
     * @var string
     */
    protected $cidFile;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $dir;

    /**
     * @param string $image
     */
    public function __construct($image)
    {
        $this->image = $image;
    }

    /**
     * {@inheritdoc}
     */
    public function getPrinted()
    {
        return $this->isPrinted;
    }

    /**
     * {@inheritdoc}
     */
    public function getCommand()
    {
        if ($this->isPrinted) {
            $this->option('-i');
        }
        if ($this->cidFile) {
            $this->option('cidfile', $this->cidFile);
        }
        return trim('docker run ' . $this->arguments . ' ' . $this->image . ' ' . $this->run);
    }

    /**
     * @return $this
     */
    public function detached()
    {
        $this->option('-d');
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function interactive($interactive = true)
    {
        if ($interactive) {
            $this->option('-i');
        }
        return parent::interactive($interactive);
    }

    /**
     * @param string|\Robo\Contract\CommandInterface $run
     *
     * @return $this
     */
    public function exec($run)
    {
        $this->run = $this->receiveCommand($run);
        return $this;
    }

    /**
     * @param string $from
     * @param null|string $to
     *
     * @return $this
     */
    public function volume($from, $to = null)
    {
        $volume = $to ? "$from:$to" : $from;
        $this->option('-v', $volume);
        return $this;
    }

    /**
     * Set environment variables.
     * n.b. $this->env($variable, $value) also available here,
     * inherited from ExecTrait.
     *
     * @param array $env
     *
     * @return $this
     */
    public function envVars(array $env)
    {
        foreach ($env as $variable => $value) {
            $this->setDockerEnv($variable, $value);
        }
        return $this;
    }

    /**
     * @param string $variable
     * @param null|string $value
     *
     * @return $this
     */
    protected function setDockerEnv($variable, $value = null)
    {
        $env = $value ? "$variable=$value" : $variable;
        return $this->option("-e", $env);
    }

    /**
     * @param null|int $port
     * @param null|int $portTo
     *
     * @return $this
     */
    public function publish($port = null, $portTo = null)
    {
        if (!$port) {
            return $this->option('-P');
        }
        if ($portTo) {
            $port = "$port:$portTo";
        }
        return $this->option('-p', $port);
    }

    /**
     * @param string $dir
     *
     * @return $this
     */
    public function containerWorkdir($dir)
    {
        return $this->option('-w', $dir);
    }

    /**
     * @param string $user
     *
     * @return $this
     */
    public function user($user)
    {
        return $this->option('-u', $user);
    }

    /**
     * @return $this
     */
    public function privileged()
    {
        return $this->option('--privileged');
    }

    /**
     * @param string $name
     *
     * @return $this
     */
    public function name($name)
    {
        $this->name = $name;
        return $this->option('name', $name);
    }

    /**
     * @param string|\Robo\Task\Docker\Result $name
     * @param string $alias
     *
     * @return $this
     */
    public function link($name, $alias)
    {
        if ($name instanceof Result) {
            $name = $name->getContainerName();
        }
        $this->option('link', "$name:$alias");
        return $this;
    }

    /**
     * @param string $dir
     *
     * @return $this
     */
    public function tmpDir($dir)
    {
        $this->dir = $dir;
        return $this;
    }

    /**
     * @return string
     */
    public function getTmpDir()
    {
        return $this->dir ? $this->dir : sys_get_temp_dir();
    }

    /**
     * @return string
     */
    public function getUniqId()
    {
        return uniqid();
    }

    /**
     * {@inheritdoc}
     */
    public function run()
    {
        $this->cidFile = $this->getTmpDir() . '/docker_' . $this->getUniqId() . '.cid';
        $result = parent::run();
        $result['cid'] = $this->getCid();
        return $result;
    }

    /**
     * @return null|string
     */
    protected function getCid()
    {
        if (!$this->cidFile || !file_exists($this->cidFile)) {
            return null;
        }
        $cid = trim(file_get_contents($this->cidFile));
        @unlink($this->cidFile);
        return $cid;
    }
}
