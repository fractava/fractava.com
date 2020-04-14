#!/bin/bash

file=./file
if [ ! -f /.notfirststart ]; then
    echo "first Start"

    rm -f -R /config/*
    mv /config-buildtime/* /config/

    #rm -R /etc/nginx/*
    #mkdir /etc/nginx/site-confs/
    #ln -s /config/nginx/nginx.conf /etc/nginx/nginx.conf
    #ln -s /config/nginx/mime.types /etc/nginx/mime.types
    #ln -s /config/nginx/site-confs/default /etc/nginx/site-confs/default

    touch /.notfirststart

    ls /config/www/
    ls /etc/nginx/
fi

nginx

while true
do
    sleep 1
done
