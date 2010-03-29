#!/bin/bash

# Convert dos line endings to unix line endings
cat recipientList | ./filters/crlftolf.sh > tempRecipientList

# Remove blank lines
cat tempRecipientList | ./filters/striplines.sh > recipientList

# Convert profile URLs to player IDs
awk 'BEGIN {FS="/";} /http.*/ {print "#" $7;} /#.*/ {print;}' recipientList > tempRecipientList

cat tempRecipientList > recipientList

# Clear the tempRecipientList
echo "" > tempRecipientList

# Convert URLs to messages
cat recipientList | ./convertList.sh
