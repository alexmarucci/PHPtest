 @api @report
Feature: Rest API - Marketing Report
  In order to calculate the conversion rate
  As a greedy marketer
  I want to be able to get the total number of the transaction and the total revenues in a given day
  Background:
  	Given I send a "GET" request to "api/v1/transactions/report" with parameters:
  	| location	| day |
  	| London	| 08/04/2018 |
 
  Scenario: Get a Marketing report
  	Then the response status code should be 200
 
  Scenario: Throw an exception using a bad location
 	Given I send a "GET" request to "api/v1/transactions/report" with parameters:
 	| location	| day |
  	| New York	| 08/04/2018 |
  	Then the response status code should be 400

  Scenario: Throw an exception using a day in the future
  	Given I send a "GET" request to "api/v1/transactions/report" with parameters:
  	| location	| day |
  	| London	| 08/04/2019 |
  	Then the response status code should be 400