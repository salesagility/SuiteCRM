<?php
namespace Consolidation\Log;

use Symfony\Component\Console\Output\OutputInterface;

/**
 * Allow a log message to by styled.
 *
 * Styling happens in two phases:
 *
 * 1. Prior to message interpolation, context variables are styled
 *    via the 'style()' method, using styles provided in the context
 *    under the '_style' key, and also using styles provided by the
 *    'defaultStyles()' method.
 *
 * @see Symfony\Component\Console\Logger\ConsoleLogger::interpolate()
 *
 * 2. After message interpolation, an appropriate method based on the
 *    log level will be called. StyledConsoleLogger::$formatFunctionMap
 *    is used to map the LogLevel to a LogOutputStylerInterface method to call.
 *
 * It is possible to select the exact class to use as the log styler
 * in the constructor of StyledConsoleLogger, and the mapping from
 * LogLevel to format function can also be extended. It is possible to
 * add new format methods not defined here, if desired, so long as
 * any method named in the format function map is implemented by the
 * selected log styler class.
 */
interface LogOutputStylerInterface
{
    const STYLE_CONTEXT_KEY = '_style';

    /**
     * Return an array of default styles to use in an application.
     * The key of the style is the variable name that the style
     * should be applied to (or '*' to match all variables that have
     * no specific style set), and the value is the contents of the
     * Symfony style tag to wrap around the variable value.
     *
     * Example:
     *  message:        'Running {command}'
     *  context:        ['command' => 'pwd']
     *  default styles: ['*' => 'info']
     *  result:         'Running <info>pwd</>'
     */
    public function defaultStyles();

    /**
     * Apply styles specified in the STYLE_CONTEXT_KEY context variable to
     * the other named variables stored in the context. The styles from
     * the context are unioned with the default styles.
     */
    public function style($context);

    /**
     * Create a wrapper object for the output stream. If this styler
     * does not require an output wrapper, it should just return
     * its $output parameter.
     */
    public function createOutputWrapper(OutputInterface $output);

    /**
     * Print an ordinary log message, usually unstyled.
     */
    public function log($output, $level, $message, $context);

    /**
     * Print a success message.
     */
    public function success($output, $level, $message, $context);

    /**
     * Print an error message. Used when log level is:
     *  - LogLevel::EMERGENCY
     *  - LogLevel::ALERT
     *  - LogLevel::CRITICAL
     *  - LogLevel::ERROR
     */
    public function error($output, $level, $message, $context);

    /**
     * Print a warning message. Used when log level is:
     *   - LogLevel::WARNING
     */
    public function warning($output, $level, $message, $context);

    /**
     * Print a note. Similar to 'text', but may contain additional
     * styling (e.g. the task name). Used when log level is:
     *   - LogLevel::NOTICE
     *   - LogLevel::INFO
     *   - LogLevel::DEBUG
     *
     * IMPORTANT: Symfony loggers only display LogLevel::NOTICE when the
     * the verbosity level is  VERBOSITY_VERBOSE, unless overridden in the
     * constructor. Robo\Common\Logger emits LogLevel::NOTICE at
     * VERBOSITY_NORMAL so that these messages will always be displayed.
     */
    public function note($output, $level, $message, $context);

    /**
     * Print an error message. Not used by default by StyledConsoleLogger.
     */
    public function caution($output, $level, $message, $context);
}
