#!/bin/sh
if [[ $EUID -eq 0 ]]; then
   echo "This script must not be run as root" 1>&2
   exit 1
fi

DIR=$( cd "$( dirname "${BASH_SOURCE[0]}" )" && pwd )
 
nohup $DIR/start_game.sh 0<&- &> /var/log/game.log &
