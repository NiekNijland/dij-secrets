# Installation

Requirements:
- Composer
- php 8.0 or higher
- some database server

```bash
cp .env.example .env
composer install
php artisan key:generate
```

Create a new database and update the database connection values in the `.env` file. 
Then run:

```bash 
php artisan migrate
```

# Running the app

You can use your favourite stack (Docker, Mamp, Homestead). Or just run:

```bash
php artisan serve
```

# Run Tests

```bash
php artisan dusk:install
php artisan dusk
```
