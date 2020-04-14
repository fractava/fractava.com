#!/bin/bash

file=./file
if [ ! -f /.notfirststart ]; then
    echo "first Start"

    rm -f -R /config/*
    mv /config-buildtime/* /config/

    touch /.notfirststart

    ls /config/www/
    ls /etc/nginx/
fi

nginx

while true
do
    sleep 1
done
