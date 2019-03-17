#!/bin/bash

# Simple script for creating archives ready for installation in wordpress
# this will list all NORMAL directories and compress them into files named like directories.
# Entries like ., .., .git, .idea will be omitted.
# Piotr Be <herbalist@herbalist.hekko24.pl>

for dname in $(ls -d */ | tr -d /); do
    archive_name=$dname'.zip'
    if [ -e "$archive_name" ]
    then
        echo -e "delete " "$archive_name" "...\n"
        rm -rf "$archive_name"
    fi
    zip -r $archive_name $dname
done;