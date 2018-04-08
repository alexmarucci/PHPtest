@api @transactions
Feature: Rest API - Add Transactions
  In order to import more transactions in the application
  As a developer
  I need to provide an endpoint to add new transactions.

  Background:
  	Given I send a "POST" request to "api/v1/transactions" with body:
  	"""
  	{"transaction_id": "123456","store": "1","total_amount": "1","currency": "GBP","created_at": "07/04/2018 16:16"}
  	"""

  Scenario: Create a transaction
  	Then the response status code should be 201

  Scenario Outline: Throw an exception using wrong methods
  	When I send a <notAllowedMethods> request to "api/v1/transactions"
  	Then the response status code should be 405

  	Examples:
	  	| notAllowedMethods |
	  	| GET |
	  	| PUT |
	  	| OPTION |
	  	| DELETE |
	  	| PATCH |

  Scenario: Throw an exception using a bad payload
  	Given I send a "POST" request to "api/v1/transactions" with body:
  	"""
  	{"store": "XX"}
  	"""
  	Then the response status code should be 400