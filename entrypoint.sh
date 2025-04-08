#!/bin/bash
set -e

echo "⏳ Waiting for PostgreSQL..."

until pg_isready -h "$DB_HOST" -p "$DB_PORT" -U "$DB_USER"; do
  sleep 2
done

echo "✅ PostgreSQL is ready!"

# Seed the database
echo "🌱 Running seed.php to initialize database..."
php /var/www/html/scripts/seed.php || echo "⚠️  Seeding failed or already done."

# Start Apache
exec apache2-foreground
