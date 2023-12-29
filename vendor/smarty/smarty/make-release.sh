#!/bin/bash

if [[ "$1" =~ ^2\.[0-9\.-rc]+$ ]]; then
   printf 'Creating release %s\n' "$1"
else
   echo "Invalid version number: $1. This script can only make v2.x.x releases."
   exit 1;
fi

git checkout -b "release/$1"
sed -i "s/=== Unreleased ===/=== Unreleased ===\\n\\n=== $1 - $(date +%Y-%m-%d) ===/" ChangeLog
sed -i "s/var \$_version = '[^']\+';/var \$_version = '$1';/" libs/Smarty.class.php

git add ChangeLog libs/Smarty.class.php
git commit -m "version bump"

git checkout support/2.6
git pull
git merge --no-ff "release/$1"
git branch -d "release/$1"
git tag -a "v$1" -m "Release $1"

printf 'Done creating release %s\n' "$1"

# shellcheck disable=SC2016
printf 'Run `git push --follow-tags origin` to publish it.\n'