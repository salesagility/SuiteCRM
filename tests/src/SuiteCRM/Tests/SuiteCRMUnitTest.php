<?php
/**
 * Created by Adam Jakab.
 * Date: 04/07/16
 * Time: 13.16
 */

namespace SuiteCRM\Tests;

/**
 * Class SuiteCRMUnitTest
 * Collection of test utility methods
 *
 * @package SuiteCRM\Tests
 */
class SuiteCRMUnitTest extends \PHPUnit_Framework_TestCase
{
    
    /**
     * Compare two strings with ignoring differences in white spaces (mostly for sql)
     *
     * @param string $expected
     * @param string $actual
     */
    protected function assertSameStringWhiteSpaceIgnore($expected, $actual)
    {
        $expected = $this->getWhitespaceCompactedStrings($expected);
        $actual = $this->getWhitespaceCompactedStrings($actual);
        $this->assertSame($expected, $actual);
    }
    
    
    /**
     * Trim and compact multiple whitespaces to single ones
     *
     * @param string $text
     * @return string
     */
    protected function getWhitespaceCompactedStrings($text)
    {
        $answer = trim((string) $text);
        $answer = preg_replace('#\s+#', ' ', $answer);
        return $answer;
    }
}