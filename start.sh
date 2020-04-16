#!/bin/bash

check-if-first-start
{
    if [ ! -f /.notfirststart ]; then
        echo "first Start"
        first-start
        echo "first start init done"
    fi
}

first-start
{
    if [ ! -f /config ]; then
        backup-config
    fi

    clear-config-folder

    mv /config-buildtime/* /config/
    cp /config/nginx/custom-config-include.conf /etc/nginx/nginx.conf

    if [ ! -f /config-backup/ ]; then
        copy-persistent-files-back
    fi
    
    touch /.notfirststart
}

clear-config-folder
{
    rm -f -R /config/*
}

backup-config()
{
    echo "config backup"
    mkdir /config-backup/
    cp /config/* /config-backup/
    ls /config-backup/
}

copy-persistent-files-back()
{
    echo "copy-persistent-files-back"
    cp /config-backup/www/js/modules/config.js /config/www/js/modules/
}

start-nginx()
{
    echo "starting nginx ..."
    nginx
    echo "nginx start done"
}

wait-forever()
{
    while true
    do
        sleep 1
    done
}

check-if-first-start
start-nginx
wait-forever
