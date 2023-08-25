docker-compose build
docker-compose up -d

docker exec app php artisan key:generate
docker exec app php artisan vendor:publish --tag=order-notification-package-config
docker exec app php artisan l5-swagger:generate
docker exec app php artisan migrate:fresh
chmod +x ./generate_auth_keys.sh
./generate_auth_keys.sh

docker exec app php artisan test
docker exec app php artisan db:seed
