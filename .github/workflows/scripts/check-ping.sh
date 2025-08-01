#!/usr/bin/env bash
set -e

HOST="${1}"

if ! ping -c1 -W2 "$HOST" &>/dev/null; then
  echo "Domain $HOST is not pingable"
  exit 1
else
  echo "Domain $HOST is pingable"
fi
