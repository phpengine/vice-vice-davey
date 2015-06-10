Feature: Your first feature
Lets check out the home page is working

  Scenario: Lets check the Home Page works
    Given I am on homepage
    Then I am on "http://www.wordpress-phlagrant.vm"
    Then I should see the workplace logo
    Then I should see the site menu

  @javascript
  Scenario: Lets check the Home Page works
    Given I am on homepage
    Then I am on "http://www.wordpress-phlagrant.vm"
    Then I should see the workplace logo
    Then I should see the site menu
