<?php
require_once 'ArtsCorps/Config/AppConfigHelper.php';
/**
 * Artist.php
 * 
 * Represents a SalesForce record type
 * 
 * @since Sep 18, 2006
 * @author Jesse Snyder at NPower Seattle (www.npowerseattle.org)
 * @package ArtsCorps_Domain
 */
class ArtsCorps_Domain_Artist {
    const ARTIST_REC_TYPE = '01230000000DLkUAAW';
    const BASE_QUERY = 'Select c.Id, c.LasName, c.FirstName, c.Artistic_Disciplines__c, c.Teacher_Bio__c From Contact c';
    const FIND_ALL_QUERY = "Select c.Id, c.LasName, c.FirstName, c.Artistic_Disciplines__c, c.Teacher_Bio__c From Contact c where c.RecordTypeId='01230000000DLkUAAW'";
    const FIND_CURRENT_ARTISTS_QUERY = "Select c.Id, c.LasName, c.FirstName, c.Artistic_Disciplines__c, c.Teacher_Bio__c From Contact c where c.RecordTypeId='01230000000DLkUAAW' and c.Teaching_Status__c='Current'";

    private $id;
    private $firstName;
    private $lastName;
    private $fullName;
    private $bio;
    private $discipline;

    public static function getFindQuery($artistID) {
        return self::BASE_QUERY  . " where c.Id='$artistID'";
    }
    
    public static function getFindAllQuery() {
        return self::FIND_ALL_QUERY;
    }
    
    public static function getFindCurrentQuery() {
        return self::FIND_CURRENT_ARTISTS_QUERY;
    }    
    public static function getFindListQuery($artistIDList) {
        return self::BASE_QUERY . " where c.Id='" . join($artistIDList, "' or c.Id='") . "'";        
    }
    
    public function __construct(SObject $queryResult) {
        $this->id = (string) $queryResult->Id;
        $this->firstName = (string) $queryResult->fields->FirstName;
        $this->lastName = (string) $queryResult->fields->LastName;
        $this->fullName = $this->firstName . ' ' . $this->lastName;
        $this->bio = (string) $queryResult->fields->Teacher_Bio__c;
        $this->discipline = (string) $queryResult->fields->Artistic_Disciplines__c;
    }
    
    public function dataDump() {
        return get_object_vars($this);
    }

    public function compareTo(ArtsCorps_Domain_Artist $other) {
        return strcasecmp(($this->lastName . $this->firstName), ($other->lastName . $other->firstName));
    }
    
    public function getArtMedium() {
        return $this->discipline;
    }
    
    public function getId() {
        return $this->id;
    }
    public function getNameString() {
        return $this->fullName;
    }     
}
?>
