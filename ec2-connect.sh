#!/bin/bash


key="/home/aris/Aws/ubuntu-key-pair.pem"

echo "Using key: $key"
ls -l "$key"

ssh -v -i "$key" ubuntu@ec2-3-80-52-236.compute-1.amazonaws.com
