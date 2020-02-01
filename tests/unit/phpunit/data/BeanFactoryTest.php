<?php

use SuiteCRM\Test\BeanFactoryTestCase;

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
        $this->assertNotFalse($bean, 'Unable to get core bean for module: ' . $moduleName);
        $this->assertInstanceOf(
            $moduleConfig['className'],
            $bean,
            'Loaded bean not instance of core class: ' . $moduleConfig['className']
        );

        $this->addCoreModuleExtension($moduleName, $moduleConfig['className']);
        $refreshedConfig = $this->moduleConfigProvider()[$moduleName]['meta'];

        $customBean = BeanFactory::newBean($moduleName);
        $this->assertNotFalse($customBean, 'Unable to get custom bean for module: ' . $moduleName);
        $this->assertInstanceOf(
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
        $this->assertNotFalse($bean, 'Unable to get core test record bean for module: ' . $moduleName);
        $this->assertInstanceOf(
            $moduleConfig['className'],
            $bean,
            'Loaded bean not instance of core class: ' . $moduleConfig['className']
        );

        $this->addCoreModuleExtension($moduleName, $moduleConfig['className']);
        $refreshedConfig = $this->moduleConfigProvider()[$moduleName]['meta'];

        $customBean = BeanFactory::getBean($moduleName);
        $this->assertNotFalse($customBean, 'Unable to get custom test record bean for module: ' . $moduleName);
        $this->assertInstanceOf(
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
        $this->assertEquals($moduleConfig['className'], $beanMeta['beanName']);
        $this->assertEquals($moduleConfig['className'], $beanMeta['beanClass']);
        $this->assertEquals($moduleConfig['objectName'], $beanMeta['objectName']);
        $this->assertEquals($moduleConfig['classFile'], $beanMeta['classFile']);

        $this->addCoreModuleExtension($moduleName, $moduleConfig['className']);
        $refreshedConfig = $this->moduleConfigProvider()[$moduleName]['meta'];

        $customBeanMeta = BeanFactory::getBeanMeta($moduleName);
        $this->assertEquals($refreshedConfig['customClassName'], $customBeanMeta['customBeanName']);
        $this->assertEquals($refreshedConfig['customClassName'], $customBeanMeta['beanClass']);
        $this->assertEquals($refreshedConfig['customObjectName'], $customBeanMeta['customObjectName']);
        $this->assertEquals($refreshedConfig['customClassFile'], $customBeanMeta['customClassFile']);

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
        $refreshedConfig = $this->moduleConfigProvider()[$moduleName]['meta'];

        $customBeanClass = BeanFactory::getBeanClass($moduleName);
        $this->assertEquals($refreshedConfig['customClassName'], $customBeanClass);

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
        $refreshedConfig = $this->moduleConfigProvider()[$moduleName]['meta'];

        $beanName = BeanFactory::getBeanName($moduleName);
        $this->assertNotEquals($refreshedConfig['customClassName'], $beanName);

        return compact('moduleName','refreshedConfig');
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
        $this->assertEquals($meta['refreshedConfig']['customClassName'], $customBeanName);

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
        $this->assertEquals($moduleConfig['objectName'], $objectName);

        $this->addCoreModuleExtension($moduleName, $moduleConfig['className']);
        $refreshedConfig = $this->moduleConfigProvider()[$moduleName]['meta'];

        $objectName = BeanFactory::getObjectName($moduleName);
        $this->assertNotEquals($refreshedConfig['customObjectName'], $objectName);

        return compact('moduleName','refreshedConfig');
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
        $this->assertEquals($meta['refreshedConfig']['customObjectName'], $customObjectName);

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
        $this->assertEquals($moduleConfig['classFile'], $beanFile);

        $this->addCoreModuleExtension($moduleName, $moduleConfig['className']);
        $refreshedConfig = $this->moduleConfigProvider()[$moduleName]['meta'];

        $beanFile = BeanFactory::getBeanFile($moduleName);
        $this->assertNotEquals($refreshedConfig['customClassFile'], $beanFile);

        return compact('moduleName','refreshedConfig');
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
        $this->assertEquals($meta['refreshedConfig']['customClassFile'], $customBeanFile);

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
        $this->assertTrue($coreFileLoaded);
        $this->assertTrue(class_exists($moduleConfig['className']));

        $this->addCoreModuleExtension($moduleName, $moduleConfig['className']);
        $refreshedConfig = $this->moduleConfigProvider()[$moduleName]['meta'];

        $customFileLoaded = BeanFactory::loadBeanFile($moduleName);
        $this->assertTrue($customFileLoaded);
        $this->assertTrue(class_exists($refreshedConfig['customClassName']));

        $this->removeCoreModuleExtension($moduleName, $moduleConfig['className']);
    }
}
