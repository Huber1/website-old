cd "$1" || exit 0

git pull
export COMPOSER_HOME="/usr/www/users/ulrichyb/public-moritz/composer"
alias composer="php composer.phar"
composer install --prefer-dist --no-progress
./tailwindcss -i ./src/style.css -o ./public/css/style.css --minify

exit 1
