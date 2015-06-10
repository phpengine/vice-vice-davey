<?php

class HelloLibraryTest extends PHPUnit_Framework_TestCase {

    public function setUp() {
        require_once("bootstrap.php");
        require_once(dirname(dirname(dirname(getcwd())))."/src/sites/all/modules/hire_me_now/Libraries/HelloLib.php") ;
    }

    public function testSayHelloForMeHappy() {
        $hello = new HelloLib() ;
        $word = $hello->sayHelloForMe() ;
        $this->assertTrue( $word == "Hello" ) ;
    }

    public function testSayHelloForMeSad() {
        $hello = new HelloLib() ;
        $word = $hello->sayHelloForMe() ;
        $this->assertTrue( $word != "Goodbye" ) ;
    }

}
