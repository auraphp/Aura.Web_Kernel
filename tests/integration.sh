cd integration
composer self-update
cp ../../composer.json .
if [ -d vendor ]
then
    composer update
else
    composer install
fi
cd ..
phpunit
status=$?
exit $status
