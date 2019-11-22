#!/bin/bash

file=$1
modTime=$( stat -c "%Y" $file )

while true 
do
	newTime=$( stat -c "%Y" $file )
	if [[ $newTime -eq $modTime ]] 
	then
		echo -ne "\rWaiting..."
	else 
		echo "start ${file::-4};" | sqlplus -s "ora_anag004@stu/a23835341" 
		modTime=newTime
	fi
done
