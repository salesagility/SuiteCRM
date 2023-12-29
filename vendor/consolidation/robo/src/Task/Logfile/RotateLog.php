<?php

namespace Robo\Task\Logfile;

use Robo\Result;

/**
 * Rotates a log (or any other) file
 *
 * ``` php
 * <?php
 * $this->taskRotateLog(['logfile.log'])->run();
 * // or use shortcut
 * $this->_rotateLog(['logfile.log']);
 *
 * ?>
 * ```
 */
class RotateLog extends BaseLogfile
{
    /**
     * @var int Number of copies to keep, default is 3.
     */
    protected $keep = 3;

    /**
     * @var string|string[] Logfile to rotate.
     */
    private $logfile;

    /**
     * @param string|string[] $logfiles
     */
    public function __construct($logfiles)
    {
        parent::__construct($logfiles);
    }

    /**
     * @param int $keep
     * @return RotateLog
     * @throws \Exception
     */
    public function keep(int $keep): self
    {
        if ($keep < 1) {
            throw new \InvalidArgumentException(
                'Keep should be greater than one, to truncate a logfile use taskTruncateLog($logfile).'
            );
        }

        $this->keep = $keep;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function run(): Result
    {
        foreach ($this->logfiles as $logfile) {
            $this->loadLogfile($logfile)
                ->process();
        }

        return Result::success($this);
    }

    /**
     * @param string $logfile
     * @return RotateLog
     */
    private function loadLogfile(string $logfile): self
    {
        $this->logfile = new \SplFileInfo($logfile);

        return $this;
    }

    /**
     * @return RotateLog
     */
    private function process(): self
    {
        $rotation = 0;
        foreach (scandir($this->logfile->getPath(), SCANDIR_SORT_DESCENDING) as $origin) {
            $origin = new \SplFileInfo($this->logfile->getPath().'/'.$origin);
            if ($origin->isFile() && $this->isLogfile($origin)) {
                if ($this->version($origin) < $this->keep) {
                    $rotated = $this->rotate($origin);
                    $this->printTaskInfo(
                        'Rotated from {origin} to {rotated}',
                        [
                            'origin' => $origin->getPathname(),
                            'rotated' => $rotated
                        ]
                    );
                } elseif ($this->version($origin) > $this->keep) {
                    $this->filesystem->remove($origin->getPathname());
                }
            }

            $rotation++;
        }

        $this->filesystem->dumpFile($this->logfile->getPathname(), false);
        if ($this->chmod) {
            $this->filesystem->chmod($this->logfile->getPathname(), $this->chmod);
        }

        return $this;
    }

    /**
     * @param \SplFileInfo $origin
     * @return bool
     */
    private function isLogfile(\SplFileInfo $origin): bool
    {
        if (substr($origin->getFilename(), 0, strlen($this->logfile->getFilename())) != $this->logfile->getFilename()) {
            return false;
        }

        return true;
    }

    /**
     * @param \SplFileInfo $origin
     * @return int
     */
    private function version(\SplFileInfo $origin): int
    {
        return $origin->getExtension() === $this->logfile->getExtension()
            ? 0
            : $origin->getExtension();
    }

    /**
     * @param \SplFileInfo $origin
     * @return int
     */
    private function next(\SplFileInfo $origin): int
    {
        return $this->version($origin) + 1;
    }

    /**
     * @param \SplFileInfo $origin
     * @return string
     */
    private function rotate(\SplFileInfo $origin): string
    {
        $rotated = $this->logfile->getPathname().'.'.$this->next($origin);
        if ($this->next($origin) === $this->keep) {
            $this->filesystem->remove($rotated);
        }

        $this->filesystem->rename($origin->getPathname(), $rotated);

        return $rotated;
    }
}
