Feature: user login

@mink:selenium2
    Scenario: testing user login
        Given I some data
        | username | password |
        | admin   | superadmin   |
        And I post request url "/public/user/login"
        Then I get response code 200