<?php
require_once 'PHPUnit2/Framework/TestCase.php';
require_once 'ArtsCorps/Domain/ClassManager.php';
/**
 * ClassManagerTest.php
 * 
 * Unit tests
 * 
 * @since 9-1-2006
 * @author Jesse Snyder, NPower Seattle (www.npowerseattle.org)
 * @package Test
 */

class ClassManagerTest extends PHPUnit2_Framework_TestCase {
    private $fixture;
    
    protected function setUp() {
        $this->fixture = new ArtsCorps_Domain_ClassManager();
    }

    protected function tearDown() {
        unset ($this->fixture);
    }


    public function testTest() {
        $this->assertTrue(true);
    }
    public function testConstructor() {
        $this->assertType('ArtsCorps_Domain_ClassManager', $this->fixture);
        $this->assertNotNull($this->fixture);
    }

    public function testFindAll() {
        $classes = $this->fixture->findAll();
        $this->assertNotNull($classes);
        $this->assertTrue($classes->count() > 0);
        foreach ($classes as $class) {
            $this->assertType('ArtsCorps_Domain_Class', $class);
            //print $class->displayTableEntry() . "\n";
        }
    }
    
    public function testFindById() {
        //<a href="class.php?id=0033000000La9DtAAJ">Nasrin Afrouz</a>
        $target = 'a0030000006GHKBAA4';
        $result = $this->fixture->findById($target);
        $this->assertNotNull($result);
        $this->assertRegExp('/a0030000006GHKBAA4/', $result->displayTableEntryWithArtist());
    }

    public function testFindByIds() {
        /*
         *      [exec] <a href="artist.php?id=0033000000L5HSWAA3">Christa Bell</a>
     [exec] <td><a href="class.php?id=a0030000006GHKIAA4">Urban Dance Spring 2006</a></td>
     [exec] <td></td>
     [exec] <td>Yes</td>
     [exec] </tr>
     [exec] <tr>
     [exec] <td><a href="class.php?id=a0030000006GHOxAAO">Urban Dance Theatre Spring 2006</a></td>
     [exec] <td></td>
     [exec] <td>Yes</td>
     [exec] </tr>
     [exec] <tr>
     [exec] <td><a href="class.php?id=a0030000006GHK6AAO">Urban Dance Winter 2004</a></td>
     [exec] <td></td>
     [exec] <td>Yes</td>
     [exec] </tr>
     [exec] <tr>
     [exec] <td><a href="class.php?id=a0030000006GHKBAA4">Urban Dance Winter 2004</a></td>
     [exec] <td></td>
     [exec] <td>Yes</td>
     [exec] </tr>
         */
         $targets = array('a0030000006GHKIAA4', 'a0030000006GHOxAAO', 'a0030000006GHK6AAO', 'junkID');
         $classes = $this->fixture->findByIds($targets);
         $this->assertEquals(3, $classes->count());
    }
    
    public function testFindByArtist() {
        $artistID = '0033000000L5HS0AAN';
        $classes = $this->fixture->findByArtist($artistID);
        $this->assertNotNull($classes);
        $this->assertTrue($classes->count() > 1);
    }
    
//    public function testFindPDClasses() {
//        $classes = $this->fixture->findAllProfDev();
//        foreach ($classes as $class) {
//            print $class->displayDetail();
//        }
//    }
}
?>