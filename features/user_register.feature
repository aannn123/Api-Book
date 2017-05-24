Feature: Register new User

@mink:selenium2
	Scenario: register new user
		Given I some data
			| username | name  | email           | password   | 
			| admin123 | admin | admin@gmail.com | superadmin |
		And I post request url "/public/user/register"
		Then I get response code 201
