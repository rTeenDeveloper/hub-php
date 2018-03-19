# rTeenDeveloper Hub

A place where all the teenage developers could feel like at home

## Getting Started

These instructions will get you a copy of the project up and running on your local machine for development and testing purposes. See deployment for notes on how to deploy the project on a live system.

### Prerequisites

Clone repository onto your local machine. Get into 'hub' folder, then rename .env.example to .env and make some changes 
if you need to.

### Installing

You will need composer and php installed. You can install composer using this [Tutorial](https://getcomposer.org/download).

First, run in the hub directory:

`composer install` or if installed locally (installed from the page mentioned) `php composer.phar install` 

This will install all required packages.

Then, run: 

```
php artisan key:generate
```

This command will generate an encryption key for your local development copy.

```
php artisan migrate
```

Will create you a local copy of database (be sure to set database credentials in .env first)

Finally, run 

``` 
php artisan serve
```

to run local dev server. You may use other webserver, such as Apache or Nginx if you want.


## Contributing

Please read CONTRIBUTING.md for details on our code of conduct, and the process for submitting pull requests to us.
