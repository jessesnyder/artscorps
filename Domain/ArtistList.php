<?php
require_once 'NPowerSeattle/Types/Collection.php';
/**
 * CampaignList.php
 * 
 * 
 * 
 * @since 9-1-2006
 * @author Jesse Snyder
 * @package NPowerSeattle_SVPI_Domain
 * 
 */
class ArtsCorps_Domain_ArtistList extends NPowerSeattle_Types_Collection {

    /**
     * add()
     * 
     * Add a Campaign to this list. The list is maintained in a sorted state based on 
     * ordering behaviour defined in the Campaign class.
     * 
     * @param NPowerSeattle_SVPI_CampaignIF $campaign 
     */
    public function add(ArtsCorps_Domain_Artist $artist) {
        $this->doAdd($artist);
        $this->sortMe();
    }

    /**
     * publishedOnly()
     * 
     * @return NPowerSeattle_SVPI_Domain_CampaignList $list - only those elements in this list that are published
     */
    public function publishedOnly() {
        $list = new NPowerSeattle_SVPI_Domain_CampaignList();
        
        foreach ($this as $campaign) {
            if ($campaign->isPublished()) {
                $list->add($campaign);
            }
        }
        
        return $list;
    } 
    
    public function asIdNameHash() {
        $hash = array();
        foreach ($this as $artist) {
            $hash[$artist->getId()] = $artist->getNameString();
        }
        return $hash;
    } 
         
    private function sortMe() {
        usort($this->objects, array("ArtsCorps_Domain_ArtistList", "cmp_obj"));
    }
    
    private function cmp_obj($a, $b) {
        return $a->compareTo($b);
    }
}
?>