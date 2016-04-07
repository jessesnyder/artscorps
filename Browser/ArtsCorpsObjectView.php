<?php
require_once 'NPowerSeattle/SalesForce/ObjectView.php';

abstract class ArtsCorps_Browser_ObjectView extends NPowerSeattle_SalesForce_ObjectView {
    
    public function __construct() {
        parent :: __construct();
        $this->dict = array();
    }
    /**
     * prettyDate()
     * 
     * @param String: timestamp
     * @return String: time stamp converted to m/d/Y format
     **/
    protected function prettyDate($datestamp) {
        if (!$datestamp) {
            return '';
        }
        return date('m/d/Y', $datestamp);
    }
    
    protected function link($id, $name, $handler) {
        if (! $name) {
            return '';
        }
        return '<a href="' . $handler . '?id=' . $id . '">'. $name . '</a>';
    }
    
    protected function registerLink($id, $isClosed) {
        // TODO: change this somehow to not include text in 
        // *either* case (we'll use a background image instead)
        // of text.
        if ($isClosed or !$id) {
            return '';
        }
        $name = 'register';
        $handler = 'RegisterView.php';
        return $this->link($id, $name, $handler);
    } 
    
    protected function newlinesToBrs($string) {
        $pattern = '/\n+/';
        $replacement = "\n\n";
        
        return nl2br(preg_replace($pattern, $replacement, $string));
    }
    
    protected function dump() {
        $html = '<pre>';
        $html .= print_r($this->dict, True);
        $html .= '</pre>';
        
        return $html;
    }
    
    protected function preview() {
        $html = '<dl class="simple-class-view">';
        foreach ($this->dict as $key => $value) {
            $html .= '<dt>' . $key . '</dt>' . '<dd>' . $value . "</dd>\n";
        }
        $html .= '</dl>';
        return $html;
    }
    protected function retrieveObjectForRequest($manager) {
        if (!$_REQUEST['id']) {
            $this->appendError('Must specify an object ID');
            return;
        }
        $id = $_REQUEST['id'];
        try {
            $targetObject = $manager->findById($id);
            if (!$targetObject) {
                throw new Exception('No record found for ID ' . $id . ': ' . $manager->getError()); 
            }
            return $targetObject;
        }
        catch (Exception $ex) {
            $this->appendError($ex->getMessage());
            return null;
        }
    }
    
    protected function buildClassList($classList) {
        if (! isset($classList)) {
            return array();
        }
        $detailed = array();
        foreach ($classList as $class) {
            $raw = $class->dataDump();
            $raw['dateStart'] = $this->prettyDate($raw['dateStart']);
            $raw['dateEnd'] = $this->prettyDate($raw['dateEnd']);
            $raw['classLink'] = $this->link($raw['id'], $raw['name'], 'ClassView.php');
            $raw['teacherLink'] = $this->link($raw['teacherID'], $raw['teacherName'], 'ArtistView.php');
            $raw['facilityLink'] = $this->link($raw['facilityID'], $raw['facilityName'], 'OrganizationView.php');
            $raw['registerLink'] = $this->registerLink($raw['id'], $raw['isClosed']);
            array_push($detailed, $raw);
        }

        return $detailed;
    }
    
    protected function buildKeyedClassList($classList, $filter) {
        if (! isset($classList) or ! $classList->count()) {
            return array();
        }
        $byKey = array();
        foreach ($classList as $class) {
            $key = (string)$class->$filter();
            if (! array_key_exists($key, $byKey)) {
                $byKey[$key] = array();
            }
            $raw = $class->dataDump();
            $raw['dateStart'] = $this->prettyDate($raw['dateStart']);
            $raw['dateEnd'] = $this->prettyDate($raw['dateEnd']);
            $raw['classLink'] = $this->link($raw['id'], $raw['name'], 'ClassView.php');
            $raw['teacherLink'] = $this->link($raw['teacherID'], $raw['teacherName'], 'ArtistView.php');
            $raw['facilityLink'] = $this->link($raw['facilityID'], $raw['facilityName'], 'OrganizationView.php');
            $raw['registerLink'] = $this->registerLink($raw['id'], $raw['isClosed']);
            
            array_push($byKey[$key], $raw);
        }
        ksort($byKey);
        return $byKey;        
    }
}