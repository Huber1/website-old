# go to root
cd ..
wd=$(pwd)
export COMPOSER_HOME="$wd/composer"
alias composer="php composer.phar"

git pull

composer install --prefer-dist --no-progress
./tailwindcss -i ./src/style.css -o ./public/css/style.css --minify

rm -rf storage/cache

exit 1
