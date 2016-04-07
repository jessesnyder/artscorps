<?php
require_once 'NPowerSeattle/SalesForce/ObjectManager.php';
require_once 'ArtsCorps/Domain/Class.php';
require_once 'ArtsCorps/Domain/ClassList.php';
require_once 'NPowerSeattle/WebUtil/Session.php';

/**
 * ClassManager.php
 * 
 * For retrieving Class records and some associated data from SalesForce
 * 
 * @since Sep 18, 2006
 * @author Jesse Snyder at NPower Seattle (www.npowerseattle.org)
 * @package ArtsCorps_Domain
 */
class ArtsCorps_Domain_ClassManager extends NPowerSeattle_SalesForce_ObjectManager {
    const CURRENT_QUARTER_QUERY = 'Select c.Current_Quarter_Code__c From Class__c c';
    private static $stringForQuarter = array('Winter', 'Spring', 'Summer', 'Fall');
        
    private $currentQuarterCode;
    private $currentQuarterString;
    private $nextQuarterString;
    
    public function __construct() {
        parent :: __construct();
        $this->retrieveQuarterInfo();
    }

    public function currentQuarterString() {
        return $this->currentQuarterString;
    }
    
    public function nextQuarterString() {
        return $this->nextQuarterString;        
    }
    
    public function findById($classID) {
        $query = ArtsCorps_Domain_Class :: getFindQuery($classID);

        $list = $this->runQuery($query);
        if (isset ($list)) {
            return $list->current();
        }
        return null;
    }

    public function findByIds($classIDList) {
        $query = ArtsCorps_Domain_Class :: getListQuery($classIDList);
        $list = $this->runQuery($query);
        if (isset ($list)) {
            return $list;
        }

        return null;
    }

    public function findByArtist($artistID) {
        $query = ArtsCorps_Domain_Class :: getFindByArtistQuery($artistID);
        $list = $this->runQuery($query);
        if (isset ($list)) {
            return $list;
        }
        return null;
    }

    public function findByFacility($facilityID) {
        $query = ArtsCorps_Domain_Class :: getFindByFacilityQuery($facilityID);
        $list = $this->runQuery($query);
        if (isset ($list)) {
            return $list;
        }
        return null;
    }
    
    public function findByFacilityList($facilityList) {
        $query = ArtsCorps_Domain_Class :: getFindByFacilityIdsQuery($facilityList);
        $list = $this->runQuery($query);
        if (isset ($list)) {
            return $list;
        }
        return null;
    }
    
    public function findAll() {
        $query = ArtsCorps_Domain_Class :: getFindAllYouthQuery();
        $list = $this->runQuery($query);
        if (isset ($list)) {
            return $list;
        }
        return null;
    }
    public function findAllProfDev() {
        $query = ArtsCorps_Domain_Class :: getFindAllPDQuery();
        $list = $this->runQuery($query);
        if (isset ($list)) {
            return $list;
        }
        return null;
    }    
    
    protected function targetClass() {
        return 'ArtsCorps_Domain_Class';
    }
    
    private function retrieveQuarterInfo() {
        $query = self::CURRENT_QUARTER_QUERY;
        $getRawResult = true;   
        $records = $this->runQuery($query, $getRawResult);
        $record = new SObject($records[0]);

        $this->currentQuarterCode = (double)$record->fields->Current_Quarter_Code__c;
        $year = (integer)($this->currentQuarterCode / 4);
        $quarterInt = $this->currentQuarterCode % 4;
        $this->currentQuarterString = self::$stringForQuarter[$quarterInt] . ' ' . $year;
        if ($quarterInt == 3) {
            $year++;
        }
        $this->nextQuarterString = self::$stringForQuarter[($quarterInt + 1) % 4] . ' ' . $year;
    }
}
?>