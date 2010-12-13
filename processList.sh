#!/bin/bash

# Convert dos line endings to unix line endings
cat messageData/recipientList | ./filters/crlftolf.sh > tempRecipientList

# Remove blank lines
cat tempRecipientList | ./filters/striplines.sh > messageData/recipientList

# Convert profile URLs to player IDs
awk 'BEGIN {FS="/";} /http.*/ {print "#" $7;} /#.*/ {print;}' messageData/recipientList > tempRecipientList

cat tempRecipientList > messageData/recipientList

# Clear the tempRecipientList
echo "" > tempRecipientList

# Convert URLs to messages
cat messageData/recipientList | ./idToUrl.sh

echo "" > messageData/*
