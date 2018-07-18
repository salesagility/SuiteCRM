<?php
/**
 * SugarCRM Community Edition is a customer relationship management program developed by
 * SugarCRM, Inc. Copyright (C) 2004-2013 SugarCRM Inc.
 *
 * SuiteCRM is an extension to SugarCRM Community Edition developed by SalesAgility Ltd.
 * Copyright (C) 2011 - 2018 SalesAgility Ltd.
 *
 * This program is free software; you can redistribute it and/or modify it under
 * the terms of the GNU Affero General Public License version 3 as published by the
 * Free Software Foundation with the addition of the following permission added
 * to Section 15 as permitted in Section 7(a): FOR ANY PART OF THE COVERED WORK
 * IN WHICH THE COPYRIGHT IS OWNED BY SUGARCRM, SUGARCRM DISCLAIMS THE WARRANTY
 * OF NON INFRINGEMENT OF THIRD PARTY RIGHTS.
 *
 * This program is distributed in the hope that it will be useful, but WITHOUT
 * ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS
 * FOR A PARTICULAR PURPOSE. See the GNU Affero General Public License for more
 * details.
 *
 * You should have received a copy of the GNU Affero General Public License along with
 * this program; if not, see http://www.gnu.org/licenses or write to the Free
 * Software Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA
 * 02110-1301 USA.
 *
 * You can contact SugarCRM, Inc. headquarters at 10050 North Wolfe Road,
 * SW2-130, Cupertino, CA 95014, USA. or at email address contact@sugarcrm.com.
 *
 * The interactive user interfaces in modified source and object code versions
 * of this program must display Appropriate Legal Notices, as required under
 * Section 5 of the GNU Affero General Public License version 3.
 *
 * In accordance with Section 7(b) of the GNU Affero General Public License version 3,
 * these Appropriate Legal Notices must retain the display of the "Powered by
 * SugarCRM" logo and "Supercharged by SuiteCRM" logo. If the display of the logos is not
 * reasonably feasible for technical reasons, the Appropriate Legal Notices must
 * display the words "Powered by SugarCRM" and "Supercharged by SuiteCRM".
 */

/**
 * Created by PhpStorm.
 * User: viocolano
 * Date: 17/07/18
 * Time: 16:39
 */

namespace SuiteCRM\Search\Index;

use Monolog\Formatter\FormatterInterface;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;

/**
 * This class extends the base Monolog StreamHandler to perform logging on CLI output.
 *
 * This logger is ideal for CLIs as it is minimal and offers nice colour formatting.
 */
class CliLoggerHandler extends StreamHandler
{
    /**
     * CliLoggerHandler constructor.
     * @throws \Exception
     */
    public function __construct()
    {
        parent::__construct('php://stderr');
        $this->setFormatter(new Formatter());
    }
}

/**
 * Formatter for CliLoggerHandler.
 */
class Formatter implements FormatterInterface
{
    /**  @var array a list of the available colours for quicker usage */
    private $colours = [];
    /** @var string the format of the log line */
    private $format;
    /** @var string string used for padding new lines */
    private $padding;
    /** @var bool if set to false only warning with levels >= warn will be colour formatted */
    private $alwaysColourLine = true;

    /**
     * Creates the colours and initializes the format.
     */
    public function __construct()
    {
        $this->colours = $this->getColours();

        $c = &$this->colours;

        $this->format = "[{$c['bold']}%s{$c['reset']}][%s] {$c['bold']}%s" . PHP_EOL;

        $this->padding =
            PHP_EOL
            . $c['reset']
            . $c['gray-dark']
            . str_repeat('  ~', 4)
            . $c['reset']
            . str_repeat(' ', 2);
    }

    /**
     * Creates an array with the available colours.
     *
     * @return array
     */
    protected function getColours()
    {
        return [
            'white' => $this->e(97),
            'gray-dark' => $this->e(90),
            'gray' => $this->e(37),
            'green-light' => $this->e(92),
            'green' => $this->e(32),
            'yellow' => $this->e(93),
            'yellow-dark' => $this->e(33),
            'blue' => $this->e(34),
            'blue-light' => $this->e(94),
            'purple' => $this->e(95),
            'red' => $this->e(31),
            'red-light' => $this->e(91),
            'bg-red' => $this->e(41),
            'bg-red-light' => $this->e(101),
            'bold' => $this->e(1),
            'reset' => $this->e(0),
        ];
    }

    /**
     * Utility to make a unix terminal escape sequence given the code.
     *
     * @param $code int
     * @return string
     */
    protected function e($code)
    {
        return "\e[{$code}m";
    }

    /**
     * Formats a set of log records.
     *
     * @param  array $records A set of records to format
     * @return mixed The formatted set of records
     */
    public function formatBatch(array $records)
    {
        $formatted = [];
        foreach ($records as $record) {
            $formatted = $this->format($record);
        }
        return $formatted;
    }

    /**
     * Formats a log record.
     *
     * @param  array $record A record to format
     * @return mixed The formatted record
     */
    public function format(array $record)
    {
        $level = $record['level'];
        $message = $record['message'];

        list($color, $code) = $this->getColourAndCode($level);

        if ($level >= Logger::WARNING || $this->alwaysColourLine) {
            $message = $color . $message . $this->colours['reset'];
        }

        $message = preg_replace("/\n\s*/", $this->padding . $color, $message);

        $time = (new \DateTime())->format('H:m:s');

        return sprintf($this->format, $color . $code, $time, $message);
    }

    /**
     * Retrieves the right colour formatting and symbol to show in brackets.
     *
     * @param $level int
     * @return string[]
     */
    protected function getColourAndCode($level)
    {
        switch ($level) {
            case Logger::INFO:
                $color = $this->colours['green'];
                $code = '#';
                break;
            case Logger::WARNING:
                $color = $this->colours['yellow'];
                $code = '*';
                break;
            case Logger::ERROR:
                $color = $this->colours['red-light'];
                $code = '!';
                break;
            case Logger::CRITICAL:
                $color = $this->colours['bg-red-light'];
                $code = '!';
                break;
            case Logger::EMERGENCY:
                $color = $this->colours['bg-red'];
                $code = '!';
                break;
            case Logger::DEBUG:
            default:
                $color = $this->colours['blue-light'];
                $code = '@';
                break;
        }
        return array($color, $code);
    }
}