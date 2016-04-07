<?php
require_once 'NPowerSeattle/SalesForce/ObjectManager.php';
require_once 'ArtsCorps/Domain/Organization.php';
require_once 'ArtsCorps/Domain/OrganizationList.php';
/**
 * OrganizationManager.php
 * 
 * For retrieving Organization records and some associated data from SalesForce
 * 
 * @since Sep 18, 2006
 * @author Jesse Snyder at NPower Seattle (www.npowerseattle.org)
 * @package ArtsCorps_Domain
 */
class ArtsCorps_Domain_OrganizationManager extends NPowerSeattle_SalesForce_ObjectManager
{
    
    public function __construct() {
        parent::__construct();
        
    }
    
    public function findById($orgID) {
        $query =  ArtsCorps_Domain_Organization::getFindQuery($orgID);
        $list = $this->runQuery($query);
        if (isset ($list)) {
            return $list->current();
        }
        return null;        
    }
    
    public function findByIds($orgIDList) {
        $query = ArtsCorps_Domain_Organization::getListQuery($orgIDList);
        $list = $this->runQuery($query);
        if (isset ($list)) {
            return $list;
        }
        return null;          
    }  

    public function findByArtist($artistID) {
        $query = ArtsCorps_Domain_Organization::getFindByArtistQuery($artistID);
        $list = $this->runQuery($query);
        if (isset ($list)) {
            return $list;
        }
        return null;          
    }     
    public function findAll() {
        $query = ArtsCorps_Domain_Organization::getFindAllQuery();
        $list = $this->runQuery($query);
        if (isset ($list)) {
            return $list;
        }
        return null;        
    }

    public function findFacilities() {
        $query = ArtsCorps_Domain_Organization::getFindFacilitiesQuery();
        $list = $this->runQuery($query);
        if (isset ($list)) {
            return $list;
        }
        return null;        
    }    

    public function findPartners() {
        $query = ArtsCorps_Domain_Organization::getFindPartnersQuery();
        $list = $this->runQuery($query);
        if (isset ($list)) {
            return $list;
        }
        return null;        
    } 
       
    protected function targetClass() {
        return 'ArtsCorps_Domain_Organization';
    }
}
?>
