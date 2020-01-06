<?php

if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}

use SuiteCRM\Test\SuitePHPUnitFrameworkTestCase;

require_once 'include/database/DBManager.php';

class DBManagerTest extends SuitePHPUnitFrameworkTestCase
{
    // Make sure createPreparedQuery returns the correct SQL query when given
    // a simple query.
    public function testcreatePreparedQueryWithSimpleQuery()
    {
        $db = DBManagerFactory::getInstance();

        $sql = "SELECT foo FROM bar WHERE baz = '?';";

        $stmt = $db->prepareQuery($sql);

        $this->assertEquals(
            $db->createPreparedQuery($stmt, ["foo"]),
            "SELECT foo FROM bar WHERE baz = 'foo';"
        );
    }

    // Make sure createPreparedQuery returns the correct SQL query when given
    // a slightly more complex query.
    public function testcreatePreparedQueryWithMoreComplexQuery()
    {
        $db = DBManagerFactory::getInstance();

        $sql = "SELECT foo FROM bar WHERE baz = '?' AND qux = '?';";

        $stmt = $db->prepareQuery($sql);

        $this->assertEquals(
            $db->createPreparedQuery($stmt, ["foo", "bar"]),
            "SELECT foo FROM bar WHERE baz = 'foo' AND qux = 'bar';"
        );
    }

    // Make sure createPreparedQuery returns the correct SQL query when
    // using '!=' in the input.
    public function testcreatePreparedQueryWithNegation()
    {
        $db = DBManagerFactory::getInstance();

        $sql = "SELECT foo FROM bar WHERE baz != '?';";

        $stmt = $db->prepareQuery($sql);

        $this->assertEquals(
            $db->createPreparedQuery($stmt, ["foo"]),
            "SELECT foo FROM bar WHERE baz != 'foo';"
        );
    }

    // Make sure createPreparedQuery returns the correct SQL query when
    // using '\?' in the input.
    public function testcreatePreparedQueryWithEscapedToken()
    {
        $db = DBManagerFactory::getInstance();

        // Match baz to the input variable with a question mark appended... for some reason.
        $sql = "SELECT foo FROM bar WHERE baz = '?\?';";

        $stmt = $db->prepareQuery($sql);

        $this->assertEquals(
            $db->createPreparedQuery($stmt, ["foo"]),
            "SELECT foo FROM bar WHERE baz = 'foo?';"
        );
    }
}
