#!/bin/bash

checkIfFirstStart()
{
    if [ ! -f /.notfirststart ]; then
        echo "first Start"
        firstStart
        echo "first start init done"
    fi
}

firstStart()
{
    if [ ! -f /config/www ]; then
        backupConfig
    fi

    clearConfigFolder

    mv /config-buildtime/* /config/
    mv /config-buildtime/.* /config/
    cp /config/nginx/custom-config-include.conf /etc/nginx/nginx.conf

    if [ ! -f /config-backup/ ]; then
        copyPersistentFilesBack
    fi

    initGit
    
    touch /.notfirststart
}

clearConfigFolder()
{
    rm -f -R /config/*
}

backupConfig()
{
    echo "config backup"
    mkdir /config-backup/
    cp -r /config/ /config-backup/
}

copyPersistentFilesBack()
{
    echo "copy persistent files back"
    if [ -e /config-backup/config/www/config/config.json ]; then
        mkdir /config/www/config/
        cp /config-backup/config/www/config/config.json /config/www/config/config.json
    fi
}

initGit()
{
    if [ "$branch" != "master" ]; then
        echo "init git"
        cd /config/
        git remote set-url origin https://git.fractava.com/fractava/fractava.com.git
        git checkout $1
        git reset --hard
        git pull
    fi
}

startNginx()
{
    echo "starting nginx ..."
    nginx &
    echo "nginx start done"
}

checkIfFirstStart
startNginx
