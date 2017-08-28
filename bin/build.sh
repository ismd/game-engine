#!/bin/sh
if [[ $EUID -eq 0 ]]; then
   echo "This script must not be run as root" 1>&2
   exit 1
fi

if [ -n "$1" ]; then
    JS_PATH=$1
else
    JS_PATH="site/js"
fi

cd $JS_PATH
npm update
NODE_ENV=production npm run build
