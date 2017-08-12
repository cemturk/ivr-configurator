# Cem Turk (cemturk@gmail.com) Freelance Assessment

Fictional CeM Telecom's IVR configurator interface powered by CM Telecom Voice API :)

I created the project with a nice laravel/angular boilerplate 
(https://github.com/Zemke/starter-laravel-angular) which provides a very nice 
laravel backend also you can use angular for the front end, i used mysql for database

Provided authentication and JWT authorization infrastructure
Created database migrations and seeder 


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
Work in progress

