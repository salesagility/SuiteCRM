#!/usr/bin/env bash

source /usr/local/bin/bash_standard_lib.sh

DOCKER_IMAGES="php:8.0-cli
php:7.4-cli
php:7.3-cli
php:7.2-cli
php:7.1-cli
"

for di in ${DOCKER_IMAGES}
do
(retry 2 docker pull "${di}") || echo "Error pulling ${di} Docker image, we continue"
done

