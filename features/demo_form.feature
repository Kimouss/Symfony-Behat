Feature:
    In order to create a product
    As a user
    I want to product page

    @javascript @form
    Scenario: I go to product page
        When I go to "/"
        And the response should be received
        And I should see "Hello HomeController!" appear
        And I should see "Link to form page" appear
        Then I wait "2" seconds
        
        When I click on link "Link to form page"
        And I should be redirected to "/form"
        Then I should see "I am form page" appear

        When I click on link "Link to index page"
        And I should be redirected to "/"
        Then I should see "I am index page" appear

    @javascript @form
    Scenario: I want to submit a product
        When I go to "/form"
        And the response should be received
        Then I should see "I am form page" appear

        When I fill in "Name" with "Test"
        And I fill in "Description" with "This is a short description"
        Then I fill in "Price" with "42"

        When I press "Submit"
        And I should see "I am valid page" appear
        And I should see "Product:" appear
        And I should see "Name: Test" appear
        And I should see "Description: This is a short description" appear
        Then I should see "Price: €42.00" appear

    @javascript @form
    Scenario Outline: I test fields form error
        When I go to "/form"
        And the response should be received
        And I should see "I am form page" appear

        When I fill in "Name" with "<Name>"
        Then I fill in "Price" with "<Price>"

        When I press "Submit"
        Then I should see "<Error>" appear

        Examples:
            | Name          | Price   | Error                                          |
            | No name error | 10      | Cette valeur doit être supérieur à 20.         |
            | Err           | 21      | Ce champ doit comporter plus de 4 caractères.  |
