#!/bin/bash

echo "Install dependencies only for Docker."

# Install dependencies only for Docker.
[[ ! -e /.dockerinit ]] && exit 0
set -xe
