#!/bin/bash

# Clear existing build files
rm -rf public/build

# Install dependencies
npm install

# Build assets
npm run build

# Ensure directory exists
mkdir -p public/build

# Clear Laravel cache
php artisan config:clear
php artisan cache:clear
php artisan view:clear

# Optimize Laravel
php artisan optimize
