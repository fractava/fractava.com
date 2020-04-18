#!/bin/bash

sh ./start.sh $1

waitForever()
{
    while true
    do
        sleep 1
    done
}

waitForever
