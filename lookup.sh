#!/bin/bash

APIURL="http://api.erepublik.com/v1/feeds/citizens/"${1}
cd api
wget $APIURL 2> /dev/null
cat $1 | sed -n 's_^[ ]*<name>\(.*\)</name>_\1_p'
rm $1
cd ..
