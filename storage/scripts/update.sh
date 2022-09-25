cd "$1" || exit 0

git pull
composer install
./tailwindcss -i ./src/style.css -o ./public/css/style.css --minify
