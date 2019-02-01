#!/bin/bash
set -m
# set -e
# set -o pipefail

exec supervisord -n

fg %1