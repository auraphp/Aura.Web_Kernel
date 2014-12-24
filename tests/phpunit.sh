#!/usr/bin/env bash

PWD=$( cd "$( dirname "${BASH_SOURCE[0]}" )" && pwd )
BASEDIR=`dirname $PWD`

# run tests
phpunit -c $PWD/phpunit.xml "$@"
STATUS=$?


# exit
exit $STATUS
