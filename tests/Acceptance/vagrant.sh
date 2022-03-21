#!/bin/bash

# Terminate as soon as one command fails (e)
set -e

# Source .profile for extra path etc
if [ -f ~/.profile ]
then
    source ~/.profile
fi

# Go into repository workspace
cd ~/cpriego-valet-linux

# Install valet
valet install

# Run Functional tests
./vendor/phpunit/phpunit/phpunit --group acceptance --exclude-group none
