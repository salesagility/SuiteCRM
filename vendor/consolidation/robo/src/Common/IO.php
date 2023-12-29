<?php

namespace Robo\Common;

use Robo\Symfony\ConsoleIO;
use Symfony\Component\Console\Helper\QuestionHelper;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ConfirmationQuestion;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Console\Style\SymfonyStyle;
use Consolidation\AnnotatedCommand\State\State;

trait IO
{
    use InputAwareTrait;
    use OutputAwareTrait;

    /**
     * @var \Symfony\Component\Console\Style\SymfonyStyle
     */
    protected $io;

    public function currentState()
    {
        return new class($this, $this->input, $this->output, $this->io) implements State {
            protected $obj;
            protected $input;
            protected $output;
            protected $io;

            public function __construct($obj, $input, $output, $io)
            {
                $this->obj = $obj;
                $this->input = $input;
                $this->output = $output;
                $this->io = $io;
            }

            public function restore()
            {
                $this->obj->restoreState($this->input, $this->output, $this->io);
            }
        };
    }

    // This should typically only be called by State::restore()
    public function restoreState(InputInterface $input = null, OutputInterface $output = null, SymfonyStyle $io = null)
    {
        $this->setInput($input);
        $this->setOutput($output);
        $this->io = $io;

        return $this;
    }

    public function setInput(InputInterface $input)
    {
        if ($input != $this->input) {
            $this->io = null;
        }
        $this->input = $input;

        return $this;
    }

    public function setOutput(OutputInterface $output)
    {
        if ($output != $this->output) {
            $this->io = null;
        }
        $this->output = $output;

        return $this;
    }

    /**
     * Provide access to SymfonyStyle object.
     *
     * @deprecated Use a style injector instead
     *
     * @return \Symfony\Component\Console\Style\SymfonyStyle
     *
     * @see https://symfony.com/blog/new-in-symfony-2-8-console-style-guide
     */
    protected function io()
    {
        if (!$this->io) {
            $this->io = new ConsoleIO($this->input(), $this->output());
        }
        return $this->io;
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
     * @param string $text
     */
    protected function say($text)
    {
        $char = $this->decorationCharacter('>', '➜');
        $this->writeln("$char  $text");
    }

    /**
     * @param string $text
     * @param int $length
     * @param string $color
     */
    protected function yell($text, $length = 40, $color = 'green')
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
     * @param string $question
     * @param bool $hideAnswer
     *
     * @return string
     */
    protected function ask($question, $hideAnswer = false)
    {
        if ($hideAnswer) {
            return $this->askHidden($question);
        }
        return $this->doAsk(new Question($this->formatQuestion($question)));
    }

    /**
     * @param string $question
     *
     * @return string
     */
    protected function askHidden($question)
    {
        $question = new Question($this->formatQuestion($question));
        $question->setHidden(true);
        return $this->doAsk($question);
    }

    /**
     * @param string $question
     * @param string $default
     *
     * @return string
     */
    protected function askDefault($question, $default)
    {
        return $this->doAsk(new Question($this->formatQuestion("$question [$default]"), $default));
    }

    /**
     * @param string $question
     * @param bool $default
     *
     * @return string
     */
    protected function confirm($question, $default = false)
    {
        return $this->doAsk(new ConfirmationQuestion($this->formatQuestion($question . ' (y/n)'), $default));
    }

    /**
     * @param \Symfony\Component\Console\Question\Question $question
     *
     * @return string
     */
    protected function doAsk(Question $question)
    {
        return $this->getDialog()->ask($this->input(), $this->output(), $question);
    }

    /**
     * @param string $message
     *
     * @return string
     */
    protected function formatQuestion($message)
    {
        return  "<question>?  $message</question> ";
    }

    /**
     * @return \Symfony\Component\Console\Helper\QuestionHelper
     */
    protected function getDialog()
    {
        return new QuestionHelper();
    }

    /**
     * @param $text
     */
    protected function writeln($text)
    {
        $this->output()->writeln($text);
    }
}
