#!/bin/bash
set -m
# set -e
# set -o pipefail

exec supervisord 

fg %1