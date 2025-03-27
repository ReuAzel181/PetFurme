#!/bin/bash

if [ "$1" == "local" ]; then
  cp .env.local .env
  echo "Switched to local environment"
elif [ "$1" == "production" ]; then
  cp .env.production .env
  echo "Switched to production environment"
else
  echo "Usage: ./switch-env.sh [local|production]"
fi 