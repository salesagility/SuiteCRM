<?php

namespace SuiteCRM\Test;

use \SugarBean;
use SuiteCRM\Exception\Exception;

class BeanFactoryTestCase extends SuitePHPUnitFrameworkTestCase
{
    /**
     * @var bool
     */
    protected $testAllModules = false;

    /**
     * @var string
     */
    protected $testSingleModule = 'Accounts';

    /**
     * @return void
     * @throws Exception in TestCaseAbstract::setup
     */
    public function setup()
    {
        $this->removeCoreModuleAllExtension();

        parent::setup();
    }

    /**
     * @return void
     */
    public function tearDown()
    {
        $this->removeCoreModuleAllExtension();

        $this->refreshModuleGlobals();

        parent::tearDown();
    }
    /**
     * @return array
     */
    public function moduleConfigProvider()
    {
        $this->refreshModuleGlobals();

        global $customBeanList, $objectList, $customObjectList, $beanFiles, $customBeanFiles;

        $moduleList = $this->getModuleList();

        $modulesConfig = [];
        foreach ($moduleList as $moduleName => $moduleClass) {
            if ($this->shouldSkipModule($moduleClass)) {
                continue;
            }

            $moduleConfig = [
                'name' => $moduleName,
                'meta' => [
                    'objectName' => !empty($objectList[$moduleName]) ? $objectList[$moduleName] : $moduleClass,
                    'className' => $moduleClass,
                    'classFile' => $beanFiles[$moduleClass],
                    'customObjectName' => !empty($customObjectList[$moduleName])
                        ? $customObjectList[$moduleName]
                        : null,
                    'customClassName' => !empty($customBeanList[$moduleName])
                        ? $customBeanList[$moduleName]
                        : null,
                ],
            ];

            $moduleConfig['meta']['customClassFile'] = null;

            if (!empty($customBeanList[$moduleName])) {
                if (!empty($customBeanFiles[$customBeanList[$moduleName]])) {
                    $moduleConfig['meta']['customClassFile'] = $customBeanFiles[$customBeanList[$moduleName]];
                }

                if (!empty($customBeanFiles[$moduleClass])) {
                    $moduleConfig['meta']['customClassFile'] = $customBeanFiles[$moduleClass];
                }
            }

            $modulesConfig[$moduleName] = $moduleConfig;
        }

        return $modulesConfig;
    }

    /**
     * @return array
     */
    protected function getModuleList()
    {
        global $beanList;

        return $this->testAllModules
            ? $beanList
            : [
                $this->testSingleModule => $beanList[$this->testSingleModule],
            ];
    }

    /**
     * @param $moduleClass
     * @return bool
     */
    protected function shouldSkipModule($moduleClass)
    {
        global $beanFiles;

        if (empty($beanFiles[$moduleClass]) || !file_exists($beanFiles[$moduleClass])) {
            return true;
        }

        $bean = new $moduleClass();
        if (!$bean instanceof SugarBean || empty($bean->table_name)) {
            return true;
        }

        return false;
    }

    /**
     * @return void
     */
    public function compileIncludeExtFiles()
    {
        $extensionContents = '<?php' . PHP_EOL;
        $compiledIncludePath = 'custom/application/Ext/Include';
        $extIncludePath = 'custom/Extension/application/Ext/Include';
        $noExtensions = true;

        if (!file_exists($extIncludePath)) {
            mkdir_recursive($extIncludePath, true);
        }

        $extIncludeDir = dir($extIncludePath);
        while ($file = $extIncludeDir->read()) {
            if ($this->shouldSkipFileEntry($file, $extIncludePath)) {
                continue;
            }

            $noExtensions = false;
            $contents = file_get_contents("$extIncludePath/$file");
            $extensionContents .= PHP_EOL . trim(
                    str_replace(['<?php', '?>', '<?PHP', '<?'], '', $contents)
                ) . PHP_EOL;
        }

        if (!file_exists($compiledIncludePath)) {
            mkdir_recursive($compiledIncludePath, true);
        }

        $this->assertTrue(is_writable($compiledIncludePath), 'Not writable: ' . $compiledIncludePath);

        if (is_writable($compiledIncludePath) && !$noExtensions) {
            file_put_contents("$compiledIncludePath/modules.ext.php", $extensionContents);
        }

        if ($noExtensions) {
            if (file_exists("$compiledIncludePath/modules.ext.php")) {
                unlink("$compiledIncludePath/modules.ext.php");
            }
        }
    }

