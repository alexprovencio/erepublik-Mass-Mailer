#!/bin/bash

case "$1" in
	name)
		read ID
		APIURL='http://api.erepublik.com/v1/feeds/citizens/'"${ID}"
		cd api
		wget $APIURL 2> /dev/null
		cat $ID | sed -n 's_^  <name>\(.*\)</name>_\1_p'
		rm $ID
		cd ..
		;;
	id)
		read NAME
		APIURL='http://api.erepublik.com/v1/feeds/citizens/'"${NAME}"'?by_username=true'
		cd api
		wget "$APIURL" 2> /dev/null
		cat "${NAME}"'?by_username=true' | sed -n 's_^  <id>\(.*\)</id>_\1_p'
		rm "${NAME}"'?by_username=true'
		cd ..
		;;
	*)
		echo "Invalid profile lookup parameter was specified." 1>&2
		;;
esac
