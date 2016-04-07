<?php
require_once 'PHPUnit2/Framework/TestCase.php';
require_once 'ArtsCorps/Domain/Calendar.php';
/**
 * CalendarTest.php
 * 
 * Unit tests
 * 
 * @since 9-1-2006
 * @author Jesse Snyder, NPower Seattle (www.npowerseattle.org)
 * @package Test
 */

class CalendarTest extends PHPUnit2_Framework_TestCase {
    private $fixture;

    protected function setUp() {
        $this->fixture = new ArtsCorps_Domain_Calendar();
    }

    protected function tearDown() {
        unset ($this->fixture);
    }

    public function testTest() {
        $this->assertTrue(true);
    }
    public function testConstructor() {
        $this->assertType('ArtsCorps_Domain_Calendar', $this->fixture);
        $this->assertNotNull($this->fixture);
    }

//    public function testCurrentQuarterString() {
//        
//    }
//
//    public function testNextQuarterString() {
//
//    }
//
//    public function testCurrentQuarterStartStamp() {
//
//    }
//
//    public function testCurrentQuarterEndStamp() {
//
//    }
//
//    public function testNextQuarterStartStamp() {
//
//    }
//
//    public function testNextQuarterEndStamp() {
//
//    }
//
//    public function testCurrentQuarterStartDateTime() {
//
//    }
//    public function testCurrentQuarterEndDateTime() {
//
//    }
//    public function testNextQuarterStartDateTime() {
//
//    }
//    public function testNextQuarterEndDateTime() {
//        
//
//    }
    public function testTodayDateTime() {
        $time = $this->fixture->todayDateTime();
//        print $time . "\n";
        $now = time();
//        print $now . "\n";
        $this->assertTrue($now > strtotime($time));
    }
    
    public function testBeginningOfDayDateTime() {
        $thisMorning = $this->fixture->beginningOfDayDateTime();
        
        print $thisMorning . "\n";
        $now = time();
        print $now . "\n";
        
        $this->assertTrue($thisMorning > strtotime($now));
    }
}
?>