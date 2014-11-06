composer self-update
cp ../../composer.json .
if [ -d vendor ]
then
    composer update
else
    composer install
fi
phpunit $@
status=$?
exit $status
