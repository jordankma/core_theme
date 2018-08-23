#!/bin/sh
HOST='123.30.174.148'
USER='nhvv_vnedutech'
PASSWD='rDexyy56zpGAYbdMc7'
FILE='file.txt'

ftp -in -u $HOST <<END_SCRIPT
quote USER $USER
quote PASS $PASSWD
binary
put $FILE
quit
END_SCRIPT
exit 0