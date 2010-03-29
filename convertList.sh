#!/bin/bash

# Get the url encoded form of the subject
SUBJECT=`cat subject | ./filters/urltranslate.php encode | ./striplines.sh`
MESSAGE=`cat message | ./filters/urltranslate.php encode | ./striplines.sh`

# Convert profile IDs to message URLs
LINENUMBER=1
while read line; do
	awk 'BEGIN {FS="#";} {print ("<a href=\"" "http://www.erepublik.com/en/messages/compose/" $2 "?message_subject='"$SUBJECT"'&message_body='"$MESSAGE"'\">" $2 "</a><br />");}' >> output
	((LINENUMBER++))
done

# Clear the tempOutput
echo "" > tempOutput
