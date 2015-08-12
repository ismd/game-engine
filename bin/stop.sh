#!/bin/sh
kill `ps -aux | grep ismd | grep 'start_game\|game.server.Main' | grep -v grep | tr -s ' ' | cut -d ' ' -f 2 | tr '\n' ' '`
