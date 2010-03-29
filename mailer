#!/bin/bash

cat recipientList | tr -d '\r' | awk 'BEGIN {FS="/";} {print ("<a href=\"" "http://www.erepublik.com/en/messages/compose/" $7 "?message_subject='$1'&message_body='$2'\">" $7 "</a>");}'
