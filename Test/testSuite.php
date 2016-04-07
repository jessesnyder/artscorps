<?php
define('PHPUnit2_MAIN_METHOD', 'SalesForceTests::main');
/**
 * testSuite.php
 * 
 * Runs unit tests
 * 
 * Jun 8, 2006
 *  @author Jesse Snyder at NPowerSeattle
 * @package Test
 */

require_once 'PHPUnit2/Framework/TestSuite.php';
require_once 'PHPUnit2/TextUI/TestRunner.php';
require_once 'ArtistManagerTest.php';
require_once 'ClassManagerTest.php';
require_once 'CalendarTest.php';

 
class SVPITests {
    public static function main() {
        $ts = new PHPUnit2_Framework_TestSuite('SVPI Tests');
//        $ts->addTestSuite('ArtistManagerTest');
//       $ts->addTestSuite('ClassManagerTest');
        $ts->addTestSuite('CalendarTest');
        
        PHPUnit2_TextUI_TestRunner::run($ts);
    }
}

SVPITests::main();
?>
?>
