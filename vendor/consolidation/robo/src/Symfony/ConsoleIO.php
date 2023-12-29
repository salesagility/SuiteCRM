<?php

namespace Robo\Symfony;

use Consolidation\AnnotatedCommand\CommandData;
use Consolidation\AnnotatedCommand\CommandProcessor;
use Consolidation\AnnotatedCommand\ParameterInjector;
use Robo\Common\InflectionTrait;
use Robo\Contract\InflectionInterface;
use Robo\Contract\OutputAwareInterface;
use Symfony\Component\Console\Input\InputAwareInterface;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class ConsoleIO extends SymfonyStyle implements InflectionInterface // InputInterface?
{
    use InflectionTrait;

    protected $input;
    protected $output;

    public function __construct(InputInterface $input, OutputInterface $output)
    {
        $this->input = $input;
        $this->output = $output;
        parent::__construct($input, $output);
    }

    public function input()
    {
        return $this->input;
    }

    public function output()
    {
        return $this->output;
    }

    /**
     * @param string $text
     */
    public function say($text)
    {
        $char = $this->decorationCharacter('>', '➜');
        $this->writeln("$char  $text");
    }

    /**
     * @param string $text
     * @param int $length
     * @param string $color
     */
    public function yell($text, $length = 40, $color = 'green')
    {
        $char = $this->decorationCharacter(' ', '➜');
        $format = "$char  <fg=white;bg=$color;options=bold>%s</fg=white;bg=$color;options=bold>";
        $this->formattedOutput($text, $length, $format);
    }

    /**
     * @param string $text
     * @param int $length
     * @param string $format
     */
    protected function formattedOutput($text, $length, $format)
    {
        $lines = explode("\n", trim($text, "\n"));
        $maxLineLength = array_reduce(array_map('strlen', $lines), 'max');
        $length = max($length, $maxLineLength);
        $len = $length + 2;
        $space = str_repeat(' ', $len);
        $this->writeln(sprintf($format, $space));
        foreach ($lines as $line) {
            $line = str_pad($line, $length, ' ', STR_PAD_BOTH);
            $this->writeln(sprintf($format, " $line "));
        }
        $this->writeln(sprintf($format, $space));
    }

    /**
     * @param string $nonDecorated
     * @param string $decorated
     *
     * @return string
     */
    protected function decorationCharacter($nonDecorated, $decorated)
    {
        if (!$this->output()->isDecorated() || (strncasecmp(PHP_OS, 'WIN', 3) == 0)) {
            return $nonDecorated;
        }
        return $decorated;
    }

    /**
     * {@inheritdoc}
     */
    public function lightText($message)
    {
        $this->block($message, '', 'fg=gray', '', true);
    }

    /**
     * {@inheritdoc}
     */
    public function injectDependencies($child)
    {
        if ($child instanceof InputAwareInterface) {
            $child->setInput($this->input());
        }
        if ($child instanceof OutputAwareInterface) {
            $child->setOutput($this->output());
        }
    }
}
