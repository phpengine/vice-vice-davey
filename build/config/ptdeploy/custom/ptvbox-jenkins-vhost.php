<?php

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

    /* Steps */
    private function setSteps() {

        $jenkins_url = "jenkins.{$this->virtufile->config["vm"]["name"]}.vm" ;

        $this->steps =
            array(

                array ( "Logging" => array( "log" => array( "log-message" => "Lets initialize our new download directory as a Pharaoh project"), ) ),
                array ( "Project" => array( "init" => array(), ) , ) ,

                array ( "Logging" => array( "log" => array( "log-message" => "Next create our host file entry for our local URL"), ) ),
                array ( "HostEditor" => array( "add" => array (
                    "guess" => true,
                    "host-name" => $jenkins_url,
                ), ), ),

                array ( "Logging" => array( "log" => array( "log-message" => "Next create our virtual host"), ) ),
                array ( "ApacheVHostEditor" => array( "add" => array (
                    "guess" => true,
                    "vhe-docroot" => $this->docroot,
                    "vhe-url" => $jenkins_url,
                    "vhe-ip-port" => $this->getCurrentTargetFromPapyrusLocal(),
                    "vhe-vhost-dir" => "/etc/apache2/sites-available",
                    "vhe-template" => $this->getTemplate(),
                ), ), ),

                array ( "Logging" => array( "log" => array( "log-message" => "Now lets restart Apache so we are serving our Jenkins VHost", ), ), ),
                array ( "ApacheControl" => array( "restart" => array(
                    "guess" => true,
                ), ), ),

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

    private function getTemplate() {
        $template =
            <<<'TEMPLATE'
             NameVirtualHost ****IP ADDRESS****:80
 <VirtualHost ****IP ADDRESS****:80>
    ServerAdmin webmaster@localhost
 	ServerName ****SERVER NAME****
    ProxyPreserveHost On
    ProxyPass / http://127.0.0.1:8080/
    ProxyPassReverse / http://127.0.0.1:8080/
 </VirtualHost>
TEMPLATE;
        return $template ;
    }



}
