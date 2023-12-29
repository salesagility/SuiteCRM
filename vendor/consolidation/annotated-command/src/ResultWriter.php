<?php
namespace Consolidation\AnnotatedCommand;

use Consolidation\AnnotatedCommand\Hooks\Dispatchers\ReplaceCommandHookDispatcher;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Output\ConsoleOutputInterface;

use Consolidation\OutputFormatters\FormatterManager;
use Consolidation\OutputFormatters\Options\FormatterOptions;
use Consolidation\AnnotatedCommand\Hooks\HookManager;
use Consolidation\AnnotatedCommand\Options\PrepareFormatter;

use Consolidation\AnnotatedCommand\Hooks\Dispatchers\InitializeHookDispatcher;
use Consolidation\AnnotatedCommand\Hooks\Dispatchers\OptionsHookDispatcher;
use Consolidation\AnnotatedCommand\Hooks\Dispatchers\InteractHookDispatcher;
use Consolidation\AnnotatedCommand\Hooks\Dispatchers\ValidateHookDispatcher;
use Consolidation\AnnotatedCommand\Hooks\Dispatchers\ProcessResultHookDispatcher;
use Consolidation\AnnotatedCommand\Hooks\Dispatchers\StatusDeterminerHookDispatcher;
use Consolidation\AnnotatedCommand\Hooks\Dispatchers\ExtracterHookDispatcher;

/**
 * Write the results of a command. Inject your ResultWriter
 * into the CommandProcessor.
 */
class ResultWriter
{
    /** var FormatterManager */
    protected $formatterManager;
    /** @var callable */
    protected $displayErrorFunction;

    public function setFormatterManager(FormatterManager $formatterManager)
    {
        $this->formatterManager = $formatterManager;
        return $this;
    }

    /**
     * Return the formatter manager
     * @return FormatterManager
     */
    public function formatterManager()
    {
        return $this->formatterManager;
    }

    public function setDisplayErrorFunction(callable $fn)
    {
        $this->displayErrorFunction = $fn;
        return $this;
    }

    /**
     * Handle the result output and status code calculation.
     */
    public function handle(OutputInterface $output, $result, CommandData $commandData, $statusCodeDispatcher = null, $extractDispatcher = null)
    {
        // A little messy, for backwards compatibility: if the result implements
        // ExitCodeInterface, then use that as the exit code. If a status code
        // dispatcher returns a non-zero result, then we will never print a
        // result.
        $status = null;
        if ($result instanceof ExitCodeInterface) {
            $status = $result->getExitCode();
        } elseif (isset($statusCodeDispatcher)) {
            $status = $statusCodeDispatcher->determineStatusCode($result);
            if (isset($status) && ($status != 0)) {
                return $status;
            }
        }
        // If the result is an integer and no separate status code was provided, then use the result as the status and do no output.
        if (is_integer($result) && !isset($status)) {
            return $result;
        }
        $status = $this->interpretStatusCode($status);

        // Get the structured output, the output stream and the formatter
        $structuredOutput = $result;
        if (isset($extractDispatcher)) {
            $structuredOutput = $extractDispatcher->extractOutput($result);
        }
        if (($status != 0) && is_string($structuredOutput)) {
            $output = $this->chooseOutputStream($output, $status);
            return $this->writeErrorMessage($output, $status, $structuredOutput, $result);
        }
        if ($this->dataCanBeFormatted($structuredOutput) && isset($this->formatterManager)) {
            return $this->writeUsingFormatter($output, $structuredOutput, $commandData, $status);
        }
        return $this->writeCommandOutput($output, $structuredOutput, $status);
    }

    protected function dataCanBeFormatted($structuredOutput)
    {
        if (!isset($this->formatterManager)) {
            return false;
        }
        return
            is_object($structuredOutput) ||
            is_array($structuredOutput);
    }

    /**
     * Determine the formatter that should be used to render
     * output.
     *
     * If the user specified a format via the --format option,
     * then always return that.  Otherwise, return the default
     * format, unless --pipe was specified, in which case
     * return the default pipe format, format-pipe.
     *
     * n.b. --pipe is a handy option introduced in Drush 2
     * (or perhaps even Drush 1) that indicates that the command
     * should select the output format that is most appropriate
     * for use in scripts (e.g. to pipe to another command).
     *
     * @return string
     */
    protected function getFormat(FormatterOptions $options)
    {
        // In Symfony Console, there is no way for us to differentiate
        // between the user specifying '--format=table', and the user
        // not specifying --format when the default value is 'table'.
        // Therefore, we must make --field always override --format; it
        // cannot become the default value for --format.
        if ($options->get('field')) {
            return 'string';
        }
        $defaults = [];
        if ($options->get('pipe')) {
            return $options->get('pipe-format', [], 'tsv');
        }
        return $options->getFormat($defaults);
    }

    /**
     * Determine whether we should use stdout or stderr.
     */
    protected function chooseOutputStream(OutputInterface $output, $status)
    {
        // If the status code indicates an error, then print the
        // result to stderr rather than stdout
        if ($status && ($output instanceof ConsoleOutputInterface)) {
            return $output->getErrorOutput();
        }
        return $output;
    }

    /**
     * Call the formatter to output the provided data.
     */
    protected function writeUsingFormatter(OutputInterface $output, $structuredOutput, CommandData $commandData, $status = 0)
    {
        $formatterOptions = $commandData->formatterOptions();
        $format = $this->getFormat($formatterOptions);
        $this->formatterManager->write(
            $output,
            $format,
            $structuredOutput,
            $formatterOptions
        );
        return $status;
    }

    /**
     * Description
     * @param OutputInterface $output
     * @param int $status
     * @param string $structuredOutput
     * @param mixed $originalResult
     * @return type
     */
    protected function writeErrorMessage($output, $status, $structuredOutput, $originalResult)
    {
        if (isset($this->displayErrorFunction)) {
            call_user_func($this->displayErrorFunction, $output, $structuredOutput, $status, $originalResult);
        } else {
            $this->writeCommandOutput($output, $structuredOutput);
        }
        return $status;
    }

    /**
     * If the result object is a string, then print it.
     */
    protected function writeCommandOutput(
        OutputInterface $output,
        $structuredOutput,
        $status = 0
    ) {
        // If there is no formatter, we will print strings,
        // but can do no more than that.
        if (is_string($structuredOutput)) {
            $output->writeln($structuredOutput);
        }
        return $status;
    }

    /**
     * If a status code was set, then return it; otherwise,
     * presume success.
     */
    protected function interpretStatusCode($status)
    {
        if (isset($status)) {
            return $status;
        }
        return 0;
    }
}
