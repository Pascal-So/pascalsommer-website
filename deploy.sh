#!/usr/bin/env bash

(cd laravel; yarn install --frozen-lockfile; npm run prod)

git ftp push
