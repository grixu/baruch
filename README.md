# Baruch

This project provide complete solution for Jehovah's Witnesses congregations in matter of:
- ℹ️ information board

## Architecture
This project is build in domain-oriented conception presented in Laravel beyond CRUD book by Spatie.

### Changes from normal Laravel template:
- All source code (both Application & Domain layers) in `/src` directory
- Custom `Application`class
- Customized Laravel stubs
- Using `laravel/sail` as development environment
- Using `spatie/laravel-ray`
- Using code quality tools such as: `php-cs-fixer`, `phpstan` & `php-insights`

## How to start

You need to have installed [Docker](https://www.docker.com/get-started) or [Laravel Valet](https://laravel.com/docs/8.x/valet) if you are on Mac and would like to run dev environment natively instead of Docker.

```bash
git clone https://github.com/grixu/baruch.git
cd baruch
composer install
```

### The Docker way
```bash
cp .env.example.docker .env
./vendor/bin/sail up -d
./vendor/bin/sail shell
# Then into the container's shell
php artisan key:generate
php artisan migrate
php artisan db:seed
yarn install
yarn dev
```

Then, just open your browser at http://localhost and log in.

### The Valet way
```bash
cp .env.example .env
# Then prepare database 
mysql -u root -p < "CREATE DATABASE baruch CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci;"
php artisan key:generate
php artisan migrate
php artisan db:seed
yarn install 
yarn dev
valet link baruch
```

Now, you can just open your browser at http://baruch.test (or your custom TLD if you already set so).

### Basic credentials


## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

### Security

If you discover any security related issues, please email mateusz.gostanski@gmail.com instead of using the issue tracker.

## Credits

- [Mateusz Gostański](https://github.com/grixu)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
