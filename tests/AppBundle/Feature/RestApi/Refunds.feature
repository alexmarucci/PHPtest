@api @refunds
Feature: Rest API - Refund Transactions
  In order to keep track of the refunds in the application
  As a developer
  I need to provide an endpoint to refund a transactions.

  Background:
  	Given I send a "POST" request to "api/v1/refunds" with body:
  	"""
  		{
			'transaction_id': '123456',
			'store_id': '1',
			'apiKey': 'xxxxx_good_api_key_xxxxxxx'
  		}
  	"""

  Scenario: Refund a transaction
  	Then the header "Location" should be equal to "/api/v1/refunds/1"
  	And the "transaction_id" property should be equals to "123456"

  Scenario Outline: Throw an exception using wrong methods
  	When I send a <notAllowedMethods> request to "api/v1/refunds"
  	Then the response status code should be 405

  	Examples:
	  	| notAllowedMethods |
	  	| GET |
	  	| PUT |
	  	| OPTION |
	  	| DELETE |
	  	| PATCH |

  Scenario: Throw an exception using a bad payload
  	Given I send a "POST" request to "api/v1/refunds" with body:
  	"""
  	{
		'store_id': 'XX',
		'apiKey': 'xxxxx_good_api_key_xxxxxxx'
  	}
  	"""
  	Then the response status code should be 400
  
  Scenario: Throw an exception using a wrong api key
  Given I send a "POST" request to "api/v1/refunds" with body:
	  	"""
	  	{,
			'apiKey': 'xxxxx_bad_api_key_xxxxxxx'
	  	}
	  	"""
	Then the response status code should be 401