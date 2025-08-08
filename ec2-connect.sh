#!/bin/bash


key="/home/aris/Aws/ubuntu-key-pair.pem"

echo "Using key: $key"
ls -l "$key"

ssh -v -i "$key" ubuntu@ec2-54-160-183-96.compute-1.amazonaws.com
