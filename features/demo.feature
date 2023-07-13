Feature:
    In order to prove I can write a behat test
    As a user
    I want to test the homepage

    @javascript
    Scenario: I go to the homepage
        When I go to "/"
        Then the response should be received
        Then I should see "Hello HomeController!" appear
