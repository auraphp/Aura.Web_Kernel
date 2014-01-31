composer self-update
if [ -d web-project ]
then
    cd web-project
    composer update
    cd ..
else
    composer create-project aura/web-project --prefer-dist --stability=dev
fi

rm -rf web-project/vendor/aura/web-kernel/*
cp -r autoload.php  web-project/vendor/aura/web-kernel/
cp -r composer.json web-project/vendor/aura/web-kernel/
cp -r config        web-project/vendor/aura/web-kernel/
cp -r README.md     web-project/vendor/aura/web-kernel/
cp -r scripts       web-project/vendor/aura/web-kernel/
cp -r src           web-project/vendor/aura/web-kernel/
cp -r tests         web-project/vendor/aura/web-kernel/
cd web-project/vendor/aura/web-kernel/tests
phpunit
status=$?
cd ../../../..
exit $status
