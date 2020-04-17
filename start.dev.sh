#!/bin/bash

sh ./start.sh

startWebpackWatch()
{
    echo "start webpack watch"
    cd /config/www/
    npm run watch
    echo "webpack watch initialised"
}

startWebpackWatch

echo "everything initialised"
while true
do
   sleep 1
done
