cd "$1" || exit 0

git pull
composer install --prefer-dist --no-progress
./tailwindcss -i ./src/style.css -o ./public/css/style.css --minify
