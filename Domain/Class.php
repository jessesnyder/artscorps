<?php
require_once 'ArtsCorps/Domain/OrganizationManager.php';
require_once 'ArtsCorps/Domain/ArtistManager.php';
require_once 'ArtsCorps/Domain/Calendar.php';
/**
 * Class.php
 * 
 * Represents a Class object from SalesForce
 * 
 * @since Sep 18, 2006
 * @author Jesse Snyder at NPower Seattle (www.npowerseattle.org)
 * @package ArtsCorps_Domain
 */
class ArtsCorps_Domain_Class {
    const PROF_DEV_COURSE_ID = 'a0130000008MW4XAAW'; // This is documentation only, since we can't use one const inside another
    const BASE_QUERY = 'Select c.Id, c.Name, c.Teacher__c, c.Teacher__r.Id, c.Teacher__r.FirstName, c.Teacher__r.LastName, c.Co_teacher__c, c.Co_teacher__r.Id, c.Co_teacher__r.FirstName, c.Co_teacher__r.LastName, c.Facility__c, c.Facility__r.Id, c.Facility__r.Neighborhood__c, c.Facility__r.Name, c.Capacity__c, c.Start_Date__c, c.End_Date__c, c.Days__c, c.Time__c, c.Age_Ranges__c, c.Description__c, c.Open__c, c.Class_Type__c, c.No_Class_Days__c, Class_Quarter__c, Art_Medium__c, c.Course__c From Class__c c';
    const ACTIVE_YOUTH_CLASS_QUERY_FILTER = " where (c.Class_Quarter__c='Current' or c.Class_Quarter__c='Next' or c.Class_Quarter__c='Continuing') and c.Course__c !='a0130000008MW4XAAW'";
    private $id;
    private $name;
    private $teacherID;
    private $teacherName;
    private $coteacherID;
    private $coteacherName;
    private $facilityID;
    private $facilityName;
    private $facilityHood;
    private $capacity;
    private $dateStart;
    private $dateEnd;
    private $quarter;
    private $days;
    private $time;
    private $ages;
    private $isClosed;
    private $noClassDays;
    private $description;
    private $artMedium;
    private $classType;
    private $isProfDevClass;
    
    public function __construct(SObject $queryResult) {
        $this->id = (string) $queryResult->Id;
        $this->name = (string) $queryResult->fields->Name;
        $this->capacity = (double) $queryResult->fields->Capacity__c;
        $this->dateStart = strtotime((string) $queryResult->fields->Start_Date__c);
        $this->dateEnd = strtotime((string) $queryResult->fields->End_Date__c);
        $this->quarter = (string) $queryResult->fields->Class_Quarter__c;
        $this->days = (string) $queryResult->fields->Days__c;
        $this->time = (string) $queryResult->fields->Time__c;
        $this->ages = (string) $queryResult->fields->Age_Ranges__c;
        $this->isClosed = (boolean) ($queryResult->fields->Open__c == 'false');
        $this->description = (string) $queryResult->fields->Description__c;
        $this->artMedium = (string) $queryResult->fields->Art_Medium__c;
        $this->classType = (string) $queryResult->fields->Class_Type__c;
        $this->courseId = (string)$queryResult->fields->Course__c;
        $this->noClassDays = (string) $queryResult->fields->No_Class_Days__c;
        $this->isProfDevClass = (boolean) ($this->courseId == self::PROF_DEV_COURSE_ID);
        $this->parseTeacher($queryResult);
        $this->parseCoteacher($queryResult);
        $this->parseFacility($queryResult);
    }
    
    public static function getFindQuery($classID) {
        return self::BASE_QUERY  . " where c.Id='$classID'";
    }
    
    public static function getListQuery($classIDList) {
        return self::BASE_QUERY . " where c.Id='" . join($classIDList, "' or c.Id='") . "'";
    }
    
