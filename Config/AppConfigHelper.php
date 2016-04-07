<?php
require_once 'NPowerSeattle/Types/Registry.php';
require_once 'SalesForce/AdminLoginManager.php';
/**
 * AppConfigHelper.php
 * 
 * Registry class for application configuration stuff that changes depending on the 
 * environment. The only thing that should change is the private varialbe $configFile!
 * 
 * @since 9-1-2006
 * @author Jesse Snyder, NPower Seattle (www.npowerseattle.org)
 * 
 * @package NPowerSeattle_Config
 */
class NPowerSeattle_Config_AppConfigHelper extends NPowerSeattle_Types_Registry {
    // We want to encapulate as much as possible in just changing this config file
    private static $instance;

    private function __construct() {
        // this value is read from php.ini, and should be the only change necessary
        // between hosting environments.
        $xml_config = get_cfg_var("artscorps_config");
        if (file_exists($xml_config)) {
            $xml = simplexml_load_file($xml_config);
            if (!($xml->username and $xml->password and $xml->wsdl)) {
                throw new Exception('config file ' . $xml_config . ' is not formatted correctly');
            }
            $this->setProperty('wsdl', (string) $xml->wsdl);
            if (!file_exists($this->getProperty('wsdl'))) {
                throw new Exception("wsdl file " . $this->getProperty('wsdl') . " not found.");
            }
            $this->setProperty('username', (string) $xml->username);
            $this->setProperty('password', (string) $xml->password);
            $this->setProperty('imageDirectory', (string) $xml->imageDirectory);
            $this->setProperty('doCacheQueries', (bool)(string) $xml->doCacheQueries);
            $this->setProperty('doLogQueries', (bool)(string) $xml->doLogQueries);
            $this->setProperty('SFConnection', $this->initSFConnection());
        } else {
            throw new Exception('Failed to locate config file: ' . $xml_config);
        }
    }

    /**
     * getInstance()
     * 
     * @return NPowerSeattle_SVPI_Config_AppConfigHelper $helper - The single instance of this class
     */
    public static function getInstance() {
        if (empty (self :: $instance)) {
            self :: $instance = new NPowerSeattle_Config_AppConfigHelper();
        }
        return self :: $instance;
    }

    private function initSFConnection() {
        $adminLogin = new NPowerSeattle_SalesForce_AdminLoginManager($this->getProperty('wsdl'));
        $connection = $adminLogin->login($this->getProperty('username'), $this->getProperty('password'));

        if (!$connection) {
            throw new Exception('Failed to connect to SalesForce ' . $adminLogin->getError());
        }
        return $connection;
    }
}
?>