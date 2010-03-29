#!/bin/bash

# Convert DOS-type line endings to Unix-type line endings
cat recipientList > tempRecipientList
cat tempRecipientList | tr -d '\r' > recipientList

# Remove blank lines
sed '/^$/d' recipientList > tempRecipientList

cat tempRecipientList > recipientList

# Convert URLs to messages
awk 'BEGIN {FS="/";} {print ("<a href=\"" "http://www.erepublik.com/en/messages/compose/" $7 "?message_subject='$1'&message_body='$2'\">" $7 "</a>");}' recipientList > output
