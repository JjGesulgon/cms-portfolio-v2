## Table of contents
* [General info](#general-info)
* [Technologies](#technologies)
* [Setup](#setup)

## General info
This is a custom-made internal Content Management System. This system will handle the things that will be shown or displayed on my website. Once deployed, this system can only be accessed by the admin registered in the system. 
	
## Technologies
Project is created with:
* Laravel 7
* Vue.js
	
## Setup
To setup this project, follow the steps below:

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
