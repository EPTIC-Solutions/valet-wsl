#!/usr/bin/env bash
set -e

# Determine if the port config key exists, if not, create it
function fix-config() {
    local CONFIG="$HOME/.valet/config.json"

    if [[ -f $CONFIG ]]
    then
        local PORT=$(jq -r ".port" "$CONFIG")

        if [[ "$PORT" = "null" ]]
        then
            echo "Fixing valet config file..."
            CONTENTS=$(jq '. + {port: "80"}' "$CONFIG")
            echo -n $CONTENTS >| "$CONFIG"
        fi
    fi
}

if [[ "$1" = "update" ]]
then
    if [[ "$2" ]]
    then
        composer global update "eptic/valet-wsl:$2"
    else
        composer global update "eptic/valet-wsl"
    fi
    valet install
fi

fix-config
