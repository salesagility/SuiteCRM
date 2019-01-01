<?php

use SuiteCRM\StateCheckerPHPUnitTestCaseAbstract;
use SuiteCRM\StateSaver;

//require_once __DIR__ . '/../../../../../modules/Configurator/Configurator.php';

class ConfiguratorTest extends StateCheckerPHPUnitTestCaseAbstract
{
    public function setUp() {
        parent::setUp();
        $this->state = new StateSaver();
        $this->state->pushGlobals();
        $this->state->pushTable('config');
        $this->state->pushFile('config.php');
        $this->state->pushFile('config_override.php');
    }
    
    public function tearDown() {
        $this->state->popTable('config');
        $this->state->popFile('config.php');
        $this->state->popFile('config_override.php');
        $this->state->popGlobals();
        parent::tearDown();
    }

    public function test__construct() {
        //$this->markTestIncomplete('TODO: Implement Tests');
        $object = new Configurator;
        $this->assertEquals(true, is_array($object->config));
    }

    public function testLoadConfig() {
        // This is tested by test__construct()
    }

    public function testPopulateFromPost() {
            $this->markTestIncomplete('TODO: Implement Tests');
    }

    public function testHandleOverride() {
            $this->markTestIncomplete('TODO: Implement Tests');
    }

    public function testAddKeyToIgnoreOverride() {
            $this->markTestIncomplete('TODO: Implement Tests');
    }

    public function testClearCache() {
            $this->markTestIncomplete('TODO: Implement Tests');
    }

    public function testSaveConfig() {
            $this->markTestIncomplete('TODO: Implement Tests');
    }

    public function testReadOverride() {
        $object = new Configurator;
        $this->assertEquals(true, is_array($object->readOverride()));
    }

    public function testSaveOverride() {
            $this->markTestIncomplete('TODO: Implement Tests');
    }

    public function testOverrideClearDuplicates() {
            $this->markTestIncomplete('TODO: Implement Tests');
    }

    public function testReplaceOverride() {
            $this->markTestIncomplete('TODO: Implement Tests');
    }

    public function testRestoreConfig() {
            $this->markTestIncomplete('TODO: Implement Tests');
    }

    public function testSaveImages() {
            $this->markTestIncomplete('TODO: Implement Tests');
    }

    public function testCheckTempImage() {
            $this->markTestIncomplete('TODO: Implement Tests');
    }

    public function testGetError() {
            $this->markTestIncomplete('TODO: Implement Tests');
    }

    public function testSaveCompanyLogo() {
            $this->markTestIncomplete('TODO: Implement Tests');
    }

    public function testParseLoggerSettings() {
            $this->markTestIncomplete('TODO: Implement Tests');
    }

    public function testIsConfirmOptInEnabled() {
            $this->markTestIncomplete('TODO: Implement Tests');
    }

    public function testIsOptInEnabled() {
            $this->markTestIncomplete('TODO: Implement Tests');
    }

    public function testGetConfirmOptInTemplateId() {
            $this->markTestIncomplete('TODO: Implement Tests');
    }

    public function testGetConfirmOptInEnumValue() {
            $this->markTestIncomplete('TODO: Implement Tests');
    }

    public function testEverywhere() {
            $this->markTestIncomplete('TODO: Implement Tests');
    }
}