#!/usr/bin/env bash
set -e

HOST="${1}"

if curl -s --head --connect-timeout 2 $HOST; then
  echo "Domain $HOST is not pingable"
  exit 1
else
  echo "Domain $HOST is pingable"
fi
