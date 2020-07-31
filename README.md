## Table of contents
* [General info](#general-info)
* [Technologies](#technologies)
* [Setup](#setup)

## General info
This is a custom-made internal CMS Website. This will project will handle the APIs of both the CMS and the Main Website. This system can only be accessed by the admin registered in the system. 
	
## Technologies
Project is created with:
* Laravel 7
* Vue.js
	
## Setup
To run this project, follow the steps below:

```
$ cd personal-website
$ cp .env.example .env
$ composer install 
$ php artisan storage:link
$ php artisan passport:keys
$ php artisan key:generate
$ php artisan passport:install
$ npm install *
$ npm run watch
```
