#!/bin/bash

DIR="$( cd "$( dirname "${BASH_SOURCE[0]}" )" && pwd )"
CDIR=$( pwd )
cd $DIR

MAPAS_NAME=mapas-run

sudo docker exec -w /var/www/html/protected -i $MAPAS_NAME bash -c "pnpm $*"

cd $CDIR