    /**
     * @param $file
     * @param $path
     * @return bool
     */
    protected function shouldSkipFileEntry($file, $path)
    {
        if ($file === '.' || $file === '..' || strtolower(substr($file, -4)) !== '.php') {
            return true;
        }

        if (!is_file("$path/$file")) {
            return true;
        }

        return false;
    }

    /**
     * @param string $moduleName
     * @param string $className
     * @return void
     */
    public function addCoreModuleExtension($moduleName, $className)
    {
        $extIncludePath = 'custom/Extension/application/Ext/Include';
        $customClassPath = "custom/modules/$moduleName";
        $fileStart = '<?php' . PHP_EOL . PHP_EOL;

        $extIncludeContents = $fileStart . <<<EOT
\$customBeanList['$moduleName'] = 'TestCustom$className';
\$customObjectList['$moduleName'] = 'TestCustom$className';
\$customBeanFiles['$className'] = 'custom/modules/$moduleName/TestCustom$className.php';

EOT;

        $classContents = $fileStart . <<<EOT
class TestCustom$className extends $className
{
}

EOT;

        if (!file_exists($extIncludePath)) {
            mkdir_recursive($extIncludePath, true);
        }

        $this->assertTrue(is_writable($extIncludePath), 'Directory not writable: ' . $extIncludePath);

        if (is_writable($extIncludePath)) {
            file_put_contents("$extIncludePath/ZzzTestCustom$moduleName.php", $extIncludeContents);
        }

        if (!file_exists($customClassPath)) {
            mkdir_recursive($customClassPath, true);
        }

        $this->assertTrue(is_writable($customClassPath), 'Directory not writable: ' . $customClassPath);

        if (is_writable($customClassPath)) {
            file_put_contents("$customClassPath/TestCustom$className.php", $classContents);
        }

        $this->compileIncludeExtFiles();
    }

    /**
     * @param string $moduleName
     * @param string $className
     * @return void
     */
    public function removeCoreModuleExtension($moduleName, $className)
    {
        if (file_exists("custom/Extension/application/Ext/Include/ZzzTestCustom$moduleName.php")) {
            unlink("custom/Extension/application/Ext/Include/ZzzTestCustom$moduleName.php");
        }

        if (file_exists("custom/modules/$moduleName/TestCustom$className.php")) {
            unlink("custom/modules/$moduleName/TestCustom$className.php");
        }

        $this->compileIncludeExtFiles();
    }

    /**
     * @return void
     */
    public function removeCoreModuleAllExtension()
    {
        $modulesConfig = $this->moduleConfigProvider();

        foreach ($modulesConfig as $moduleName => $moduleConfig) {
            if (file_exists("custom/Extension/application/Ext/Include/ZzzTestCustom$moduleName.php")) {
                unlink("custom/Extension/application/Ext/Include/ZzzTestCustom$moduleName.php");
            }

            if (file_exists("custom/modules/$moduleName/TestCustom{$moduleConfig['meta']['className']}.php")) {
                unlink("custom/modules/$moduleName/TestCustom{$moduleConfig['meta']['className']}.php");
            }
        }

        $this->compileIncludeExtFiles();
    }

    /**
     * @return void
     */
    public function refreshModuleGlobals()
    {
        $beanList = $customBeanList = $objectList = $customObjectList = $beanFiles = $customBeanFiles = [];

        require 'include/modules.php';

        $tmpBeanList = $beanList;
        $tmpCustomBeanList = $customBeanList;
        $tmpObjectList = $objectList;
        $tmpCustomObjectList = $customObjectList;
        $tmpBeanFiles = $beanFiles;
        $tmpCustomBeanFiles = $customBeanFiles;

        global $beanList, $customBeanList, $objectList, $customObjectList, $beanFiles, $customBeanFiles;

        $beanList = $tmpBeanList;
        $customBeanList = $tmpCustomBeanList;
        $objectList = $tmpObjectList;
        $customObjectList = $tmpCustomObjectList;
        $beanFiles = $tmpBeanFiles;
        $customBeanFiles = $tmpCustomBeanFiles;
    }
}
