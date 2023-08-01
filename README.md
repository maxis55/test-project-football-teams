# PURE DOCKER SETUP

# Common Commands
- `docker-compose exec php /bin/sh -c "COMPOSER_MEMORY_LIMIT=-1 composer install"`
- `docker-compose run --rm npm run dev`
- `docker-compose exec php /bin/sh -c "php /var/www/artisan"`

# Setup
- Copy .env.example and paste it as .env file, in the root folder and src folder respectively
- `docker-compose down -v` (if already installed with other data)
- `docker-compose build` (or after adding new settings in Dockerfile)

# Run app
- `docker-compose up`

# Finish setup
- `docker-compose exec php /bin/sh -c "COMPOSER_MEMORY_LIMIT=-1 composer install"`
- `docker-compose exec php /bin/sh -c "php /var/www/artisan key:generate"`   
- `docker-compose exec php /bin/sh -c "php /var/www/artisan migrate --seed"`   

docker-compose exec php /bin/sh -c "vendor/bin/phpunit --configuration phpunit.xml --coverage-html reports --log-junit reports/junit.xml"

# Testing
For full information about tests
- `docker-compose exec php /bin/sh -c "vendor/bin/phpunit --configuration phpunit.xml --coverage-html reports --log-junit reports/junit.xml"`

For fast tests
- `docker-compose exec php /bin/sh -c "php /var/www/artisan test"`  

- App will run on the port 8080, i.e. http://localhost:8080/
Make sure that its available or change docker-compose settings
