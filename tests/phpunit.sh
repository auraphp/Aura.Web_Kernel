#!/usr/bin/env bash

# update dependencies
PWD=$( cd "$( dirname "${BASH_SOURCE[0]}" )" && pwd )
BASEDIR=`dirname $PWD`
#composer update --working-dir=$BASEDIR

# run tests
phpunit -c $PWD/phpunit.xml "$@"
STATUS=$?


# exit
exit $STATUS
