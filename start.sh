#!/bin/bash

checkIfFirstStart()
{
    if [ ! -f /.notfirststart ]; then
        echo "first Start"
        echo "branch: $1"
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

startNginx()
{
    echo "starting nginx ..."
    nginx &
    echo "nginx start done"
}

checkIfFirstStart
startNginx
