#!/bin/bash

# Convert DOS-type line endings to Unix-type line endings
cat recipientList > tempRecipientList
cat tempRecipientList | tr -d '\r' > recipientList

# Remove blank lines
sed '/^$/d' recipientList > tempRecipientList

cat tempRecipientList > recipientList

# Convert URLs to messages
cat recipientList $1 $2 | ./convertList.sh
