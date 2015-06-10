<?php

use Behat\Behat\Context\ContextInterface;
use Behat\Behat\Exception\PendingException;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;
use Behat\MinkExtension\Context\MinkContext;

/**
 * Behat context class.
 */
class FeatureContext extends MinkContext implements ContextInterface
{

    protected $session ;

    /**
     * Initializes context. Every scenario gets it's own context object.
     *
     * @param array $parameters Suite parameters (set them up through behat.yml)
     */
    public function __construct(array $parameters)
    {
    }

    /**
     * @Given /^I start a new session$/
     */
    public function iStartANewSession()
    {
        $driver = new \Behat\Mink\Driver\Selenium2Driver('firefox');
        $this->session = new \Behat\Mink\Session($driver);
        $this->session->start();
    }

    /**
     * @Given /^I am on the home page$/
     */
    public function iAmOnTheHomePage()
    {
        $this->session->visit('http://www.drupal-hello.vm');
    }

    /**
     * @Then /^I should see the drupal logo$/
     */
    public function iShouldSeeTheDrupalLogo()
    {
        $page = $this->session->getPage() ;
        $page->find('css', 'html.js body div#page-wrapper div#page div#header a#logo img');
    }

    /**
     * @Then /^I should see the site title$/
     */
    public function iShouldSeeTheSiteTitle()
    {
        $page = $this->session->getPage() ;
        $page->find('css', 'html body header.main div.inner a h1.logo');
    }

    /**
     * @Then /^I should see login fields$/
     */
    public function iShouldSeeLoginFields()
    {
        $page = $this->session->getPage() ;
        $page->find('css', 'input#edit-name');
        $page->find('css', 'input#edit-pass');
    }

    /**
     * @Then /^I enter my username in the username field$/
     */
    public function iEnterMyUsernameInTheUsernameField()
    {
        $page = $this->session->getPage() ;
        $el = $page->find('css', 'input#edit-name');
        $el->setValue("ishouldhiredave") ;
    }

    /**
     *@Given /^I enter my password in the password field$/
     */
    public function iEnterMyPasswordInThePasswordField()
    {
        $page = $this->session->getPage() ;
        $el = $page->find('css', 'input#edit-pass');
        $el->setValue("rightnow") ;
    }

    /**
     * @Then /^I submit the login form$/
     */
    public function iSubmitTheLoginForm()
    {
        $page = $this->session->getPage() ;
        $el = $page->find('css', 'input#edit-submit');
        $el->press();
    }

    /**
     * @Then /^I should see a greeting message$/
     */
    public function iShouldSeeAGreetingMessage()
    {
        $page = $this->session->getPage() ;
        $el = $page->find('css', 'html.js body div.region.region-page-top div#toolbar.toolbar.overlay-displace-top.clearfix.toolbar-processed div.toolbar-menu.clearfix ul#toolbar-user li.account.first a');
        $plainText = $el->getText();
        if ($plainText != "Hello ishouldhiredave") {
            throw new Exception('Incorrect Greeting Message'); };
    }


    /**
     * @Given /^I end the session$/
     */
    public function iEndTheSession()
    {
        $this->session->stop() ;
    }
}