# http://en.wikipedia.org/wiki/ReStructuredText
php composer dump-autoload



php artisan migrate
php artisan migrate:make add_reported_on_to_website
php artisan migrate:make add_ogfields_on_website_status
php artisan migrate:make add_referer_and_robots_on_url_status
php artisan migrate:make add_fields_on_crawl_stats
php artisan migrate:make add_fields_softDeletes
php artisan migrate:make add_redirects_on_url_status
php artisan migrate:make alter_foreigns_on_delete_crawl_id
php artisan migrate:make add_images_table
php artisan migrate:rollback


php artisan generate:laroute

server:
php composer.phar update google/apiclient

CRON:
composer update liebig/cron
php artisan migrate --package="liebig/cron"
-- php artisan config:publish liebig/cron
-- * * * * * /usr/bin/php /var/www/laravel/artisan cron:run