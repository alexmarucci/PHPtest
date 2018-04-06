Feature: Import CSV Command
  In order to get all the daily sales from the stores
  As a developer
  I need to import all the transactions on a CSV file into the database
 
  Scenario: I can run the command without parameters
    Given a shell console
    When I execute the "transactions:import-csv" command
    Then the command output should be "success"