#!/bin/bash

if [ ! -f /.notfirststart ]; then
    echo "first Start"

    rm -f -R /config/*
    mv /config-buildtime/* /config/

    ln /config/nginx/custom-config-include.conf /etc/nginx/nginx.conf

    touch /.notfirststart

    echo "first start init done"
fi

echo "starting nginx ..."
nginx
echo "nginx start done"

while true
do
    sleep 1
done
