# rTeenDeveloper Hub

This is a complete instruction on setting up a server for rTeenDeveloper Hub. This includes caching servers and stuff.
You may not need some of these things if you're just setting up a local copy for development purposes. 

## Getting started 

First, we're going to setup webserver. The most efficient (and the only supported by developers) is using nginx for 
everything. So:

```
sudo apt-get install nginx
```

Now we're going to get the basic packages, which will be required to get source code installed on our machine.

```
sudo apt-get update
sudo apt-get install php7.1 git composer php-zip unzip
``` 

What we want to do now is going to the webserver files directory, which is /var/www and cloning the latest version of Hub. So:

WARNING: If you want the latest *stable* version, change 'development' to 'master'

```
cd /var/www
git clone https://github.com/rTeenDeveloper/hub-php.git -b development .
```

Now we're going to get all vendor packages and dependencies. So:

```
sudo apt-get install php-dom php-mbstring php-fpm php-mysql
composer install
```

It's permissions time! 

```
sudo chmod 777 -R storage vendor bootstrap
```

Webserver. Almost there (still a lots of work, but will be able to actually see results! Isn't that cool?)

```
sudo apt-get install nginx
```

Now we should configure it, so use your favorite editor to open nginx config. The configuration file may be a little bit
different, it depends on your distribution (TODO: separate install tutorials for every dist)

First, change this line (all the following lines will be in ```server``` block):

```root	/usr/share/nginx/html;```

to:

```root /var/www/public;```

You can now type ```sudo service nginx restart``` and visit your server's address. It should display you 403 error, as 
we haven't configured nginx to work with php yet.
