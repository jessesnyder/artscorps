<?php
require_once 'NPowerSeattle/Types/Collection.php';
/**
 * ClassList.php
 * 
 * 
 * 
 * @since 9-1-2006
 * @author Jesse Snyder
 * @package ArtsCorps_Domain
 * 
 */
class ArtsCorps_Domain_OrganizationList extends NPowerSeattle_Types_Collection {

    /**
     * add()
     * 
     * Add a Campaign to this list. The list is maintained in a sorted state based on 
     * ordering behaviour defined in the Campaign class.
     * 
     * 
     */
    public function add(ArtsCorps_Domain_Organization $org) {
        $this->doAdd($org);
        $this->sortMe();
    }
    
    public function asIdNameHash() {
        $hash = array();
        foreach ($this as $org) {
            $hash[$org->getId()] = $org->getName();
        }
        return $hash;
    }
   
    private function sortMe() {
        usort($this->objects, array("ArtsCorps_Domain_OrganizationList", "cmp_obj"));
    }
    
    private function cmp_obj($a, $b) {
        return $a->compareTo($b);
    }
}
?>