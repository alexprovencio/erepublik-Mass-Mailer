#!/bin/bash

# Get the url encoded form of the subject
SUBJECT=`cat messageData/subject | ./filters/urltranslate.php encode | ./filters/striplines.sh`
MESSAGE=`cat messageData/message | ./filters/urltranslate.php encode | ./filters/striplines.sh`

# Convert profile IDs to message URLs
LINENUMBER=1
while read LINE; do
	echo "$LINENUMBER"
	
	# use sed to replace in echo "$MESSAGE" a string {{REPLACEME}} with the LINENUMBERth line of replaceOne
	REPLACEENTRY=`sed -n ${LINENUMBER}p <messageData/replaceOne`
	echo "$REPLACEENTRY"
	MODIFIEDSUBJECT=`printf "%s" "$SUBJECT" | sed 's_%7B%7BREPLACEME%7D%7D_'"${REPLACEENTRY}"'_g'`
	MODIFIEDMESSAGE=`printf "%s" "$MESSAGE" | sed 's_%7B%7BREPLACEME%7D%7D_'"${REPLACEENTRY}"'_g'`
	echo "$MODIFIEDMESSAGE"
	
	# If "{{PROFILENAME}}" exists in either the message or the subject, generate a list of profile names
#	case "${MESSAGE}${SUBJECT}"
#		grep .*'{{PROFILENAME}}'.*)
#			echo "Generate a list" > blah
#	esac
	
	# use sed to replace in echo "$MESSAGE" the string {{PROFILENAME}} with the name of the corresponding player
#	REPLACEENTRY=`sed -n ${LINENUMBER}p <messageData/profileNames`
#	MODIFIEDSUBJECT=`printf "%s" "$MODIFIEDSUBJECT" | sed 's_%7B%7BPROFILENAME%7D%7D_'"${REPLACEENTRY}"'_g'`
#	MODIFIEDMESSAGE=`printf "%s" "$MODIFIEDMESSAGE" | sed 's_%7B%7BPROFILENAME%7D%7D_'"${REPLACEENTRY}"'_g'`

	# Generate the URL with html code
	printf "%s" "$LINE" | awk 'BEGIN {FS="#";} {print ("<a href=\"" "http://www.erepublik.com/en/messages/compose/" $2 "?message_subject='"$MODIFIEDSUBJECT"'&message_body='"$MODIFIEDMESSAGE"'\">" $2 "</a><br />");}' >> output
	((LINENUMBER++))
done

# Clear the tempOutput
echo "" > tempOutput
