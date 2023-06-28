#!/bin/bash

DIRNAME="$( cd "$( dirname "$0" )" && pwd )"
source "${DIRNAME}/helpers.sh"

compose exec php bash -c "composer $1"
