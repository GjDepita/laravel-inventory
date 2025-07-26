#!/bin/sh

echo "⏳ Waiting for MySQL to be ready..."

until nc -z -v -w30 db 3306
do
  echo "❌ MySQL not ready. Waiting..."
  sleep 5
done

echo "✅ MySQL is up – starting Laravel server"

php artisan migrate --force
php artisan serve --host=0.0.0.0 --port=8000
