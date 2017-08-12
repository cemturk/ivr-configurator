# Cem Turk (cemturk@gmail.com) Development Assessment

Fictional CeM Telecom's SMS web interface powered by CM Telecom SMS Gateway :)

I created the project with a nice laravel/angular boilerplate 
(https://github.com/Zemke/starter-laravel-angular) which provides a very nice 
laravel backend also you can use angular for the front end, i used mysql for database

Provided authentication and JWT authorization infrastructure
Created database migrations and seeder 
Send Message view could use SMS sources and receipents from a db also you could use select2 or similar
library to enable selection of multiple receipents, you could use arrays to add the functionality.
Currently only receipent is my mobile number and it is hardcoded in the view for the demo.


## Installation

```
composer install --prefer-dist
```
```
npm install
```

### Database setup

Edit `.env` according to your environment also provide CM telecom product token there

Run these commands to create the tables within the database you have already created.

```
php artisan migrate:install
```
```
php artisan migrate:refresh
```
Run following command to create demo user
```
php artisan db:seed
```

If you get an error like a `PDOException` try editing your `.env` file and change `DB_HOST=localhost` to `DB_HOST=127.0.0.1`. If that doesn’t work, file an issue on GitHub, I will be glad to help.
Source: http://stackoverflow.com/a/20733001

## Run

To provide the JS and CSS files and to keep track of changes to these files:
```
gulp && gulp watch
```

To start the PHP built-in server:
```
php -S localhost:8080 -t public/
```

Now you can browse the site  [http://localhost:8080](http://localhost:8080). 🙌

## Requirements

- PHP >= 5.4
- Composer
- Gulp
- NPM
- MySQL

#General Thoughts
I am sorry for the delay, I didnt have the time to complete the assessment in a shorter time due to
health problems and business at work. I could add some datetime, sender, receipent etc.. filters 
to Sent Messages. Also some unit tests can be added to test backend and front end pages. 

I chose to limit message count to 8 as suggested in the docs. I think API is well documented but 
I would love to have Online Gateway to return some text message when you successfuly send SMS using XML
instead of empty response. 

I am yet to receive any SMS from the system (maybe its because I am located in Turkey) but my credit went down 
so I took it as successful SMS, I had no errors regarding bad receipents or sth similar.


