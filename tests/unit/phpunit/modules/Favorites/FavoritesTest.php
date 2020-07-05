<?php

use SuiteCRM\Test\SuitePHPUnitFrameworkTestCase;

class FavoritesTest extends SuitePHPUnitFrameworkTestCase
{
    public function testFavorites()
    {
        // Execute the constructor and check for the Object type and  attributes
        $favorites = BeanFactory::newBean('Favorites');
        $this->assertInstanceOf('Favorites', $favorites);
        $this->assertInstanceOf('Basic', $favorites);
        $this->assertInstanceOf('SugarBean', $favorites);

        $this->assertAttributeEquals('Favorites', 'module_dir', $favorites);
        $this->assertAttributeEquals('Favorites', 'object_name', $favorites);
        $this->assertAttributeEquals('favorites', 'table_name', $favorites);
        $this->assertAttributeEquals(true, 'new_schema', $favorites);
    }

    public function testdeleteFavorite()
    {
        $favorites = BeanFactory::newBean('Favorites');

        //testing with an empty ID
        $result = $favorites->deleteFavorite('');
        $this->assertEquals(false, $result);
    }

    public function testgetFavoriteID()
    {
        $favorites = BeanFactory::newBean('Favorites');

        //test with blank string parameters
        $result = $favorites->getFavoriteID('', '');
        $this->assertEquals(false, $result);

        //test with string parameters
        $result = $favorites->getFavoriteID('Accounts', '1');
        $this->assertEquals(false, $result);
    }

    public function testgetCurrentUserSidebarFavorites()
    {
        $favorites = BeanFactory::newBean('Favorites');

        //test with empty string parameter
        $result = $favorites->getCurrentUserSidebarFavorites();
        $this->assertTrue(is_array($result));

        //test with string
        $result = $favorites->getCurrentUserSidebarFavorites('1');
        $this->assertTrue(is_array($result));
    }
}
