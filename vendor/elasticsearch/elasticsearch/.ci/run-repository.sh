#!/usr/bin/env bash
# parameters are available to this script

# STACK_VERSION -- version e.g Major.Minor.Patch(-Prelease)
# TEST_SUITE -- which test suite to run: oss or xpack
# ELASTICSEARCH_URL -- The url at which elasticsearch is reachable, a default is composed based on STACK_VERSION and TEST_SUITE
# PHP_VERSION -- PHP version (defined in test-matrix.yml, a default is hardcoded here)
script_path=$(dirname $(realpath -s $0))
source $script_path/functions/imports.sh
set -euo pipefail

PHP_VERSION=${PHP_VERSION-8.0-cli}
ELASTICSEARCH_URL=${ELASTICSEARCH_URL-"$elasticsearch_url"}
elasticsearch_container=${elasticsearch_container-}

echo -e "\033[34;1mINFO:\033[0m VERSION ${STACK_VERSION}\033[0m"
echo -e "\033[34;1mINFO:\033[0m TEST_SUITE ${TEST_SUITE}\033[0m"
echo -e "\033[34;1mINFO:\033[0m URL ${ELASTICSEARCH_URL}\033[0m"
echo -e "\033[34;1mINFO:\033[0m CONTAINER ${elasticsearch_container}\033[0m"
echo -e "\033[34;1mINFO:\033[0m PHP_VERSION ${PHP_VERSION}\033[0m"

echo -e "\033[1m>>>>> Build docker container >>>>>>>>>>>>>>>>>>>>>>>>>>>>>\033[0m"

docker build \
  --no-cache \
  --file .ci/Dockerfile \
  --tag elastic/elasticsearch-php \
  --build-arg PHP_VERSION=${PHP_VERSION} \
  .

echo -e "\033[1m>>>>> Run test:integration >>>>>>>>>>>>>>>>>>>>>>>>>>>>>\033[0m"

repo=$(realpath $(dirname $(realpath -s $0))/../)

docker run \
  --network=${network_name} \
  --workdir="/usr/src/app" \
  --volume=${repo}/tests:/usr/src/app/tests \
  --env STACK_VERSION=${STACK_VERSION} \
  --env TEST_SUITE=${TEST_SUITE} \
  --env PHP_VERSION=${PHP_VERSION} \
  --env ELASTICSEARCH_URL=${ELASTICSEARCH_URL} \
  --ulimit nofile=65535:65535 \
  --name elasticsearch-php \
  --rm \
  elastic/elasticsearch-php