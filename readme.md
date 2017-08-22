
## About Neo

Neo is a small app that gets asteroids data from Nasa API and does simple categorization on it

## Environment requirements

The application uses Laravel framework 5.4 and requires: 

- PHP >= 5.6.4

- OpenSSL PHP Extension

- PDO PHP Extension

- Mbstring PHP Extension

- Tokenizer PHP Extension

- XML PHP Extension

- Composer (install globally / locally instructions avaliable at https://getcomposer.org/download/ )


## API installation

- From the root folder open a command window prompt and type "composer install" if composer is installed globally or type "php composer.phar install" if installed locally.

- In the environment file ".env" make sure to set the (dbname, username, password) values for the mysql database you created on your server. Also included the NASA API KEY in this file as NASA_API_KEY.

- After all dependencies are installed by composer & database variables were set in the environment, type the command "php artisan migrate" to migrate the database.

- To check unit tests, type the command "phpunit" or if you have an older version already installed and saved in your system environment variable type "vendor/bin/phpunit" instead to be sure to use the needed version.
