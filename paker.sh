#!/bin/bash

for dname in $(ls -d */ | tr -d /); do
    archive_name=$dname'.zip'
    zip -r $archive_name $dname
done;