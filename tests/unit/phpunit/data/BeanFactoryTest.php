<?php

use PHPUnit\Framework\TestCase;

/**
 * Class BeanFactoryTest
 * TODO: BeanFactoryTest::testInitBeanRegistry
 * TODO: BeanFactoryTest::testHasEncodeFlag
 * TODO: BeanFactoryTest::testHasDeletedFlag
 * TODO: BeanFactoryTest::testRegisterBean
 * TODO: BeanFactoryTest::testUnregisterBean
 *
 */
class BeanFactoryTest extends TestCase
{
    /**
     * @return void
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

        parent::tearDown();
    }

    /**
     * @return void
     */
    public function compileIncludeExtFiles()
    {
        $extensionContents = '<?php' . PHP_EOL;
        $compiledIncludePath = 'custom/application/Ext/Include';
        $extIncludePath = 'custom/Extension/application/Ext/Include';
        $extIncludeDir = dir($extIncludePath);

        $noExtensions = true;
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
    public function refreshGlobals()
    {
        $beanList = $customBeanList = $objectList = $customObjectList = $beanFiles = $customBeanFiles = [];

        require 'include/modules.php';

        $GLOBALS['beanList'] = $beanList;
        $GLOBALS['customBeanList'] = $customBeanList;
        $GLOBALS['objectList'] = $objectList;
        $GLOBALS['customObjectList'] = $customObjectList;
        $GLOBALS['beanFiles'] = $beanFiles;
        $GLOBALS['customBeanFiles'] = $customBeanFiles;
    }

    /**
     * @return array
     */
    public function moduleConfigProvider()
    {
        $this->refreshGlobals();

        global $beanList, $customBeanList, $objectList, $customObjectList, $beanFiles, $customBeanFiles;

        $modulesConfig = [];
        foreach ($beanList as $moduleName => $moduleClass) {
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
     * @dataProvider moduleConfigProvider
     *
     * @param string $moduleName
     * @param array $moduleConfig
     * @return void
     */
    public function testNewBean($moduleName, $moduleConfig)
    {
        $this->removeCoreModuleExtension($moduleName, $moduleConfig['className']);

        $bean = BeanFactory::newBean($moduleName);
        $this->assertNotFalse($bean, 'Unable to get core bean for module: ' . $moduleName);
        $this->assertInstanceOf(
            $moduleConfig['className'],
            $bean,
            'Loaded bean not instance of core class: ' . $moduleConfig['className']
        );

        $this->addCoreModuleExtension($moduleName, $moduleConfig['className']);
        $refreshedModuleConfig = $this->moduleConfigProvider()[$moduleName]['meta'];

        $customBean = BeanFactory::newBean($moduleName);
        $this->assertNotFalse($customBean, 'Unable to get custom bean for module: ' . $moduleName);
        $this->assertInstanceOf(
            $refreshedModuleConfig['customClassName'],
            $customBean,
            'Loaded bean not instance of custom class: ' . $refreshedModuleConfig['customClassName']
        );

        $this->removeCoreModuleExtension($moduleName, $moduleConfig['className']);
    }


    /**
     * @dataProvider moduleConfigProvider

     *
     * @param string $moduleName
     * @param array $moduleConfig
     * @return void
     */
    public function testGetBean($moduleName, $moduleConfig)
    {
        $this->removeCoreModuleExtension($moduleName, $moduleConfig['className']);

        $bean = BeanFactory::getBean($moduleName);
        $this->assertNotFalse($bean, 'Unable to get core test record bean for module: ' . $moduleName);
        $this->assertInstanceOf(
            $moduleConfig['className'],
            $bean,
            'Loaded bean not instance of core class: ' . $moduleConfig['className']
        );

        $this->addCoreModuleExtension($moduleName, $moduleConfig['className']);
        $refreshedModuleConfig = $this->moduleConfigProvider()[$moduleName]['meta'];

        $customBean = BeanFactory::getBean($moduleName);
        $this->assertNotFalse($customBean, 'Unable to get custom test record bean for module: ' . $moduleName);
        $this->assertInstanceOf(
            $refreshedModuleConfig['customClassName'],
            $customBean,
            'Loaded bean not instance of custom class: ' . $refreshedModuleConfig['customClassName']
        );

        $this->removeCoreModuleExtension($moduleName, $moduleConfig['className']);
    }

    /**
     * @dataProvider moduleConfigProvider
     *
     * @param string $moduleName
     * @param array $moduleConfig
     * @return void
     */
    public function testGetBeanMeta($moduleName, $moduleConfig)
    {
        $this->removeCoreModuleExtension($moduleName, $moduleConfig['className']);

        $beanMeta = BeanFactory::getBeanMeta($moduleName);
        $this->assertEquals($moduleConfig['className'], $beanMeta['beanName']);
        $this->assertEquals($moduleConfig['className'], $beanMeta['beanClass']);
        $this->assertEquals($moduleConfig['objectName'], $beanMeta['objectName']);
        $this->assertEquals($moduleConfig['classFile'], $beanMeta['classFile']);

        $this->addCoreModuleExtension($moduleName, $moduleConfig['className']);
        $refreshedModuleConfig = $this->moduleConfigProvider()[$moduleName]['meta'];

        $customBeanMeta = BeanFactory::getBeanMeta($moduleName);
        $this->assertEquals($refreshedModuleConfig['customClassName'], $customBeanMeta['customBeanName']);
        $this->assertEquals($refreshedModuleConfig['customClassName'], $customBeanMeta['beanClass']);
        $this->assertEquals($refreshedModuleConfig['customObjectName'], $customBeanMeta['customObjectName']);
        $this->assertEquals($refreshedModuleConfig['customClassFile'], $customBeanMeta['customClassFile']);

        $this->removeCoreModuleExtension($moduleName, $moduleConfig['className']);
    }

    /**
     * @dataProvider moduleConfigProvider
     *
     * @param string $moduleName
     * @param array $moduleConfig
     * @return void
     */
    public function testGetBeanClass($moduleName, $moduleConfig)
    {
        $this->removeCoreModuleExtension($moduleName, $moduleConfig['className']);

        $coreBeanClass = BeanFactory::getBeanClass($moduleName);
        $this->assertEquals($moduleConfig['className'], $coreBeanClass);

        $this->addCoreModuleExtension($moduleName, $moduleConfig['className']);
        $refreshedModuleConfig = $this->moduleConfigProvider()[$moduleName]['meta'];

        $customBeanClass = BeanFactory::getBeanClass($moduleName);
        $this->assertEquals($refreshedModuleConfig['customClassName'], $customBeanClass);

        $this->removeCoreModuleExtension($moduleName, $moduleConfig['className']);
    }

    /**
     * @dataProvider moduleConfigProvider
     *
     * @param string $moduleName
     * @param array $moduleConfig
     * @return array
     */
    public function testGetBeanName($moduleName, $moduleConfig)
    {
        $this->removeCoreModuleExtension($moduleName, $moduleConfig['className']);

        $beanName = BeanFactory::getBeanName($moduleName);
        $this->assertEquals($moduleConfig['className'], $beanName);

        $this->addCoreModuleExtension($moduleName, $moduleConfig['className']);
        $refreshedModuleConfig = $this->moduleConfigProvider()[$moduleName]['meta'];

        $beanName = BeanFactory::getBeanName($moduleName);
        $this->assertNotEquals($refreshedModuleConfig['customClassName'], $beanName);

        return compact('moduleName','refreshedModuleConfig');
    }

    /**
     * @depends testGetBeanName
     *
     * @param array $meta
     * @return void
     */
    public function testGetCustomBeanName($meta)
    {
        $customBeanName = BeanFactory::getCustomBeanName($meta['moduleName']);
        $this->assertEquals($meta['refreshedModuleConfig']['customClassName'], $customBeanName);

        $this->removeCoreModuleExtension($meta['moduleName'], $meta['refreshedModuleConfig']['className']);
    }

    /**
     * @dataProvider moduleConfigProvider
     *
     * @param string $moduleName
     * @param array $moduleConfig
     * @return array
     */
    public function testGetObjectName($moduleName, $moduleConfig)
    {
        $this->removeCoreModuleExtension($moduleName, $moduleConfig['className']);

        $objectName = BeanFactory::getObjectName($moduleName);
        $this->assertEquals($moduleConfig['objectName'], $objectName);

        $this->addCoreModuleExtension($moduleName, $moduleConfig['className']);
        $refreshedModuleConfig = $this->moduleConfigProvider()[$moduleName]['meta'];

        $objectName = BeanFactory::getObjectName($moduleName);
        $this->assertNotEquals($refreshedModuleConfig['customObjectName'], $objectName);

        return compact('moduleName','refreshedModuleConfig');
    }

    /**
     * @depends testGetObjectName
     *
     * @param array $meta
     * @return void
     */
    public function testGetCustomObjectName($meta)
    {
        $customObjectName = BeanFactory::getCustomObjectName($meta['moduleName']);
        $this->assertEquals($meta['refreshedModuleConfig']['customObjectName'], $customObjectName);

        $this->removeCoreModuleExtension($meta['moduleName'], $meta['refreshedModuleConfig']['className']);
    }

    /**
     * @dataProvider moduleConfigProvider
     *
     * @param string $moduleName
     * @param array $moduleConfig
     *
     * @return array
     */
    public function testGetBeanFile($moduleName, $moduleConfig)
    {
        $this->removeCoreModuleExtension($moduleName, $moduleConfig['className']);

        $beanFile = BeanFactory::getBeanFile($moduleName);
        $this->assertEquals($moduleConfig['classFile'], $beanFile);

        $this->addCoreModuleExtension($moduleName, $moduleConfig['className']);
        $refreshedModuleConfig = $this->moduleConfigProvider()[$moduleName]['meta'];

        $beanFile = BeanFactory::getBeanFile($moduleName);
        $this->assertNotEquals($refreshedModuleConfig['customClassFile'], $beanFile);

        return compact('moduleName','refreshedModuleConfig');
    }

    /**
     * @depends testGetBeanFile
     *
     * @param array $meta
     * @return void
     */
    public function testGetCustomBeanFile($meta)
    {
        $customBeanFile = BeanFactory::getCustomBeanFile($meta['moduleName']);
        $this->assertEquals($meta['refreshedModuleConfig']['customClassFile'], $customBeanFile);

        $this->removeCoreModuleExtension($meta['moduleName'], $meta['refreshedModuleConfig']['className']);
    }

    /**
     * @dataProvider moduleConfigProvider
     *
     * @param string $moduleName
     * @param array $moduleConfig
     */
    public function testLoadBeanFile($moduleName, $moduleConfig)
    {
        $this->removeCoreModuleExtension($moduleName, $moduleConfig['className']);

        $coreFileLoaded = BeanFactory::loadBeanFile($moduleName);
        $this->assertTrue($coreFileLoaded);
        $this->assertTrue(class_exists($moduleConfig['className']));

        $this->addCoreModuleExtension($moduleName, $moduleConfig['className']);
        $refreshedModuleConfig = $this->moduleConfigProvider()[$moduleName]['meta'];

        $customFileLoaded = BeanFactory::loadBeanFile($moduleName);
        $this->assertTrue($customFileLoaded);
        $this->assertTrue(class_exists($refreshedModuleConfig['customClassName']));

        $this->removeCoreModuleExtension($moduleName, $moduleConfig['className']);
    }
}
