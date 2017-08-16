# Cem Turk (cemturk@gmail.com) Freelance Assessment

Fictional CeM Telecom's IVR configurator interface powered by CM Telecom Voice API :)

I created the project with a nice laravel/angular boilerplate 
(https://github.com/Zemke/starter-laravel-angular) which provides a very nice 
laravel backend also you can use angular for the front end, i used mysql for database

Provided authentication and JWT authorization infrastructure
Created database migrations and seeder 
Added a chart like IVR Configurator


## Installation

```
composer install --prefer-dist
```
```
npm install
```

### Database setup

Edit `.env` according to your environment 

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

If you get an error like a `PDOException` try editing your `.env` file and change `DB_HOST=localhost` to `DB_HOST=127.0.0.1`. 
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
Chart like configurator makes it very easy to configure, you can view the current config nicely and add/set items very easily.
The app can look a lot better with proper styling, also some custom actions like go to instruction can be added for control over IVR flow.
Also IVR configurator should have a validator to check any possible dead-ends.
TTS is the default option for all prompts for this app, also voice settings are not editable. 

Instructions are stored as json strings in the db because they have variable number of properties. 

All requests/responses to/from the backend are logged to make it easier to debug any potential problems.

Overall it was fun to do this assessment, working with real services is always nice. 

Also special thanks to Michael for assisting me with the small issues I had.

## Feedback About Voice API

Voice API uses hyphens in variables like prompt-type etc, this makes consistent naming of the properties in PHP or javascript  
difficult as these languages don't allow hyphens in variable/object/property names, instead you could use underscore or camel casing.

Also in the documentation here https://docs.cmtelecom.com/voice-api/v2.0#/events_(post_commands)%7Cnew_call_event
the variable for the number that has been called is listed as "called" but in practice variable in Voice API is called "callee"

