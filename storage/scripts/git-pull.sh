cd "$1" || exit 0

git fetch
git reset --hard HEAD
git merge '@u'
export COMPOSER_HOME="/usr/www/users/ulrichyb/public-moritz/composer"
composer install --prefer-dist --no-progress
./tailwindcss -i ./src/style.css -o ./public/css/style.css --minify

echo "pulled"