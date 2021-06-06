<?php

use SuiteCRM\Tests\SuiteCRM\Test\BeanFactoryTestCase;

/**
 * Class BeanFactoryTest
 * TODO: BeanFactoryTest::convertParams
 * TODO: BeanFactoryTest::testInitBeanRegistry
 * TODO: BeanFactoryTest::testHasEncodeFlag
 * TODO: BeanFactoryTest::testHasDeletedFlag
 * TODO: BeanFactoryTest::testRegisterBean
 * TODO: BeanFactoryTest::testUnregisterBean
 *
 */
class BeanFactoryTest extends BeanFactoryTestCase
{
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
        self::assertNotFalse($bean, 'Unable to get core bean for module: ' . $moduleName);
        self::assertInstanceOf(
            $moduleConfig['className'],
            $bean,
            'Loaded bean not instance of core class: ' . $moduleConfig['className']
        );

        $this->addCoreModuleExtension($moduleName, $moduleConfig['className']);
        $refreshedConfig = $this->moduleConfigProvider()[$moduleName]['meta'];

        $customBean = BeanFactory::newBean($moduleName);
        self::assertNotFalse($customBean, 'Unable to get custom bean for module: ' . $moduleName);
        self::assertInstanceOf(
            $refreshedConfig['customClassName'],
            $customBean,
            'Loaded bean not instance of custom class: ' . $refreshedConfig['customClassName']
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
        self::assertNotFalse($bean, 'Unable to get core test record bean for module: ' . $moduleName);
        self::assertInstanceOf(
            $moduleConfig['className'],
            $bean,
            'Loaded bean not instance of core class: ' . $moduleConfig['className']
        );

        $this->addCoreModuleExtension($moduleName, $moduleConfig['className']);
        $refreshedConfig = $this->moduleConfigProvider()[$moduleName]['meta'];

        $customBean = BeanFactory::getBean($moduleName);
        self::assertNotFalse($customBean, 'Unable to get custom test record bean for module: ' . $moduleName);
        self::assertInstanceOf(
            $refreshedConfig['customClassName'],
            $customBean,
            'Loaded bean not instance of custom class: ' . $refreshedConfig['customClassName']
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
        self::assertEquals($moduleConfig['className'], $beanMeta['beanName']);
        self::assertEquals($moduleConfig['className'], $beanMeta['beanClass']);
        self::assertEquals($moduleConfig['objectName'], $beanMeta['objectName']);
        self::assertEquals($moduleConfig['classFile'], $beanMeta['classFile']);

        $this->addCoreModuleExtension($moduleName, $moduleConfig['className']);
        $refreshedConfig = $this->moduleConfigProvider()[$moduleName]['meta'];

        $customBeanMeta = BeanFactory::getBeanMeta($moduleName);
        self::assertEquals($refreshedConfig['customClassName'], $customBeanMeta['customBeanName']);
        self::assertEquals($refreshedConfig['customClassName'], $customBeanMeta['beanClass']);
        self::assertEquals($refreshedConfig['customObjectName'], $customBeanMeta['customObjectName']);
        self::assertEquals($refreshedConfig['customClassFile'], $customBeanMeta['customClassFile']);

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
        self::assertEquals($moduleConfig['className'], $coreBeanClass);

        $this->addCoreModuleExtension($moduleName, $moduleConfig['className']);
        $refreshedConfig = $this->moduleConfigProvider()[$moduleName]['meta'];

        $customBeanClass = BeanFactory::getBeanClass($moduleName);
        self::assertEquals($refreshedConfig['customClassName'], $customBeanClass);

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
        self::assertEquals($moduleConfig['className'], $beanName);

        $this->addCoreModuleExtension($moduleName, $moduleConfig['className']);
        $refreshedConfig = $this->moduleConfigProvider()[$moduleName]['meta'];

        $beanName = BeanFactory::getBeanName($moduleName);
        self::assertNotEquals($refreshedConfig['customClassName'], $beanName);

        $this->subTestGetCustomBeanName(compact('moduleName', 'refreshedConfig'));
    }

    /**
     * @depends testGetBeanName
     *
     * @param array $meta
     * @return void
     */
    public function subTestGetCustomBeanName($meta)
    {
        $customBeanName = BeanFactory::getCustomBeanName($meta['moduleName']);
        self::assertEquals($meta['refreshedConfig']['customClassName'], $customBeanName);

        $this->removeCoreModuleExtension($meta['moduleName'], $meta['refreshedConfig']['className']);
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
        self::assertEquals($moduleConfig['objectName'], $objectName);

        $this->addCoreModuleExtension($moduleName, $moduleConfig['className']);
        $refreshedConfig = $this->moduleConfigProvider()[$moduleName]['meta'];

        $objectName = BeanFactory::getObjectName($moduleName);
        self::assertNotEquals($refreshedConfig['customObjectName'], $objectName);

        $this->subTestGetCustomObjectName(compact('moduleName', 'refreshedConfig'));
    }

    /**
     * @depends testGetObjectName
     *
     * @param array $meta
     * @return void
     */
    public function subTestGetCustomObjectName($meta)
    {
        $customObjectName = BeanFactory::getCustomObjectName($meta['moduleName']);
        self::assertEquals($meta['refreshedConfig']['customObjectName'], $customObjectName);

        $this->removeCoreModuleExtension($meta['moduleName'], $meta['refreshedConfig']['className']);
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
        self::assertEquals($moduleConfig['classFile'], $beanFile);

        $this->addCoreModuleExtension($moduleName, $moduleConfig['className']);
        $refreshedConfig = $this->moduleConfigProvider()[$moduleName]['meta'];

        $beanFile = BeanFactory::getBeanFile($moduleName);
        self::assertNotEquals($refreshedConfig['customClassFile'], $beanFile);

        $this->subTestGetCustomBeanFile(compact('moduleName', 'refreshedConfig'));
    }

    /**
     * @depends testGetBeanFile
     *
     * @param array $meta
     * @return void
     */
    public function subTestGetCustomBeanFile($meta)
    {
        $customBeanFile = BeanFactory::getCustomBeanFile($meta['moduleName']);
        self::assertEquals($meta['refreshedConfig']['customClassFile'], $customBeanFile);

        $this->removeCoreModuleExtension($meta['moduleName'], $meta['refreshedConfig']['className']);
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
        self::assertTrue($coreFileLoaded);
        self::assertTrue(class_exists($moduleConfig['className']));

        $this->addCoreModuleExtension($moduleName, $moduleConfig['className']);
        $refreshedConfig = $this->moduleConfigProvider()[$moduleName]['meta'];

        $customFileLoaded = BeanFactory::loadBeanFile($moduleName);
        self::assertTrue($customFileLoaded);
        self::assertTrue(class_exists($refreshedConfig['customClassName']));

        $this->removeCoreModuleExtension($moduleName, $moduleConfig['className']);
    }
}
