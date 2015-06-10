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

    /* Steps */
    private function setSteps() {

	    $this->steps =
	      array(

              array ( "Logging" => array( "log" => array( "log-message" => "Lets initialize our new download directory as a dapper project"), ) ),
              array ( "Project" => array( "init" => array(), ) , ) ,

              array ( "Logging" => array( "log" => array( "log-message" => "Next create our host file entry for our local URL"), ) ),
              array ( "HostEditor" => array( "add" => array (
                  "guess" => true,
                  "host-name" => "www.{$this->virtufile->config["vm"]["name"]}.vm",
              ), ), ),

              array ( "Logging" => array( "log" => array( "log-message" => "Next create our virtual host"), ) ),
              array ( "ApacheVHostEditor" => array( "add" => array (
                  "guess" => true,
                  "vhe-docroot" => $this->docroot."/",
                  "vhe-url" => "www.{$this->virtufile->config["vm"]["name"]}.vm",
                  "vhe-ip-port" => $this->getCurrentTargetFromPapyrusLocal(),
                  "vhe-vhost-dir" => "/etc/apache2/sites-available",
                  "vhe-template" => $this->getTemplate(),
              ), ), ),

              array ( "Logging" => array( "log" => array( "log-message" => "Next ensure our db file configuration is reset to blank" ), ), ),
              array ( "DBConfigure" => array( "wordpress-reset" => array(
                  "parent-path" => $this->docroot."/",
                  "platform" => "wordpress",
              ), ), ),

              array ( "Logging" => array( "log" => array("log-message" => "Next configure our projects db configuration file"), ) ),
              array ( "DBConfigure" => array( "wordpress-conf" => array(
                  "parent-path" => $this->docroot."/",
                  "mysql-host" => "127.0.0.1",
                  "mysql-user" => "ph_user",
                  "mysql-pass" => "ph_pass",
                  "mysql-db" => "ph_db",
                  "mysql-platform" => "wordpress",
                  "mysql-admin-user" => "root",
                  "mysql-admin-pass" => "ptconfigure",
              ), ) , ) ,

              array ( "Logging" => array( "log" => array( "log-message" => "Now lets drop our current database if it exists"), ) ),
              array ( "DBInstall" => array( "drop" => array(
                  "parent-path" => $this->docroot."/",
                  "mysql-host" => "127.0.0.1",
                  "mysql-user" => "ph_user",
                  "mysql-pass" => "ph_pass",
                  "mysql-db" => "ph_db",
                  "mysql-platform" => "wordpress",
                  "mysql-admin-user" => "root",
                  "mysql-admin-pass" => "ptconfigure",
              ), ), ),

              array ( "Logging" => array( "log" => array("log-message" => "Now lets install our database (with Wordpress DB Hooks)"), ), ),
              array ( "DBInstall" => array( "wordpress-install" => array(
                  "parent-path" => $this->docroot."/",
                  "mysql-host" => "127.0.0.1",
                  "mysql-user" => "ph_user",
                  "mysql-pass" => "ph_pass",
                  "mysql-db" => "ph_db",
                  "mysql-platform" => "wordpress",
                  "mysql-admin-user" => "root",
                  "mysql-admin-pass" => "ptconfigure",
                  "hook-url" => "www.{$this->virtufile->config["vm"]["name"]}.vm"
              ), ), ),

              array ( "Logging" => array( "log" => array( "log-message" => "Now lets restart Apache so we are serving our new application version", ), ), ),
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
 	DocumentRoot ****WEB ROOT****src
 	<Directory ****WEB ROOT****src>
 		Options Indexes FollowSymLinks MultiViews
 		AllowOverride All
 		Order allow,deny
 		allow from all
 	</Directory>
   ErrorLog /var/log/apache2/error.log
   CustomLog /var/log/apache2/access.log combined
 </VirtualHost>

# NameVirtualHost ****IP ADDRESS****:443
# <VirtualHost ****IP ADDRESS****:443>
# 	 ServerAdmin webmaster@localhost
# 	 ServerName ****SERVER NAME****
# 	 DocumentRoot ****WEB ROOT****src
   # SSLEngine on
 	 # SSLCertificateFile /etc/apache2/ssl/ssl.crt
   # SSLCertificateKeyFile /etc/apache2/ssl/ssl.key
   # SSLCertificateChainFile /etc/apache2/ssl/bundle.crt
# 	 <Directory ****WEB ROOT****src>
# 		 Options Indexes FollowSymLinks MultiViews
#		AllowOverride All
#		Order allow,deny
#		allow from all
#	</Directory>
#  ErrorLog /var/log/apache2/error.log
#  CustomLog /var/log/apache2/access.log combined
#  </VirtualHost>
TEMPLATE;

        return $template ;
    }

}