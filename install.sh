# install.sh 
#!/bin/bash

npm install
npm run dev
composer install
cp .env.example .env
php artisan key:generate

sed -i 's/DB_HOST=127.0.0.1/DB_HOST=172.17.0.1/g' .env &&

php artisan migrate --seed
php artisan storage:link
