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
    if [ ! -f /config ]; then
        backupConfig
    fi

    clearConfigFolder

    mv /config-buildtime/* /config/
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
    cp /config/* /config-backup/
    ls /config-backup/
}

copyPersistentFilesBack()
{
    echo "copy-persistent-files-back"
    if [ -e /config-backup/www/config/config.json ]; then
        cp /config-backup/www/config/config.json /config/www/config/
    fi
}

startNginx()
{
    echo "starting nginx ..."
    nginx
    echo "nginx start done"
}

waitForever()
{
    while true
    do
        sleep 1
    done
}

checkIfFirstStart
startNginx
waitForever
