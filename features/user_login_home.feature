Feature: user login homepage

@mink:selenium2
	Scenario: get url
		Given I set token "6237ac8e089a5a9a68a7f7a483d398cf"
		When I get url "/public"
		Then I get response 200
