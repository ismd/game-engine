#!/bin/sh
if [[ $EUID -eq 0 ]]; then
    echo "This script must not be run as root" 1>&2
    exit 1
fi

if [ -n "$1" ]; then
    SERVER_PATH=$1
else
    SERVER_PATH="server"
fi

cd $SERVER_PATH
mvn "-Dexec.args=-classpath %classpath game.server.Main ../layouts" -Dexec.executable=/usr/lib/jvm/java-7-openjdk/bin/java process-classes org.codehaus.mojo:exec-maven-plugin:1.2.1:exec
