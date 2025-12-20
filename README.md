git pull origin main

composer install --no-dev --optimize-autoloader

php artisan config:cache
php artisan route:cache
php artisan view:cache

php artisan queue:restart

php artisan octane:reload
