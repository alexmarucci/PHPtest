@importCSV
Feature: Import CSV Command
  In order to get all the daily sales from the stores
  As a developer
  I need to import all the transactions on a CSV file into the database
 
  Scenario: I can run the command with filename parameter and the file provided is a valid CSV file
    Given a shell console
    When I execute the "transactions:import-csv" command with a "filename" option and "salesData_06-04-2018.csv" parameter
    And the file "salesData_06-04-2018.csv" exists
    And the file "salesData_06-04-2018.csv" is a CSV file
    Then the command output should be "15 transactions has been successfully imported."

  Scenario: I can run the command with filename parameter and the file provided does not exist
    Given a shell console
    When I execute the "transactions:import-csv" command with a "filename" option and "XsalesData_06-04-2018.csv" parameter
    And the file "XsalesData_06-04-2018.csv" does not exists
    Then the command CommandException should be "No data available. The file could not be found."

  Scenario: I can run the command with filename parameter and the file provided is not a valid CSV
    Given a shell console
    When I execute the "transactions:import-csv" command with a "filename" option and "salesData_06-04-2018_invalid.csv" parameter
    And the file "salesData_06-04-2018_invalid.csv" exists
    And the file "salesData_06-04-2018_invalid.csv" is not a valid CSV
    Then the command CommandException should be "Error while parsing the file. ""salesData_06-04-2018_invalid.csv"