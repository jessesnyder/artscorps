<?php
require_once 'NPowerSeattle/SalesForce/ObjectManager.php';
require_once 'ArtsCorps/Domain/FacilityContact.php';
require_once 'ArtsCorps/Domain/FacilityContactList.php';
/**
 * FacilityContactManager.php
 * 
 * For retrieving FacilityContact/Teacher records and some associated data from SalesForce
 * 
 * @since Sep 18, 2006
 * @author Jesse Snyder at NPower Seattle (www.npowerseattle.org)
 * @package ArtsCorps_Domain
 */
class ArtsCorps_Domain_FacilityContactManager extends NPowerSeattle_SalesForce_ObjectManager
{
    
    public function __construct() {
        parent::__construct();
    }
    
    public function findById($contactID) {
        $query =  ArtsCorps_Domain_FacilityContact::getFindQuery($contactID);
        $list = $this->runQuery($query);
        if (isset ($list)) {
            return $list->current();
        }
        return null;  
    
    }
    
    public function findByIds($ids) {
        throw new Exception('This class does not support searching for lists');
    }
    
    public function findForFacility($facilityID) {
        $helper = NPowerSeattle_Config_AppConfigHelper::getInstance();
        $sfConnection = $helper->getProperty('SFConnection');
        $query =  ArtsCorps_Domain_FacilityContact::getFindContactForFacilityQuery($facilityID);
        trigger_error($query);
        $contactID = null;        
        try {
            $result = $sfConnection->query($query);

            if (!isset ($result->records)) {
                $this->errorString = "No records found matching those criteria";
                return null;
            }
            foreach ($result->records as $record) {
                $contact = new SObject($record);

                $contactID = (string) $contact->fields->ContactId;
                break;
            }
        } catch (Exception $e) {
            $this->errorString = $e->getMessage();
            trigger_error($this->errorString, E_USER_WARNING);
            return null;
        }
        return $this->findById($contactID);       
    }    

    protected function targetClass() {
        return 'ArtsCorps_Domain_FacilityContact';
    }    
}
?>
