<?php

Namespace Core ;

class AutoPilotConfigured extends AutoPilot {

    protected $virtufile ;
    protected $docroot ;
    public $steps ;

    public function __construct($params = null) {
        parent::__construct($params);
        $this->setDocRoot();
        $this->setVirtufile();
        $this->setSteps();
    }

    /* Steps */
    protected function setSteps() {

        $guestPath = $this->virtufile->config["vm"]["shared_folders"][0]["guest_path"] ;

        $this->steps =
            array(
                array ( "Logging" => array( "log" => array( "log-message" => "Lets begin Configuration of a Pharaoh Virtualize Box"),),),

                array ( "Logging" => array( "log" => array( "log-message" => "Lets ensure the Pharaoh Virtualize user can use Sudo without a Password"),),),
                array ( "SudoNoPass" => array( "install" => array(
                    "install-user-name" => "ptv"
                ),),),

                // PHP Modules
                array ( "Logging" => array( "log" => array( "log-message" => "Lets ensure our common PHP Modules are installed" ),),),
                array ( "PHPModules" => array( "ensure" => array(),),),

                // All Pharoes
                array ( "Logging" => array( "log" => array( "log-message" => "Lets ensure Pharaoh Configure" ),),),
                array ( "PTConfigure" => array( "ensure" => array(),),),
                array ( "Logging" => array( "log" => array( "log-message" => "Lets ensure Pharaoh Deploy" ),),),
                array ( "PTDeploy" => array( "ensure" => array(),),),
                array ( "Logging" => array( "log" => array( "log-message" => "Lets ensure Pharaoh Test" ),),),
                array ( "PTTest" => array( "ensure" => array(),),),
                array ( "Logging" => array( "log" => array( "log-message" => "Lets ensure Pharaoh Build" ),),),
                array ( "PTBuild" => array( "ensure" => array(),),),

                // Apache
                array ( "Logging" => array( "log" => array( "log-message" => "Lets ensure Apache Server is installed" ),),),
                array ( "ApacheServer" => array( "ensure" =>  array("version" => "2.2"), ), ),

                // Apache Modules
                array ( "Logging" => array( "log" => array( "log-message" => "Lets ensure our common Apache Modules are installed" ),),),
                array ( "ApacheModules" => array( "ensure" => array(),),),

                // Apache Modules
                array ( "Logging" => array( "log" => array( "log-message" => "Lets ensure our Reverse Proxy Apache Modules are installed" ),),),
                array ( "ApacheReverseProxyModules" => array( "ensure" => array(),),),

                // Standard Tools
                array ( "Logging" => array( "log" => array( "log-message" => "Lets ensure some standard tools are installed" ),),),
                array ( "StandardTools" => array( "ensure" => array(),),),

                // Git Tools
                array ( "Logging" => array( "log" => array( "log-message" => "Lets ensure some git tools are installed" ),),),
                array ( "GitTools" => array( "ensure" => array(),),),

                // Git Key Safe
                array ( "Logging" => array( "log" => array( "log-message" => "Lets ensure Git SSH Key Safe version is are installed" ),),),
                array ( "GitKeySafe" => array( "ensure" => array(),),),

                // Firefox 24
                array ( "Logging" => array( "log" => array( "log-message" => "Lets ensure Firefox 33 is installed for selenium" ),),),
                array ( "Firefox33" => array( "ensure" => array(),),),

                /* BDD Testing */

                // Selenium Server
                array ( "Logging" => array( "log" => array( "log-message" => "Lets ensure Selenium Server is installed"),),),
                array ( "SeleniumServer" => array( "ensure" => array("guess" => true ),),),

                // Start the Selenium Server
                array ( "Logging" => array( "log" => array( "log-message" => "Lets also start Selenium so we can use it"),),),
                array ( "RunCommand" => array("install" => array(
                    "guess" => true,
                    "command" => 'selenium > /tmp/selenium-output.out 2> /tmp/selenium-error.err < /dev/null &',
                    "nohup" => true
                ),),),

                // Behat
                array ( "Logging" => array( "log" => array( "log-message" => "Lets ensure Behat is installed"),),),
                array ( "Behat" => array( "ensure" => array("guess" => true ),),),

                // Restart Apache for new modules
                array ( "Logging" => array( "log" => array( "log-message" => "Lets restart Apache for our PHP and Apache Modules" ),),),
                array ( "RunCommand" => array( "install" => array(
                    "guess" => true,
                    "command" => "ptdeploy apachecontrol restart --yes --guess",
                ) ) ),

                /* Package Managers */
                array ( "Logging" => array( "log" => array( "log-message" => "Lets ensure Pear is installed"),),),
                array ( "Pear" => array( "ensure" => array("guess" => true ),),),


                /* Build/CI Servers & Build Tools */

                // Jenkins
                array ( "Logging" => array( "log" => array( "log-message" => "Lets ensure Jenkins is installed" ),),),
                array ( "Jenkins" => array( "ensure" => array(),),),
                array ( "Logging" => array( "log" => array( "log-message" => "Lets ensure Jenkins PHP Plugins are installed"),),),
                array ( "JenkinsPlugins" => array( "ensure" => array(),),),
                array ( "Logging" => array( "log" => array( "log-message" => "Lets ensure the Jenkins user can use Sudo without a Password"),),),
                array ( "JenkinsSudoNoPass" => array( "ensure" => array(),),),


                // copy to jenkins home
                array ( "Logging" => array( "log" => array( "log-message" => "Lets add global jenkins config"),),),
                array ( "RunCommand" => array("install" => array(
                    "guess" => true,
                    "command" => 'cp '.$guestPath.'/build/config/jenkins/global/* /var/lib/jenkins',
                ),),),

                // Bash script to create jenkins job
                // ususlly would use a platform independent method, but time
                array ( "Logging" => array( "log" => array( "log-message" => "Lets create our jenkins job"),),),
                array ( "RunCommand" => array("install" => array(
                    "guess" => true,
                    "command" => 'sh '.$guestPath.'/build/config/jenkins/create_job.sh',
                ),),),

                array ( "Logging" => array( "log" => array( "log-message" => "Lets also restart Jenkins"),),),
                array ( "RunCommand" => array("install" => array(
                    "guess" => true,
                    "command" => 'sudo service jenkins restart',
                ),),),

                // VNC
                array ( "Logging" => array( "log" => array( "log-message" => "Lets install VNC Server for Jenkins"),),),
                array ( "VNC" => array("ensure" => array(),),),

                // VNC
                array ( "Logging" => array( "log" => array( "log-message" => "Lets setup VNC Server Password for Jenkins"),),),
                array ( "VNCPasswd" => array("install" => array(
                    "guess" => true,
                    "vnc-user" => "jenkins"
                ),),),

                //Mysql
                array ( "Logging" => array( "log" => array( "log-message" => "Lets ensure Mysql Server is installed" ),),),
                array ( "MysqlServer" => array( "ensure" =>  array(
                    "version" => "5",
                    "version-operator" => "+"
                ), ), ),

                array ( "Logging" => array( "log" => array( "log-message" => "Lets ensure a Mysql Admin User is installed"),),),
                array ( "MysqlAdmins" => array( "install" => array(
                    "root-user" => "root",
                    "root-pass" => "ptconfigure",
                    "new-user" => "root",
                    "new-pass" => "root",
                    "mysql-host" => "127.0.0.1"
                ) ) ),

                // @todo surely, captain, there must be a better way...
                array ( "Logging" => array( "log" => array(
                    "log-message" => "Here's a bug... but not one of mine... due to the following firefox bug - ".
                    "https://bugzilla.mozilla.org/show_bug.cgi?id=198863 when the ptv user tries to open ".
                    "Firefox, the profile dir is created as root and the Firefox program (opened as ptv) cannot ".
                    "open or write to it. Anyhow, we have to start firefox as that user, let it fail, delete the root ".
                    "profile dir then on next opening it will work".
                    " "
                ),),),

                // mozilla dir
                array ( "Logging" => array( "log" => array( "log-message" => "the mozilla dir ends up being owned by root somehow, so fix" ),),),
                array ( "RunCommand" => array( "install" => array(
                    "guess" => true,
                    "run-as-user" => "ptv",
                    "command" => "chown -R ptv /home/ptv/.mozilla",
                ) ) ),

                array ( "RunCommand" => array( "install" => array(
                    "guess" => true,
                    "command" => "rm -rf /home/ptv/.mozilla",
                ) ) ),

                array ( "RunCommand" => array( "install" => array(
                    "guess" => true,
                    "command" => "chmod -R 775 /home/ptv/.mozilla",
                ) ) ),

                array ( "RunCommand" => array( "install" => array(
                    "guess" => true,
                    "command" => "cp -r ".$guestPath."/build/config/firefox/* /home/ptv/.mozilla",
                ) ) ),

                array ( "Logging" => array( "log" => array(
                    "log-message" => "Pharaoh Configuration Management of your Pharaoh Virtualize VM complete"
                ),),),

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

}
