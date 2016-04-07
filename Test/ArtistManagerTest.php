<?php
require_once 'PHPUnit2/Framework/TestCase.php';
require_once 'ArtsCorps/Domain/ArtistManager.php';
/**
 * ArtistManagerTest.php
 * 
 * Unit tests
 * 
 * @since 9-1-2006
 * @author Jesse Snyder, NPower Seattle (www.npowerseattle.org)
 * @package Test
 */

class ArtistManagerTest extends PHPUnit2_Framework_TestCase {
    private $fixture;
    
    protected function setUp() {
        $this->fixture = new ArtsCorps_Domain_ArtistManager();
    }

    protected function tearDown() {
        unset ($this->fixture);
    }


    public function testTest() {
        $this->assertTrue(true);
    }
    public function testConstructor() {
        $this->assertType('ArtsCorps_Domain_ArtistManager', $this->fixture);
        $this->assertNotNull($this->fixture);
    }

    public function testFindAll() {
        $artists = $this->fixture->findAll();
        $this->assertNotNull($artists);
        $this->assertTrue($artists->count() > 0);
        foreach ($artists as $artist) {
            $this->assertType('ArtsCorps_Domain_Artist', $artist);
           // print $artist->displayShortLink() . "\n";
        }
    }
    
    public function testFindById() {
        //<a href="artist.php?id=0033000000La9DtAAJ">Nasrin Afrouz</a>
        $target = '0033000000La9DtAAJ';
        $nasrin = $this->fixture->findById($target);
        $this->assertNotNull($nasrin);
        $this->assertRegExp('/id=0033000000La9DtAAJ"/', $nasrin->displayShortLink());
    }

    public function testFindByIds() {
        /*
         *      [exec] <a href="artist.php?id=0033000000L5HSWAA3">Christa Bell</a>
     [exec] <a href="artist.php?id=0033000000L5HSXAA3">Anne-Marie Grgich</a>
     [exec] <a href="artist.php?id=0033000000L5HSYAA3">Timothy Miller</a>
         */
         $targets = array('0033000000L5HSWAA3', '0033000000L5HSXAA3', '0033000000L5HSYAA3', 'junkID');
         $artists = $this->fixture->findByIds($targets);
         $this->assertEquals(3, $artists->count());
    }
}
?>