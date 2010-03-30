#!/bin/sh

while read LINE; do
	awk 'BEGIN {FS="/";} /http.*/ {print "#" $7;} /#[0-9]*/ {print;} /.{4,30}/ {print;}' >> tempRecipientList
done
