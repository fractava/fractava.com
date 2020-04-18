#!/bin/bash

sh ./start.sh

startWebpackWatch()
{
    echo "start webpack watch"
    cd /config/www/
    npm run watch
    echo "webpack watch initialised"
}
initGit()
{
    cd /config/
    git remote set-url origin https://git.fractava.com/fractava/fractava.com.git
    git checkout $1
}

startWebpackWatch
initGit

echo "everything initialised"
while true
do
   sleep 1
done
