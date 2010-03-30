#!/bin/bash

# Get the url encoded form of the subject
SUBJECT=`cat subject | ./filters/urltranslate.php encode | ./filters/striplines.sh`
MESSAGE=`cat message | ./filters/urltranslate.php encode | ./filters/striplines.sh`

# Convert profile IDs to message URLs
LINENUMBER=1
while read LINE; do
#	echo "$LINENUMBER"
	# use sed to replace in echo "$MESSAGE" a string {{ARRAY1}} with the LINENUMBERth line of array1
	ARRAYENTRY=`sed -n ${LINENUMBER}p <arrayOne`
#	echo "$ARRAYENTRY"
	MODIFIEDSUBJECT=`printf "%s" "$SUBJECT" | sed 's_%7B%7BARRAYONE%7D%7D_'${ARRAYENTRY}'_g'`
	MODIFIEDMESSAGE=`printf "%s" "$MESSAGE" | sed 's_%7B%7BARRAYONE%7D%7D_'${ARRAYENTRY}'_g'`
#	echo "$MODIFIEDMESSAGE"
	printf "%s" "$LINE" | awk 'BEGIN {FS="#";} {print ("<a href=\"" "http://www.erepublik.com/en/messages/compose/" $2 "?message_subject='"$MODIFIEDSUBJECT"'&message_body='"$MODIFIEDMESSAGE"'\">" $2 "</a><br />");}' >> output
	((LINENUMBER++))
done

# Clear the tempOutput
echo "" > tempOutput
