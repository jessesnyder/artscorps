<?php
require_once 'NPowerSeattle/SalesForce/ObjectManager.php';
require_once 'ArtsCorps/Domain/ArtistList.php';
require_once 'ArtsCorps/Domain/Artist.php';
/**
 * ArtistManager.php
 * 
 * For retrieving Artist/Teacher records and some associated data from SalesForce
 * 
 * @since Sep 18, 2006
 * @author Jesse Snyder at NPower Seattle (www.npowerseattle.org)
 * @package ArtsCorps_Domain
 */
class ArtsCorps_Domain_ArtistManager extends NPowerSeattle_SalesForce_ObjectManager
{
    
    public function __construct() {
        parent::__construct();
    }
    
    public function findById($artistID) {
        $query =  ArtsCorps_Domain_Artist::getFindQuery($artistID);
        
        $list = $this->runQuery($query);
        if (isset ($list)) {
            return $list->current();
        }
        return null;        
    }
    
    public function findByIds($artistIDList) {
        $query =  ArtsCorps_Domain_Artist::getFindListQuery($artistIDList);
        $list = $this->runQuery($query);
        if (isset ($list)) {
            return $list;
        }
        return null;         
    }  
    
    public function findAll() {
        $query =  ArtsCorps_Domain_Artist::getFindAllQuery();
        $list = $this->runQuery($query);
        if (isset ($list)) {
            return $list;
        }
        return null;        
    }
 
    public function findCurrentArtists() {
        $query =  ArtsCorps_Domain_Artist::getFindCurrentQuery();
        $list = $this->runQuery($query);
        if (isset ($list)) {
            return $list;
        }
        return null;        
    }   
    
    protected function targetClass() {
        return 'ArtsCorps_Domain_Artist';
    }    
}
?>
