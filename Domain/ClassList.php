<?php
require_once 'NPowerSeattle/Types/Collection.php';
require_once 'ArtsCorps/Domain/OrganizationManager.php';
require_once 'ArtsCorps/Domain/ArtistManager.php';
require_once 'ArtsCorps/Domain/Calendar.php';
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
class ArtsCorps_Domain_ClassList extends NPowerSeattle_Types_Collection {
    private $calendar;
    
    public function __construct() {
        parent::__construct();
        $this->calendar = new ArtsCorps_Domain_Calendar();    
    }
    /**
     * add()
     * 
     * Add a Campaign to this list. The list is maintained in a sorted state based on 
     * ordering behaviour defined in the Campaign class.
     * 
     * @param NPowerSeattle_SVPI_CampaignIF $campaign 
     */
    public function add(ArtsCorps_Domain_Class $class) {
        $this->doAdd($class);
        $this->sortMe();
    }
    public function dataDump() {
        return get_object_vars($this);
    }
    
    public function forCurrentQuarter() {
        $inRangeClasses = new ArtsCorps_Domain_ClassList();
        
        foreach ($this as $class) {
            if ($class->isInCurrentQuarter()) {
                $inRangeClasses->add($class);
            }
        }
        
        return $inRangeClasses;       
    }
    
    public function forNextQuarter() {
        $inRangeClasses = new ArtsCorps_Domain_ClassList();
        
        foreach ($this as $class) {
            if ($class->isNextQuarter()) {
                $inRangeClasses->add($class);
            }
        }
        
        return $inRangeClasses;       
    } 
  
    public function displayProfDevClasses() {
        if ($this->count() < 1) {
            trigger_error('displayProfDevClasses() called on empty ClassList ');
            return '<p>No classes found</p>';
        }
        $orgManager = new ArtsCorps_Domain_OrganizationManager();    
        $facilityIds = array();
        foreach ($this as $class) {
            $facilityIds[] = $class->getFacilityId();
        }
        $facilityList = $orgManager->findByIds($facilityIds);
        $facilityHash = $facilityList->asIdNameHash();
        $html = '<table width="100%">
            <tr>
                <th>Course Name</th>
                <th>Facility</th>
                <th>Date</th>
            </tr>';

        foreach($this as $class) {
            $html .=  $class->displayPdClassTableEntry($facilityHash);
        }
        $html .= '</table>';
        
        return $html;        
    }     
    
    public function filterByArtMedium($medium) {
        $filteredClasses = new ArtsCorps_Domain_ClassList();
        foreach($this as $class) {
            if ($class->getArtMedium() == $medium) {
                $filteredClasses->add($class);
            }
        }
        return $filteredClasses;
    }
    
    private function sortMe() {
        usort($this->objects, array("ArtsCorps_Domain_ClassList", "cmp_obj"));
    }
    
    private function cmp_obj($a, $b) {
        return $a->compareTo($b);
    }

    public function sortByDate($reverse=True) {
        usort($this->objects, array("ArtsCorps_Domain_ClassList", "cmpByDate"));
        if ($reverse) {
            $this->objects = array_reverse($this->objects);
        }
    }    
    
    private function cmpByDate($a, $b) {
        return $a->compareByStartDate($b);
    }
}
?>