<?php

/*************************************
*      Generated Autopilot file      *
*     ---------------------------    *
*Autopilot Generated By Pharaoh Deploy *
*     ---------------------------    *
*************************************/

Namespace Core ;

class AutoPilotConfigured extends AutoPilot {

    protected $virtufile ;
    protected $docroot ;
    public $steps ;

    public function __construct($params = null) {
        parent::__construct($params) ;
        $this->setDocRoot() ;
        $this->setVirtufile() ;
        $this->setSteps();
    }

    protected function setSteps() {

	    $this->steps =
	      array(

              array ( "Logging" => array( "log" => array( "log-message" => "Starting Pharaoh Deploy Application Configuration of Virtual Machine Host"), ) ),

              array ( "Logging" => array( "log" => array( "log-message" => "Remove our host file entry for VM Wordpress"), ) ),
              array ( "HostEditor" => array( "rm" => array (
                  "guess" => true,
                  "host-name" => "www.{$this->virtufile->config["vm"]["name"]}.vm",
              ), ), ),
              array ( "Logging" => array( "log" => array( "log-message" => "Remove our host file entry for VM Jenkins"), ) ),
              array ( "HostEditor" => array( "rm" => array (
                  "guess" => true,
                  "host-name" => "jenkins.{$this->virtufile->config["vm"]["name"]}.vm",
              ), ), ),

              array ( "Logging" => array( "log" => array( "log-message" => "Pharaoh Deploy Application Configuration of Virtual Machine Host Complete", ), ), ),

	      );

	  }

    private function setDocRoot() {
        $this->docroot = $this->params["docroot"] ;
    }

    private function setVirtufile() {
        $vflbo = $this->docroot."/VirtufileBase.php";
        $vflo = $this->docroot."/Virtufile";
        require_once($vflbo);
        require_once($vflo);
        $this->virtufile = new \Model\Virtufile ;
    }

    protected function getCurrentTargetFromPapyrusLocal() {
        $pf = file_get_contents($this->docroot."/papyrusfilelocal") ;
        $pf = unserialize($pf);
        if (is_array($pf) && count($pf)>0) {
            return $pf[$this->virtufile->config["vm"]["name"]]["target"] ; }
        return null ;
    }

}
