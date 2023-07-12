Feature:
    In order to prove I can write a behat test
    As a user
    I want to test the homepage

    Scenario: I go to the homepage
        When a demo scenario sends a request to "/"
        Then the response should be received
        Then I should see the text "Hello HomeController!"
