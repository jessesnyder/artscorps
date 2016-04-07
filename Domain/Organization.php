<?php
require_once 'ArtsCorps/Domain/ClassManager.php';
/**
 * Organization.php
 * 
 * Represents a Facility object from SalesForce
 * 
 * @since Sep 18, 2006
 * @author Jesse Snyder at NPower Seattle (www.npowerseattle.org)
 * @package ArtsCorps_Domain
 */
class ArtsCorps_Domain_Organization {
    const FACILITY_RECORD_TYPE = '01230000000DM58AAG';
    const BASE_QUERY = 'Select a.Id, a.Name, a.Type, a.Website, a.RecordTypeId, a.BillingStreet, a.BillingCity, a.BillingState, a.BillingPostalCode, a.Phone, a.Description, a.Community_Partner__c, a.Facility_Status__c, a.Neighborhood__c From Account a';
    
    private $id;
    private $name;
    private $type;
    private $isFacility;
    private $street;
    private $city;
    private $state;
    private $zip;
    private $phone;
    private $description;
    private $website;
    private $neighborhood;
    
    public function __construct(SObject $queryResult) {
        $this->id = (string) $queryResult->Id;
        $this->name = (string) $queryResult->fields->Name;
        $isFacilityType = (boolean) $queryResult->fields->RecordTypeId == self::FACILITY_RECORD_TYPE;
        $isCurrentFacility = (boolean) $queryResult->fields->Facility_Status__c == 'Current';
        $this->isFacility = $isFacilityType and $isCurrentFacility;
        $this->street = (string) $queryResult->fields->BillingStreet;
        $this->city = (string) $queryResult->fields->BillingCity;
        $this->state = (string) $queryResult->fields->BillingState;
        $this->zip = (string) $queryResult->fields->BillingPostalCode;
        $this->phone = (string) $queryResult->fields->Phone;
        $this->website = $this->normalizeWebsite((string) $queryResult->fields->Website);
        $this->description = (string) $queryResult->fields->Description;
        $this->neighborhood = (string) $queryResult->fields->Neighborhood__c;
        $this->isPartner = (boolean) $queryResult->fields->Community_Partner__c;
    }
    public static function getFindQuery($orgID) {
        return self::BASE_QUERY  . " where a.Id='$orgID'";
    }
    
    public static function getListQuery($orgIDList) {
        return self::BASE_QUERY . " where a.Id='" . join($orgIDList, "' or a.Id='") . "'";
    }
    
    public static function getFindAllQuery() {
        return self::BASE_QUERY;
    }

    public static function getFindFacilitiesQuery() {
        return self::BASE_QUERY . " where a.RecordTypeId='" . self::FACILITY_RECORD_TYPE . "' and a.Facility_Status__c='Current'";
    }
    
    public static function getFindPartnersQuery() {
        return self::BASE_QUERY . " where a.Community_Partner__c=true";
    }
    
    public function dataDump() {
        return get_object_vars($this);
    }

    public function compareTo(ArtsCorps_Domain_Organization $other) {
        return strcasecmp($this->name, $other->name);
    }
    
    public function getId() {
        return $this->id;
    }
    public function getName() {
        return $this->name;
    }
    
    public function getNeighborhood() {
        return $this->neighborhood;
    }
    
    private function normalizeWebsite($webString) {
        if (strlen(trim($webString)) > 0 and !strstr($webString, 'http://')) {
            return 'http://' . $webString;
        }
        return $webString;
    } 
}
?>
