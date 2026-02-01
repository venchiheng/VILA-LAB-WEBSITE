#!/bin/bash
# docker-entrypoint.sh

# Ensure bootstrap/cache and storage exist
mkdir -p bootstrap/cache storage

# Set correct permissions
chown -R www-data:www-data bootstrap/cache storage
chmod -R 775 bootstrap/cache storage

# Run the original command (php-fpm by default)
exec "$@"
