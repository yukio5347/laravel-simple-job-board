# Simple Job Board
This is a simple job board that does not require any user registrations to post jobs or apply for jobs.

## Installation and setup

#### Clone the repository.
```
git clone git@github.com:yukio5347/laravel-simple-job-board.git
```

#### Go to the project directory
```
cd laravel-simple-job-board
```

#### Install packages
```
composer install
```

#### Setup the `.env` file.
```
cp .env.example .env
php artisan key:generate
```
Edit at least `APP_NAME`, `APP_ENV`, `APP_DEBUG`, `APP_URL`, `MAIL_XXX` and `DB_XXX` variables.

#### Create tables
```
php artisan migrate
```

## Localization
It's very easy to localize to your language. The following example shows the steps to localize into French.

#### Install the lang files
```
composer require laravel-lang/common --dev
php artisan lang:add fr
```
Please refer to [the official documentation](https://laravel-lang.com/) for more details.

#### Copy and edit the JSON file
```
cp lang/en.json lang/fr.json
```

#### Set `LOCALE` variable in `.env`
```
LOCALE=fr
```
