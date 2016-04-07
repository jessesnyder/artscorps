<?php
/**
 * FacilityContact.php
 * 
 * Represents a SalesForce record type
 * 
 * @since Sep 18, 2006
 * @author Jesse Snyder at NPower Seattle (www.npowerseattle.org)
 * @package ArtsCorps_Domain
 */
class ArtsCorps_Domain_FacilityContact {
    const BASE_QUERY = 'Select c.Id, c.LastName, c.FirstName, c.Phone, c.Email, c.Title From Contact c';
    const PRIMARY_CONTACT_QUERY = 'Select a.Id, a.AccountId, a.ContactId, a.IsPrimary From AccountContactRole a';

    private $id;
    private $firstName;
    private $lastName;
    private $fullName;
    private $phone;
    private $email;
    private $title;

    public static function getFindQuery($contactID) {
        return self::BASE_QUERY  . " where c.Id='$contactID'";
    }
    
    public static function getFindContactForFacilityQuery($facilityID) {
        return self::PRIMARY_CONTACT_QUERY . " where a.AccountId='$facilityID' and a.IsPrimary=true";
    }
    
    public function __construct(SObject $queryResult) {
        $this->id = (string) $queryResult->Id;
        $this->firstName = (string) $queryResult->fields->FirstName;
        $this->lastName = (string) $queryResult->fields->LastName;
        $this->phone = (string) $queryResult->fields->Title;
        $this->fullName = $this->firstName . ' ' . $this->lastName . ' - ' . $this->title;
        $this->email = (string) $queryResult->fields->Email;
        $this->phone = (string) $queryResult->fields->Phone;
        
    }

    public function getPhone() {
        return $this->phone;
    }
    
    public function getEmailLink() {
        return '<a href="mailto:' . $this->email . '">' . $this->email  . '</a>';
    }
    
    public function getId() {
        return $this->id;
    }
    public function getNameString() {
        return $this->fullName;
    }     
}
?>
