@api @refunds
Feature: Rest API - Refund Transactions
  In order to keep track of the refunds in the application
  As a developer
  I need to provide an endpoint to refund a transactions.

  Background:
  	Given I send a "PATCH" request to "api/v1/transactions/1/refund"

  Scenario: Refund a transaction
  	Then the response status code should be 200

  Scenario Outline: Throw an exception using wrong methods
    When I send a <notAllowedMethods> request to "api/v1/transactions/1/refund"
    Then the response status code should be 405

  	Examples:
	  	| notAllowedMethods |
	  	| GET |
	  	| POST |
      | PUT |
      | OPTION |
      | DELETE |

  Scenario: Throw an exception if the transaction does not exist
  	Given I send a "PATCH" request to "api/v1/transactions/0/refund"
  	Then the response status code should be 404