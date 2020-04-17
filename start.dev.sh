#!/bin/bash

sh ./start.sh

startWebpackWatch()
{
    cd /config/www/
    npm run watch
}
waitForever()
{
    while true
    do
        sleep 1
    done
}

startWebpackWatch
waitForever
