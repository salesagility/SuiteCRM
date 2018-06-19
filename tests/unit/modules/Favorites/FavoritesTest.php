<?PHP

class FavoritesTest extends SuiteCRM\StateCheckerPHPUnitTestCaseAbstract
{
    public function testFavorites()
    {

        
        $favorites = new Favorites();
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
        $state = new SuiteCRM\StateSaver();
        
        
        

        $favorites = new Favorites();

        
        $result = $favorites->deleteFavorite('');
        $this->assertEquals(false, $result);
        
        
        
        
    }

    public function testgetFavoriteID()
    {
        $favorites = new Favorites();

        
        $result = $favorites->getFavoriteID('', '');
        $this->assertEquals(false, $result);

        
        $result = $favorites->getFavoriteID('Accounts', '1');
        $this->assertEquals(false, $result);
    }

    public function testgetCurrentUserSidebarFavorites()
    {
        $favorites = new Favorites();

        
        $result = $favorites->getCurrentUserSidebarFavorites();
        $this->assertTrue(is_array($result));

        
        $result = $favorites->getCurrentUserSidebarFavorites('1');
        $this->assertTrue(is_array($result));
    }
}
