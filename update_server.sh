#!/bin/zsh

# Sends the entire app folder to the remote server if some PHP file is modified

declare -A modTimes

spin='-\|/'
GREEN="\033[1;32m"
NOCOLOR="\033[0m"

i=0
while true
do
    i=$(( (i+1) %4 ))
    printf "\r$GREEN Waiting for file changes ${spin:$i:1} $NOCOLOR"
    sleep 0.1

    for file in $( find app ) 
    do
        newTime=$( stat -f %a $file )
        if [[ ${modTimes[$file]} == $newTime ]] 
        then
            :
        else 
            scp -r app anag004@remote.students.cs.ubc.ca:~/public_html/
            modTimes[$file]=$newTime
        fi 
    done
done