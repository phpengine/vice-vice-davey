Feature: Your first feature
Lets check out the home page is working

  Scenario: Lets check the Home Page works
    Given I start a new session
    And I am on the home page
    Then I should see the drupal logo
    Then I should see the site title
    Then I end the session

  Scenario: Lets check Login works
    Given I start a new session
    And I am on the home page
    Then I should see login fields
    When I enter my username in the username field
    And I enter my password in the password field
    Then I submit the login form
    Then I should see a greeting message
    Then I end the session