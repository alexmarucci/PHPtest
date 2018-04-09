PHPtestB
========

A Symfony project created on April 5, 2018, 8:10 pm.

# Installation

Install the dependencies and devDependencies and run the composer install.

```sh
$ git clone https://github.com/alexmarucci/PHPtest.git ./testphp
$ cd testphp
$ composer install
```
### Database  Init
Create database schema for dev and test environment.
```sh
$ bin/console doctrine:database:create
$ bin/console doctrine:database:create --env=test
```
Populate both databases.
```sh
$ bin/console doctrine:migrations:migrate
$ bin/console doctrine:migrations:migrate --env=test
```
### Start the local server
```sh
$ bin/console server:start
  127.0.0.1:8000
```
### Run Unit Test and BDD Test
```sh
$ ./vendor/bin/simple-phpunit
$ ./vendor/bin/behat
```

### Design Patterns
 Main design patterns I have been used for this project

| Plugin | Pattern |
| ------ | ------ |
| ADR | Action Domain Responder Pattern |
| Visitor | Visitor Pattern |
| BDD | Behaviour Driven Design |
| TDD | Test Driven Design |
| Command Bus | Command Bus |

### Todos

 - Write MORE Tests
 - Add endpoint to get the data
 - Better algorithm to check whether or not a store lies inside a particual location/Area