    public static function getFindAllYouthQuery() {
        return self::BASE_QUERY . self::ACTIVE_YOUTH_CLASS_QUERY_FILTER;
    }

    public static function getFindAllPDQuery() {
        $calendar = new ArtsCorps_Domain_Calendar();
        return self::BASE_QUERY . " where c.Start_Date__c>=" . $calendar->beginningOfDayDateTime() .
                                  " and c.Course__c='a0130000008MW4XAAW'";
    }   
    public static function getFindByArtistQuery($artistID) {
        return self::BASE_QUERY . self::ACTIVE_YOUTH_CLASS_QUERY_FILTER . " and (c.Teacher__c='$artistID' or c.Co_teacher__c='$artistID')";
    }
    
    public static function getFindByFacilityQuery($facilityID) {
        return self::BASE_QUERY . self::ACTIVE_YOUTH_CLASS_QUERY_FILTER . " and c.Facility__c='$facilityID'";
    }
 
    public static function getFindByFacilityIdsQuery($facilityIDList) {
        return self::BASE_QUERY . self::ACTIVE_YOUTH_CLASS_QUERY_FILTER . " and (c.Facility__c='" . join($facilityIDList, "' or c.Facility__c='") . "')";
    }   
    public function isOpen() {
        return (! $this->isClosed);
    }
    
    public function getQuarter() {
        return $this->quarter;
    }
    
    public function isInCurrentQuarter() {
        return $this->quarter == 'Current';
    }

    public function isNextQuarter() {
        return $this->quarter == 'Next';
    }
        
    public function dataDump() {
        return get_object_vars($this);
    }
    public function compareTo(ArtsCorps_Domain_Class $other) {
        return strcasecmp($this->name, $other->name);
    }
    
    public function compareByStartDate(ArtsCorps_Domain_Class $other) {
        if ($this->dateStart < $other->dateStart) {
            return 1;
        }
        if ($other->dateStart < $other->dateStart) {
            return -1;
        }
        return 0;
    }
    public function shortNameString() {
        $string = $this->name;
        $pattern = '/,? (Fall|Spring|Winter|Summer) (\d+)/i';
        $replacement = '';
        $clean = preg_replace($pattern, $replacement, $this->name);
        
        return $clean;
    }
    public function getId() {
        return $this->id;
    }
    public function getName() {
        return $this->name;
    } 
    
    public function getFacilityID() {
        return $this->facilityID;
    } 

    public function getNeighborhood() {
        return $this->facilityHood;
    }
    
    public function getArtistID() {
        return $this->teacherID;
    }
    
    public function getArtMedium() {
        return $this->artMedium;
    }
    
    public function getClassType() {
        return $this->classType;
    }
    
    private function parseTeacher($result)  {
        $this->teacherID = (string) $result->fields->Teacher__c;
        foreach($result->sobjects as $subObject) {
            if ($subObject->Id == $this->teacherID) {
                $first = (string)$subObject->fields->FirstName;
                $last = (string)$subObject->fields->LastName;
                $this->teacherName = $first . ' ' . $last;
                break;
            }
        }
    }
    private function parseCoteacher($result)  {
        $this->coteacherID = (string) $result->fields->Co_teacher__c;
        foreach($result->sobjects as $subObject) {
            if ($subObject->Id == $this->coteacherID ) {
                $first = (string)$subObject->fields->FirstName;
                $last = (string)$subObject->fields->LastName;
                $this->coteacherName = $first . ' ' . $last;
                break;
            }
        }
    }    
    private function parseFacility($result)  {
        $this->facilityID = (string) $result->fields->Facility__c;
        foreach($result->sobjects as $subObject) {
            if ($subObject->Id == $this->facilityID) {
                $name = (string)$subObject->fields->Name;
                $hood = (string)$subObject->fields->Neighborhood__c;
                $this->facilityName = $name;
                $this->facilityHood = $hood;
                break;
            }
        }
    }
    
}
?>