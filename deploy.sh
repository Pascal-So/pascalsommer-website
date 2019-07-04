#!/usr/bin/env bash
set -eu

(cd laravel; yarn install --frozen-lockfile; npm run prod)

git ftp push
