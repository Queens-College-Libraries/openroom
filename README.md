# Openroom 

Openroom is a web application that manages your room reservations.

This version of openroom is a work-in-progress. 
We have a lot of enhancements planned. 
The project is free and open source (GPLv3). 

## Implemented changes 

Please help test "normal" mode (as opposed to ldap) of the application. 
Openroom now has preliminary support for `password_hash()` and `password_verify()`. 
This is a long overdue change and it is as important as fixing our SQL injection vulnerabilities. 
This means anyone who is using normal mode before today (hopefully not in production), 
should inform their users that we need to rehash their passwords. 
This is also a good time to ask the users to change their passwords. 
Please take it for a spin today and tell me if you face any bugs! 

## Proposed technologies 

* PHP 7.1 for a better PHP 
* PDO for database interaction 
* Twig for templating and better theme support  
* jQuery and bootstrap for front end 

## Proposed supported web browsers 

* Support current versions of Google Chrome and Mozilla Firefox 

## A demo for twig support 
Please take a look at 

[this screen shot](https://i.imgur.com/gQxtCB5.png). 
![List of reservations](https://i.imgur.com/gQxtCB5.png) 

It is just an example to show you what I want you to be able to do with your own custom theme.
This form is not functional and likely will not be in 2018. 
This is only a demonstration of my vision. 

# Thoughts? 

Please feel free to open an issue or a pull request on github. 
