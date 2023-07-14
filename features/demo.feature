Feature:
    In order to prove I can write a behat test
    As a user
    I want to test the homepage

    @javascript @demo
    Scenario: I go to the homepage
        When I go to "/"
        Then the response should be received
        And I should see "Hello HomeController!" appear
        And I should see "I am index page" appear
#        Then I wait "10" seconds
