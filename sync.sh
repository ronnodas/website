#! /bin/bash

EXTERNAL_SERVER_ADDRESS='access.cmi.ac.in'
INTERNAL_SERVER_ADDRESS='server2'
LOCAL_DIRECTORY="~/Dropbox/webpage"

if [ -e ~/Dropbox/webpage ]
then
    echo exists
    chmod -R 755 ~/Dropbox/webpage/*
    if ping -c 1 $INTERNAL_SERVER_ADDRESS
    then
        unison ~/Dropbox/webpage ssh://"$INTERNAL_SERVER_ADDRESS"/.www
    else
        unison ~/Dropbox/webpage ssh://"$EXTERNAL_SERVER_ADDRESS"/.www
    fi
else
    echo doesn\'t
fi


