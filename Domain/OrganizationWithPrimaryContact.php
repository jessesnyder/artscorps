<?php
require_once 'ArtsCorps/Domain/ClassManager.php';
require_once 'ArtsCorps/Domain/FacilityContactManager.php';
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
    const BASE_QUERY = 'Select a.Id, a.Name, a.Type, a.Website, a.RecordTypeId, a.BillingStreet, a.BillingCity, a.BillingState, a.BillingPostalCode, a.Phone, a.Description, a.Community_Partner__c, a.Facility_Partner__c From Account a';
    
    private $id;
    private $name;
    private $type;
    private $isFacilityType;
    private $isCurrentFacility;
    private $street;
    private $city;
    private $state;
    private $zip;
    private $phone;
    private $description;
    private $website;
    private $contact;
    
    public function __construct(SObject $queryResult) {
        $this->id = (string) $queryResult->Id;
        $this->name = (string) $queryResult->fields->Name;
        $this->type = (string) $queryResult->fields->Type;
        $this->isFacilityType = (boolean) $queryResult->fields->RecordTypeId == self::FACILITY_RECORD_TYPE;
        $this->isCurrentFacility = (boolean) $queryResult->fields->Facility_Status__c == 'Current';
        $this->street = (string) $queryResult->fields->BillingStreet;
        $this->city = (string) $queryResult->fields->BillingCity;
        $this->state = (string) $queryResult->fields->BillingState;
        $this->zip = (string) $queryResult->fields->BillingPostalCode;
        $this->phone = (string) $queryResult->fields->Phone;
        $this->website = (string) $queryResult->fields->Website;
        $this->description = (string) $queryResult->fields->Description;

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
        return self::BASE_QUERY . " where a.RecordTypeId='" . self::FACILITY_RECORD_TYPE . "' and a.Facility_Partner__c=true";
    }
    
    public static function getFindPartnersQuery() {
        return self::BASE_QUERY . " where a.Community_Partner__c=true";
    }
    

    public function displayShortLink() {
        $html = '<li><a href="organization.php?id=' . $this->id . '">' . $this->name . '</a></li>';
        
        return $html;
    }
    
    public function displayDetail() {
        if ($this->isFacility()) {
//            $contactManager = new ArtsCorps_Domain_FacilityContactManager();
//            $this->contact = $contactManager->findForFacility($this->id);
            $classManager = new ArtsCorps_Domain_ClassManager();
            $classesForThisFacility = $classManager->findByFacility($this->id);
        }
        ob_start();
        print '<h1>' . $this->name . '</h1>';
        if ($this->street != '') { 
            print '<p>' . $this->street . '<br />' . $this->city . ', ' . $this->state . '<br />' . $this->zip . '</p>';
        }
        if ($this->phone != '') { 
            print '<p>' . $this->phone . '</p>';
        }
        if ($this->website != '') { 
            print '<p><a href="' . $this->website . '">' . $this->website . '</a></p>';
        }                
        if (isset($this->contact)) { ?>
        Contact: <?php print $this->contact->getNameString() ?><br>
        Phone: <?php print $this->contact->getPhone() ?><br>
        Email: <?php print $this->contact->getEmailLink() ?><br>
        <?php
        } ?>
        
        </p>

        <p><?php print $this->description ?></p>

        <?php 
            if (isset($classesForThisFacility)) { ?>
        <!-- Table of classes appears only for Facility-type orgs. -->
        <h2>Classes at this facility</h2>
        <table width="100%">
            <tr>
                <th>Course Name</th>
                <th>Teacher</th>
                <th class="isOpen">Open?</th>
            </tr>

            <!-- Repeat list for every class record that has facility set to this account and Start_Date within this or next quarter. -->
         <?php   
                foreach ($classesForThisFacility as $class) {
                    print $class->displayTableEntryWithArtist();
                }
            }
         ?>
            
        </table>        
        <?php
        
        $html = ob_get_contents();
        ob_end_clean();

        return $html; 
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
    
    private function isFacility() {
        return $this->isFacilityType and $this->isCurrentFacility;
    }
}
?>
