Example PHP project
===================

[![Build Status](https://travis-ci.org/openroom/phpci.svg?branch=master)](https://travis-ci.org/openroom/phpci)

Source
------
To run unit tests locally, 

* give your postgres user password of postgres
* create hello_world_test database 
* make postgres owner of the database 
* go to your project folder 
* run something like vendor/bin/phpunit --configuration phpunit_pgsqllocal.xml --coverage-text 

enjoy!
