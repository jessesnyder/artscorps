<?php
require_once 'ArtsCorps/Config/AppConfigHelper.php';
require_once 'NPowerSeattle/WebUtil/Session.php';
/**
 * Utils.php
 * 
 * Miscellaneous helper stuff that doesn't fit other places
 * 
 * @since May 1st, 2008
 * @author Jesse Snyder at NPower Seattle (www.npowerseattle.org)
 * @package ArtsCorps_Domain
 */
class ArtsCorps_Domain_Utils {
    const NOT_FOUND_ERROR = "No records found matching those criteria";
    protected $errorString;
    private $sessionCache;
    
    public function __construct() {
        $this->sessionCache = new NPowerSeattle_WebUtil_Session();
        $this->helper = NPowerSeattle_Config_AppConfigHelper::getInstance();
        $this->doUseCache = $this->helper->getProperty('doCacheQueries');
        $this->doReportQuery = $this->helper->getProperty('doLogQueries');           
    }
    
    public function getError() {
        return $this->errorString;
    }
    
    public function getNeighborhoodsForLeadType() {
        if ($this->doReportQuery) {
            trigger_error("Calling describeSObject() on 'Lead'");
        }
        if ($this->doUseCache) {
            $result = $this->getCachedOperation('describeSObject', 'Lead');
        }
        else {
            $result = null;
        }
        if ($result) {
            trigger_error("retrieved data from session");
        } else {
            trigger_error("retrieving data from salesForce");
            $result = $this->doOperationAndCacheResult('describeSObject', 'Lead');
        }           
        if (!isset($result)) {
            $this->errorString = self::NOT_FOUND_ERROR;
            trigger_error($this->errorString);
            return null;
        }
        $leadInfo = $result;
        $neighborhoodField = null;
        foreach ($leadInfo->fields as $field) {
            if ($field->name == "Neighborhood__c") {
                $neighborhoodField = $field;
                break;
            }
        }

        $neighborhoodList = array();
        foreach ($neighborhoodField->picklistValues as $picklistObject) {
            array_push($neighborhoodList, $picklistObject->label);
        }
        
        return $neighborhoodList;
    }

    /**
     * describeSObject($SFType)
     * 
     * @param String - The query string
     * @return SObject - The query result
     */
    private function describeSObject($SFType) {
        $sfConnection = $this->helper->getProperty('SFConnection');
        try {
            $result = $sfConnection->describeSObject($SFType);
            if (!isset ($result)) {
                $this->errorString = self::NOT_FOUND_ERROR;
                return null;
            }
            return $result;
        } catch (Exception $e) {
            $this->errorString = $e->getMessage();
            trigger_error($this->errorString . $e->getTraceAsString(), E_USER_WARNING);

            return null;
        }
    }
    
    private function getCachedOperation($operation, $arg) {
        $opString = join('|', array($operation, $arg));
        $opKey = md5($opString);
        $keys = array_keys($_SESSION);
        $cached = $this->sessionCache->get($opKey);
        if ($cached) {
            trigger_error("Retuning cached operation from Utils");
            return unserialize($cached);
        }

        return null;       
    }
    
    private function doOperationAndCacheResult($operation, $arg) {
        $opString = join('|', array($operation, $arg));
        $opKey = md5($opString);   
        $result = $this->$operation($arg);
        if (isset($result) and ! $this->getError()) {
            $frozen = serialize($result);
            $this->sessionCache->set($opKey, $frozen); 

            return $result;
        }
        return null;
       
    }
}
?>